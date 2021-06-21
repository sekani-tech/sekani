<?php
include("../../../functions/connect.php");
session_start();
$insitutionId = $_SESSION['int_id'];
$branchId = $_SESSION['branch_id'];
$today =  date("Y-m-d H:i:s");
if (isset($_POST['charge_id'])) {
    $chargeId = $_POST['charge_id'];
    $tempId = $_POST['tempId'];

    $findCharge = selectOne('charge', ['id' => $chargeId]);
    echo $values = $findCharge["charge_time_enum"];
    $nameofc = $findCharge["name"];
    $forp = $findCharge["charge_calculation_enum"];
    // $main_p = $_SESSION["product_temp"];
    $amt = number_format($findCharge["amount"], 2);
    if ($forp == 1) {
        $chg = $amt . " Flat";
    } else {
        $chg = $amt . "% of Loan Principal";
    }
    
    
    if ($values == 1) {
        $xs = "Disbursement";
    } else if ($values == 2) {
        $xs = "Specified Due Date";
    } else if ($values == 3) {
        $xs = "Installment Fees";
    } else if ($values == 4) {
        $xs = "Overdue Installment Fees";
    } else if ($values == 5) {
        $xs = "Disbursement - Paid with Repayment";
    } else if ($values == 6) {
        $xs = "Loan Rescheduliing Fee";
    } else if ($values == 7) {
        $xs = "Transaction";
    }

    $cacheChargeDetails = [
        'int_id' => $insitutionId,
        'branch_id' => $branchId,
        'charge_id' => $chargeId,
        'name' => $nameofc,
        'charge' => $chg,
        'collected_on' => $xs,
        'date' => $today,
        'is_status' => 0,
        'cache_prod_id' => $tempId
    ];

    $storeCache = insert('charges_cache', $cacheChargeDetails);
    if (!$storeCache) {
        printf("Error: \n", mysqli_error($connection)); //checking for errors
        $output = "error";
        exit();
    } else {
        $output = "success";
    }
    echo $output;
}
