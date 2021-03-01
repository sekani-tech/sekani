<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate Airtime object
include_once '../objects/airtime_mobile.php';
  
$database = new Database();
$db = $database->getConnection();
  
$airtime = new Sekani($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->phone) &&
    !empty($data->amount) &&
    !empty($data->network) &&
    !empty($data->request_id) &&
    !empty($data->int_id) &&
    !empty($data->client_id) &&
    !empty($data->account_no)
){
    // making a new move in the code
    
    $airtime->phone = $data->phone;
    $airtime->amount = $data->amount;
    $airtime->network = $data->network;
    $airtime->request_id = $data->request_id;
    $airtime->int_id = $data->int_id;
    $airtime->client_id = $data->client_id;
    $airtime->account_no = $data->account_no;
  
    // create the Airtime
    if($airtime->airtimex()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        // echo json_encode(array("message" => "Airtime was Successful."));
    }
  
    // if unable to create the Airtime, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        // echo json_encode(array("message" => "Unable to Recharge Airtime."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to Recharge Airtime. Data is incomplete."));
}
?>