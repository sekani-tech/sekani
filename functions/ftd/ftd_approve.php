<?php
include("../connect.php");
session_start();
$userId = $_SESSION['user_id'];
$sessint_id = $_SESSION['int_id'];
$randms = str_pad(rand(0, pow(10, 8) - 1), 10, '0', STR_PAD_LEFT);
// first condition caters for when you first view before approval
if(!isset($_GET["approve"])){
    
    // Declare Variables
    $ftd_id = $_POST['ftd_id'];
    $amount = $_POST['amount'];
    $ftd_no = $_POST['ftd_no'];
    $submittedon_date = date('Y-m-d H:i:s');
    $booked_date = $_POST['booked_date'];
    $l_term = $_POST['l_term'];
    $int_rate = $_POST['int_rate'];
    $linked = $_POST['linked'];
    $int_repay = $_POST['int_repay'];
    $auto_renew = $_POST['auto_renew'];
    $acc_off = $_POST['acc_off'];
    $curr_date = date('Y-m-d h:i:sa');
    $tday = date('Y-m-d');

    // update record in case of changes
    $up = "UPDATE ftd_booking_account SET ftd_no = '$ftd_no', field_officer_id = '$acc_off', submittedon_date = '$submittedon_date', account_balance_derived = '$amount', term = '$l_term',
              int_rate = '$int_rate', booked_date = '$booked_date', linked_savings_account = '$linked', auto_renew_on_closure = '$auto_renew', interest_repayment = '$int_repay',
              status = 'Approved' WHERE int_id = '$sessint_id' AND id = '$ftd_id'";
    $update = mysqli_query($connection, $up);

    if($up){
        // BACKTO
        // check for the needed FTD information
        $pickFTD = mysqli_query($connection, "SELECT * FROM ftd_booking_account WHERE int_id = '$sessint_id' AND id = '$ftd_id'");
        $picked = mysqli_fetch_array($pickFTD);
        $bookedAmount = $picked['account_balance_derived'];
        $linkedAccount = $picked['linked_savings_account'];
        $institutionId = $picked['int_id'];
        $branchId = $picked['branch_id'];
        $transaction_date = $picked['booked_date'];
        $intRate = $picked['int_rate'];
        $ftdTerm = $picked['term'];

        if($pickFTD){
            // check clients account balance so we can make the necessary deduction
            // first collect data for check
            $checkAccount = mysqli_query($connection, "SELECT id, account_balance_derived, account_no, product_id, client_id 
            FROM account WHERE int_id = '$institutionId' AND account_no = '$linkedAccount'");
            $accountDetails = mysqli_fetch_array($checkAccount);
            $accountId = $picked['id'];
            $currentAccountBalance = $accountDetails['account_balance_derived'];
            $productId = $accountDetails['product_id'];
            $clientId = $accountDetails['client_id'];
            // now run check
            if($currentAccountBalance >= $bookedAmount){
                // We can now successfully book the clients FTD by deducting the amount from 1
                // the linked account
                // first calculate amount after withdrawal
                $debitAmount = $currentAccountBalance - $bookedAmount;
                // update customers account
                $updateCurrentBalance = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$debitAmount', last_withdrawal = $bookedAmount 
                WHERE account_no = $linkedAccount");
                if($updateCurrentBalance){
                    // now we insert the the transaction record into the db
                    $transactionRecords = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'client_id' => $clientId,
                        'account_no' => $linkedAccount,
                        'amount' => $amount,
                        'account_id' => $accountId,
                        'transaction_id' => $ftd_no,
                        'description' => "FTD Booking",
                        'transaction_date' => $transaction_date,
                        'transaction_type' => "debit",
                        'overdraft_amount_derived' => $amount,
                        'running_balance_derived' => $debitAmount,
                        'appuser_id' => $userId,
                        'debit' => $amount
                    ];

                    // after collecting the details we then insert it into the db
                    $recordTransaction = insert('account_transaction', $transactionRecords);
                    if($recordTransaction){
                        $interestValue = ($intRate / 100) * $amount;
                        $ftdTermMonth = $ftdTerm / 30;
                        $interestAmount =  $interestValue / $ftdTermMonth;
                        $i = 1;
                        while ($i <= $ftdTermMonth) {
                            $maturity_date = date('Y-m-d', strtotime('+'. $i * 30 .' Days', strtotime($transaction_date)));
                            $scheduleData = [
                                'int_id' => $institutionId,
                                'branch_id' => $branchId,
                                'ftd_id' => $ftd_id,
                                'client_id' => $clientId,
                                'ftd_no' => $ftd_no,
                                'installment' => $amount,
                                'maturity_date' => $maturity_date,
                                'interest_rate' => $intRate,
                                'interest_amount' => $interestAmount,
                                'interest_repayment' => '0',
                                'linked_savings_account' => $linkedAccount
                            ];
                            $schedule = insert('ftd_interest_schedule', $scheduleData);
                            
                            if ($schedule) {
                                // success message
                                echo "Schedule created for " + $clientId;
                            }
                            $i++;

                            $updateFTD = mysqli_query($connection, "UPDATE ftd_booking_account SET status = 'Approved' WHERE id = '$ftd_id'");
                            if($updateFTD){
                                $_SESSION["Lack_of_intfund_$randms"] = "FTD approval Successful";
                                echo header("Location: ../../mfi/ftd_approval.php?message1=$randms");
                            }else{
                                // something is wrong... update not successful
                                $_SESSION["Lack_of_intfund_$randms"] = "Something is wrong! FTD status not changed";
                                echo header("Location: ../../mfi/ftd_approval.php?message7=$randms");       
                            }

                        }
                    }
                    else{
                        // something is wrong... transaction record not inserted into DB
                        $_SESSION["Lack_of_intfund_$randms"] = "Money deducted but record of transaction not stored";
                        echo header("Location: ../../mfi/ftd_approval.php?message6=$randms");
                    }

                }else{
                    // something is wrong... accounts table not updated hence 
                    // money not deducted
                    $_SESSION["Lack_of_intfund_$randms"] = "Money not deducted from account";
                    echo header("Location: ../../mfi/ftd_approval.php?message4=$randms");
                }
                
            }else{
                // not enough money in linked account
                $_SESSION["Lack_of_intfund_$randms"] = "Not enough Money in Linked account!";
                echo header("Location: ../../mfi/ftd_approval.php?message3=$randms");    
            }
        }else{
            printf('Error: %s\n', mysqli_error($connection));//checking for errors
            exit();
        }
    }else{
        $_SESSION["Lack_of_intfund_$randms"] = "Something is wrong unable to Approve FTD!";
        echo header("Location: ../../mfi/ftd_approval.php?message9=$randms");
    }
    // ends here
}else if(isset($_GET["approve"])){ //here I am only carrying out the function when you hit approve on ftd_approval.php
    // check for the needed FTD information
    $ftd_id = $_GET["approve"];
    $pickFTD = mysqli_query($connection, "SELECT * FROM ftd_booking_account WHERE int_id = '$sessint_id' AND id = '$ftd_id'");
    $picked = mysqli_fetch_array($pickFTD);
    $ftd_id = $picked['id'];
    $ftd_no = $picked['ftd_no'];
    $bookedAmount = $picked['account_balance_derived'];
    $linkedAccount = $picked['linked_savings_account'];
    $institutionId = $picked['int_id'];
    $branchId = $picked['branch_id'];
    $submittedon_date = date('Y-m-d H:i:s');
    $transaction_date = $picked['booked_date'];
    $intRate = $picked['int_rate'];
    $ftdTerm = $picked['term'];

    if($pickFTD){
        // check clients account balance so we can make the necessary deduction
        // first collect data for check
        $checkAccount = mysqli_query($connection, "SELECT id, account_balance_derived, account_no, product_id, client_id FROM account WHERE int_id = '$institutionId' AND account_no = '$linkedAccount'");
        $accountDetails = mysqli_fetch_array($checkAccount);
        $accountId = $picked['id'];
        $currentAccountBalance = $accountDetails['account_balance_derived'];
        $productId = $accountDetails['product_id'];
        $clientId = $accountDetails['client_id'];
        

        // now run check
        if($currentAccountBalance >= $bookedAmount){
            // We can now successfully book the clients FTD by deducting the amount from 2
            // the linked account
            // first calculate amount after withdrawal
            $debitAmount = $currentAccountBalance - $bookedAmount;
            // update customers account
            $updateCurrentBalance = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$debitAmount', last_withdrawal = $bookedAmount 
            WHERE account_no = $linkedAccount");
            if($updateCurrentBalance){
                // now we insert the the transaction record into the db
                $transactionRecords = [
                    'int_id' => $institutionId,
                    'branch_id' => $branchId,
                    'client_id' => $clientId,
                    'account_no' => $linkedAccount,
                    'amount' => $bookedAmount,
                    'account_id' => $accountId,
                    'transaction_id' => $ftd_no,
                    'description' => "FTD Booking",
                    'transaction_date' => $transaction_date,
                    'transaction_type' => "debit",
                    'overdraft_amount_derived' => $bookedAmount,
                    'running_balance_derived' => $debitAmount,
                    'appuser_id' => $userId,
                    'debit' => $bookedAmount
                ];

                // dd($transactionRecords);
                // after collecting the details we then insert it into the db
                $recordTransaction = insert('account_transaction', $transactionRecords);
                if($recordTransaction){
                    $interestValue = ($intRate / 100) * $bookedAmount;
                    $ftdTermMonth = $ftdTerm / 30;
                    $interestAmount =  $interestValue / 12;
                    $i = 1;
                    while ($i <= $ftdTermMonth) {
                        $maturity_date = date('Y-m-d', strtotime('+'. $i * 30 .' Days', strtotime($transaction_date)));
                        echo $maturity_date . '</br>';
                        $scheduleData = [
                            'int_id' => $institutionId,
                            'branch_id' => $branchId,
                            'client_id' => $clientId,
                            'ftd_id' => $ftd_id,
                            'installment' => $bookedAmount,
                            'ftd_no' => $ftd_no,
                            'maturity_date' => $maturity_date,
                            'interest_rate' => $intRate,
                            'interest_amount' => $interestAmount,
                            'interest_repayment' => '0',
                            'linked_savings_account' => $linkedAccount
                        ];
                        $schedule = insert('ftd_interest_schedule', $scheduleData);
                        
                        if ($schedule) {
                            // success message
                            echo "Schedule created for " + $clientId;
                        }
                        $i++;

                        $updateFTD = mysqli_query($connection, "UPDATE ftd_booking_account SET status = 'Approved' WHERE id = '$ftd_id'");
                        if($updateFTD){
                            $_SESSION["Lack_of_intfund_$randms"] = "FTD approval Successful";
                            echo header("Location: ../../mfi/ftd_approval.php?message1=$randms");
                        }else{
                            // something is wrong... update not successful
                            $_SESSION["Lack_of_intfund_$randms"] = "Something is wrong! FTD status not changed";
                            echo header("Location: ../../mfi/ftd_approval.php?message7=$randms");       
                        }
                    }
                }
                else{
                    // something is wrong... transaction record not inserted into DB
                    $_SESSION["Lack_of_intfund_$randms"] = "Money deducted but record of transaction not stored";
                    echo header("Location: ../../mfi/ftd_approval.php?message6=$randms");
                }

            }else{
                // something is wrong... accounts table not updated hence 
                // money not deducted
                $_SESSION["Lack_of_intfund_$randms"] = "Money not deducted from account";
                echo header("Location: ../../mfi/ftd_approval.php?message4=$randms");
            }
            
        }else{
            // not enough money in linked account
            $_SESSION["Lack_of_intfund_$randms"] = "Not enough Money in Linked account!";
            echo header("Location: ../../mfi/ftd_approval.php?message3=$randms");    
        }
    }else{
        printf('Error: %s\n', mysqli_error($connection));//checking for errors
        exit();
    }

}else{
    $_SESSION["Lack_of_intfund_$randms"] = " Something is wrong with this FTD booking!";
    echo header("Location: ../../mfi/ftd_approval.php?message2=$randms");
}