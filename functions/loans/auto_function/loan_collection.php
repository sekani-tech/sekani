<?php
// include("../../connect.php");
// session_start();
// get today's date
function loan_collection($connection) {

$today = date("Y-m-d");
$todayTime = date("Y-m-d");

// check for clients with outstanding loans
// if the oustanding loan value
// loan status should be either true or false
$debtorsCondition = [
    'total_outstanding_derived' => 0
];

$debtorsData =  selectAllGreater('loan', $debtorsCondition);
// dd($debtorsData);
if (!$debtorsData) {
    // printf('1-Error: %s\n', mysqli_error($connection)); //checking for errors
    // exit();
}
// after collecting data for each owing client
// loop through the loan collection proccess
foreach ($debtorsData as $key => $debtors) {
    // intialize debtors data
    $clientId = $debtors['client_id'];
    $loanId = $debtors['id'];
    $accountNo = $debtors['account_no'];
    $institutionId = $debtors['int_id'];
    $productId = $debtors['product_id'];

    // Loan GL Portfolio and interest GL code
    $loanGl = selectOne("acct_rule", ['int_id' => $institutionId, 'loan_product_id' => $productId]);
    if (!$loanGl) {
        // printf('2-Error: %s\n', mysqli_error($connection)); //checking for errors
        // exit();
    }
    $loanPortfolio = $loanGl['asst_loan_port'];
    $loanInterestPortfolio = $loanGl['inc_interest'];

    // create conditions to check schedule table
    $conditions = [
        'loan_id' => $loanId,
        'client_id' => $clientId
    ];
    $dateConditions = [
        'duedate' => $today
    ];

    $debtSchedule = checkLoanDebtor('loan_repayment_schedule', $conditions, $dateConditions);
    if (!$debtSchedule) {
        // printf('3-Error: %s\n', mysqli_error($connection)); //checking for errors
        // exit();
    }
    // $scheduleId = $debtSchedule['id'];
    // $principalAmount =  $debtSchedule['principal_amount'];
    // $interestAmount = $debtSchedule['interest_amount'];
    // $amountDue =  $principalAmount + $interestAmount;


    // dd($debtSchedule);
    foreach ($debtSchedule as  $schedule) {
        $scheduleId = $schedule['id'];
        $principalAmount =  $schedule['principal_amount'];
        $interestAmount = $schedule['interest_amount'];
        $amountDue =  $principalAmount + $interestAmount;
        // dd($amountDue);

        $accountData = [
            'account_no' => $accountNo,
            'client_id' => $clientId
        ];

        $accountBalance = [
            'account_balance_derived' => 0
        ];

        $checkAccount = checkAccount('account', $accountData, $accountBalance);
        if (!$checkAccount) {
            // printf('4-Error: %s\n', mysqli_error($connection)); //checking for errors
            // exit();
        } else {
            //initialize clients account data
            $branchId = $checkAccount['branch_id'];
            $digits = 7;
            $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
            $transacionId = $clientId . "_" . $randms . "_" . $branchId;
            $client = selectAll('client', ['id'=>$clientId]);
            $description = "Loan_Repayment_Principal_Interest / {$client[0]['display_name']}";
            $branchId = $checkAccount['branch_id'];
            $savingsProductID = $checkAccount['product_id'];
            $accountBalance = $checkAccount['account_balance_derived'];
            $newBalance = $accountBalance - $amountDue;
            // if amount account balance is higher than the amount
            if ($accountBalance >= $amountDue) {
                // deduct full amount from client
                // mark schedule as fully paid
                $updateDetails = [
                    'account_balance_derived' => $newBalance,
                    'last_withdrawal' => $amountDue,
                    'last_activity_date' => $today,
                ];
                $updateCondition = [
                    'int_id' => $institutionId,
                    'account_no' => $accountNo
                ];
                $updateBalance = update('account', $accountNo, 'account_no', $updateDetails);
                if ($updateBalance) {
                    // for future reference 
                    // do note the following information in the transactionDetails array
                    // are all the information you must provide 
                    // when storing a transaction
                    $transactionDetails = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'amount' => $amountDue,
                        'transaction_id' => $transacionId,
                        'description' => $description,
                        'account_no' => $accountNo,
                        'product_id' => $savingsProductID,
                        'client_id' => $clientId,
                        'transaction_type' => "debit",
                        'transaction_date' => $today,
                        'overdraft_amount_derived' => $amountDue,
                        'running_balance_derived' => $newBalance,
                        'cumulative_balance_derived' => $newBalance,
                        'appuser_id' => 0,
                        'debit' => $amountDue,
                        'created_date' => $todayTime
                    ];
                    $storeTransaction = insert('account_transaction', $transactionDetails);
                    if (!$storeTransaction) {
                        // printf('5-Error: %s\n', mysqli_error($connection)); //checking for errors
                        // exit();
                    } else {
                        //we've taken the money from client
                        // we settle his loan then
                        // first we record the loan details in the appropriate gl's
                        $loanPortfolioConditions = [
                            'gl_code' => $loanPortfolio,
                            'int_id' => $institutionId
                        ];
                        $findLoanPortfolio = selectOne('acc_gl_account', $loanPortfolioConditions);
                        if (!$findLoanPortfolio) {
                            // printf('6-Error: %s\n', mysqli_error($connection)); //checking for errors
                            // exit();
                        }
                        $portfolioBalance = $findLoanPortfolio['organization_running_balance_derived'] - $principalAmount;
                        $portfolioId = $findLoanPortfolio['id'];
                        $portfolioGlParent = $findLoanPortfolio['parent_id'];
                        $updatePortfolio = update('acc_gl_account', $portfolioId, 'id', ['organization_running_balance_derived' => $portfolioBalance]);
                        if (!$updatePortfolio) {
                            // printf('7-Error: %s\n', mysqli_error($connection)); //checking for errors
                            // exit();
                        } else {
                            // then we store the loan portfolio data
                            $portfolioTransactionDetails = [
                                'int_id' => $institutionId,
                                'branch_id' => $branchId,
                                'gl_code' => $loanPortfolio,
                                'parent_id' => $portfolioGlParent,
                                'transaction_id' => $transacionId,
                                'description' => $description,
                                'transaction_type' => "debit",
                                'transaction_date' => $today,
                                'amount' => $principalAmount,
                                'gl_account_balance_derived' => $portfolioBalance,
                                'overdraft_amount_derived' => $principalAmount,
                                'cumulative_balance_derived' => $portfolioBalance,
                                'debit' => $principalAmount
                            ];
                            $storePortfolioTransaction = insert('gl_account_transaction', $portfolioTransactionDetails);
                            if (!$storePortfolioTransaction) {
                                // printf('8-Error: %s\n', mysqli_error($connection)); //checking for errors
                                // exit();
                            } else {
                                // secondly we store the loan interest as a credit
                                $loanInterestConditions = [
                                    'gl_code' => $loanInterestPortfolio,
                                    'int_id' => $institutionId
                                ];
                                $findInterestPortfolio = selectOne('acc_gl_account', $loanInterestConditions);
                                if (!$findInterestPortfolio) {
                                    // printf('9-Error: %s\n', mysqli_error($connection)); //checking for errors
                                    // exit();
                                }
                                $interetGlBalance = $findInterestPortfolio['organization_running_balance_derived'] + $interestAmount;
                                $interestGlId = $findInterestPortfolio['id'];
                                $interestGlParent = $findInterestPortfolio['parent_id'];
                                $updateInterestPortfolio = update('acc_gl_account', $interestGlId, 'id', ['organization_running_balance_derived' => $interetGlBalance]);
                                if (!$updateInterestPortfolio) {
                                    // printf('10-Error: %s\n', mysqli_error($connection)); //checking for errors
                                    // exit();
                                } else {
                                    // then we store the loan portfolio data
                                    $interestTransactionDetails = [
                                        'int_id' => $institutionId,
                                        'branch_id' => $branchId,
                                        'gl_code' => $loanInterestPortfolio,
                                        'parent_id' => $interestGlParent,
                                        'transaction_id' => $transacionId,
                                        'description' => $description,
                                        'transaction_type' => "credit",
                                        'transaction_date' => $today,
                                        'amount' => $interestAmount,
                                        'gl_account_balance_derived' => $interetGlBalance,
                                        'overdraft_amount_derived' => $interestAmount,
                                        'cumulative_balance_derived' => $interetGlBalance,
                                        'credit' => $interestAmount
                                    ];
                                    $storeInterestTransaction = insert('gl_account_transaction', $interestTransactionDetails);
                                    if (!$storeInterestTransaction) {
                                        // printf('11-Error: %s\n', mysqli_error($connection)); //checking for errors
                                        // exit();
                                    } else {
                                        // get loan data to aide in performing loan update
                                        $loanConditions = [
                                            'id' => $loanId,
                                            'client_id' => $clientId,
                                            'int_id' => $institutionId,
                                        ];
                                        $findLoan = selectOne('loan', $loanConditions);
                                        if (!$findLoan) {
                                            // printf('12-Error: %s\n', mysqli_error($connection)); //checking for errors
                                            // exit();
                                        }
                                        // dd($findLoan);
                                        # found the loan
                                        $totalOutstandingBalance = $findLoan["total_outstanding_derived"] - $amountDue;
                                        $totalRepayment = $findLoan['total_repayment_derived'] + $amountDue;
                                        $oustandingPrincipalDerived = $findLoan['principal_outstanding_derived'] - $principalAmount;
                                        $repaidPrincipal = $findLoan['principal_repaid_derived'] + $principalAmount;
                                        $oustandingInterestDerived = $findLoan['interest_outstanding_derived'] - $interestAmount;
                                        $repaidInterest = $findLoan['interest_repaid_derived'] + $interestAmount;
                                        $loanCollectionConditions = [
                                            'total_outstanding_derived' => $totalOutstandingBalance,
                                            'total_repayment_derived' => $totalRepayment,
                                            'principal_outstanding_derived' => $oustandingPrincipalDerived,
                                            'principal_repaid_derived' => $repaidPrincipal,
                                            'interest_outstanding_derived' => $oustandingInterestDerived,
                                            'interest_repaid_derived' => $repaidInterest
                                        ];
                                        $markCollection = update('loan', $loanId, 'id', $loanCollectionConditions);
                                        // dd($markCollection);
                                        if (!$markCollection) {
                                            // printf('13-Error: %s\n', mysqli_error($connection)); //checking for errors
                                            // exit();
                                        } else {
                                            // firstly store loan collection transaction
                                            $collectionTransactionDetails = [
                                                'int_id' => $institutionId,
                                                'branch_id' => $branchId,
                                                'product_id' => $productId,
                                                'loan_id' => $loanId,
                                                'transaction_id' => $transacionId,
                                                'client_id' => $clientId,
                                                'account_no' => $accountNo,
                                                'is_reversed' => 0,
                                                'external_id' => 0,
                                                'transaction_type' => "Repayment",
                                                'transaction_date' => $today,
                                                'amount' => $amountDue,
                                                'payment_method' => "auto_account",
                                                'principal_portion_derived' => $principalAmount,
                                                'interest_portion_derived' => $interestAmount,
                                                'fee_charges_portion_derived' => 0,
                                                'penalty_charges_portion_derived' => 0,
                                                'overpayment_portion_derived' => 0,
                                                'unrecognized_income_portion' => 0,
                                                'suspended_interest_portion_derived' => 0,
                                                'suspended_fee_charges_portion_derived' => 0,
                                                'suspended_penalty_charges_portion_derived' => 0,
                                                'outstanding_loan_balance_derived' => $totalOutstandingBalance,
                                                'recovered_portion_derived' => $amountDue,
                                                'submitted_on_date' => $today,
                                                'manually_adjusted_or_reversed' => 0,
                                                'created_date' => $today,
                                                'appuser_id' => 0,
                                                'is_account_transfer' => 1
                                            ];
                                            $storeLoanTransaction = insert('loan_transaction', $collectionTransactionDetails);
                                            // dd($storeLoanTransaction);
                                            // update loan schedule to complete the process
                                            if (!$storeLoanTransaction) {
                                                // printf('14-Error: %s\n', mysqli_error($connection)); //checking for errors
                                                // exit();
                                            } else {
                                                // loan schedule data to update
                                                $loanScheduleDetails = [
                                                    'installment' => 0,
                                                    'amount_collected' => $amountDue,
                                                    'completed_derived' => $amountDue,
                                                    'obligations_met_on_date' => $today,
                                                    'principal_completed_derived' => $principalAmount,
                                                    'interest_completed_derived' => $interestAmount
                                                ];
                                                $updateSchedule = update('loan_repayment_schedule', $scheduleId, 'id', $loanScheduleDetails);
                                                if (!$updateSchedule) {
                                                    // printf('15-Error: %s\n', mysqli_error($connection)); //checking for errors
                                                    // exit();
                                                } else {
                                                    echo "Current Schedule successfully cleared for " . $accountNo . "<br>";
                                                    if ($totalOutstandingBalance == 0) {
                                                        // mark loan obligation as met
                                                        echo $accountNo . " Has met their loan obligation ";
                                                    } else {
                                                        echo "Expecting next repayment From " . $accountNo . "<br>";
                                                    }
                                                }
                                            }
                                        }
                                        # mark collection as carried out
                                    }
                                }
                                # interest gl amount updated
                            }
                            # portfolio gl transaction stored
                        }
                        # portfolio gl amount updated
                    }
                    #account transction stored
                }
            } else if ($accountBalance > 0 && $accountBalance >=  1000) {
                // mark loan as partially paid
                $newBalance = 0;
                if ($accountBalance > $interestAmount) {
                    $newBalance = $accountBalance - $interestAmount;
                    $finalBalance = $newBalance - $newBalance;
                } else {
                    $finalBalance = $accountBalance - $accountBalance;
                }
                // deduct amount from client
                $updateDetails = [
                    'account_balance_derived' => $finalBalance,
                    'last_withdrawal' => $accountBalance,
                    'last_activity_date' => $today,
                ];
                $updateCondition = [
                    'int_id' => $institutionId,
                    'account_no' => $accountNo
                ];
                $updateBalance = update('account', $accountNo, 'account_no', $updateDetails);
                if ($updateBalance) {
                    // for future reference 
                    // do note the following information in the transactionDetails array
                    // are all the information you must provide 
                    // when storing a transaction
                    $transactionDetails = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'amount' => $accountBalance,
                        'transaction_id' => $transacionId,
                        'description' => $description,
                        'account_no' => $accountNo,
                        'product_id' => $savingsProductID,
                        'client_id' => $clientId,
                        'transaction_type' => "debit",
                        'transaction_date' => $today,
                        'overdraft_amount_derived' => $accountBalance,
                        'running_balance_derived' => $finalBalance,
                        'cumulative_balance_derived' => $finalBalance,
                        'appuser_id' => 0,
                        'debit' => $accountBalance,
                        'created_date' => $todayTime
                    ];
                    $storeTransaction = insert('account_transaction', $transactionDetails);
                    if (!$storeTransaction) {
                        // printf('5b-Error: %s\n', mysqli_error($connection)); //checking for errors
                        // exit();
                    } else {
                        //we've taken the money from client
                        // we settle his loan then
                        // first we record the loan details in the appropriate gl's
                        $loanPortfolioConditions = [
                            'gl_code' => $loanPortfolio,
                            'int_id' => $institutionId
                        ];
                        $findLoanPortfolio = selectOne('acc_gl_account', $loanPortfolioConditions);
                        if (!$findLoanPortfolio) {
                            // printf('6b-Error: %s\n', mysqli_error($connection)); //checking for errors
                            // exit();
                        }
                        if ($newBalance > 0) {
                            $portfolioBalance = $findLoanPortfolio['organization_running_balance_derived'] - $newBalance;
                            $portfolioId = $findLoanPortfolio['id'];
                            $portfolioGlParent = $findLoanPortfolio['parent_id'];
                            $updatePortfolio = update('acc_gl_account', $portfolioId, 'id', ['organization_running_balance_derived' => $portfolioBalance]);
                            if (!$updatePortfolio) {
                                // printf('7b-Error: %s\n', mysqli_error($connection)); //checking for errors
                                // exit();
                            } else {
                                // then we store the loan portfolio data
                                $portfolioTransactionDetails = [
                                    'int_id' => $institutionId,
                                    'branch_id' => $branchId,
                                    'gl_code' => $loanPortfolio,
                                    'parent_id' => $portfolioGlParent,
                                    'transaction_id' => $transacionId,
                                    'description' => $description,
                                    'transaction_type' => "debit",
                                    'transaction_date' => $today,
                                    'amount' => $newBalance,
                                    'gl_account_balance_derived' => $portfolioBalance,
                                    'overdraft_amount_derived' => $newBalance,
                                    'cumulative_balance_derived' => $portfolioBalance,
                                    'debit' => $newBalance
                                ];
                                $storePortfolioTransaction = insert('gl_account_transaction', $portfolioTransactionDetails);
                                if (!$storePortfolioTransaction) {
                                    // printf('8b-Error: %s\n', mysqli_error($connection)); //checking for errors
                                    // exit();
                                } else {
                                    // secondly we store the loan interest as a credit
                                    $loanInterestConditions = [
                                        'gl_code' => $loanInterestPortfolio,
                                        'int_id' => $institutionId
                                    ];
                                    $findInterestPortfolio = selectOne('acc_gl_account', $loanInterestConditions);
                                    if (!$findInterestPortfolio) {
                                        // printf('9b-Error: %s\n', mysqli_error($connection)); //checking for errors
                                        // exit();
                                    }
                                    $interetGlBalance = $findInterestPortfolio['organization_running_balance_derived'] + $interestAmount;
                                    $interestGlId = $findInterestPortfolio['id'];
                                    $interestGlParent = $findInterestPortfolio['parent_id'];
                                    $updateInterestPortfolio = update('acc_gl_account', $interestGlId, 'id', ['organization_running_balance_derived' => $interetGlBalance]);
                                    if (!$updateInterestPortfolio) {
                                        // printf('10b-Error: %s\n', mysqli_error($connection)); //checking for errors
                                        // exit();
                                    }
                                }
                            }
                        } else {
                            // secondly we store the loan interest as a credit
                            $loanInterestConditions = [
                                'gl_code' => $loanInterestPortfolio,
                                'int_id' => $institutionId
                            ];
                            $findInterestPortfolio = selectOne('acc_gl_account', $loanInterestConditions);
                            if (!$findInterestPortfolio) {
                                // printf('9b-Error: %s\n', mysqli_error($connection)); //checking for errors
                                // exit();
                            }
                            $interetGlBalance = $findInterestPortfolio['organization_running_balance_derived'] + $finalBalance;
                            $interestGlId = $findInterestPortfolio['id'];
                            $interestGlParent = $findInterestPortfolio['parent_id'];
                            $updateInterestPortfolio = update('acc_gl_account', $interestGlId, 'id', ['organization_running_balance_derived' => $interetGlBalance]);
                            if (!$updateInterestPortfolio) {
                                // printf('10b-Error: %s\n', mysqli_error($connection)); //checking for errors
                                // exit();
                            }
                        }
                        // get loan data to aide in performing loan update
                        $loanConditions = [
                            'id' => $loanId,
                            'client_id' => $clientId,
                            'int_id' => $institutionId,
                        ];
                        $findLoan = selectOne('loan', $loanConditions);
                        if (!$findLoan) {
                            // printf('12b-Error: %s\n', mysqli_error($connection)); //checking for errors
                            // exit();
                        }
                        // dd($findLoan);
                        # found the loan
                        $totalOutstandingBalance = $findLoan["total_outstanding_derived"] - $finalBalance;
                        $totalRepayment = $findLoan['total_repayment_derived'] + $finalBalance;
                        $oustandingPrincipalDerived = $findLoan['principal_outstanding_derived'] - $newBalance;
                        $repaidPrincipal = $findLoan['principal_repaid_derived'] + $newBalance;
                        if ($newBalance > 0) {
                            $oustandingInterestDerived = $findLoan['interest_outstanding_derived'] - $interestAmount;
                            $repaidInterest = $findLoan['interest_repaid_derived'] + $interestAmount;
                        } else {
                            $oustandingInterestDerived = $findLoan['interest_outstanding_derived'] - $finalBalance;
                            $repaidInterest = $findLoan['interest_repaid_derived'] + $finalBalance;
                        }

                        $loanCollectionConditions = [
                            'total_outstanding_derived' => $totalOutstandingBalance,
                            'total_repayment_derived' => $totalRepayment,
                            'principal_outstanding_derived' => $oustandingPrincipalDerived,
                            'principal_repaid_derived' => $repaidPrincipal,
                            'interest_outstanding_derived' => $oustandingInterestDerived,
                            'interest_repaid_derived' => $repaidInterest
                        ];
                        $markCollection = update('loan', $loanId, 'id', $loanCollectionConditions);
                        // dd($markCollection);
                        if (!$markCollection) {
                            // printf('13b-Error: %s\n', mysqli_error($connection)); //checking for errors
                            // exit();
                        } else {
                            // firstly store loan collection transaction
                            $collectionTransactionDetails = [
                                'int_id' => $institutionId,
                                'branch_id' => $branchId,
                                'product_id' => $productId,
                                'loan_id' => $loanId,
                                'transaction_id' => $transacionId,
                                'client_id' => $clientId,
                                'account_no' => $accountNo,
                                'is_reversed' => 0,
                                'external_id' => 0,
                                'transaction_type' => "Repayment",
                                'transaction_date' => $today,
                                'amount' => $finalBalance,
                                'payment_method' => "auto_account",
                                'principal_portion_derived' => $newBalance,
                                'interest_portion_derived' => $repaidInterest,
                                'fee_charges_portion_derived' => 0,
                                'penalty_charges_portion_derived' => 0,
                                'overpayment_portion_derived' => 0,
                                'unrecognized_income_portion' => 0,
                                'suspended_interest_portion_derived' => 0,
                                'suspended_fee_charges_portion_derived' => 0,
                                'suspended_penalty_charges_portion_derived' => 0,
                                'outstanding_loan_balance_derived' => $totalOutstandingBalance,
                                'recovered_portion_derived' => $finalBalance,
                                'submitted_on_date' => $today,
                                'manually_adjusted_or_reversed' => 0,
                                'created_date' => $today,
                                'appuser_id' => 0,
                                'is_account_transfer' => 1
                            ];
                            $storeLoanTransaction = insert('loan_transaction', $collectionTransactionDetails);
                            // dd($storeLoanTransaction);
                            // update loan schedule to complete the process
                            if (!$storeLoanTransaction) {
                                // printf('14b-Error: %s\n', mysqli_error($connection)); //checking for errors
                                // exit();
                            } else {
                                // loan schedule data to update
                                $loanScheduleDetails = [
                                    
                                    'amount_collected' => $finalBalance,
                                    'completed_derived' => 1,
                                    'obligations_met_on_date' => $today,
                                    'principal_completed_derived' => $newBalance,
                                    'interest_completed_derived' => $repaidInterest
                                ];
                                $updateSchedule = update('loan_repayment_schedule', $scheduleId, 'id', $loanScheduleDetails);
                                if (!$updateSchedule) {
                                    // printf('15b-Error: %s\n', mysqli_error($connection)); //checking for errors
                                    // exit();
                                } else {
                                    echo "Current Schedule Partially cleared for " . $accountNo . "<br>";
                                    if ($totalOutstandingBalance == 0) {
                                        // mark loan obligation as met
                                        echo $accountNo . " Has met their loan obligation ";
                                    } else {
                                        echo "Expecting next repayment From " . $accountNo . "<br>";
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                // include("../arrears.php");
                arrears($connection);
            }
        }
    }
    #loop ends here
}
}


function arrears($connection) {
    $sessint_id = $_SESSION['int_id'];
$currentdate = date('Y-m-d');
$currentdate_time = date('Y-m-d H:i:s');

// count it
// check it check if installment is 0 or 1.
$conditions = [
    'int_id' => $sessint_id,
    'installment' => 1
];
$dateConditions = [
    'duedate' => $currentdate
];

$select_arrears = selectAllLessEq('loan_repayment_schedule', $conditions, $dateConditions);

if ($select_arrears) {
    for ($i = 0; $i < sizeof($select_arrears); $i++) {
        // now we need to get it.
        $lr_schedule_id = $select_arrears[$i]['id'];
        $lr_int_id = $select_arrears[$i]['int_id'];
        $lr_loan_id = $select_arrears[$i]['loan_id'];
        $lr_client_id = $select_arrears[$i]['client_id'];
        $lr_fromdate = $select_arrears[$i]['fromdate'];
        $lr_duedate = $select_arrears[$i]['duedate'];
        $lr_installment = $select_arrears[$i]['installment'];
        $lr_principal_amount = $select_arrears[$i]['principal_amount'];
        $lr_principal_completed_derived = $select_arrears[$i]['principal_completed_derived'];
        $lr_interest_amount = $select_arrears[$i]['interest_amount'];
        $lr_interest_completed_derived = $select_arrears[$i]['interest_completed_derived'];
        
        $arrearConditions = [
            'loan_id' => $lr_loan_id,
            'loan_schedule_id' => $lr_schedule_id
        ];
    
        $findArrear = selectAll('loan_arrear', $arrearConditions);

        $currentdate = date('Y-m-d');
        $cal_start = strtotime($lr_duedate);
        $cal_end = strtotime($currentdate);
        $days_between = ceil(abs($cal_end - $cal_start) / 86400);
    
        if (!$findArrear) {
            if(count($findArrear) == 0) {
                $arrearData = [
                    'int_id' => $lr_int_id,
                    'loan_id' => $lr_loan_id,
                    'loan_schedule_id' => $lr_schedule_id,
                    'client_id' => $lr_client_id,
                    'fromdate' => $lr_fromdate,
                    'duedate' => $lr_duedate,
                    'installment' => $lr_installment,
                    'counter' => $days_between,
                    'principal_amount' => $lr_principal_amount,
                    'principal_completed_derived' => $lr_principal_completed_derived,
                    'interest_amount' => $lr_interest_amount,
                    'interest_completed_derived' => $lr_interest_completed_derived,
                    'created_date' => $currentdate_time,
                    'lastmodified_date' => $currentdate_time,
                    'completed_derived' => 1        // value as 1 means it has not been paid off
                ];
    
                $insertArrears = insert('loan_arrear', $arrearData);
                if (!$insertArrears) {
                    // printf('1-Error: %s\n', mysqli_error($connection));
                    // exit();
    
                } else {
                    // echo 'INSERTED SUCCESSFULLY - Loan ID: ' . $lr_loan_id . '<br>';
                }
            }        
    
        } else {

            $currentdate = date('Y-m-d');
            $currentdate_time = date('Y-m-d H:i:s');
            $cal_start = strtotime($lr_duedate);
            $cal_end = strtotime($currentdate);
            $days_between = ceil(abs($cal_end - $cal_start) / 86400);

            if(30 > $days_between && $days_between > 0) {
                $ffd = $select_arrears[$i]['principal_amount'];
                $bnk_prov = (0.05 * $ffd);
            }
            else if(60 > $days_between && $days_between > 30) {
                $fdfdf = $select_arrears[$i]['principal_amount'];
                $bnk_prov = (0.2 * $fdfdf);
            }
            else if(90 > $days_between && $days_between > 60) {
                $dfgd = $select_arrears[$i]['principal_amount'];
                $bnk_prov = (0.5 * $dfgd) ;
            }
            else if($days_between > 90) {
                $juiui = $select_arrears[$i]['principal_amount'];
                $bnk_prov = $juiui;
            } else {
                $bnk_prov = 0;
            }

            $prin = $select_arrears[$i]['principal_amount'];
            $par = ($bnk_prov/$prin) * 100;
            
            $arrear_update = mysqli_query($connection, "UPDATE loan_arrear SET principal_amount = {$lr_principal_amount}, interest_amount = {$lr_interest_amount}, counter = {$days_between}, 
            par = {$par}, bank_provision = {$bnk_prov}, lastmodified_date = '$currentdate_time' WHERE int_id = {$sessint_id} AND loan_id = {$lr_loan_id} AND loan_schedule_id = {$lr_schedule_id}");
            if (!$arrear_update) {
                // printf('2-Error: %s\n', mysqli_error($connection)); //checking for errors
                // exit();
            } else {
                echo 'UPDATED SUCCESSFULLY - Loan ID: ' . $lr_loan_id . '<br>';
            }
        }
    } 

} else {
    // printf('3-Error: %s\n', mysqli_error($connection));
    // exit();
}

}