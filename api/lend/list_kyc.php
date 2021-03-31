
<?php

header("Access-Control-Allow-Origin=> *");
header("Content-Type=> application/json; charset=UTF-8");

include_once '../config/database.php';
include_once 'kyc.php';

$database = new Database();
$db = $database->getConnection();

$items = new Kyc($db);

$items->client_id = $_GET['client_id'];

$stmt = $items->getKyc();

$item_count = $stmt->rowCount();

if($item_count > 0){
	
	$kyc_arr = [];
	$kyc_arr["data"] = [];

	$kyc_arr["item_count"] = $item_count;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$row;
		array_push($kyc_arr["data"], $row);
	}
	echo json_encode($kyc_arr);
}

else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}


?>
