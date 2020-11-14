<?php
class Sekani{
  
    // database connection and table name
    private $conn;
    private $table_name = "sekani_wallet";
  
    // object properties
    public $id;
    public $int_id;
    public $total_deposit;
    public $total_withdrawal;
    public $running_balance;
    public $API_KEY;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create Airtime API
function cable_request(){

    $select_query = "SELECT * FROM " . $this->table_name . " WHERE API_KEY =:api_key";
    // prepare query
    $stmt = $this->conn->prepare($select_query);
  
    // sanitize
    $this->api_key=htmlspecialchars(strip_tags($this->api_key));
  
    // bind values
    $stmt->bindParam(":api_key", $this->api_key);
  
    // execute query
    $stmt->execute();
    
    $row = $stmt->fetch();
    $num = $stmt->rowCount();

    if ($num > 0 && $row["API_KEY"] != "0") {
        $running_balance = $row["running_balance"];
    if ($running_balance >= 0) {
        // get all the vaule to Shago
        $smart = $this->smartcardNo;
        $cable = $this->type;
        // start integration
        $curl = curl_init();

            curl_setopt_array($curl, array(
              // CURLOPT_URL => "http://34.68.51.255/shago/public/api/test/b2b",
              CURLOPT_URL => "https://shagopayments.com/api/live/b2b",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"GDS\",\r\n\"smartCardNo\" : \"$smart\",\r\n\"type\" : \"$cable\"\r\n}",
              CURLOPT_HTTPHEADER => array(
                "hashKey: ddceb2126614e2b4aec6d0d247e17f746de538fef19311cc4c3471feada85d30",
                "Content-Type: application/json",
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
            $obj = json_decode($response, TRUE);
            $status = $obj['status'];
            $msg = $obj['message'];
            // echo $response;
            // status
            if ($status == "200" && $status != "") {
        echo $response;
        return true;
            } else {
                echo json_encode(array("message" => "Unable to Request Cable", "status" => "failed"));
            }
        }
    } else {
        // Balance not Up to
        echo json_encode(array("message" => "Insufficient Fund, Please Fund your Sekani Wallet!", "status" => "failed"));
    }
} else {
    echo json_encode(array("message" => "No Institution Found", "status" => "failed"));
}
    
}

// Airtime
}