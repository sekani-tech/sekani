<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/loan.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$Loan = new Loan($db);
  
// read products will be here
// query products
$stmt = $Loan->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $loan_arr=array();
    $loan_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $loan_item=array(
            "id" => $id,
            "int_id" => $int_id,
            "client_id" => $client_id,
            "loan_amount" => $principal_amount,
            "interest_rate" => $interest_rate,
            "loan_creation_date" => $submittedon_date,
            "repayment_date" => $repayment_date,
            "dob" => $date_of_birth,
            "city" => $ADDRESS,
            "lga" => $LGA,
            "state" => $STATE_OF_ORIGIN,
            "employment_type" => $emp_stat,
            "job_length" => $years_in_job
        );
  
        array_push($loan_arr["records"], $loan_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($loan_arr);
} else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No Loan found.")
    );
}
  
// no products found will be here
?>