
<?php
// required headers
header("Access-Control-Allow-Origin: *");   
header("Content-Type: application/json; charset=UTF-8");    
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");    
header("Access-Control-Max-Age: 3600");    
header("Access-Control-Allow-Headers: Content-Type, origin");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
   return 0;    
}

// get database connection
include_once '../config/database.php';
 
// instantiate  object
include_once 'loan.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Loan($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

    // set property values
    $item->int_id = $data->int_id;
    $item->account_no = $data->account_no;
    $item->client_id = $data->client_id;
    $item->product_id = $data->product_id;
    $item->col_id = $data->col_id;
    $item->col_name = $data->col_name;
    $item->col_description = $data->col_description;
    $item->loan_officer = $data->loan_officer;
    $item->loan_purpose = $data->loan_purpose;
    $item->currency_code = $data->currency_code;
    $item->currency_digits = $data->currency_digits;
    $item->principal_amount_proposed = $data->principal_amount_proposed;
    $item->principal_amount = $data->principal_amount;
    $item->loan_term = $data->loan_term;
    $item->interest_rate = $data->interest_rate;
    $item->approved_principal = $data->approved_principal;
    $item->principal_amount = $data->principal_amount;
    $item->repayment_date = $data->repayment_date;
    $item->term_frequency = $data->term_frequency;
    $item->repay_every = $data->repay_every;
    $item->number_of_repayments = $data->number_of_repayments;
    $item->submittedon_date = $data->submittedon_date;
    $item->submittedon_userid = $data->submittedon_userid;
    $item->approvedon_date = $data->approvedon_date;
    $item->approvedon_userid = $data->approvedon_userid;
    $item->expected_disbursedon_date = $data->expected_disbursedon_date;
    $item->expected_firstrepaymenton_date = $data->expected_firstrepaymenton_date;
    $item->disbursement_date = $data->disbursement_date;
    $item->disbursedon_userid = $data->disbursedon_userid;
    $item->repay_principal_every = $data->repay_principal_every;
    $item->repay_interest_every = $data->repay_interest_every;

    // create the item
    if( $item->createLoan() ){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "item was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create item."));
    }

?>
