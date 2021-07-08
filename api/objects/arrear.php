<?php
class Arrear{
    // database connection and table name
    private $conn;
    private $table_name = "loan_arrear";
  
    // object properties
    public $id;
    public $loan_id;
    public $int_id;
    public $client_id;
    public $due_date;
    public $installment;
    public $days_counter;
    public $par;
    public $principal_amount_outstanding;
    public $interest_amount_outstanding;
    public $created_date;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read
    // read products
function arrear(){
    // select all query
    $query = "SELECT
                loan_arrear.id, loan_arrear.loan_id, loan_arrear.int_id, loan_arrear.client_id, loan_arrear.duedate, loan_arrear.installment, loan_arrear.counter, loan_arrear.par, loan_arrear.principal_amount, loan_arrear.interest_amount, loan_arrear.created_date
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