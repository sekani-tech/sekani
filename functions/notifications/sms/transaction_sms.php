<?php

if (isset($_POST['account_no']) && isset($_POST['balance']) && isset($_POST['trans_type']) && isset($_POST['amount'])) {
    // collect and intialize post data
    $accountNo = $_POST['account_no'];
    $transType = $_POST['trans_type'];
    $currentAccountBalance = $_POST['balance'];
    $amount = $_POST['amount'];
    $description = $_POST['desc'];
    $today = date('Y-m-d h:i:sa');

    $balance = number_format($currentAccountBalance, 2);
    $msg = "Acct: " . appendAccountNo($accountNo, 6) . "\nAmt: NGN " . number_format($amount, 2) . " " . $transType . "\nDesc: " . $description . "\nAvail Bal: " . $balance . "\nDate: " . $today;
    // creating unique message ID
    $digits = 9;
    $messageId = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
    // check for needed values
    // if exists proceed to send SMS
    if ($sender_id != "" && $client_phone != "" && $msg != "" && $sessint_id != "" && $branch_id != "") {
        // Check the length of the phone numer
        // if 10 add country code
        $phoneLength = strlen($client_phone);
        if ($phoneLength == 10) {
            $clientPhone = "234" . $client_phone;
        }
        if ($phoneLength == 11) {
            $phone =  substr($client_phone, 1);
            $clientPhone = "234" . $phone;
        }
        $testData = [
            'int_id' => $sessint_id,
            'texts' => $clientPhone,
            'number' => $client_phone
        ];
        $insertTest = insert('test_data', $testData);
        $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$sessint_id'");
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
            } else {
                $obj = json_decode($response, TRUE);
                $status = $obj['response'];
                // check for success response
                if ($status != "") {
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
                    $trans = "SKWAL" . $randms . "SMS" . $sessint_id;
                    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET sms_balance = '$cal_bal', total_withdrawal = '$cal_with',
                                  int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$sessint_id' AND branch_id = '$branch_id'");
                    if ($update_transaction) {
                        // inserting record of transaction.
                        $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                                    `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
                                    `int_profit`, `sekani_charge`, `merchant_charge`)
                                    VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', 'SMS charge', 'sms', NULL, '0', '{$date}', '4', '{$cal_bal}', '{$cal_bal}', {$date}, 
                                    NULL, NULL, '{$date2}', '0', '0.00', '4.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
                        if ($insert_transaction) {
                            // store SMS charge
                            $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', '{$client_id}', '{$accountNo}', '4', '{$date}')");
                        }
                    }
                }
            }
        }
    }
    #ends here
}
