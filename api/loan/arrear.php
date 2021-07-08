<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/arrear.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$Arrear = new Arrear($db);
  
// read products will be here
// query products
$stmt = $Arrear->arrear();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $arrear_arr=array();
    $arrear_arr["loan_arrear"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $arrear_item=array(
            "id" => $id,
            "loan_id" => $loan_id,
            "int_id" => $int_id,
            "client_id" => $client_id,
            "due_date" => $duedate,
            "installment" => $installment,
            "days_counter" => $counter,
            "par" => $par,
            "principal_amount_outstanding" => $principal_amount,
            "interest_amount_outstanding" => $interest_amount,
            "created_date" => $created_date
        );
        array_push($arrear_arr["loan_arrear"], $arrear_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($arrear_arr);
} else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No Loan is in Arrear")
    );
}
  
// no products found will be here
?>