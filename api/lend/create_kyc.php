
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
include_once 'kyc.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Kyc($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

 
// make sure data is not empty
if(
    !empty($data->int_id) &&
    !empty($data->client_id) &&
    !empty($data->marital_status) &&
    !empty($data->no_of_dependent) &&
    !empty($data->level_of_ed) &&
    !empty($data->emp_stat) &&
    !empty($data->emp_bus_name) &&
    !empty($data->income) &&
    !empty($data->years_in_job) &&
    !empty($data->res_type) &&
    !empty($data->rent_per_year) &&
    !empty($data->year_in_res) &&
    !empty($data->other_bank) &&
    !empty($data->emp_category) 
){
 
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
 
    // create the item
    if( $item->createKyc() ){
 
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
