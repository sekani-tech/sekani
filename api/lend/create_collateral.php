
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
include_once 'collateral.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Collateral($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

 
// make sure data is not empty
if(
    !empty($data->date) &&
    !empty($data->type) &&
    !empty($data->value) &&
    !empty($data->description) &&
    !empty($data->int_id) &&
    !empty($data->client_id) &&
    !empty($data->status)
){
 
    // set property values
    $item->date = $data->date;
    $item->type = $data->type;
    $item->value = $data->value;
    $item->description = $data->description;
    $item->int_id = $data->int_id;
    $item->client_id = $data->client_id;
    $item->status = $data->status;
 
    // create the item
    if( $item->createCollateral() ){
 
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
