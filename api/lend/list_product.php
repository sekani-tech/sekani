
<?php

    // Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
    		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    	exit(0);
    }

    include_once '../config/database.php';
    include_once 'product.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Product($db);

    $items->int_id = $_GET['int_id'];

    $stmt = $items->getProduct();

    $item_count = $stmt->rowCount();

    if($item_count > 0){

    	$product_arr = [];
    	$product_arr["data"] = [];

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




