<?php
include("../../../functions/connect.php");
session_start();
$insitutionId = $_SESSION['int_id'];
// $branchId = $_SESSION['branch_id'];
// $today =  date("Y-m-d H:i:s");
if (isset($_POST['charge_id'])) {
    $chargeId = $_POST['charge_id'];
    $product = $_POST['product'];
      

    $cacheChargeDetails = [
        'int_id' => $insitutionId,
        'charge_id' => $chargeId,
        'savings_id' => $product
    ];

    $storeCache = insert('savings_product_charge', $cacheChargeDetails);
    if (!$storeCache) {
        printf("Error: \n", mysqli_error($connection)); //checking for errors
        $output = "error";
        exit();
    } else {
        $output = "success";
    }
    echo $output;
}
