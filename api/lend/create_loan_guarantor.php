
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
    !empty($data->client_id) &&
    !empty($data->first_name) &&
    !empty($data->last_name) &&
    !empty($data->phone) &&
    !empty($data->phone2) &&
    !empty($data->home_address) &&
    !empty($data->office_address) &&
    !empty($data->email) &&
    !empty($data->int_id) &&
    !empty($data->status)
){
 
    // set property values
   $item->client_id = $data->client_id;
   $item->first_name = $data->first_name;
   $item->last_name = $data->last_name;
   $item->phone = $data->phone;
   $item->phone2 = $data->phone2;
   $item->home_address = $data->home_address;
   $item->office_address = $data->office_address;
   $item->email = $data->email;
   $item->int_id = $data->int_id;
   $item->status = $data->status;
 
    // create the item
    if( $item->createLoanGuarantor() ){
 
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
