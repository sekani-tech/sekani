<?php
// going good
include("../../functions/connect.php");
// CURL
$curl = curl_init();
$reference = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '';
if(!$reference){
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
    "Authorization: Bearer FLWSECK_TEST-f5c2cd0e4248224ab1ca2311e9d6241b-X"
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
$int_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
$amount = $_SESSION["amount"];
$trans = $_SESSION["transaction_id"];
$desc = $_SESSION["desc"];
$date = date('Y-m-d');
$date2 = date('Y-m-d H:i:s');

// CHECK IF SAME REFERENC
$select_wallet = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
$xm = mysqli_fetch_array($select_wallet);
$running_balance = $xm["running_balance"];
$total_deposit = $xm["total_deposit"];
// CALCULATED BALANCES
$run_bal = $running_balance + $amount;
$tot_dep = $tot_dep + $amount;
$select_transaction = mysqli_query($connection, "SELECT * FROM `sekani_wallet_transaction` WHERE transaction_id	= '$trans'");
$num_t = mysqli_num_rows($select_transaction);
if ($num_t <= 0) {
$update_wallet = mysqli_query($connection, "UPDATE sekani_wallet SET running_balance = '$run_bal', total_deposit = '$tot_dep' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
if ($update_wallet) {
    $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
    `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`)
     VALUES ('{$int_id}', '{$branch_id}', '{$trans}', '{$desc}', 'refill', NULL, '0', '{$date}', '{$amount}', '{$run_bal}', '{$run_bal}', {$date}, 
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
    ?>
    <a href="https://app.sekanisystems.com.ng/mfi/sekani_wallet" >CLICK ME</a>
    <?php
}
}
// OUT IN THE EAST
?>