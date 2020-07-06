<?php
// going good
include("../../functions/connect.php");
// CURL
$curl = curl_init();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer sk_live_626100308622d4ecd00a6bcf0a95d1b452b9306a",
    "cache-control: no-cache"
  ],
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

if('success' == $tranx->data->status){
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
$update_wallet = mysqli_query($connection, "UPDATE sekani_wallet SET running_balance = '$run_bal', total_deposit = '$tot_dep'");
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