<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/repayment.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$Repayment = new Repayment($db);
  
// read products will be here
// query products
$stmt = $Repayment->repay();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $repayment_arr=array();
    $repayment_arr["loan_repayment_schedule"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $repayment_item=array(
            "id" => $id,
            "loan_id" => $loan_id,
            "int_id" => $int_id,
            "client_id" => $client_id,
            "due_date" => $duedate,
            "installment" => $installment,
            "principal_amount" => $principal_amount,
            "interest_amount" => $interest_amount,
            "created_date" => $created_date
        );
        array_push($repayment_arr["loan_repayment_schedule"], $repayment_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($repayment_arr);
} else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No Loan Repayment Schedule Found!")
    );
}
  
// no products found will be here
?>