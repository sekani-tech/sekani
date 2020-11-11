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
function wallet(){

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
        $running_balance = $row["running_balance"];
        $total_deposit = $row["total_deposit"];
        $total_withdrawal = $row["total_withdrawal"];
        $total_int_profit = $row["int_profit"];
        $total_merchant_charge = $row["merchant_charge"];
        $total_sekani_charge = $row["sekani_charge"];
        // make a move
        echo json_encode(array("message" => "Institution Found", "balance" => "$running_balance",
    "total_deposited" => "$total_deposit", "total_spent" => "$total_withdrawal", "profit" => "$total_int_profit", "status" => "success"));
    return true;
} else {
    echo json_encode(array("message" => "No Institution Found", "status" => "failed"));
}
    
}

// Airtime
}