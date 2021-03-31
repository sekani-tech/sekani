<?php
class Loan{

        // Connection
    private $conn;

        // Table
    private $db_table_loan_charge = "loan_charge";
    private $db_table_product_loan_charge = "product_loan_charge";
    private $db_table_loan_gaurantor = "loan_gaurantor";
    private $db_table_loan_disbursement_cache = "loan_disbursement_cache";

        // Columns
    public $id;
    public $charge_id;
    public $client_id;
    public $loan_cache_id;

    public $int_id;
    public $product_loan_id;

    public $first_name;
    public $last_name;
    public $phone;
    public $phone2;
    public $home_address;
    public $office_address;
    public $email;

    public $account_no;
    public $product_id;
    public $col_id;
    public $col_name;
    public $col_description;
    public $loan_officer;
    public $loan_purpose;
    public $currency_code;
    public $currency_digits;
    public $principal_amount_proposed;
    public $principal_amount;
    public $loan_term;
    public $interest_rate;
    public $approved_principal;
    public $repayment_date;
    public $term_frequency;
    public $repay_every;
    public $number_of_repayments;
    public $submittedon_date;
    public $submittedon_userid;
    public $approvedon_date;
    public $approvedon_userid;
    public $expected_disbursedon_date;
    public $expected_firstrepaymenton_date;
    public $disbursement_date;
    public $disbursedon_userid;
    public $repay_principal_every;
    public $repay_interest_every;

    public $status;


        // Db connection
    public function __construct($db){
        $this->conn = $db;
    }

