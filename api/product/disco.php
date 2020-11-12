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
include_once '../objects/disco.php';
  
$database = new Database();
$db = $database->getConnection();
  
$disco_go = new Sekani($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->disco) &&
    !empty($data->meterNo) &&
    !empty($data->type) &&
    !empty($data->amount) &&
    !empty($data->phonenumber) &&
    !empty($data->name) &&
    !empty($data->address) &&
    !empty($data->request_id) &&
    !empty($data->api_key)
){
  
    // set Airtime property values
    $disco_go->disco = $data->disco;
    $disco_go->meterNo = $data->meterNo;
    $disco_go->type = $data->type;
    $disco_go->amount = $data->amount;
    $disco_go->phonenumber= $data->phonenumber;
    $disco_go->name= $data->name;
    $disco_go->address= $data->address;
    $disco_go->request_id= $data->request_id;
    $disco_go->api_key = $data->api_key;
  
    // create the Airtime
    if($disco_go->load_disco()){
  
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
    echo json_encode(array("message" => "Unable to Complete Disco Transaction. Information is incomplete."));
}
?>