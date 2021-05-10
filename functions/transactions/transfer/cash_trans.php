<?php
include("../../connect.php");
session_start();
?>

<?php
// Session data declaration
$emailu = $_SESSION["email"];
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$institutionId = $_SESSION["int_id"];
$sender_id = $_SESSION["sender_id"];
$nm = $_SESSION["username"];
$institutionId = $_SESSION['int_id'];
$user_id = $_SESSION["user_id"];
$digits = 6;
$today = date('Y-m-d');
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
$getacct1 = mysqli_query($connection, "SELECT * FROM staff WHERE user_id = '$user_id' && int_id = '$institutionId'");
if (count([$getacct1]) == 1) {
    $uw = mysqli_fetch_array($getacct1);
    $staff_id = $uw["id"];
    $staff_email = $uw["email"];
}
$taketeller = "SELECT * FROM tellers WHERE name = '$staff_id' && int_id = '$institutionId'";

if (isset($_GET['approve'])) {
    // Declaring Variables
    $cacheId = $_GET['approve'];
    $cacheConditions = [
        'id' => $cacheId,
        'status' => "Pending",
        'int_id' => $institutionId
    ];
    $cahcheDetails = selectOne('transfer_cache', $cacheConditions);
    if (!$cahcheDetails) {
        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry Transaction may already have been approved - " . $error;
        $_SESSION["Lack_of_intfund_$randms"] = "9";
        echo header("Location: ../../../mfi/transfer_approval.php?message9=$randms");
    }
    $transacionId = $cahcheDetails['transact_id'];
    $transferFrom = $cahcheDetails['trans_from'];
    $amount = $cahcheDetails['amount'];
    $transferTo = $cahcheDetails['trans_to'];
    $branchId = $cahcheDetails['branch_id'];
    $transactionDate = $cahcheDetails['trans_date'];


    $getacct1 = mysqli_query($connection, "SELECT * FROM staff WHERE user_id = '$userId' && int_id = '$institutionId'");
    if (count([$getacct1]) == 1) {
        $uw = mysqli_fetch_array($getacct1);
        $staff_id = $uw["id"];
        $staff_email = $uw["email"];
    }




    // find all sender info before procedding with transaction
    $senderConditions = [
        'account_no' => $transferFrom,
        'int_id' => $institutionId
    ];
    $senderDetails = selectOne('account', $senderConditions);
    if (!$senderDetails) {
        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry " . $transferFrom . " account not found - " . $error;
        $_SESSION["Lack_of_intfund_$randms"] = "8";
        echo header("Location: ../../../mfi/transfer_approval.php?message8=$randms");
        exit();
        // send them back
    }
    $senderAccountBalance = $senderDetails['account_balance_derived'];
    $senderAccountId = $senderDetails['id'];
    $senderproductID = $senderDetails['product_id'];
    $senderclientId = $senderDetails['client_id'];
    $senderWithrawalBlance = $senderDetails['total_withdrawals_derived'];
    $senderNewBalance = $senderAccountBalance - $amount;
    $senderNewWithdrwalBalnce = $senderWithrawalBlance + $amount;


    // receivers info
    $receiverConditions = [
        'account_no' => $transferTo,
        'int_id' => $institutionId
    ];
    $receiverDetails = selectOne('account', $receiverConditions);
    if (!$receiverDetails) {
        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry " . $transferTo . " account not found - " . $error;
        $_SESSION["Lack_of_intfund_$randms"] = "7";
        echo header("Location: ../../../mfi/transfer_approval.php?message7=$randms");
        exit();
        // send them back
    }
    $receiverAccountBalance = $receiverDetails['account_balance_derived'];
    $receiverAccountId = $receiverDetails['id'];
    $receiverproductID = $receiverDetails['product_id'];
    $receiverclientId = $receiverDetails['client_id'];
    $receiverDepositBalance = $receiverDetails['total_deposits_derived'];
    $receiverNewBalance = $receiverAccountBalance + $amount;
    $receiverDepositBalance = $receiverDepositBalance + $amount;
    // find senders' and  recevivers' name
    // create description and pull data for sms notfication
    $findSendersName = mysqli_query($connection, "SELECT display_name FROM client WHERE id = '$senderclientId'");
    $sender = mysqli_fetch_array($findSendersName);
    $fromName = $sender['display_name'];
    $fromSMSstatus = $sender['SMS_ACTIVE'];
    $fromPhoneNo = $sender['mobile_no'];
    $findReceiversName = mysqli_query($connection, "SELECT display_name FROM client WHERE id = '$receiverclientId'");
    $receiver = mysqli_fetch_array($findReceiversName);
    $toName = $receiver['display_name'];
    $toSMSstatus = $receiver['SMS_ACTIVE'];
    $toPhoneNo = $receiver['mobile_no'];
    $descriptionFrom = "Transfer frm " . $fromName . " to " . $toName;
    $descriptionTo = "Transfer to " . $toName . " frm " . $fromName;
    // we can now move on with the transactions
    // but first confirm is sender has enough money in thier account
    if ($senderAccountBalance >= $amount) {
        // continue transactions
        $senderUpdatedData = [
            'account_balance_derived' => $senderNewBalance,
            'total_withdrawals_derived' => $senderNewWithdrwalBalnce,
            'last_withdrawal' => $amount
        ];
        $updateSenderAccount =  update('account', $senderAccountId, 'id', $senderUpdatedData);
        if (!$updateSenderAccount) {
            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
            $_SESSION["feedback"] = $transferFrom . " account can not be DEBITED at the moment - " . $error;
            $_SESSION["Lack_of_intfund_$randms"] = "6";
            echo header("Location: ../../../mfi/transfer_approval.php?message6=$randms");
            exit();
            // send error could not update senders account
        } else {
            // store transaction data
            $senderTransactionDetails = [
                'int_id' => $institutionId,
                'branch_id' => $branchId,
                'amount' => $amount,
                'transaction_id' => $transacionId,
                'description' => $descriptionFrom,
                'account_no' => $transferFrom,
                'product_id' => $senderproductID,
                'client_id' => $senderclientId,
                'transaction_type' => "debit",
                'transaction_date' => $transactionDate,
                'overdraft_amount_derived' => $amount,
                'running_balance_derived' => $senderNewBalance,
                'cumulative_balance_derived' => $senderNewBalance,
                'appuser_id' => $userId,
                'debit' => $amount,
                'created_date' => $today
            ];

            $storeSenderTransaction =  insert('account_transaction', $senderTransactionDetails);
            if (!$storeSenderTransaction) {
                $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                $_SESSION["feedback"] = "Sorry Transaction incomplete " . $transferFrom . " DEBITED but trnasaction details not stored - " . $error;
                $_SESSION["Lack_of_intfund_$randms"] = "5";
                echo header("Location: ../../../mfi/transfer_approval.php?message5=$randms");
                exit();
            } else {
                // send debit alert to Sender
                if ($fromSMSstatus == 1) {
                    $balance = number_format($senderNewBalance, 2);
                    $msg = "Acct: " . appendAccountNo($accountNo, 6) . "\nAmt: NGN " . number_format($amount, 2) . " " . $transType . "\nDesc: " . $description . "\nAvail Bal: " . $balance . "\nDate: " . $today;
                    // creating unique message ID
                    $digits = 9;
                    $messageId = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                    // check for needed values
                    // if exists proceed to send SMS
                    if ($sender_id != "" && $fromPhoneNo != "" && $msg != "" && $institutionId != "" && $branchId != "") {
                        // Check the length of the phone numer
                        // if 10 add country code
                        $phoneLength = strlen($fromPhoneNo);
                        if ($phoneLength == 10) {
                            $clientPhone = "234" . $fromPhoneNo;
                        }
                        if ($phoneLength == 11) {
                            $phone =  substr($fromPhoneNo, 1);
                            $clientPhone = "234" . $phone;
                        }
                        // $testData = [
                        //     'int_id' => $institutionId,
                        //     'texts' => $clientPhone,
                        //     'number' => $client_phone
                        // ];
                        // $insertTest = insert('test_data', $testData);
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
                                                  "src": "' . $sender_id . '",
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
                //receivers transaction details
                $receiverUpdatedData = [
                    'account_balance_derived' => $receiverNewBalance,
                    'total_deposits_derived' => $receiverDepositBalance,
                    'last_deposit' => $amount
                ];
                $updateReceiverAccount =  update('account', $receiverAccountId, 'id', $receiverUpdatedData);
                if (!$updateReceiverAccount) {
                    $error = "Error: %s\n" . mysqli_error($connection); //checking for errors

                    $_SESSION["feedback"] = "Sorry can't credit " . $transferTo . " at the moment - " . $error;
                    $_SESSION["Lack_of_intfund_$randms"] = "4";
                    echo header("Location: ../../../mfi/transfer_approval.php?message4=$randms");
                    exit();
                } else {
                    // store revecivers transaction
                    $receiverTransactionDetails = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'amount' => $amount,
                        'transaction_id' => $transacionId,
                        'description' => $descriptionTo,
                        'account_no' => $transferTo,
                        'product_id' => $receiverproductID,
                        'client_id' => $receiverclientId,
                        'transaction_type' => "credit",
                        'transaction_date' => $transactionDate,
                        'overdraft_amount_derived' => $amount,
                        'running_balance_derived' => $receiverNewBalance,
                        'cumulative_balance_derived' => $receiverNewBalance,
                        'appuser_id' => $userId,
                        'credit' => $amount,
                        'created_date' => $today
                    ];

                    $storeReceiverTransaction =  insert('account_transaction', $receiverTransactionDetails);
                    if (!$storeReceiverTransaction) {
                        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                        // could not store receivers transaction
                        // otherwise transaction sucessful
                        $_SESSION["feedback"] = "Transaction Successful, could not store receivers transaction - $error";
                        $_SESSION["Lack_of_intfund_$randms"] = "2";
                        echo header("Location: ../../../mfi/transfer_approval.php?message1=$randms");
                        exit();
                    } else {
                        // send debit alert to Sender
                        if ($toSMSstatus == 1) {
                            $balance = number_format($receiverNewBalance, 2);
                            $msg = "Acct: " . appendAccountNo($transferTo, 6) . "\nAmt: NGN " . number_format($amount, 2) . " " . $transType . "\nDesc: " . $description . "\nAvail Bal: " . $balance . "\nDate: " . $today;
                            // creating unique message ID
                            $digits = 9;
                            $messageId = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                            // check for needed values
                            // if exists proceed to send SMS
                            if ($sender_id != "" && $toPhoneNo != "" && $msg != "" && $institutionId != "" && $branchId != "") {
                                // Check the length of the phone numer
                                // if 10 add country code
                                $phoneLength = strlen($toPhoneNo);
                                if ($phoneLength == 10) {
                                    $clientPhone = "234" . $toPhoneNo;
                                }
                                if ($phoneLength == 11) {
                                    $phone =  substr($toPhoneNo, 1);
                                    $clientPhone = "234" . $phone;
                                }
                                // $testData = [
                                //     'int_id' => $institutionId,
                                //     'texts' => $clientPhone,
                                //     'number' => $client_phone
                                // ];
                                // $insertTest = insert('test_data', $testData);
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
                                                  "src": "' . $sender_id . '",
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
                                                    $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$institutionId}', '{$branchId}', '{$trans}', '{$receiverclientId}', '{$transferTo}', '4', '{$date}')");
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        #ends here
                        // output success message
                        $updateApprovalData = [
                            'status' => "Approved"
                        ];
                        $updateApproval =  update('transfer_cache', $cacheId, 'id', $updateApprovalData);
                        if (!$updateApproval) {
                            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                            $_SESSION["feedback"] = "Transaction Successful but approval status not changed - $error";
                            $_SESSION["Lack_of_intfund_$randms"] = "1";
                            echo header("Location: ../../../mfi/transfer_approval.php?message3=$randms");
                            exit();
                        } else {
                            $_SESSION["feedback"] = "Transaction Successful";
                            $_SESSION["Lack_of_intfund_$randms"] = "1";
                            echo header("Location: ../../../mfi/transfer_approval.php?message0=$randms");
                        }
                    }
                }
            }
        }
    } else {
        // send back inssuficient funds feedback message
        $_SESSION["feedback"] = "Insufficent Funds in Client Account";
        $_SESSION["Lack_of_intfund_$randms"] = "2";
        echo header("Location: ../../../mfi/transfer_approval.php?message2=$randms");
    }
    # !ends here

    #isset ends here

} else if (isset($_GET['decline'])) {
    $fdf = $_GET['decline'];
    $we = mysqli_query($connection, "UPDATE transfer_cache SET status = 'Declined' WHERE id = '$fdf'");
    if ($we) {
        $_SESSION["feedback"] = "Successfully Declined";
        $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
        echo header("Location: ../../../mfi/transfer_approval.php?message10=$randms");
    }
}
?>
