<?php
// called database connection
include("connect.php");
// user management
session_start();

?>
<?php
$sessint_id = $_SESSION["int_id"];
$charge_id = $_POST['charge_id'];
$name = $_POST['name'];
$short_name = $_POST['short_name'];
$description = $_POST['description'];
$fund_id = $_POST['fund_id'];
$in_amt_multiples = $_POST['in_amt_multiples'];
$principal_amount = $_POST['principal_amount'];
$min_principal_amount = $_POST['min_principal_amount'];
$max_principal_amount = $_POST['max_principal_amount'];
$loan_term = $_POST['loan_term'];
$min_loan_term = $_POST['min_loan_term'];
$max_loan_term = $_POST['max_loan_term'];
$repayment_frequency = $_POST['repayment_frequency'];
$repayment_every = $_POST['repayment_every'];
$i_r = $_POST['interest_rate'];
$interest_rate = $i_r / 100;
$min_i_r = $_POST['min_interest_rate'];
$min_interest_rate = $min_i_r / 100;
$max_i_r = $_POST['max_interest_rate'];
$max_interest_rate = $max_i_r / 100;
$interest_rate_applied = $_POST['interest_rate_applied'];
$interest_rate_methodoloy = $_POST['interest_rate_methodoloy'];
$ammortization_method = $_POST['ammortization_method'];
$cycle_count = $_POST['cycle_count'];
$auto_allocate_overpayment = $_POST['auto_allocate_overpayment'];
$additional_charge = $_POST['additional_charge'];
$auto_disburse = $_POST['auto_disburse'];
$linked_savings_acct = $_POST['linked_savings_acct'];
// credit checks and accounting rules
// insertion query for product
$query = "INSERT INTO product (int_id, charge_id, name, short_name, description, 
fund_id, in_amt_multiples, principal_amount, min_principal_amount, max_principal_amount,
loan_term, min_loan_term, max_loan_term, repayment_frequency, repayment_every,
interest_rate, min_interest_rate, max_interest_rate, interest_rate_applied, interest_rate_methodoloy,
ammortization_method, cycle_count, auto_allocate_overpayment, additional_charge,
auto_disburse, linked_savings_acct) VALUES ('{$sessint_id}', '{$charge_id}', '{$name}', '{$short_name}', '{$description}', 
'{$fund_id}', '{$in_amt_multiples}', '{$principal_amount}', '{$min_principal_amount}', '{$max_principal_amount}',
'{$loan_term}', '{$min_loan_term}', '{$max_loan_term}', '{$repayment_frequency}', '{$repayment_every}',
'{$interest_rate}', '{$min_interest_rate}', '{$max_interest_rate}', '{$interest_rate_applied}', '{$interest_rate_methodoloy}',
'{$ammortization_method}', '{$cycle_count}', '{$auto_allocate_overpayment}', '{$additional_charge}',
'{$auto_disburse}', '{$linked_savings_acct}')";

$res = mysqli_query($connection, $query);

 if ($res) {
    echo header("location: ../mfi/products.php");
 } else {
     echo "<p>Error</p>";
 }
if ($connection->error) {
        try {   
            throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $msqli->errno);   
        } catch(Exception $e ) {
            echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
            echo nl2br($e->getTraceAsString());
        }
    }

?>