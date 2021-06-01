<?php

include("../../../functions/connect.php");

// Collect session data
session_start();
$institutionId = $_SESSION["int_id"];
$branchId = $_SESSION["branch_id"];
$senderId = $_SESSION['sender_id'];

// collect clien Post data
$mobileNo = $_POST['phone'];
$clientId = $_POST["client_id"];
$accountNo = $_POST["account_no"];
$msg = $_POST['msg'];
$escape = mysqli_real_escape_string($connection, $msg);

if ($senderId != "" && $mobileNo != "" && $msg != "" && $senderId != "" && $branchId != "") {
    // Check the length of the phone numer
    // if 10 add country code
    $phoneLength = strlen($mobileNo);
    if ($phoneLength == 10) {
      $clientPhone = "234" . $mobileNo;
    }
    if ($phoneLength == 11) {
      $phone =  substr($mobileNo, 1);
      $clientPhone = "234" . $phone;
    }
    $testData = [
      'int_id' => $senderId,
      'texts' => $clientPhone,
      'number' => $mobileNo
    ];
    $insertTest = insert('test_data', $testData);
    $condition = [
        'int_id' => $senderId
    ];
    $walletData = selectOne('sekani_wallet', $condition);
    if(!$walletData) {
       printf("Error: \n", mysqli_error($connection));//checking for errors
       exit();
    }
    $walletId = $walletDatas["id"];
    $smsBalance = $walletData["sms_balance"];
    $total_with = $walletData["total_withdrawal"];
    $total_int_profit = $walletData["int_profit"];
    $total_sekani_charge = $walletData["sekani_charge"];
    $total_merchant_charge = $walletDatas["merchant_charge"];
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
          $trans = "SKWAL" . $randms . "SMS" . $senderId;
          $updateValue = [
            'sms_balance' => $cal_bal, 
            'total_withdrawal' => $cal_with,
            'int_profit' => $cal_int_prof, 
            'sekani_charge' => $cal_sek, 
            'merchant_charge' => $cal_mch
          ];
          $updateWalllet = update('sekani_wallet', $walletId, 'id', $updateValue);
        //   $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET sms_balance = '$cal_bal', total_withdrawal = '$cal_with',
        //   int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$senderId' AND branch_id = '$branchId'");
          if ($updateWalllet) {
            // inserting record of transaction.
            $transactionData = [
                `int_id` => $institutionId, 
                `branch_id` => $branchId, 
                `transaction_id` => $trans, 
                `description` => "SMS charge", 
                `transaction_type` => "sms", 
                `teller_id` => NULL, 
                `is_reversed` => 0, 
                `transaction_date` => $date, 
                `amount` => 4, 
                `wallet_balance_derived` => $cal_bal, 
                `overdraft_amount_derived` => $cal_bal, 
                `balance_end_date_derived` => $date,
                `balance_number_of_days_derived` => null, 
                `cumulative_balance_derived` => null, 
                `created_date` => $date2, 
                `manually_adjusted_or_reversed` => 0, 
                `credit` => "0.00", 
                `debit` => "4.00",
                `int_profit` => $cal_int_prof, 
                `sekani_charge` => $cal_sek, 
                `merchant_charge` => $cal_mch
            ];
            $insert_transaction = insert('sekani_wallet_transaction', $transactionData);
            // $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
            // `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
            // `int_profit`, `sekani_charge`, `merchant_charge`)
            // VALUES ('{$senderId}', '{$branchId}', '{$trans}', 'SMS charge', 'sms', NULL, '0', '{$date}', '4', '{$cal_bal}', '{$cal_bal}', {$date}, 
            // NULL, NULL, '{$date2}', '0', '0.00', '4.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
            if ($insert_transaction) {
              // store SMS charge
              $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$senderId}', '{$branchId}', '{$trans}', '{$client_id}', '{$acct_no}', '4', '{$date}')");
            }else {
                printf("'Error: \n'", mysqli_error($connection));//checking for errors
            exit();
            }
          } else {  
            printf("'Error: \n'", mysqli_error($connection));//checking for errors
            exit();
          }
        }
      }
    }
  }