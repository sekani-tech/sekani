<?php
class Sekani{
  
    // database connection and table name
    private $conn;
    private $table_name = "sekani_wallet_transaction";
  
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
    $select_query = "SELECT sekani_wallet_transaction.id, sekani_wallet_transaction.transaction_id, sekani_wallet_transaction.description, sekani_wallet_transaction.transaction_type, sekani_wallet_transaction.transaction_date,
    sekani_wallet_transaction.amount, sekani_wallet_transaction.wallet_balance_derived, sekani_wallet_transaction.created_date, sekani_wallet_transaction.credit, sekani_wallet_transaction.debit, sekani_wallet_transaction.int_profit FROM " . $this->table_name . " JOIN 
    sekani_wallet ON sekani_wallet_transaction.int_id = sekani_wallet.int_id WHERE sekani_wallet.API_KEY =:api_key
    ORDER BY
    sekani_wallet_transaction.id ASC";
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

    if ($num > 0) {
        // make a move
        $transaction=array();
        $transaction["wallet_transaction"]=array();
        // making move
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
    
            $transaction_item=array(
                "id" => $id,
                "transaction_id" => $transaction_id,
                "request_id" => $description,
                "transaction_type" => $transaction_type,
                "transaction_date" => $transaction_date,
                "amount" => $amount,
                "wallet_balance" => $wallet_balance_derived,
                "credit" => $credit,
                "debit" => $debit,
                "profit" => $int_profit,
                "date_time" => $created_date
            );
            array_push($transaction["wallet_transaction"], $transaction_item);
        }
        echo json_encode($transaction);
    return true;
} else {
    echo json_encode(array("message" => "No Institution or Transaction Found", "status" => "failed"));
}
    
}

// Airtime
}