<?php

include("../../connect.php");
session_start();
echo $today = Date('Y-m-d H.i.s');
echo "<br>";
$institutionId = $_SESSION["int_id"];
$userId = $_SESSION["user_id"];
$branch_id = $_SESSION["branch_id"];
$sender_id = $_SESSION["sender_id"];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
// first find if the user is given the autorithy to do this

if (isset($_POST['message']) && isset($_POST['phone_no'])) {
    $message = mysqli_real_escape_string($connection, $_POST['message']);

    
        // concatenate customers phone numbers
        $phone_length = strlen($phoneNumbers['mobile_no']);
        // CHECK
        if ($phone_length == 11) {
            $phone =  substr($phoneNumbers['mobile_no'], 1);
            echo $phone = "234" . $phone;
            echo "<br>";
        }
        if ($phone_length == 10) {
            //    make phone have number
            echo $phone = "234" . $phoneNumbers['mobile_no'];
            echo "<br>";
        }

        if ($phone != "") {
            $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$institutionId'");
            $qw = mysqli_fetch_array($sql_fund);
            $smsBalance = $qw["sms_balance"];
            $total_with = $qw["total_withdrawal"];
            $total_int_profit = $qw["int_profit"];
            $total_sekani_charge = $qw["sekani_charge"];
            $total_merchant_charge = $qw["merchant_charge"];
            if ($smsBalance >= 4) {

                $curl = curl_init();
                $escape = mysqli_real_escape_string($connection, $message);

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
                                                      "dest":"' . $phone . '",
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


                echo $response = curl_exec($curl);
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
                        'branch_id' => $branch_id,
                        'mobile_no' => $phone,
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
                        $smsData = [
                            'int_id' => $institutionId,
                            'branch_id' => $branch_id,
                            'mobile_no' => $phone,
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
                                      int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$institutionId' AND branch_id = '$branch_id'");
                        if ($update_transaction) {
                            // inserting record of transaction.
                            $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                                        `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
                                        `int_profit`, `sekani_charge`, `merchant_charge`)
                                        VALUES ('{$institutionId}', '{$branch_id}', '{$trans}', 'SMS charge', 'sms', NULL, '0', '{$date}', '4', '{$cal_bal}', '{$cal_bal}', {$date}, 
                                        NULL, NULL, '{$date2}', '0', '0.00', '4.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
                            if ($insert_transaction) {
                                // store SMS charge
                                $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$institutionId}', '{$branch_id}', '{$trans}', '{$client_id}', '{$acct_no}', '4', '{$date}')");
                            }
                        }
                    }
                }
            }
        }
        
} else {
    $_SESSION["feedback"] = "Message can not be empty";
    $_SESSION["Lack_of_intfund_$randms"] = "1";
    // echo header("Location: ../../../mfi/alerts_sms.php?message1=$randms");
    exit();
    // no data was posted
}