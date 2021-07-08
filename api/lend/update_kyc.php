
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once 'kyc.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare  object
$item = new Kyc($db);
  
// get id of to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of id to be edited
$item->id = $data->id;
  
    // set property values
    $item->int_id = $data->int_id;
    $item->client_id = $data->client_id;
    $item->marital_status = $data->marital_status;
    $item->no_of_dependent = $data->no_of_dependent;
    $item->level_of_ed = $data->level_of_ed;
    $item->emp_stat = $data->emp_stat;
    $item->emp_bus_name = $data->emp_bus_name;
    $item->income = $data->income;
    $item->years_in_job = $data->years_in_job;
    $item->res_type = $data->res_type;
    $item->rent_per_year = $data->rent_per_year;
    $item->year_in_res = $data->year_in_res;
    $item->other_bank = $data->other_bank;
    $item->emp_category = $data->emp_category;
  
// update the item
if( $item->updateKyc() ){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Item was updated."));
}
  
// if unable to update the product, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update item."));
}
?>