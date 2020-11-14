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
function load_disco(){

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
        $id = $row["id"];
        $int_id = $row["int_id"];
        $branch_id = $row["branch_id"];
        $running_balance = $row["running_balance"];
        $total_deposit = $row["total_deposit"];
        $total_withdrawal = $row["total_withdrawal"];
        $total_int_profit = $row["int_profit"];
        $total_merchant_charge = $row["merchant_charge"];
        $total_sekani_charge = $row["sekani_charge"];
    if ($running_balance >= $this->amount) {
        // get all the vaule to Shago
        $disco = $this->disco;
        $meter = $this->meterNo;
        $type = $this->type;
        $amount = $this->amount;
        $phonenumber = $this->phonenumber;
        $name = $this->name;
        $address = $this->address;
        $generate = $this->request_id;
        // start integration
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://shagopayments.com/api/live/b2b",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"AOB\",\r\n\"disco\" : \"$disco\",\r\n\"meterNo\": \"$meter\",\r\n\"type\" : \"$type\",\r\n\"amount\": \"$amount\",\r\n\"phonenumber\": \"$phonenumber\",\r\n\"name\": \"$name\",\r\n\"address\":\"$address\",\r\n\"request_id\" : \"$generate\n}",
              CURLOPT_HTTPHEADER => array(
                "hashKey: ddceb2126614e2b4aec6d0d247e17f746de538fef19311cc4c3471feada85d30",
                "Content-Type: application/json"
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
            // status
            echo $response;
            $token = $obj['token'];
            if ($status == "200" && $status != "") {
                $cal_bal = $running_balance - $amount;
                $cal_with = $total_withdrawal + $amount;
                $cal_sek = $total_sekani_charge + 0;
                $cal_mch = $total_merchant_charge + $amount;
                $cal_int_prof = $total_int_profit + 0;
                $digits = 9;
                $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
                $trans = "SKWAL".$randms."AIRTIME".$int_id;
                $date = date("Y-m-d");
                $date2 = date('Y-m-d H:i:s');

                // RUN UPDATE QUERY
                $update_query = "UPDATE
                " . $this->table_name . "
            SET
              running_balance = :cal_bal,
              total_withdrawal = :cal_with,
              int_profit = :cal_int_prof,
              sekani_charge = :cal_sek,
              merchant_charge = :cal_mch
            WHERE
                id = :id";

                // prepare query statement
    $stmtu = $this->conn->prepare($update_query);
    $stmtu->bindParam(':cal_bal', $cal_bal);
    $stmtu->bindParam(':cal_with', $cal_with);
    $stmtu->bindParam(':cal_int_prof', $cal_int_prof);
    $stmtu->bindParam(':cal_sek', $cal_sek);
    $stmtu->bindParam(':cal_mch', $cal_mch);
    $stmtu->bindParam(':id', $id);

    if($stmtu->execute()){
        include("../../functions/connect.php");
        $query_table = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
        `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
        `int_profit`, `sekani_charge`, `merchant_charge`)
         VALUES ('{$int_id}', '{$branch_id}', '{$trans}',
         '{$generate}', 'bill_disco', 
         NULL, '0', '{$date}', '{$amount}', '{$cal_bal}',
         '{$cal_bal}', {$date}, 
         NULL, NULL, '{$date2}', '0', '0.00', '{$amount}', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");

    // MAKE FINAL ECHO
    if($query_table){
        echo $response;
        return true;
    } else {
        echo json_encode(array("message" => "Error at Inserting Wallet Transaction, Please Contact Sekani", "status" => "failed"));
    }
    } else {
        echo json_encode(array("message" => "Error at Updating Wallet, Please Contact Sekani", "status" => "failed"));
    }
            } else {
                echo json_encode(array("message" => "Unable to Pay Disco. Please Check Request id for duplicate", "status" => "failed"));
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