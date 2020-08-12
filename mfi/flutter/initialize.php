<?php
session_start();

    $amount = $_POST["amt"];
    $trans = $_POST["trans"];
    $desct = $_POST["desc"];
    $email = $_SESSION["int_email"];
    $firstname = $_SESSION["int_name"];
    $int_logo = $_SESSION["int_logo"];
    $int_phone = $_SESSION["int_phone"];
    $username = $_SESSION["username"];
    // SESSION THE AMOUNT
    // SESSION THE DESCRIPTION
    $_SESSION["amount"] = $amount;
    $_SESSION["transaction_id"] = $trans;
    $_SESSION["desc"] = $desct;

  $curl = curl_init();

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
  CURLOPT_POSTFIELDS =>"{\r\n   \"tx_ref\":\"$trans\",\r\n   \"amount\":\"$amount\",\r\n   \"currency\":\"NGN\",\r\n   \"redirect_url\":\"https://app.sekanisystems.com.ng/mfi/flutter/callback.php\",\r\n   \"payment_options\":\"card\",\r\n   \"customer\":{\r\n      \"email\":\"$email\",\r\n      \"phonenumber\":\"$int_phone\",\r\n      \"name\":\"$username\"\r\n   },\r\n   \"customizations\":{\r\n      \"title\":\"Institution Account Refill\",\r\n      \"description\":\"Refilling the sekani wallet\",\r\n      \"logo\":\"$int_logo\"\r\n   }\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer FLWSECK-2e1fc0c6b08527b62b30f752405be2f2-X",
    "Content-Type: application/json"
  ),
));

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
?>