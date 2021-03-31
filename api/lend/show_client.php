
<?php

header("Access-Control-Allow-Origin=> *");
header("Content-Type=> application/json; charset=UTF-8");

include_once '../config/database.php';
include_once 'client.php';

$database = new Database();
$db = $database->getConnection();

$items = new Client($db);

$items->id = $_GET['id'];

$stmt = $items->getSingleClient();

$item_count = $stmt->rowCount();


echo json_encode($item_count);

if($item_count > 0){
    
    $client_arr["data"] = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $row;
        array_push($client_arr["data"], $row);
    }
    echo json_encode($client_arr);
}

else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}

?>