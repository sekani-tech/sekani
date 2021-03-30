

<?php

header("Access-Control-Allow-Origin=> *");
header("Content-Type=> application/json; charset=UTF-8");

include_once '../config/database.php';
include_once 'payment.php';

$database = new Database();
$db = $database->getConnection();

$items = new Payment($db);

$items->id = $_GET['id'];

$stmt = $items->getSinglePayment();

$item_count = $stmt->rowCount();


echo json_encode($item_count);

if($item_count > 0){
	
	$payment_arr = [];
	$payment_arr["data"] = [];
	$payment_arr["item_count"] = $item_count;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$row;
		array_push($payment_arr["data"], $row);
	}
	echo json_encode($payment_arr);
}

else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}

?>