        // GET ALL
    public function getProductLoanCharge(){
        $sqlQuery = "SELECT *  FROM  {$this->db_table_product_loan_charge} WHERE product_loan_id = ? && int_id = ?  ";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1 , $this->product_loan_id);
        $stmt->bindParam(2, $this->int_id);
        $stmt->execute();
        return $stmt;
    }

        // GET ALL
    public function getLoanCharge(){
        $sqlQuery = "SELECT *  FROM  {$this->db_table_loan_charge} WHERE product_loan_id = ? && int_id = ?  ";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1 , $this->product_loan_id);
        $stmt->bindParam(2, $this->int_id);
        $stmt->execute();
        return $stmt;
    }

        // GET ALL
    public function getLoanGuarantor(){
        $sqlQuery = "SELECT *  FROM  {$this->db_table_loan_gaurantor} WHERE client_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1 , $this->client_id);
        $stmt->execute();
        return $stmt;
    }

        // GET ALL
    public function getLoanGuarantorStrict(){
        $sqlQuery = "SELECT *  FROM  {$this->db_table_loan_gaurantor} WHERE client_id = ? && phone = ? OR email = ?  ";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1 , $this->client_id);
        $stmt->bindParam(2 , $this->phone);
        $stmt->bindParam(3, $this->email);
        $stmt->execute();
        return $stmt;
    }

        // CREATE
    public function createLoanGuarantor() {
        $sqlQuery = "INSERT INTO
        {$this->db_table_loan_gaurantor}
        SET 
        int_id=:int_id, 
        client_id=:client_id,
        first_name=:first_name, 
        last_name=:last_name, 
        phone=:phone, 
        phone2=:phone2,
        home_address=:home_address,
        office_address=:office_address,
        status=:status,
        email=:email";
        
        $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
        $this->int_id=htmlspecialchars(strip_tags($this->int_id));
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->phone2=htmlspecialchars(strip_tags($this->phone2));
        $this->home_address=htmlspecialchars(strip_tags($this->home_address));
        $this->office_address=htmlspecialchars(strip_tags($this->office_address));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->client_id=htmlspecialchars(strip_tags($this->client_id));
        $this->status=htmlspecialchars(strip_tags($this->status));
        
            // bind data
        $stmt->bindParam(":int_id", $this->int_id);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":phone2", $this->phone2);
        $stmt->bindParam(":home_address", $this->home_address);
        $stmt->bindParam(":office_address", $this->office_address);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":client_id", $this->client_id);
        $stmt->bindParam(":status", $this->status);
        
        if($stmt->execute()){
         return true;
     }
     return false;
 }


        // CREATE
 public function createLoan(){
    $sqlQuery = "INSERT INTO
    {$this->db_table_loan_disbursement_cache}
    SET
    int_id = :int_id, 
    client_id = :client_id, 
    product_id = :product_id, 
    account_no = :account_no,
    col_id = :col_id,
    col_name = :col_name,
    col_description = :col_description,
    loan_officer = :loan_officer,
    loan_purpose = :loan_purpose,
    currency_code = :currency_code,
    currency_digits = :currency_digits,
    principal_amount_proposed = :principal_amount_proposed,
    principal_amount = :principal_amount,
    loan_term = :loan_term,
    interest_rate = :interest_rate,
    approved_principal = :approved_principal,
    repayment_date = :repayment_date,
    term_frequency = :term_frequency,
    repay_every = :repay_every,
    number_of_repayments = :number_of_repayments,
    submittedon_date = :submittedon_date,
    submittedon_userid = :submittedon_userid,
    approvedon_date = :approvedon_date,
    approvedon_userid = :approvedon_userid,
    expected_disbursedon_date = :expected_disbursedon_date,
    expected_firstrepaymenton_date = :expected_firstrepaymenton_date,
    disbursement_date = :disbursement_date,
    disbursedon_userid = :disbursedon_userid,
    expected_disbursedon_date = :expected_disbursedon_date,
    disbursement_date = :disbursement_date,
    disbursedon_userid = :disbursedon_userid,
    repay_principal_every = :repay_principal_every,
    repay_interest_every = :repay_interest_every";
    
    
    $stmt = $this->conn->prepare($sqlQuery);
    
            // sanitize
    $this->int_id=htmlspecialchars(strip_tags($this->int_id));
    $this->client_id=htmlspecialchars(strip_tags($this->client_id));
    $this->account_no=htmlspecialchars(strip_tags($this->account_no));
    $this->product_id=htmlspecialchars(strip_tags($this->product_id));
    $this->col_id=htmlspecialchars(strip_tags($this->col_id));
    $this->col_name=htmlspecialchars(strip_tags($this->col_name));
    $this->col_description=htmlspecialchars(strip_tags($this->col_description));
    $this->loan_officer=htmlspecialchars(strip_tags($this->loan_officer));
    $this->loan_purpose=htmlspecialchars(strip_tags($this->loan_purpose));
    $this->currency_code=htmlspecialchars(strip_tags($this->currency_code));
    $this->currency_digits=htmlspecialchars(strip_tags($this->currency_digits));
    $this->principal_amount_proposed=htmlspecialchars(strip_tags($this->principal_amount_proposed));
    $this->principal_amount=htmlspecialchars(strip_tags($this->principal_amount));
    $this->loan_term=htmlspecialchars(strip_tags($this->loan_term));
    $this->interest_rate=htmlspecialchars(strip_tags($this->interest_rate));
    $this->approved_principal=htmlspecialchars(strip_tags($this->approved_principal));
    $this->repayment_date=htmlspecialchars(strip_tags($this->repayment_date));
    $this->term_frequency=htmlspecialchars(strip_tags($this->term_frequency));
    $this->repay_every=htmlspecialchars(strip_tags($this->repay_every));
    $this->number_of_repayments=htmlspecialchars(strip_tags($this->number_of_repayments));
    $this->submittedon_date=htmlspecialchars(strip_tags($this->submittedon_date));
    $this->submittedon_userid=htmlspecialchars(strip_tags($this->submittedon_userid));
    $this->approvedon_date=htmlspecialchars(strip_tags($this->approvedon_date));
    $this->expected_disbursedon_date=htmlspecialchars(strip_tags($this->expected_disbursedon_date));
    $this->expected_firstrepaymenton_date=htmlspecialchars(strip_tags($this->expected_firstrepaymenton_date));
    $this->disbursement_date=htmlspecialchars(strip_tags($this->disbursement_date));
    $this->disbursedon_userid=htmlspecialchars(strip_tags($this->disbursedon_userid));
    $this->repay_principal_every=htmlspecialchars(strip_tags($this->repay_principal_every));
    $this->repay_interest_every=htmlspecialchars(strip_tags($this->repay_interest_every));
    
            // bind data
    $stmt->bindParam(":int_id", $this->int_id);
    $stmt->bindParam(":account_no", $this->account_no);
    $stmt->bindParam(":client_id", $this->client_id);
    $stmt->bindParam(":product_id", $this->product_id);
    $stmt->bindParam(":col_id", $this->col_id);
    $stmt->bindParam(":col_name", $this->col_name);
    $stmt->bindParam(":col_description", $this->col_description);
    $stmt->bindParam(":loan_officer", $this->loan_officer);
    $stmt->bindParam(":loan_purpose", $this->loan_purpose);
    $stmt->bindParam(":currency_code", $this->currency_code);
    $stmt->bindParam(":currency_digits", $this->currency_digits);
    $stmt->bindParam(":principal_amount_proposed", $this->principal_amount_proposed);
    $stmt->bindParam(":principal_amount", $this->principal_amount);
    $stmt->bindParam(":loan_term", $this->loan_term);
    $stmt->bindParam(":interest_rate", $this->interest_rate);
    $stmt->bindParam(":approved_principal", $this->approved_principal);
    $stmt->bindParam(":repayment_date", $this->repayment_date);
    $stmt->bindParam(":term_frequency", $this->term_frequency);
    $stmt->bindParam(":repay_every", $this->repay_every);
    $stmt->bindParam(":number_of_repayments", $this->number_of_repayments);
    $stmt->bindParam(":submittedon_date", $this->submittedon_date);
    $stmt->bindParam(":submittedon_userid", $this->submittedon_userid);
    $stmt->bindParam(":approvedon_date", $this->approvedon_date);
    $stmt->bindParam(":approvedon_userid", $this->approvedon_userid);
    $stmt->bindParam(":expected_disbursedon_date", $this->expected_disbursedon_date);
    $stmt->bindParam(":expected_firstrepaymenton_date", $this->expected_firstrepaymenton_date);
    $stmt->bindParam(":disbursement_date", $this->disbursement_date);
    $stmt->bindParam(":disbursedon_userid", $this->disbursedon_userid);
    $stmt->bindParam(":repay_principal_every", $this->repay_principal_every);
    $stmt->bindParam(":repay_interest_every", $this->repay_interest_every);
    
    if($stmt->execute()){
     return true;
 }
 return false;
}

        // DELETE
function deleteLoanCharge(){
    $sqlQuery = "DELETE FROM  {$this->db_table_loan_charge}  WHERE id = ?";
    $stmt = $this->conn->prepare($sqlQuery);
    $this->id=htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1, $this->id);
    if($stmt->execute()){
        return true;
    }
    return false;
}

}

?>