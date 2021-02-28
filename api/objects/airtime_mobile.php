<?php
class Sekani{
    // define class path
function airtimex(){
        // get all the vaule to Shago
        $phone = $this->phone;
        $amount = $this->amount;
        $network = $this->network;
        $generate = $this->request_id;
        // start integration
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://shagopayments.com/api/live/b2b",
        //   CURLOPT_URL => "http://34.68.51.255/shago/public/api/test/b2b",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"QAB\",\r\n\"phone\" : \"$phone\",\r\n\"amount\": \"$amount\",\r\n\"vend_type\" : \"VTU \",\r\n\"network\": \"$network\",\r\n\"request_id\": \"$generate\"\r\n}",
          CURLOPT_HTTPHEADER => array(
            "hashKey: ddceb2126614e2b4aec6d0d247e17f746de538fef19311cc4c3471feada85d30",
            "Content-Type: application/json"
            // "email: test@shagopayments.com",
            // "password: test123"
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
    
}

// Airtime
}