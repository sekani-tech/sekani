
<?php

header("Access-Control-Allow-Origin=> *");
header("Content-Type=> application/json; charset=UTF-8");

include_once '../config/database.php';
include_once 'account.php';

$database = new Database();
$db = $database->getConnection();

$items = new Account($db);

$items->id = $_GET['id'];

$stmt = $items->getAccount();

$item_count = $stmt->rowCount();

if($item_count > 0){
	
	$account_arr = [];
	$account_arr["data"] = [];

	$account_arr["item_count"] = $item_count;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$row;
		array_push($account_arr["data"], $row);
	}
	echo json_encode($account_arr);
}

else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}


?>
