<?php
class Sekani{
    // define class path
function airtimex(){
  include('../../functions/connect.php');
        // get all the vaule to Shago
        $phone = $this->phone;
        $amount = $this->amount;
        $network = $this->network;
        $generate = $this->request_id;
        $int_id = $this->int_id;
        $client_id = $this->client_id;
        $account_no = $this->account_no;

  // $get_intwall = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
  // if (mysqli_num_rows($get_intwall) > 0) {
  //   $xcv = mysqli_fetch_array($get_intwall);
  //   $wallet_balance = $xcv["bills_balance"];

  //   if ($wallet_balance >= $amount) {
  //     $get_client = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$account_no' AND client_id = '$client_id' AND int_id = '$int_id'");
  //     if (mysqli_num_rows($get_client) > 0) {
  //       $xpc = mysqli_fetch_array($get_client);
  //       $account_balance = $xpc["account_balance_derived"];

  //       if ($account_balance >= $amount) {
  //         // EXECUTE
  //       } else {
  //         echo json_encode(array("message" => "You have insufficient fund", "status" => "failed"));
  //       }
  //     } else {
  //       echo json_encode(array("message" => "No User Account Found", "status" => "failed"));
  //     }
  //   } else {
  //     echo json_encode(array("message" => "Insufficient Institution Balance", "status" => "failed"));
  //   }
  // } else {
  //   echo json_encode(array("message" => "No Wallet Found", "status" => "failed"));
  // }

  $get_intwall = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
  if (mysqli_num_rows($get_intwall) > 0) {
    $xcv = mysqli_fetch_array($get_intwall);
    $wallet_balance = $xcv["bills_balance"];

    if ($wallet_balance >= $amount) {
      $get_client = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$account_no' AND client_id = '$client_id' AND int_id = '$int_id'");
      if (mysqli_num_rows($get_client) > 0) {
        $xpc = mysqli_fetch_array($get_client);
        $account_balance = $xpc["account_balance_derived"];

        if ($account_balance >= $amount) {
          // EXECUTE
          // start integration
          $curl = curl_init();
          
          curl_setopt_array($curl, array(
          //   CURLOPT_URL => "https://shagopayments.com/api/live/b2b",
            CURLOPT_URL => "http://34.68.51.255/shago/public/api/test/b2b",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"QAB\",\r\n\"phone\" : \"$phone\",\r\n\"amount\": \"$amount\",\r\n\"vend_type\" : \"VTU \",\r\n\"network\": \"$network\",\r\n\"request_id\": \"$generate\"\r\n}",
            CURLOPT_HTTPHEADER => array(
              // "hashKey: ddceb2126614e2b4aec6d0d247e17f746de538fef19311cc4c3471feada85d30",
              "Content-Type: application/json",
              "email: test@shagopayments.com",
              "password: test123"
            ),
          ));
          // return true;
          $response = curl_exec($curl);      
          $err = curl_close($curl);
          if ($err) {
              echo json_encode(array("message" => "Network Error", "status" => "failed"));
          } else {
              echo $response;
              return true;
          }
        } else {
          echo json_encode(array("message" => "You have insufficient fund", "status" => "failed"));
        }
      } else {
        echo json_encode(array("message" => "No User Account Found", "status" => "failed"));
      }
    } else {
      echo json_encode(array("message" => "Insufficient Institution Balance", "status" => "failed"));
    }
  } else {
    echo json_encode(array("message" => "No Wallet Found", "status" => "failed"));
  }

        
    
}

// Airtime
}