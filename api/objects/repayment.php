<?php
class Repayment{
    // database connection and table name
    private $conn;
    private $table_name = "loan_repayment_schedule";
  
    // object properties
    public $id;
    public $loan_id;
    public $int_id;
    public $client_id;
    public $due_date;
    public $installment;
    public $principal_amount;
    public $interest_amount;
    public $created_date;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read
    // read products
function repay(){
    // select all query
    $query = "SELECT
                id, loan_id, int_id, client_id, duedate, installment, principal_amount, interest_amount, created_date
            FROM
                " . $this->table_name . "
            ORDER BY
                id DESC";
    // loan the statment here
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
}
?>