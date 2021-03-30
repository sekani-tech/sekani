<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate  object
include_once 'loan.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Loan($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->int_id) &&
    !empty($data->account_no) &&
    !empty($data->client_id) &&
    !empty($data->product_id) &&
    !empty($data->col_id) &&
    !empty($data->col_name) &&
    !empty($data->col_description) &&
    !empty($data->loan_officer) &&
    !empty($data->loan_purpose) &&
    !empty($data->currency_code) &&
    !empty($data->currency_digits) &&
    !empty($data->principal_amount_proposed) &&
    !empty($data->principal_amount) &&
    !empty($data->loan_term) &&
    !empty($data->interest_rate) &&
    !empty($data->approved_principal) &&
    !empty($data->repayment_date) &&
    !empty($data->term_frequency) &&
    !empty($data->repay_every) &&
    !empty($data->number_of_repayments) &&
    !empty($data->submittedon_date) &&
    !empty($data->submittedon_userid) &&
    !empty($data->approvedon_date) &&
    !empty($data->approvedon_userid) &&
    !empty($data->expected_disbursedon_date) &&
    !empty($data->expected_firstrepaymenton_date) &&
    !empty($data->disbursement_date) &&
    !empty($data->disbursedon_userid) &&
    !empty($data->repay_principal_every) &&
    !empty($data->repay_interest_every) 
){

    // set property values
    $item->int_id = $data->int_id;
    $item->account_no = $data->account_no;
    $item->client_id = $data->client_id;
    $item->product_id = $data->product_id;
    $item->fund_id = $data->fund_id;
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
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create item. Data is incomplete."));
}
?>
