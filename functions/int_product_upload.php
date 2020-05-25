<?php
// called database connection
include("connect.php");
// user management
session_start();
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sessint_id = $_SESSION["int_id"];
$charge_id = $_POST['charge_id'];
$rand_id = $randms;
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
$g_principal = $_POST['grace_on_principal'];
$g_interest = $_POST['grace_on_interest'];
$g_interest_charged = $_POST['grace_on_interest_charged'];
$interest_rate_applied = $_POST['interest_rate_applied'];
$interest_rate_methodoloy = $_POST['interest_rate_methodoloy'];
$ammortization_method = $_POST['ammortization_method'];
$cycle_count = $_POST['cycle_count'];
$auto_allocate_overpayment = $_POST['auto_allocate_overpayment'];
$additional_charge = $_POST['additional_charge'];
// loan product adding CHARGE PLACE
// LOAN PRODUCT ADDING ACCOUNTING RULE
$asst_fund_src = $_POST["asst_fund_src"];
$asst_loan_port = $_POST["asst_loan_port"];
$li_overpayment = $_POST["li_overpayment"];
$li_suspended_income = $_POST["li_suspended_income"];
$inc_interest = $_POST["inc_interest"];
$inc_fees = $_POST["inc_fees"];
$inc_penalties = $_POST["inc_penalties"];
$inc_recovery = $_POST["inc_recovery"];
$exp_loss_written_off = $_POST["exp_loss_written_off"];
$exp_interest_written_off = $_POST["exp_interest_written_off"];
// insertion query for product
$query = "INSERT INTO product (int_id, charge_id, rand_id, name, short_name, description, 
fund_id, in_amt_multiples, principal_amount, min_principal_amount, max_principal_amount,
loan_term, min_loan_term, max_loan_term, repayment_frequency, repayment_every,
interest_rate, min_interest_rate, max_interest_rate, interest_rate_applied, interest_rate_methodoloy,
ammortization_method, cycle_count, auto_allocate_overpayment, additional_charge,
auto_disburse, linked_savings_acct, grace_on_principal_amount, grace_on_interest_amount, grace_on_interest_charged) VALUES ('{$sessint_id}', '{$charge_id}', '{$rand_id}', '{$name}', '{$short_name}', '{$description}', 
'{$fund_id}', '{$in_amt_multiples}', '{$principal_amount}', '{$min_principal_amount}', '{$max_principal_amount}',
'{$loan_term}', '{$min_loan_term}', '{$max_loan_term}', '{$repayment_frequency}', '{$repayment_every}',
'{$interest_rate}', '{$min_interest_rate}', '{$max_interest_rate}', '{$interest_rate_applied}', '{$interest_rate_methodoloy}',
'{$ammortization_method}', '{$cycle_count}', '{$auto_allocate_overpayment}', '{$additional_charge}',
'{$auto_disburse}', '{$linked_savings_acct}', '{$g_principal}', '{$g_interest}', '{$g_interest_charged}')";

$res = mysqli_query($connection, $query);

 if ($res) {
    $id_of_p = mysqli_query($connection, "SELECT * FROM product WHERE rand_id = '$rand_id' && int_id = '$sessint_id'");
    $mr = mysqli_fetch_array($id_of_p);
    $product_id = $mr["id"];
    if ($product_id != 0 || $product_id != "") {
        $making = mysqli_query($connection, "INSERT INTO `acct_rule` (`int_id`, `loan_product_id`, `asst_fund_src`, `asst_loan_port`, `li_overpayment`, `li_suspended_income`, `inc_interest`, `inc_fees`, `inc_penalties`, `inc_recovery`, `exp_loss_written_off`, `exp_interest_written_off`, `rule_type`)
        VALUES ('{$sessint_id}', '{$product_id}', '{$asst_fund_src}', '{$asst_loan_port}', '{$li_overpayment}', '{$li_suspended_income}', '{$inc_interest}', '{$inc_fees}', '{$inc_penalties}', '{$inc_recovery}', '{$exp_loss_written_off}', '{$exp_interest_written_off}', '{$rand_id}')");
        if ($making) {
            $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
    echo header ("Location: ../mfi/products.php?message1=$randms");
        } else {
            $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
            echo "error";
           echo header ("Location: ../mfi/products.php?message2=$randms");
        }
    } else {
        // echo out
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
        echo "error";
       echo header ("Location: ../mfi/products.php?message2=$randms");
    }
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/products.php?message2=$randms");
            // echo header("location: ../mfi/client.php");
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