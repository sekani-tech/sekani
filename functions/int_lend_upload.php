<?php
include("connect.php");
session_start();

$sessint_id = $_SESSION["int_id"];
$client_id = $_POST["client_id"];
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
$col_name = $_POST['col_name'];
$col_description = $_POST['col_description'];
// gaurantors
$first_name = $_POST['gau_first_name'];
$last_name = $_POST['gau_last_name'];
$phone = $_POST['gau_phone'];
$phone2 = $_POST['gau_phone2'];
$home_address = $_POST['gau_home_address'];
$office_address = $_POST['gau_office_address'];
$position_held = $_POST['gau_position_held'];
$email = $_POST['gau_email'];
// date of submitted
// lc
$r = $interest_rate;
$prina = $principal_amount;
$gi = $r * $prina;
$pd = $gi + $prina;

$submitted_on = date("Y-m-d");
$currency = "NGN";
$cd = 2;
$query = "INSERT INTO loan (int_id, account_no, client_id,
product_id, col_id, col_name, col_description,
loan_officer, loan_purpose, currency_code,
currency_digits, principal_amount_proposed, principal_amount,
loan_term, interest_rate, approved_principal, repayment_date,
term_frequency, repay_every, number_of_repayments, submittedon_date,
submittedon_userid, approvedon_date, approved_userid,
expected_disburedon_date, expected_firstrepaymenton_date, disbursement_date,
disbursedon_userid,  ) VALUES ('{$sessint_id}', '{$accr_no}', '{$client_id}',
'{$product_id}', '{$col_id}', '{$col_name}', '{$col_description}',
'{$loan_officer}', '{$loan_purpose}', '{$currency}', '{$cd}',
'{$principal_amount}', '{$pd}')";
// stopped at principal amount
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