<?php
include("connect.php");
session_start();

$sessint_id = $_SESSION["int_id"];
$client_id = $_SESSION["client_id"];
$product_id = $_POST['product_id'];
$principal_amount = $_POST['principal_amount'];
$loan_term = $_POST['loan_term'];
$repay_every = $_POST['repay_every'];
$interest_rate = $_POST['interest_rate'];
$disbursement_date = $_POST['disbursement_date'];
$loan_officer = $_POST['loan_officer'];
$loan_purpose = $_POST['loan_purpose'];
$linked_savings_acct = $_POST['linked_savings_acct'];
$repay_start = $_POST['repay_start'];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];
$ = $_POST[''];

$query = "INSERT INTO loan (int_id, ) VALUES ('{$}',)";

$res = mysqli_query($connection, $query);

if ($connection->error) {
    try {
        throw new Exception("MYSQL error $connection->error <br> $query ", $mysqli->error);
    } catch (Exception $e) {
        echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
        echo n12br($e->getTraceAsString());
    }
}
?>