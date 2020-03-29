<?php include("connect.php")?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
if (isset($_POST['id'])) {
$id = $_POST['id'];
$int_id = $_POST['int_id'];
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
$interest_rate = $_POST['interest_rate'];
$min_interest_rate = $_POST['min_interest_rate'];
$max_interest_rate = $_POST['max_interest_rate'];
$interest_rate_applied = $_POST['interest_rate_applied'];
$interest_rate_methodology = $_POST['interest_rate_methodology'];
$ammortization_method = $_POST['ammortization_method'];
$cycle_count = $_POST['cycle_count'];
$auto_allocate_overpayment = $_POST['auto_allocate_overpayment'];
$additional_charge = $_POST['additional_charge'];
$auto_disburse = $_POST['auto_disburse'];
$linked_savings_acct = $_POST['linked_savings_acct'];
  $query = "UPDATE product SET id = '$id', int_id = '$int_id', charge_id = '$charge_id', name = '$name', short_name = '$short_name', description = '$description', fund_id = '$fund_id', in_amt_multiples = '$in_amt_multiples',
   principal_amount = '$principal_amount', min_principal_amount = '$min_principal_amount', max_principal_amount = '$max_principal_amount', loan_term = '$loan_term', min_loan_term = '$min_loan_term', max_loan_term = '$max_loan_term',
   repayment_frequency = '$repayment_frequency', repayment_every = '$repayment_every', interest_rate = '$interest_rate', min_interest_rate = '$min_interest_rate',  max_interest_rate = '$max_interest_rate', interest_rate_applied = '$interest_rate_applied',
   interest_rate_methodoloy = '$interest_rate_methodoloy', ammortization_method = '$ammortization_method', cycle_count = '$cycle_count', auto_allocate_overpayment = '$auto_allocate_overpayment', additional_charge = '$additional_charge',
   auto_disburse = '$auto_disburse', linked_savings_acct = '$linked_savings_acct' WHERE id = '$id'";

  $result = mysqli_prepare($connection, $query);
  if(mysqli_stmt_execute($result)) {
      // If 'result' is successful, it will send the required message to client.php
    $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
    echo header ("Location: ../mfi/products.php?message3=$randms");
  } else {
     $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
     echo "error";
    echo header ("Location: ../mfi/products.php?message4=$randms");
      // echo header("location: ../mfi/client.php");
  }
}
mysqli_close($connection);
?>