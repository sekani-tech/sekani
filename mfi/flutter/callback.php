<?php
// going good
include("../../functions/connect.php");
// CURL
$curl = curl_init();
$reference = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '';
if(!$reference){
  echo header("Location: ../sekani_wallet.php");
  die('No reference supplied');
} else {
  echo "...";
}
// CHECK FLUTTER
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/".rawurlencode($reference)."/verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer FLWSECK-2e1fc0c6b08527b62b30f752405be2f2-X"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
    // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}

if('success' == $tranx->status){
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
  echo "<h2>Processing....</h2>";
//   STORE THE TRANSACTION - GET THE INT_ID AND OTHER STUDDS
session_start();
// $int_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
if ($branch_id == NULL) {
  $branch_id = 1;
}
// $amount = $_SESSION["amount"];
// $trans = $_SESSION["transaction_id"];
// $desc = $_SESSION["desc"];

$query_transaction_query = mysqli_query($connection, "SELECT * FROM wallet_transaction_cache WHERE reference = '$reference' AND status = 'Pending'");

if (mysqli_num_rows($query_transaction_query) > 0) {

  $rowe = mysqli_fetch_array($query_transaction_query);
  $id = $rowe["id"];
  $int_id = $rowe["int_id"];
  $amount = $rowe["amount"];
  $wallet_type = $rowe["wallet_type"];
  $desc = $rowe["description"];
  $trans = $rowe["reference"];

  // Define Type of Transaction
  if ($wallet_type == "sms") {
    $sms_amount = $amount;
    $bvn_amount = 0;
    $bills_amount = 0;
    $pay_desc = "SMS REFILL";
  } else if ($wallet_type == "bvn") {
    $sms_amount = 0;
    $bvn_amount = $amount;
    $bills_amount = 0;
    $pay_desc = "BVN REFILL";
  } else if ($wallet_type == "bills") {
    $sms_amount = 0;
    $bvn_amount = 0;
    $bills_amount = $amount;
    $pay_desc = "BILLS REFILL";
  }

$date = date('Y-m-d');
$date2 = date('Y-m-d H:i:s');

// CHECK IF SAME REFERENC
$select_wallet = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
$xm = mysqli_fetch_array($select_wallet);
$sms_balance = $xm["sms_balance"] + $sms_amount;
$bvn_balance = $xm["bvn_balance"] + $bvn_amount;
$bills_balance = $xm["bills_balance"] + $bills_amount;

// REFILL FOR BALANCE
if ($wallet_type == "sms") {
  $general_balance = $xm["sms_balance"] + $sms_amount;
} else if ($wallet_type == "bvn") {
  $general_balance = $xm["bvn_balance"] + $sms_amount;
} else if ($wallet_type == "bills") {
  $general_balance = $xm["bills_balance"] + $bills_amount;
}
$total_deposit = $xm["total_deposit"];
// CALCULATED BALANCES
$tot_dep = $tot_dep + $amount;
$select_transaction = mysqli_query($connection, "SELECT * FROM `sekani_wallet_transaction` WHERE transaction_id	= '$trans'");
$num_t = mysqli_num_rows($select_transaction);
if ($num_t <= 0) {
$update_wallet = mysqli_query($connection, "UPDATE sekani_wallet SET sms_balance = '$sms_balance', bvn_balance = '$bvn_balance', bills_balance = '$bills_balance' total_deposit = '$tot_dep' WHERE int_id = '$int_id'");
if ($update_wallet) {
    $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
    `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`)
     VALUES ('{$int_id}', '{$branch_id}', '{$trans}', '{$desc}', '{$pay_desc}', NULL, '0', '{$date}', '{$amount}', '{$general_balance}', '{$general_balance}', {$date}, 
     NULL, NULL, '{$date2}', '0', '{$amount}', '0.00')");
     if ($insert_transaction) {
        //  destroy ref, amount and descriptiomn
        //  ------
        echo header("Location: ../sekani_wallet.php");
        // redirect
     } else {
         echo "ERROR IN TRANSACTION";
     }
} else {
    echo "CANT UPDATE WALLET";
}
} else {
    echo "PAID ALREADY";
}
} else {
  echo "Cant Find Transaction";
  echo header("Location: ../sekani_wallet.php?message=NoTransactionFound");
  die('No reference supplied');
  
}

}
// OUT IN THE EAST
?>