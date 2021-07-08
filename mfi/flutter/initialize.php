<?php
include('../../functions/connect.php');
session_start();

    $amount = $_POST["amt"];
    $trans = $_POST["trans"];
    $desct = $_POST["desc"];
    $int_id = $_POST["int_id_transaction"];
    // GET INT (CALL BACK)
    $int_call_back = mysqli_query($connection, "SELECT payment_callback FROM `institutions` WHERE int_id = '$int_id'");
    if (mysqli_num_rows($int_call_back) > 0) {
      $xcb = mysqli_fetch_array($int_call_back);
      $payment_callback = $xcb['payment_callback'];
      // Check for if call back is null
      if ($payment_callback ==  NULL) {
        header('Location: ../sekani_wallet.php');
      }
    } else {
      echo "Institution Found";
    }
    $email = $_SESSION["int_email"];
    $firstname = $_SESSION["int_name"];
    $int_logo = $_SESSION["int_logo"];
    $int_phone = $_SESSION["int_phone"];
    $username = $_SESSION["username"];
    $user_id = $_SESSION["user_id"];
    $wallet_type = $_POST["wallet"];
    // SESSION THE AMOUNT
    $datetime = date('Y-m-d H:i:s');

  $curl = curl_init();

  // PUSHING
$store_transaction = mysqli_query($connection, "INSERT INTO `wallet_transaction_cache` (`int_id`, `user_id`, `reference`, `amount`, `wallet_type`, `description`, `datetime`, `status`) VALUES ('{$int_id}', '{$user_id}', '{$trans}', '{$amount}', '{$wallet_type}', '{$desct}', '{$datetime}', 'Pending')");

if ($store_transaction) {
  
// url to go to after payment
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n   \"tx_ref\":\"$trans\",\r\n   \"amount\":\"$amount\",\r\n   \"currency\":\"NGN\",\r\n   \"redirect_url\":\"$payment_callback\",\r\n   \"payment_options\":\"card\",\r\n   \"customer\":{\r\n      \"email\":\"$email\",\r\n      \"phonenumber\":\"$int_phone\",\r\n      \"name\":\"$username\"\r\n   },\r\n   \"customizations\":{\r\n      \"title\":\"Institution Account Refill\",\r\n      \"description\":\"Refilling the sekani wallet\",\r\n      \"logo\":\"$int_logo\"\r\n   }\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer FLWSECK-2e1fc0c6b08527b62b30f752405be2f2-X",
    "Content-Type: application/json"
  ),
));
// holla
$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response, true);

if($tranx['status'] != "success"){
  // there was an error from the API
  print_r('API returned error: ' . $tranx['message']);
}

// comment out this line if you want to redirect the user to the payment page
print_r($tranx);
// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
header('Location: ' . $tranx['data']['link']);
} else {
  echo  "ERROR OCCURED WHILE TRYING TO INITIALIZE TRANSACTION";
}
?>