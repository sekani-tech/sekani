<?php
class Loan{
    // database connection and table name
    private $conn;
    private $table_name = "loan";
  
    // object properties
    public $id;
    public $int_id;
    public $client_id;
    public $loan_amount;
    public $interest_rate;
    public $loan_creation_date;
    public $repayment_date;
    // client data
    public $first_name;
    public $last_name;
    public $dob;
    public $city;
    public $lga;
    public $state;
    public $employment_type;
    public $job_length;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read
    // read products
function read(){
    // select all query
    $query = "SELECT
                loan.id, loan.int_id, loan.client_id, loan.principal_amount, loan.interest_rate, loan.submittedon_date, loan.repayment_date, client.firstname, client.lastname, client.date_of_birth, client.ADDRESS, client.LGA, client.STATE_OF_ORIGIN, kyc.emp_stat, kyc.years_in_job
            FROM
                " . $this->table_name . " JOIN 
            client ON loan.client_id = client.id 
            JOIN kyc ON client.id = kyc.client_id
            ORDER BY
                loan.id DESC";
    // loan the statment here
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
}
?>