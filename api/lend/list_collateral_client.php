
<?php

header("Access-Control-Allow-Origin=> *");
header("Content-Type=> application/json; charset=UTF-8");

include_once '../config/database.php';
include_once 'collateral.php';

$database = new Database();
$db = $database->getConnection();


$items = new Collateral($db);

$items->client_id = $_GET['client_id'];

$stmt = $items->getCollateralClient();

$item_count = $stmt->rowCount();


if($item_count > 0){
	
	$collateral_arr = [];
	$collateral_arr["data"] = [];

	$collateral_arr["item_count"] = $item_count;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$row;
		array_push($collateral_arr["data"], $row);
	}
	echo json_encode($collateral_arr);
}

else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}


?>

