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
$branch_id = $_SESSION["branch_id"];
$charge_cache = $_SESSION["stemp"];
// Declaring post values
$name = $_POST['name'];
$short_name = $_POST['short_name'];
$description = $_POST['description'];
$product_type = $_POST['product_type'];
$saving_cat = $_POST['saving_cat'];
$autocreate = $_POST['autocreate'];
$currency = $_POST['currency'];
$nominal_int_rate = $_POST['nominal_int_rate'];
$compound_period = $_POST['compound_period'];
$int_post_type = $_POST['int_post_type'];
$int_cal_type = $_POST['int_cal_type'];
$int_cal_days = $_POST['int_cal_days'];
$auto_op_bal = $_POST['auto_op_bal'];
$min_balance_cal = $_POST['min_balance_cal'];
// $max_pve_bal = $_POST['max_pve_bal'];
// $min_nve_bal = $_POST['min_nve_bal'];
$lock_per_freq = $_POST['lock_per_freq'];
$lock_per_freq_time = $_POST['lock_per_freq_time'];
$allover = $_POST['allover'];
$trk_dormancy = $_POST['trk_dormancy'];
// $with_notice = $_POST['with_notice'];
$dfpfi = "SELECT * from savings_product WHERE int_id = '$sessint_id' AND (name = '$name' OR short_name = '$short_name')";
$dp = mysqli_query($connection, $dfpfi);
$d = mysqli_fetch_array($dp);
$naming = $d['name'];
$shrtnaming = $d['short_name'];
if(($naming == $name) || ($shrtnaming == $short_name)) {
    $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
    echo "error";
   echo header ("Location: ../mfi/products_config.php?message11=$randms");
}
else{
// Query to Input data into table
$fomd = "INSERT INTO `savings_product` (`int_id`, `branch_id`, `name`, `short_name`, `description`,
 `currency_code`, `currency_digits`, `nominal_annual_interest_rate`, `interest_compounding_period_enum`,
  `interest_posting_period_enum`, `interest_calculation_type_enum`, `interest_calculation_days_in_year_type_enum`,
   `lockin_period_frequency`, `lockin_period_frequency_enum`, `accounting_type`,
   `allow_overdraft`, `is_dormancy_tracking_active`, `min_balance_for_interest_calculation`, `savings_cat`, `auto_create`,
    `min_required_balance`) 
        VALUES ('{$sessint_id}', '{$branch_id}', '{$name}', '{$short_name}', '{$description}', '{$currency}', '2', '{$nominal_int_rate}', '{$compound_period}', '{$int_post_type}'
        , '{$int_cal_type}', '{$int_cal_days}', '{$lock_per_freq}', '{$lock_per_freq_time}', '{$product_type}', '{$allover}', '{$trk_dormancy}', '{$min_balance_cal}'
        , '{$saving_cat}', '{$autocreate}', '{$auto_op_bal}')";
        $dona = mysqli_query($connection, $fomd);

        if($dona){
            $sjs = "SELECT * FROM savings_product WHERE int_id = '$sessint_id' AND name = '$name'";
            $djdj = mysqli_query($connection, $sjs);
            $xs = mysqli_fetch_array($djdj);
            $savingid = $xs['id'];

            $fod = "SELECT * FROM interest_rate_chart WHERE int_id = '$sessint_id' AND prod_cache_id = '$charge_cache'";
            $sdd = mysqli_query($connection, $fod);
            while($er = mysqli_fetch_array($sdd)){
                $inter_id = $er['id'];

                $code = "UPDATE interest_rate_chart SET savings_id = '$savingid', prod_cache_id = NULL WHERE int_id = '$sessint_id' AND prod_cache_id = '$charge_cache'";
                $coding =  mysqli_query($connection, $code);
            }
            if($coding){
                // query to add charges
    
                $charges = "SELECT * FROM charges_cache WHERE int_id = '$sessint_id' AND cache_prod_id = '$charge_cache'";
                $que = mysqli_query($connection, $charges);
                while($ef = mysqli_fetch_array($que)){
                    $iddd = $ef['id'];
                    $charge_id = $ef['charge_id'];
                     
                    $idn  = "INSERT INTO `savings_product_charge` (`int_id`, `savings_id`, `charge_id`)
                     VALUES ('{$sessint_id}', '{$savingid}', '{$charge_id}')";
                     $fif = mysqli_query($connection, $idn);
                     if($fif){
                        $dso = "DELETE FROM `charges_cache` WHERE id = '$iddd'";
                        $sodkfo = mysqli_query($connection, $dso);
                     }
                }
                if($sodkfo){
                    $loan_portfolio = $_POST['asst_loan_port'];
                    $insufficient_repay = $_POST['asst_insuff_rep'];
                    $overpayments = $_POST['li_overpayment'];
                    $suspended_income = $_POST['li_suspended_income'];
                    $income_interest = $_POST['inc_interest'];
                    $income_fees = $_POST['inc_fees'];
                    $income_penalties = $_POST['inc_penalties'];
                    $income_recovery = $_POST['inc_recovery'];
                    $bvni = $_POST['bvn_income'];
                    $bvne = $_POST['bvn_expense'];
                    $loss_written_off = $_POST['exp_loss_written_off'];
                    $interest_written_off = $_POST['exp_interest_written_off'];

                    $making = mysqli_query($connection, "INSERT INTO `savings_acct_rule` (`int_id`, `savings_product_id`,
                     `asst_loan_port`, `li_overpayment`, `li_suspended_income`, `inc_interest`, `inc_fees`, `inc_penalties`,
                      `inc_recovery`, `exp_loss_written_off`, `exp_interest_written_off`, `rule_type`, `insufficient_repayment`, `bvn_income`, `bvn_expense`)
                    VALUES ('{$sessint_id}', '{$savingid}', '{$loan_portfolio}', '{$overpayments}', '{$suspended_income}',
                     '{$income_interest}', '{$income_fees}', '{$income_penalties}', '{$income_recovery}', '{$loss_written_off}',
                      '{$interest_written_off}', '{$rand_id}', '{$insufficient_repay}', '{$bvni}', '{$bvne}')");

                      if($making){
                        $id_trans = $_SESSION["product_temp"];
                        $select_cache = mysqli_query($connection, "SELECT * FROM `prod_acct_cache` WHERE prod_cache_id = '$id_trans'");
                        while ($sc = mysqli_fetch_array($select_cache)) {
                        $gl_code = $sc["gl_code"];
                        $gl_name = $sc["name"];
                        $acct_gl_code = $sc["acct_gl_code"];
                        $acct = $sc["acct"];
                        $type_c = $sc["type"];
                        $insert_cache = mysqli_query($connection, "INSERT INTO `sav_acct` (`int_id`, `gl_code`, `name`, `savings_id`, `acct_gl_code`, `acct`, `type`)
                         VALUES ('{$sessint_id}', '{$gl_code}', '{$gl_name}', '{$savingid}', '{$acct_gl_code}', '{$acct}', '{$type_c}')");
                        if ($insert_cache) {
                            $delet_cache = mysqli_query($connection, "DELETE FROM `prod_acct_cache` WHERE prod_cache_id = '$id_trans'");
                        }
                      }
                    }
                    if ($delet_cache) {
                        $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
                        echo header ("Location: ../mfi/products_config.php?message1=$randms");
                    } else {
                        
                        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                        echo "error4";
                        // echo header ("Location: ../mfi/products_config.php?message2=$randms");
                    }
                    
                
                }
                else{
                    if ($connection->error) {
                        try {   
                            throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $msqli->errno);   
                        } catch(Exception $e ) {
                            echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                            echo nl2br($e->getTraceAsString());
                        }
                }
                echo "error3";
                }
            }
            else{
                if ($connection->error) {
                    try {   
                        throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $msqli->errno);   
                    } catch(Exception $e ) {
                        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                        echo nl2br($e->getTraceAsString());
                    }
            }
            echo "error2";
            }
        }
        else{
            if ($connection->error) {
            try {   
                throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $msqli->errno);   
            } catch(Exception $e ) {
                echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                echo nl2br($e->getTraceAsString());
            }
        }
        echo "error1";
        }
    }
?>