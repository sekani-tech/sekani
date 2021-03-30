
<?php

header("Access-Control-Allow-Origin=> *");
header("Content-Type=> application/json; charset=UTF-8");

include_once '../config/database.php';
include_once 'staff.php';

$database = new Database();
$db = $database->getConnection();

$items = new Staff($db);

$items->int_id = $_GET['int_id'];
$items->employee_status = $_GET['employee_status'];

$stmt = $items->getStaff();

$item_count = $stmt->rowCount();

if($item_count > 0){
	
	$staff_arr = [];
	$staff_arr["data"] = [];

	$staff_arr["item_count"] = $item_count;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$row;
		array_push($staff_arr["data"], $row);
	}
	echo json_encode($staff_arr);
}

else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}


?>
