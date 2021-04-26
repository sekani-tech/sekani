<?php

// something
include("../../../functions/connect.php");
// Try the sms api
session_start();
$int_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
$send_id = $_SESSION["sender_id"];
$phone = "07059658235";
$msg = "This Should be Final tests";
$client_id = $_POST["client_id"];
$account_no = $_POST["account_no"];
// quick test
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
// end
if ($send_id != "" && $phone != "" && $msg != "" && $int_id != "" && $branch_id != "") {
    // AIIT MAKING A 
// // echo $int_id;
// $bvn = $_POST["bvn"];
// $dob = $_POST["dob"];
// $check_DOB = date('d-F-y', strtotime($dob));
// MOVING TO THE NEXT
    $phone_length = strlen($phone);
// CHECK
    if($phone_length == 11){
        $phone =  substr($phone, 1);
        $phone = "234" . $phone;
    }
    if ($phone_length == 10) {
//    make phone have number
        $phone = "234" . $phone;
    }
    // sender ID
    $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
    $qw = mysqli_fetch_array($sql_fund);
    $balance = 50;
    $total_with = $qw["total_withdrawal"];
    $total_int_profit = $qw["int_profit"];
    $total_sekani_charge = $qw["sekani_charge"];
    $total_merchant_charge = $qw["merchant_charge"];
    if ($balance >= 4) {
        // start
        // make it possible
       $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://sms.vanso.com//rest/sms/submit',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "account": {
                "password": "kwPPkiV4",
                "systemId": "NG.102.0421"
                },
                "sms": {
                    "dest":"'.$phone.'",
                    "src": "'.$send_id.'",
                    "text": "'.$msg.'",
                    "unicode": true
                }

            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic TkcuMTAyLjA0MjE6a3dQUGtpVjQ='
            ),
        ));

         echo $response = curl_exec($curl);

// success
        $err = curl_close($curl);
        if ($err) {
            //    echo "cURL Error #:" . $err;
            echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "CONNECTION ERROR",
            text: "TIMED OUT",
            showConfirmButton: false,
            timer: 3000
        })
        document.getElementById("cbvn").setAttribute("hidden", "");
        document.getElementById("wbvn").removeAttribute("hidden");
        $(":input[type=submit]").prop("disabled", true);
    });
    </script>
    ';
            echo "NO INTERNET CONNECTION";
        } else {
// echo $response;
            $obj = json_decode($response, TRUE);
            $status = $obj['response'];
            if ($status != "") {
                // make a post online
                $cal_bal = $balance - 4;
                $cal_with = $total_with + 4;
                $cal_sek = $total_sekani_charge + 0;
                $cal_mch = $total_merchant_charge + 4;
                $cal_int_prof = $total_int_profit + 0;
                $digits = 9;
                $date = date("Y-m-d");
                $date2 = date('Y-m-d H:i:s');
                $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                $trans = "SKWAL" . $randms . "SMS" . $int_id;
                // end making a post online
                $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET sms_balance = '$cal_bal', total_withdrawal = '$cal_with',
    int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
                if ($update_transaction) {
                    // update
                    $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
        `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
        `int_profit`, `sekani_charge`, `merchant_charge`)
         VALUES ('{$int_id}', '{$branch_id}', '{$trans}', 'SMS charge', 'sms', NULL, '0', '{$date}', '4', '{$cal_bal}', '{$cal_bal}', {$date}, 
         NULL, NULL, '{$date2}', '0', '0.00', '4.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
                    if ($insert_transaction) {
                        //  get the transaction.
                        $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$int_id}', '{$branch_id}', '{$trans}', '{$client_id}', '{$account_no}', '4', '{$date}')");
                        if ($insert_qualif) {
                            echo "WE ARE GOOD NOW";
                        } else {
                            echo "NOT DONE";
                        }
                    } else {
                        echo "ERROR IN RECORED TRANSACTION";
                    }
                } else {
                    echo "ERROR IN UPDATE TRANSACTION";
                }
            }
            if ($status == "Success") {
                // end
                echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Message sent Successfully! - ' . $status . '",
            text: "SMS HAS BEEN SENT",
            showConfirmButton: false,
            timer: 3000
        });
        document.getElementById("print_disco").setAttribute("hidden", "");
    });
    </script>
    ';
                echo "SUCCESSFUL";
            } else {
                echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Status Error! - ' . $status . '",
            text: "API error",
            showConfirmButton: false,
            timer: 3000
        });
    });
    </script>
    ';
                echo "API STATUS ERROR";
            }
        }
        // end
    } else {
        echo "INSUFFICIENT WALLET BALANCE";
    }

    // end
} else {
    // echo Error
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "No Data",
            text: "Input Data",
            showConfirmButton: false,
            timer: 3000
        });
    });
    </script>
    ';
}