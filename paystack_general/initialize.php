<?php
    $amount = $_POST["amt"];
    $trans = $_POST["trans"];
    $email = "techsupport@sekanisystems.com.ng";
    $firstname = "SEKANI REFILL";
    // SESSION THE AMOUNT

  $curl = curl_init();

// url to go to after payment
$callback_url = 'https://app.sekanisystems.com.ng/paystack_general/callback.php';  

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
    "authorization: Bearer sk_live_5bbf0cb5832fbdd35b07a53baaa495b6c62dba8b", //replace this with your own test key
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