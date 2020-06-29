<?php
session_start();

    $amount = $_POST["amt"];
    $trans = $_POST["trans"];
    $desct = $_POST["desc"];
    $email = $_SESSION["int_email"];
    $firstname = $_SESSION["int_name"];
    // SESSION THE AMOUNT
    // SESSION THE DESCRIPTION
    $_SESSION["amount"] = $amount;
    $_SESSION["transaction_id"] = $trans;
    $_SESSION["desc"] = $desct;

  $curl = curl_init();

// url to go to after payment
$callback_url = 'https://app.sekanisystems.com.ng/mfi/paystack/callback.php';  

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount * 100,
    'email'=>$email,
    'firstname'=>$firstname,
    'reference'=>$trans,
    'callback_url' => $callback_url
  ]),
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer sk_live_6a0c005846f82f326365635f8270ad3b2c34536e", //replace this with your own test key
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response, true);

if(!$tranx['status']){
  // there was an error from the API
  print_r('API returned error: ' . $tranx['message']);
}

// comment out this line if you want to redirect the user to the payment page
print_r($tranx);
// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
header('Location: ' . $tranx['data']['authorization_url']);
?>