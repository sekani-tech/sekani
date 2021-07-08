
<?php

header("Access-Control-Allow-Origin=> *");
header("Content-Type=> application/json; charset=UTF-8");

include_once '../config/database.php';
include_once 'product.php';

$database = new Database();
$db = $database->getConnection();

$items = new Product($db);

$items->id = $_GET['id'];

$stmt = $items->getSingleProduct();

$item_count = $stmt->rowCount();


echo json_encode($item_count);

if($item_count > 0){
	
	$product_arr = [];
	$product_arr["data"] = [];
	$product_arr["item_count"] = $item_count;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$row;
		array_push($product_arr["data"], $row);
	}
	echo json_encode($product_arr);
}

else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}

?>