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
// $fund_id = $_POST['fund_id'];
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
// $asst_fund_src = $_POST["asst_fund_src"];
$asst_loan_port = $_POST["asst_loan_port"];
$asst_insuff_rep = $_POST["asst_insuff_rep"];
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
in_amt_multiples, principal_amount, min_principal_amount, max_principal_amount,
loan_term, min_loan_term, max_loan_term, repayment_frequency, repayment_every,
interest_rate, min_interest_rate, max_interest_rate, interest_rate_applied, interest_rate_methodoloy,
ammortization_method, cycle_count, auto_allocate_overpayment, additional_charge,
grace_on_principal_amount, grace_on_interest_amount, grace_on_interest_charged) VALUES ('{$sessint_id}', '{$charge_id}', '{$rand_id}', '{$name}', '{$short_name}', '{$description}', 
'{$in_amt_multiples}', '{$principal_amount}', '{$min_principal_amount}', '{$max_principal_amount}',
'{$loan_term}', '{$min_loan_term}', '{$max_loan_term}', '{$repayment_frequency}', '{$repayment_every}',
'{$interest_rate}', '{$min_interest_rate}', '{$max_interest_rate}', '{$interest_rate_applied}', '{$interest_rate_methodoloy}',
'{$ammortization_method}', '{$cycle_count}', '{$auto_allocate_overpayment}', '{$additional_charge}',
'{$g_principal}', '{$g_interest}', '{$g_interest_charged}')";

$res = mysqli_query($connection, $query);
// wikinigs
 if ($res) {
    $id_of_p = mysqli_query($connection, "SELECT * FROM product WHERE rand_id = '$rand_id' && int_id = '$sessint_id'");
    $mr = mysqli_fetch_array($id_of_p);
    $product_id = $mr["id"];
    if ($product_id != 0 || $product_id != "") {
        $making = mysqli_query($connection, "INSERT INTO `acct_rule` (`int_id`, `loan_product_id`, `asst_loan_port`, `li_overpayment`, `li_suspended_income`, `inc_interest`, `inc_fees`, `inc_penalties`, `inc_recovery`, `exp_loss_written_off`, `exp_interest_written_off`, `rule_type`, `insufficient_repayment`)
        VALUES ('{$sessint_id}', '{$product_id}', '{$asst_loan_port}', '{$li_overpayment}', '{$li_suspended_income}', '{$inc_interest}', '{$inc_fees}', '{$inc_penalties}', '{$inc_recovery}', '{$exp_loss_written_off}', '{$exp_interest_written_off}', '{$rand_id}', '{$asst_insuff_rep}')");
        if ($making) {
            $id_trans = $_SESSION["product_temp"];
            $select_cache = mysqli_query($connection, "SELECT * FROM `prod_acct_cache` WHERE prod_cache_id = '$id_trans'");
            while ($sc = mysqli_fetch_array($select_cache)) {
            $gl_code = $sc["gl_code"];
            $gl_name = $sc["name"];
            $acct_gl_code = $sc["acct_gl_code"];
            $acct = $sc["acct"];
            $type_c = $sc["type"];
            $insert_cache = mysqli_query($connection, "INSERT INTO `prod_acct` (`int_id`, `gl_code`, `name`, `acct_gl_code`, `acct`, `prod_id`, `type`) VALUES ('$sessint_id', 
            '{$gl_code}', '{$gl_name}', '{$acct_gl_code}', '{$acct}', '{$product_id}', '{$type_c}')");
            if ($insert_cache) {
                $delet_cache = mysqli_query($connection, "DELETE FROM `prod_acct_cache` WHERE prod_cache_id = '$id_trans'");
            } else {
                $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
            echo "error";
           echo header ("Location: ../mfi/products.php?message2=$randms");
            }
            }
            $select_charge = mysqli_query($connection, "SELECT * FROM `charges_cache` WHERE cache_prod_id = '$id_trans'");
            if($select_charge) {
                    while ($sxx = mysqli_fetch_array($select_charge)) {
                        echo "hello";
                        $charge_idx = $sxx["charge_id"];
                        $insert_charge = mysqli_query($connection, "INSERT INTO `product_loan_charge` (`int_id`, `product_loan_id`, `charge_id`) VALUES
                         ('{$sessint_id}', '{$product_id}', '{$charge_idx}')");
                        if ($insert_charge) {
                            $delet_cache = mysqli_query($connection, "DELETE FROM `charges_cache` WHERE cache_prod_id = '$id_trans'");
                            if ($delet_cache) {
                                $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
                    echo header ("Location: ../mfi/products.php?message1=$randms");
                            } else {
                                // error
                                $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
            echo "error";
           echo header ("Location: ../mfi/products.php?message2=$randms");
                            }
                        } else {
                            // error
                            $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
            echo "error";
           echo header ("Location: ../mfi/products.php?message2=$randms");
                        }
                    }
                } else{
                    echo "Error here";
                }
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