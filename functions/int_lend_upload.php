<?php
include("connect.php");
session_start();

$sessint_id = $_SESSION["int_id"];
$client_id = $_SESSION["client_id"];
$goacctn = mysqli_query($connection, "SELECT account_no FROM client WHERE id = '$client_id' ");
if (count([$accnq]) == 1) {
    $a = mysqli_fetch_array($accnq);
    $acct_no = $a['account_no'];
}
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
// part for collatera
$col_id = $_POST['col_id'];
$col_name = $_POST['col_description'];
// gaurantors
$first_name = $_POST['gau_first_name'];
$last_name = $_POST['gau_last_name'];
$phone = $_POST['gau_phone'];
$phone2 = $_POST['gau_phone2'];
$home_address = $_POST['gau_home_address'];
$office_address = $_POST['gau_office_address'];
$position_held = $_POST['gau_position_held'];
$email = $_POST['gau_email'];

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