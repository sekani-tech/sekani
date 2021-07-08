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
include_once '../objects/cable_request.php';
  
$database = new Database();
$db = $database->getConnection();
  
$cable = new Sekani($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->smartcardNo) &&
    !empty($data->type) &&
    !empty($data->api_key)
){
  
    // set Airtime property values
    $cable->smartcardNo = $data->smartcardNo;
    $cable->type = $data->type;
    $cable->api_key = $data->api_key;
  
    // create the Airtime
    if($cable->cable_request()){
  
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
    echo json_encode(array("message" => "Unable to request Cable. Information is incomplete."));
}
?>