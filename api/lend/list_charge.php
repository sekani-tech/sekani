<?php

header("Access-Control-Allow-Origin=> *");
header("Content-Type=> application/json; charset=UTF-8");

include_once '../config/database.php';
include_once 'charge.php';

$database = new Database();
$db = $database->getConnection();

$items = new Charge($db);

$items->id = $_GET['id'];
$items->int_id = $_GET['int_id'];

$stmt = $items->getCharge();

$item_count = $stmt->rowCount();

if($item_count > 0){
	
	$charge_arr = [];
	$charge_arr["data"] = [];

	$charge_arr["item_count"] = $item_count;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$row;
		array_push($charge_arr["data"], $row);
	}
	echo json_encode($charge_arr);
}

else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}


?>

