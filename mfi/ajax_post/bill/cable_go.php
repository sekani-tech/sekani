<?php
// making a good move
include("../../../functions/connect.php");
// porty
session_start();
$int_id = $_SESSION["int_id"];
$int_name = $_SESSION["int_name"];
$branch_id = $_SESSION["branch_id"];
$sender_id = $_SESSION["sender_id"];
$type = $_POST["cable"];
$smart = $_POST["smart"];
$customerName = $_SESSION["customerName"];
$packagename = $_SESSION["packagename"];
$amount = $_SESSION["price"];
$productsCode = $_SESSION["code"];
$period = $_SESSION["period"];
// MAD
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// end the code
// end
if ($type != "" && $smart != "" && $productsCode != "" && $amount != "" && $int_id != "" && $branch_id != "") {
    // finnin
    $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
        $qw = mysqli_fetch_array($sql_fund);
        $balance = $qw["running_balance"];
        $total_with = $qw["total_withdrawal"];
        $total_int_profit = $qw["int_profit"];
        $total_sekani_charge = $qw["sekani_charge"];
        $total_merchant_charge = $qw["merchant_charge"];
        // test
        if ($balance >= $amount) {
            // STAT API
            $curl = curl_init();
            // soon
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://shagopayments.com/api/live/b2b",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"GDB\",\r\n\"smartCardNo\" : \"$smart\",\r\n\"customerName\": \"$customerName\",\r\n\"type\" : \"$type\",\r\n\"amount\": \"$amount\",\r\n\"packagename\" : \"$packagename\",\r\n\"productsCode\": \"$productsCode\",\r\n\"period\": \"$period\",\r\n\"hasAddon\" : \"0\",\r\n\"request_id\": \"$randms\"\r\n}",
  CURLOPT_HTTPHEADER => array(
    "hashKey: ddceb2126614e2b4aec6d0d247e17f746de538fef19311cc4c3471feada85d30",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);  
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
        // making a nextweek
        // make 
$obj = json_decode($response, TRUE);
$status = $obj['status'];
$msg = $obj['message'];
// repsonse working up.
$transId = $obj['transId'];
$type = $obj['type'];
$package = $obj['package'];
$amount = $obj['amount'];
// make a move | qwerty
if ($status == "200" && $status != "") {
    // alright
    $cal_bal = $balance - $amount;
    $cal_with = $total_with + $amount;
    $cal_sek = $total_sekani_charge + 0;
    $cal_mch = $total_merchant_charge + $amount;
    $cal_int_prof = $total_int_profit + 0;
    $digits = 9;
    $date = date("Y-m-d");
    $date2 = date('Y-m-d H:i:s');
    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    $trans = "SKWAL".$randms."DISCO".$int_id;
    // GD
    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET running_balance = '$cal_bal', total_withdrawal = '$cal_with',
    int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
    if ($update_transaction) {
        // WE ARE DONE
        $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
        `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
        `int_profit`, `sekani_charge`, `merchant_charge`)
         VALUES ('{$int_id}', '{$branch_id}', '{$trans}', 'SMART CARD: $smart, TRANS: $transId, Package: $package', 'bill_cable', NULL, '0', '{$date}', '{$amount}', '{$cal_bal}', '{$cal_bal}', {$date}, 
         NULL, NULL, '{$date2}', '0', '0.00', '{$amount}', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
         if ($insert_transaction) {
            //  go withdra
            echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Paid - '.$msg.'",
            text: "TRANS: '.$transId.' - AMOUNT: '.$amount.' - PACKAGE: '.$packagename.'",
            showConfirmButton: false,
            timer: 6000
        });
    });
    </script>
    ';
         } else {
            //  NOTHING AT ALL
            echo "ERROR IN TRANSACTION";
         }
    } else {
        // NOTHING AT ALL
        echo "ERROR IN WALLET";
    }
} else {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error Message - '.$msg.'",
            text: "DATA ERROR",
            showConfirmButton: false,
            timer: 5000
        });
    });
    </script>
    ';
}
    }
        } else {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "INSUFFICIENT FUND",
                    text: "REFILL YOUR WALLET",
                    showConfirmButton: false,
                    timer: 3000
                });
            });
            </script>
            ';
        }
}
?>