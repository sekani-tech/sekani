<?php

include("../connect.php");
session_start();
$institutionId = $_SESSION['int_id'];
$branchId = $_SESSION['branch_id'];
$today = date("Y-m-d");
$user = $_SESSION['user_id'];
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if(isset($_POST['amount']) && isset($_POST['income_gl']) && isset($_POST['expense_gl'])){
    $incomeGl = $_POST['income_gl'];
    $expenseGl = $_POST['expense_gl'];
    $amount = $_POST['amount'];
    $transactionId = $_POST['transid'];
    $description = $_POST['description'];
}else{
    // provide all necessary information
}