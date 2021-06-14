<?php
include("../../connect.php");
// session_start();
// $institutionId = $_SESSION['int_id'];
$today = date("Y-m-d");

if (isset($_POST['account_no']) && isset($_POST['amount']) && isset($_POST['description'])) {
    $accountNo = $_POST['account_no'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $transactionId = $_POST['transaction_id'];
    $institutionId = $_POST['int_id'];
    $branchId = $_POST['branch_id'];
    $transactionDate = $_POST['trans_date'];
    $userId = $_POST['user_id'];
    #process begins
    // collect transaction details
    $accountConditions = [
        'account_no' => $accountNo,
        'int_id' => $institutionId
    ];
    $accountDetails = selectOne('account', $accountConditions);
    if (!$accountDetails) {
        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
        exit();
        // send them back
    }
    $accountBalance = $accountDetails['account_balance_derived'];
    $accountId = $accountDetails['id'];
    $productID = $accountDetails['product_id'];
    $clientId = $accountDetails['client_id'];
    $depositBlance = $accountDetails['total_deposits_derived'];
    $newBalance = $accountBalance + $amount;
    $newDepositBalnce = $depositBlance + $amount;
    // Begin transaction
    $debitUpdatedData = [
        'account_balance_derived' => $newBalance,
        'total_withdrawals_derived' => $newDepositBalnce,
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
            'transaction_date' => $transactionDate,
            'overdraft_amount_derived' => $amount,
            'running_balance_derived' => $newBalance,
            'cumulative_balance_derived' => $newBalance,
            'appuser_id' => $userId,
            'debit' => $amount,
            'created_date' => $today
        ];

        $storeDebitTransaction =  insert('account_transaction', $debitTransactionDetails);
        if (!$storeDebitTransaction) {
            $output = "Error: %s\n" . mysqli_error($connection); //checking for errors\
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
            $newGlBalnce = $glBalance + $amount;
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
                    'transaction_type' => "credit",
                    'transaction_date' => $transactionDate,
                    'amount' => $amount,
                    'gl_account_balance_derived' => $newGlBalnce,
                    'overdraft_amount_derived' => $amount,
                    'cumulative_balance_derived' => $newGlBalnce,
                    'credit' => $amount
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
            $findInsitution = selectOne('institutions', ['int_id' => $institutionId]);
            $senderId = $findInsitution['sender_id'];
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
}

echo $output;