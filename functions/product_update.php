<?php include("connect.php")?>
<?php
session_start();
$sint_id = $_SESSION['int_id'];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
if (isset($_POST['prod_id'])) {
  $Loan_prod = $_POST['prod_id'];

$name = $_POST['name'];
$short_name = $_POST['short_name'];
$description = $_POST['description'];
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
$grace_on_principal = $_POST['grace_on_principal'];
$grace_on_interest = $_POST['grace_on_interest'];
$grace_on_interest_charged = $_POST['grace_on_interest_charged'];
$interest_rate_methodology = $_POST['interest_rate_methodoloy'];
$ammortization_method = $_POST['ammortization_method'];
$cycle_count = $_POST['cycle_count'];
$auto_allocate_overpayment = $_POST['auto_allocate_overpayment'];
$additional_charge = $_POST['additional_charge'];

$asst_loan_port = $_POST['asst_loan_port']; 
$li_overpayment = $_POST['li_overpayment'];
$li_suspended_income = $_POST['li_suspended_income'];
$inc_interest = $_POST['inc_interest'];
$inc_fees = $_POST['inc_fees'];
$inc_penalties = $_POST['inc_penalties']; 
$inc_recovery = $_POST['inc_recovery']; 
$exp_loss_written_off = $_POST['exp_loss_written_off']; 
$exp_interest_written_off = $_POST['exp_interest_written_off'];
$insufficient_repayment = $_POST['asst_insuff_rep'];

  $query = "UPDATE product SET  name = '$name', short_name = '$short_name', description = '$description', in_amt_multiples = '$in_amt_multiples',
   principal_amount = '$principal_amount', min_principal_amount = '$min_principal_amount', max_principal_amount = '$max_principal_amount', loan_term = '$loan_term', min_loan_term = '$min_loan_term', max_loan_term = '$max_loan_term',
   repayment_frequency = '$repayment_frequency', repayment_every = '$repayment_every', interest_rate = '$interest_rate', min_interest_rate = '$min_interest_rate',  max_interest_rate = '$max_interest_rate', interest_rate_applied = '$interest_rate_applied',
   interest_rate_methodoloy = '$interest_rate_methodology', ammortization_method = '$ammortization_method', cycle_count = '$cycle_count', auto_allocate_overpayment = '$auto_allocate_overpayment', additional_charge = '$additional_charge'
    WHERE int_id = '$sint_id' AND id = '$Loan_prod'";

  $result = mysqli_query($connection, $query);
  if($result) {
    $dfer = "UPDATE acct_rule SET asst_loan_port= '{$asst_loan_port}', li_overpayment= '{$li_overpayment}', li_suspended_income= '{$li_suspended_income}', inc_interest= '{$inc_interest}',
    inc_fees= '{$inc_fees}', inc_penalties= '{$inc_penalties}', inc_recovery= '{$inc_recovery}', exp_loss_written_off= '{$exp_loss_written_off}', exp_interest_written_off= '{$exp_interest_written_off}',
    insufficient_repayment= '{$insufficient_repayment}' WHERE int_id = '$sint_id' AND loan_product_id = '$Loan_prod'";
      // If 'result' is successful, it will send the required message to client.php
      $mfdi = mysqli_query($connection, $dfer);
      if($mfdi){
        $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
        echo header ("Location: ../mfi/products_config.php?message7=$randms");
      }
      else {
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
        echo "error";
       echo header ("Location: ../mfi/products_config.php?message8=$randms");
         // echo header("location: ../mfi/client.php");
    
  }
 }
  else {
     $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
     echo "error";
    echo header ("Location: ../mfi/products_config.php?message8=$randms");
      // echo header("location: ../mfi/client.php");
  }
}
mysqli_close($connection);
?>