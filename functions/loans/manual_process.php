<?php
include("../connect.php");
include("../ajax/ajaxcall.php");
// die($_POST["amount"]);
// OUTTA HERE
session_start();
$today = date("Y-m-d");
$institutionId =  $_SESSION['int_id'];
$senderId = $_SESSION['sender_id'];
$branchId = $_SESSION['branch_id'];
$userId = $_SESSION['user_id'];
if (isset($_POST["amount"]) && isset($_POST["payment_date"])) {

    $amount = $_POST["amount"];
    $manualPaymentDate = $_POST["payment_date"];
    $manualPaymentType = $_POST["payment_type"];
    $digits = 10;
    $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
    $transactionId = "Loan_" . $randms;
    $scheduleId = $_POST["out_id"];
    // loan details
    $loanScheduleDetails = selectOne("loan_repayment_schedule", ['id' => $scheduleId]);
    $loanId = $loanScheduleDetails['loan_id'];
    $amountCollected = $loanScheduleDetails['amount_collected'] + $amount;
    $amountCompleted = $loanScheduleDetails['completed_derived'] + $amount;
    $expectedPrincipal = $loanScheduleDetails['principal_amount'];
    $expectedInterest = $loanScheduleDetails['interest_amount'];
    $totaldue = $expectedPrincipal + $expectedInterest;
    if ($manualPaymentType == "Pay Interest Amount") {
        $description = "Loan_Interest_Repayment";
        $interestAmount = $loanScheduleDetails['interest_completed_derived'] + $amount;
        $principalAmount = $loanScheduleDetails['principal_completed_derived'];
    } else if ($manualPaymentType == "Pay Principal Amount") {
        $description = "Loan_Principal_Repayment";
        $principalAmount = $loanScheduleDetails['principal_completed_derived'] + $amount;
        $interestAmount = $loanScheduleDetails['interest_completed_derived'];
    } else if ($manualPaymentType == "Pay Principal and Interest Amount") {
        $description = "Loan_Principal_and_Interest_Repayment";
        if ($totaldue == $amount) {
            $principalAmount = $expectedPrincipal;
            $interestAmount = $expectedInterest;
        } else if ($amount < $totaldue) {
            $expectedInterestAmount = $expectedInterest - $loanScheduleDetails['interest_completed_derived'];
            $expectedPrincipalAmount = $amount - $expectedInterestAmount;
            if ($expectedPrincipalAmount < 0) {
                $_SESSION["feedback"] = "Amount inputted is insuffcient - Principal can not be deducted";
                $_SESSION["Lack_of_intfund_$randms"] = "10";
                echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                exit();
            }
            $interestAmount = $loanScheduleDetails['interest_completed_derived'] + $expectedInterestAmount;
            $principalAmount = $loanScheduleDetails['principal_completed_derived'] + $expectedPrincipalAmount;
        } else {
            $_SESSION["feedback"] = "Amount inputted is greater than value owed";
            $_SESSION["Lack_of_intfund_$randms"] = "10";
            echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
            exit();
        }
    }


    $findLoan = selectOne('loan', ['id' => $loanId]);
    $productId = $findLoan['product_id'];
    $clientId = $findLoan['client_id'];
    $loanGl = selectOne("acct_rule", ['int_id' => $institutionId, 'loan_product_id' => $productId]);
    if (!$loanGl) {
        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Something went wrong, can't find loan product details - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
        exit();
    }
    $loanPortfolio = $loanGl['asst_loan_port'];
    $loanInterestPortfolio = $loanGl['inc_interest'];
    // Collect money from client
    $accountNo = $_POST["account_no"];
    $accountConditions = [
        'account_no' => $accountNo,
        'int_id' => $institutionId
    ];
    $accountDetails = selectOne('account', $accountConditions);
    if (!$accountDetails) {
        $error = "Error: " . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Something went wrong, can't access Customers linked account - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
        exit();
        // send them back
    }
    
    $accountBalance = $accountDetails['account_balance_derived'];
    if ($accountBalance >= $amount) {
        #process begins
        // collect transaction details
        $accountConditions = [
            'account_no' => $accountNo,
            'int_id' => $institutionId
        ];
        $accountDetails = selectOne('account', $accountConditions);
        if (!$accountDetails) {
            $output = "Error: %s\n" . mysqli_error($connection); //checking for errors
            exit();
            // send them back
        }
        $accountBalance = $accountDetails['account_balance_derived'];
        $accountId = $accountDetails['id'];
        $productID = $accountDetails['product_id'];
        $clientId = $accountDetails['client_id'];
        $withrawalBlance = $accountDetails['total_withdrawals_derived'];
        $newBalance = $accountBalance - $amount;
        $newWithdrwalBalnce = $withrawalBlance + $amount;
        // Begin transaction
        $debitUpdatedData = [
            'account_balance_derived' => $newBalance,
            'total_withdrawals_derived' => $newWithdrwalBalnce,
            'last_withdrawal' => $amount
        ];
        $updateSenderAccount =  update('account', $accountId, 'id', $debitUpdatedData);
        if (!$updateSenderAccount) {
            $output = "Error: %s\n" . mysqli_error($connection); //checking for errors
            exit();
            // send error could not update senders account
        } else {
            // store transaction data
            $debitTransactionDetails = [
                'int_id' => $institutionId,
                'branch_id' => $branchId,
                'amount' => $amount,
                'transaction_id' => $transactionId,
                'description' => $description,
                'account_no' => $accountNo,
                'product_id' => $productID,
                'client_id' => $clientId,
                'transaction_type' => "debit",
                'transaction_date' => $manualPaymentDate,
                'overdraft_amount_derived' => $amount,
                'running_balance_derived' => $newBalance,
                'cumulative_balance_derived' => $newBalance,
                'appuser_id' => $userId,
                'debit' => $amount,
                'created_date' => $today
            ];

            $storeDebitTransaction =  insert('account_transaction', $debitTransactionDetails);
            if (!$storeDebitTransaction) {
                $output = "Error: %s\n" . mysqli_error($connection); //checking for errors
                exit();
            } else {
                $findSavingsGl = selectOne('savings_acct_rule', ['savings_product_id' => $productID, 'int_id' => $institutionId]);
                $savingsGlcode = $findSavingsGl['asst_loan_port'];
                $savingsGlConditions = [
                    'int_id' => $institutionId,
                    'gl_code' => $savingsGlcode
                ];
                $findGl = selectOne('acc_gl_account', $savingsGlConditions);
                $glBalance = $findGl['organization_running_balance_derived'];
                $glSavingsID = $findGl['id'];
                $glSavingsParent = $findGl['parent_id'];
                // $conditionsGlUpdate = [
                //     'int_id' => $institutionId,
                //     'gl_code' => $savingsGlcode
                // ];
                $newGlBalnce = $glBalance - $amount;
                $updateSavingsGlDetails = [
                    'organization_running_balance_derived' => $newGlBalnce
                ];
                $updateSavingsGlBalance = update('acc_gl_account', $glSavingsID, 'id', $updateSavingsGlDetails);
                if ($updateSavingsGlBalance) {
                    $glSavingsTransactionDetails = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'gl_code' => $savingsGlcode,
                        'parent_id' => $glSavingsParent,
                        'transaction_id' => $transactionId,
                        'description' => $description,
                        'transaction_type' => "debit",
                        'transaction_date' => $manualPaymentDate,
                        'amount' => $amount,
                        'gl_account_balance_derived' => $newGlBalnce,
                        'overdraft_amount_derived' => $amount,
                        'cumulative_balance_derived' => $newGlBalnce,
                        'debit' => $amount
                    ];
                    $storeSavingsGlTransaction = insert('gl_account_transaction', $glSavingsTransactionDetails);
                    if (!$storeSavingsGlTransaction) {
                        printf("<br>1-Error: \n", mysqli_error($connection)); //checking for errors
                        exit();
                    } else {
                        $output = "Success";
                    }
                }
                // find clients alert prefrences
                $findClientDetails = selectOne('client', ['id' => $clientId]);
                $name = $findClientDetails['display_name'];
                $SMSstatus = $findClientDetails['SMS_ACTIVE'];
                $phoneNo = $findClientDetails['mobile_no'];
                // find institution details
                // $findInsitution = selectOne('institutions', ['int_id' => $institutionId]);
                // $senderId = $findInsitution['sender_id'];
                // send debit alert to Sender
                if ($SMSstatus == 1) {
                    $balance = number_format($newBalance, 2);
                    $msg = "Acct: " . appendAccountNo($accountNo, 6) . "\nAmt: NGN " . number_format($amount, 2) . " " . $transType . "\nDesc: " . $description . "\nAvail Bal: " . $balance . "\nDate: " . $today;
                    // creating unique message ID
                    $digits = 9;
                    $messageId = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                    // check for needed values
                    // if exists proceed to send SMS
                    if ($senderId != "" && $phoneNo != "" && $msg != "" && $institutionId != "" && $branchId != "") {
                        // Check the length of the phone numer
                        // if 10 add country code
                        $phoneLength = strlen($phoneNo);
                        if ($phoneLength == 10) {
                            $clientPhone = "234" . $phoneNo;
                        }
                        if ($phoneLength == 11) {
                            $phone =  substr($phoneNo, 1);
                            $clientPhone = "234" . $phone;
                        }

                        $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$institutionId'");
                        $qw = mysqli_fetch_array($sql_fund);
                        $smsBalance = $qw["sms_balance"];
                        $total_with = $qw["total_withdrawal"];
                        $total_int_profit = $qw["int_profit"];
                        $total_sekani_charge = $qw["sekani_charge"];
                        $total_merchant_charge = $qw["merchant_charge"];
                        if ($smsBalance >= 4) {

                            $curl = curl_init();
                            $escape = mysqli_real_escape_string($connection, $msg);

                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://sms.vanso.com//rest/sms/submit/long',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => '{
                                          "account": {
                                              "password": "kwPPkiV4",
                                              "systemId": "NG.102.0421"
                                              },
                                              "sms": {
                                                  "dest":"' . $clientPhone . '",
                                                  "src": "' . $senderId . '",
                                                  "text": "' . $escape . '",
                                                  "unicode": true
                                              }

                                          }',
                                CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/json',
                                    'Authorization: Basic TkcuMTAyLjA0MjE6a3dQUGtpVjQ='
                                ),
                            ));


                            $response = curl_exec($curl);
                            // dd($response);
                            // success
                            $err = curl_close($curl);
                            if ($err) {
                                echo "Connection Error";
                                $obj = json_decode($response, TRUE);
                                $status = $obj['messageParts'][0]['status'];
                                $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                $errorCode = $obj['messageParts'][0]['errorCode'];
                                $smsData = [
                                    'int_id' => $institutionId,
                                    'branch_id' => $branchId,
                                    'mobile_no' => $clientPhone,
                                    'message' => $escape,
                                    'status' => $status,
                                    'ticket_id' => $ticketId,
                                    'error_message' => $errorMessage,
                                    'error_code' => $errorCode
                                ];
                                $insertSms = insert('sms_record', $smsData);
                            } else {
                                $obj = json_decode($response, TRUE);
                                $status = $obj['messageParts'][0]['status'];
                                $ticketId = $obj['messageParts'][0]['ticketId'];
                                $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                $errorCode = $obj['messageParts'][0]['errorCode'];
                                // check for success response
                                if ($status != "") {
                                    // store sms record
                                    $smsData = [
                                        'int_id' => $institutionId,
                                        'branch_id' => $branchId,
                                        'mobile_no' => $clientPhone,
                                        'message' => $escape,
                                        'transaction_date' => $today,
                                        'status' => $status,
                                        'ticket_id' => $ticketId,
                                        'error_message' => $errorMessage,
                                        'error_code' => $errorCode
                                    ];
                                    $insertSms = insert('sms_record', $smsData);
                                    // Declare variables needed to keep record of the transaction
                                    $cal_bal = $smsBalance - 4;
                                    $cal_with = $total_with + 4;
                                    $cal_sek = $total_sekani_charge + 0;
                                    $cal_mch = $total_merchant_charge + 4;
                                    $cal_int_prof = $total_int_profit + 0;
                                    $digits = 9;
                                    $date = date("Y-m-d");
                                    $date2 = date('Y-m-d H:i:s');
                                    $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                                    $trans = "SKWAL" . $randms . "SMS" . $institutionId;
                                    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET sms_balance = '$cal_bal', total_withdrawal = '$cal_with',
                                  int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$institutionId' AND branch_id = '$branchId'");
                                    if ($update_transaction) {
                                        // inserting record of transaction.
                                        $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                                    `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
                                    `int_profit`, `sekani_charge`, `merchant_charge`)
                                    VALUES ('{$institutionId}', '{$branchId}', '{$trans}', 'SMS charge', 'sms', NULL, '0', '{$date}', '4', '{$cal_bal}', '{$cal_bal}', {$date}, 
                                    NULL, NULL, '{$date2}', '0', '0.00', '4.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
                                        if ($insert_transaction) {
                                            // store SMS charge
                                            $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$institutionId}', '{$branchId}', '{$trans}', '{$senderclientId}', '{$transferFrom}', '4', '{$date}')");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                #ends here

            }
        }

        # end of process

        if ($manualPaymentType == "Pay Interest Amount") {
            // we store the loan interest as a credit
            $loanInterestConditions = [
                'gl_code' => $loanInterestPortfolio,
                'int_id' => $institutionId
            ];
            $findInterestPortfolio = selectOne('acc_gl_account', $loanInterestConditions);
            if (!$findInterestPortfolio) {
                printf('9-Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
            }
            $interetGlBalance = $findInterestPortfolio['organization_running_balance_derived'] + $interestAmount;
            $interestGlId = $findInterestPortfolio['id'];
            $interestGlParent = $findInterestPortfolio['parent_id'];
            $updateInterestPortfolio = update('acc_gl_account', $interestGlId, 'id', ['organization_running_balance_derived' => $interetGlBalance]);
            if (!$updateInterestPortfolio) {
                printf('10-Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
            } else {
                // then we store the loan portfolio data
                $interestTransactionDetails = [
                    'int_id' => $institutionId,
                    'branch_id' => $branchId,
                    'gl_code' => $loanInterestPortfolio,
                    'parent_id' => $interestGlParent,
                    'transaction_id' => $transactionId,
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
                    $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                    $_SESSION["feedback"] = "Something went wrong, While Storing Transaction details - $error";
                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                    echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                    exit();
                } else {
                    $totalOutstandingBalance = $findLoan["total_outstanding_derived"] - $amount;
                    $totalRepayment = $findLoan['total_repayment_derived'] + $amount;
                    $oustandingInterestDerived = $findLoan['interest_outstanding_derived'] - $interestAmount;
                    $repaidInterest = $findLoan['interest_repaid_derived'] + $interestAmount;
                    $loanCollectionConditions = [
                        'total_outstanding_derived' => $totalOutstandingBalance,
                        'total_repayment_derived' => $totalRepayment,
                        'interest_outstanding_derived' => $oustandingInterestDerived,
                        'interest_repaid_derived' => $repaidInterest
                    ];
                    $markCollection = update('loan', $loanId, 'id', $loanCollectionConditions);
                    if (!$markCollection) {
                        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                        $_SESSION["feedback"] = "Something went wrong, while updating loan data - $error";
                        $_SESSION["Lack_of_intfund_$randms"] = "10";
                        echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                        exit();
                    } else {
                        // firstly store loan collection transaction
                        $collectionTransactionDetails = [
                            'int_id' => $institutionId,
                            'branch_id' => $branchId,
                            'product_id' => $productId,
                            'loan_id' => $loanId,
                            'transaction_id' => $transactionId,
                            'client_id' => $clientId,
                            'account_no' => $accountNo,
                            'is_reversed' => 0,
                            'external_id' => 0,
                            'transaction_type' => "Repayment",
                            'transaction_date' => $today,
                            'amount' => $amount,
                            'payment_method' => "auto_account",
                            'principal_portion_derived' => 0,
                            'interest_portion_derived' => $interestAmount,
                            'fee_charges_portion_derived' => 0,
                            'penalty_charges_portion_derived' => 0,
                            'overpayment_portion_derived' => 0,
                            'unrecognized_income_portion' => 0,
                            'suspended_interest_portion_derived' => 0,
                            'suspended_fee_charges_portion_derived' => 0,
                            'suspended_penalty_charges_portion_derived' => 0,
                            'outstanding_loan_balance_derived' => $totalOutstandingBalance,
                            'recovered_portion_derived' => $amount,
                            'submitted_on_date' => $today,
                            'manually_adjusted_or_reversed' => 0,
                            'created_date' => $today,
                            'appuser_id' => 0,
                            'is_account_transfer' => 1
                        ];
                        $storeLoanTransaction = insert('loan_transaction', $collectionTransactionDetails);
                        // update loan schedule to complete the process
                        if (!$storeLoanTransaction) {
                            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                            $_SESSION["feedback"] = "Something went wrong, could not store Loan Transaction - $error";
                            $_SESSION["Lack_of_intfund_$randms"] = "10";
                            echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                            exit();
                        } else {
                            // loan schedule data to update
                            if ($amountCollected == $totaldue) {
                                $installment = 0;
                            } else {
                                $installment = 1;
                            }
                            $loanScheduleDetails = [
                                'installment' => $installment,
                                'amount_collected' => $amountCollected,
                                'completed_derived' => $amountCompleted,
                                'obligations_met_on_date' => $today,
                                'principal_completed_derived' => $principalAmount,
                                'interest_completed_derived' => $interestAmount
                            ];
                            $updateSchedule = update('loan_repayment_schedule', $scheduleId, 'id', $loanScheduleDetails);
                            if (!$updateSchedule) {
                                $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                                $_SESSION["feedback"] = "Something went wrong, could not update schedule details - $error";
                                $_SESSION["Lack_of_intfund_$randms"] = "10";
                                echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                                exit();
                            } else {
                                if ($totalOutstandingBalance == 0) {
                                    // mark loan obligation as met
                                    echo $accountNo . " Has met their loan obligation ";
                                    $_SESSION["feedback"] = "Transaction Successful - Loan obligation Has been met";
                                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                                    echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message0=$randms");
                                    exit();
                                } else {
                                    echo "Expecting next repayment From " . $accountNo . "<br>";
                                    $_SESSION["feedback"] = "Transaction Successful";
                                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                                    echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message0=$randms");
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
        } else if ($manualPaymentType == "Pay Principal Amount") {
            //we've taken the money from client
            // we settle his loan then
            // first we record the loan details in the appropriate gl's
            $loanPortfolioConditions = [
                'gl_code' => $loanPortfolio,
                'int_id' => $institutionId
            ];
            $findLoanPortfolio = selectOne('acc_gl_account', $loanPortfolioConditions);
            if (!$findLoanPortfolio) {
                $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                $_SESSION["feedback"] = "Something went wrong, can't access GL account - $error";
                $_SESSION["Lack_of_intfund_$randms"] = "10";
                echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                exit();
            }
            $portfolioBalance = $findLoanPortfolio['organization_running_balance_derived'] - $principalAmount;
            $portfolioId = $findLoanPortfolio['id'];
            $portfolioGlParent = $findLoanPortfolio['parent_id'];
            $updatePortfolio = update('acc_gl_account', $portfolioId, 'id', ['organization_running_balance_derived' => $portfolioBalance]);
            if (!$updatePortfolio) {
                $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                $_SESSION["feedback"] = "Something went wrong, could not update loan portfolio - $error";
                $_SESSION["Lack_of_intfund_$randms"] = "10";
                echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                exit();
            } else {
                // then we store the loan portfolio data
                $portfolioTransactionDetails = [
                    'int_id' => $institutionId,
                    'branch_id' => $branchId,
                    'gl_code' => $loanPortfolio,
                    'parent_id' => $portfolioGlParent,
                    'transaction_id' => $transactionId,
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
                if ($storePortfolioTransaction) {
                    $totalOutstandingBalance = $findLoan["total_outstanding_derived"] - $amount;
                    $totalRepayment = $findLoan['total_repayment_derived'] + $amount;
                    $oustandingPrincipalDerived = $findLoan['principal_outstanding_derived'] - $principalAmount;
                    $repaidPrincipal = $findLoan['principal_repaid_derived'] + $principalAmount;
                    $loanCollectionConditions = [
                        'total_outstanding_derived' => $totalOutstandingBalance,
                        'total_repayment_derived' => $totalRepayment,
                        'principal_outstanding_derived' => $oustandingPrincipalDerived,
                        'principal_repaid_derived' => $repaidPrincipal
                    ];
                    $markCollection = update('loan', $loanId, 'id', $loanCollectionConditions);
                    if (!$markCollection) {
                        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                        $_SESSION["feedback"] = "Something went wrong, could not update loan record - $error";
                        $_SESSION["Lack_of_intfund_$randms"] = "10";
                        echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                        exit();
                    } else {
                        // firstly store loan collection transaction
                        $collectionTransactionDetails = [
                            'int_id' => $institutionId,
                            'branch_id' => $branchId,
                            'product_id' => $productId,
                            'loan_id' => $loanId,
                            'transaction_id' => $transactionId,
                            'client_id' => $clientId,
                            'account_no' => $accountNo,
                            'is_reversed' => 0,
                            'external_id' => 0,
                            'transaction_type' => "Repayment",
                            'transaction_date' => $today,
                            'amount' => $amount,
                            'payment_method' => "auto_account",
                            'principal_portion_derived' => $principalAmount,
                            'interest_portion_derived' => 0,
                            'fee_charges_portion_derived' => 0,
                            'penalty_charges_portion_derived' => 0,
                            'overpayment_portion_derived' => 0,
                            'unrecognized_income_portion' => 0,
                            'suspended_interest_portion_derived' => 0,
                            'suspended_fee_charges_portion_derived' => 0,
                            'suspended_penalty_charges_portion_derived' => 0,
                            'outstanding_loan_balance_derived' => $totalOutstandingBalance,
                            'recovered_portion_derived' => $amount,
                            'submitted_on_date' => $today,
                            'manually_adjusted_or_reversed' => 0,
                            'created_date' => $today,
                            'appuser_id' => 0,
                            'is_account_transfer' => 1
                        ];
                        $storeLoanTransaction = insert('loan_transaction', $collectionTransactionDetails);
                        // update loan schedule to complete the process
                        if (!$storeLoanTransaction) {
                            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                            $_SESSION["feedback"] = "Something went wrong, could not store loan transaction - $error";
                            $_SESSION["Lack_of_intfund_$randms"] = "10";
                            echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                            exit();
                        } else {
                            // loan schedule data to update
                            if ($amountCollected == $totaldue) {
                                $installment = 0;
                            } else {
                                $installment = 1;
                            }
                            $loanScheduleDetails = [
                                'installment' => $installment,
                                'amount_collected' => $amountCollected,
                                'completed_derived' => $amountCompleted,
                                'obligations_met_on_date' => $today,
                                'principal_completed_derived' => $principalAmount
                            ];
                            $updateSchedule = update('loan_repayment_schedule', $scheduleId, 'id', $loanScheduleDetails);
                            if (!$updateSchedule) {
                                $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                                $_SESSION["feedback"] = "Something went wrong, could not update schedule record - $error";
                                $_SESSION["Lack_of_intfund_$randms"] = "10";
                                echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                                exit();
                            } else {
                                if ($totalOutstandingBalance == 0) {
                                    // mark loan obligation as met
                                    echo $accountNo . " Has met their loan obligation ";
                                    $_SESSION["feedback"] = "Transaction Successful - Loan obligation Has been met";
                                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                                    echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message0=$randms");
                                    exit();
                                } else {
                                    echo "Expecting next repayment From " . $accountNo . "<br>";
                                    $_SESSION["feedback"] = "Transaction Successful";
                                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                                    echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message0=$randms");
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
        } else if ($manualPaymentType == "Pay Principal and Interest Amount") {
            $loanPortfolioConditions = [
                'gl_code' => $loanPortfolio,
                'int_id' => $institutionId
            ];
            $findLoanPortfolio = selectOne('acc_gl_account', $loanPortfolioConditions);
            if (!$findLoanPortfolio) {
                printf('6-Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
            }
            $portfolioBalance = $findLoanPortfolio['organization_running_balance_derived'] - $principalAmount;
            $portfolioId = $findLoanPortfolio['id'];
            $portfolioGlParent = $findLoanPortfolio['parent_id'];
            $updatePortfolio = update('acc_gl_account', $portfolioId, 'id', ['organization_running_balance_derived' => $portfolioBalance]);
            if (!$updatePortfolio) {
                printf('7-Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
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
                    printf('8-Error: %s\n', mysqli_error($connection)); //checking for errors
                    exit();
                } else {
                    // secondly we store the loan interest as a credit
                    $loanInterestConditions = [
                        'gl_code' => $loanInterestPortfolio,
                        'int_id' => $institutionId
                    ];
                    $findInterestPortfolio = selectOne('acc_gl_account', $loanInterestConditions);
                    if (!$findInterestPortfolio) {
                        printf('9-Error: %s\n', mysqli_error($connection)); //checking for errors
                        exit();
                    }
                    $interetGlBalance = $findInterestPortfolio['organization_running_balance_derived'] + $interestAmount;
                    $interestGlId = $findInterestPortfolio['id'];
                    $interestGlParent = $findInterestPortfolio['parent_id'];
                    $updateInterestPortfolio = update('acc_gl_account', $interestGlId, 'id', ['organization_running_balance_derived' => $interetGlBalance]);
                    if (!$updateInterestPortfolio) {
                        printf('10-Error: %s\n', mysqli_error($connection)); //checking for errors
                        exit();
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
                            printf('11-Error: %s\n', mysqli_error($connection)); //checking for errors
                            exit();
                        }
                    }
                }
            }
            # found the loan
            $totalOutstandingBalance = $findLoan["total_outstanding_derived"] - $amount;
            $totalRepayment = $findLoan['total_repayment_derived'] + $amount;
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
            if (!$markCollection) {
                $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                $_SESSION["feedback"] = "Something went wrong, could not update loan record - $error";
                $_SESSION["Lack_of_intfund_$randms"] = "10";
                echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
            } else {
                // firstly store loan collection transaction
                $collectionTransactionDetails = [
                    'int_id' => $institutionId,
                    'branch_id' => $branchId,
                    'product_id' => $productId,
                    'loan_id' => $loanId,
                    'transaction_id' => $transactionId,
                    'client_id' => $clientId,
                    'account_no' => $accountNo,
                    'is_reversed' => 0,
                    'external_id' => 0,
                    'transaction_type' => "Repayment",
                    'transaction_date' => $today,
                    'amount' => $amount,
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
                    'recovered_portion_derived' => $amount,
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
                    $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                    $_SESSION["feedback"] = "Something went wrong, could not store loan transaction record - $error";
                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                    echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                    exit();
                } else {
                    // loan schedule data to update

                    if ($amountCollected == $totaldue) {
                        $installment = 0;
                    } else {
                        $installment = 1;
                    }
                    $loanScheduleDetails = [
                        'installment' => $installment,
                        'amount_collected' => $amountCollected,
                        'completed_derived' => $amountCompleted,
                        'obligations_met_on_date' => $today,
                        'principal_completed_derived' => $principalAmount,
                        'interest_completed_derived' => $interestAmount
                    ];
                    $updateSchedule = update('loan_repayment_schedule', $scheduleId, 'id', $loanScheduleDetails);
                    if (!$updateSchedule) {
                        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                        $_SESSION["feedback"] = "Something went wrong, could not update schedule record - $error";
                        $_SESSION["Lack_of_intfund_$randms"] = "10";
                        echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message1=$randms");
                        exit();
                    } else {
                        echo "Current Schedule successfully cleared for " . $accountNo . "<br>";
                        if ($totalOutstandingBalance == 0) {
                            // mark loan obligation as met
                            echo $accountNo . " Has met their loan obligation ";
                            $_SESSION["feedback"] = "Transaction Successful - Loan obligation Has been met";
                            $_SESSION["Lack_of_intfund_$randms"] = "10";
                            echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message0=$randms");
                            exit();
                        } else {
                            echo "Expecting next repayment From " . $accountNo . "<br>";
                            $_SESSION["feedback"] = "Transaction Successful";
                            $_SESSION["Lack_of_intfund_$randms"] = "10";
                            echo header("Location: ../../mfi/manual_recollection.php?view=$loanId&message0=$randms");
                            exit();
                        }
                    }
                }
            }
        }
    } else {
        // inssufient amount
    }
}
    // END OUTTA HERE
