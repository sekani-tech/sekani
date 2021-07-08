<?php
// CONNECT TO DATABASE
include "../connect.php";
session_start();

$int_id = $_SESSION['int_id'];
$term = $_GET['term'];
$rows = searchGroup('groups', $int_id, $term);
// loading of display name that looks like the search term into data array
$data = [];
foreach ($rows as $key => $row){
    $data[] = $row['g_name'];
}

   
// returning result via json
echo json_encode($data);