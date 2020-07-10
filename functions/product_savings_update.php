<?php include("connect.php")?>
<?php
session_start();
$sint_id = $_SESSION['int_id'];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
if (isset($_POST['sav_id'])) {
    $sav_id = $_POST['sav_id'];
    $name = $_POST['name'];
    $short_name = $_POST['short_name'];
    $description = $_POST['description'];
    $accounting_type = $_POST['accounting_type'];
    $saving_cat = $_POST['saving_cat'];
    $auto_renew = $_POST['auto_renew'];
    $currency = $_POST['currency_code'];
    $noml_al_int_rate = $_POST['nominal_annual_interest_rate'];
    $interest_compounding_period_enum = $_POST['interest_compounding_period_enum'];
    $interest_posting_period_enum = $_POST['interest_posting_period_enum'];
    $interest_calculation_type_enum = $_POST['interest_calculation_type_enum'];
    $interest_calculation_days_in_year_type_enum = $_POST['interest_calculation_days_in_year_type_enum'];
    $min_required_opening_balance = $_POST['min_required_opening_balance'];
    $min_balance_for_interest_calculation = $_POST['min_balance_for_interest_calculation'];
    $minimum_negative_balance = $_POST['minimum_negative_balance'];
    $maximum_positve_balance = $_POST['maximum_positve_balance'];
    $lockin_period_frequency = $_POST['lockin_period_frequency'];
    $lockin_period_frequency_enum = $_POST['lockin_period_frequency_enum'];
    $allow_overdraft = $_POST['allow_overdraft'];
    $is_dormancy_tracking_active = $_POST['is_dormancy_tracking_active'];
    $enable_withdrawal_notice = $_POST['enable_withdrawal_notice'];

    $asst_loan_port = $_POST['asst_loan_port'];
    $li_overpayment = $_POST['li_overpayment'];
    $li_suspended_income = $_POST['li_suspended_income'];
    $inc_interest = $_POST['inc_interest'];
    $inc_fees = $_POST['inc_fees'];
    $inc_penalties = $_POST['inc_penalties'];
    $inc_recovery = $_POST['inc_recovery'];
    $bvn_income = $_POST['bvn_income'];
    $bvn_expense = $_POST['bvn_expense'];
    $exp_loss_written_off = $_POST['exp_loss_written_off'];
    $exp_interest_written_off = $_POST['exp_interest_written_off'];
    $insufficient_repayment = $_POST['insufficient_repayment'];

    $qurt = "UPDATE savings_product SET name='{$name}', short_name='{$short_name}', description='{$description}', savings_cat='{$saving_cat}', currency_code='{$currency}', nominal_annual_interest_rate='{$noml_al_int_rate}',
      interest_compounding_period_enum='{$interest_compounding_period_enum}',  interest_posting_period_enum='{$interest_posting_period_enum}',  interest_calculation_type_enum='{$interest_calculation_type_enum}',  interest_calculation_days_in_year_type_enum='{$interest_calculation_days_in_year_type_enum}', 
     min_required_opening_balance='{$min_required_opening_balance}', lockin_period_frequency='{$lockin_period_frequency}', lockin_period_frequency_enum='{$lockin_period_frequency_enum}', accounting_type='{$accounting_type}', maximum_positve_balance='{$maximum_positve_balance}', 
      minimum_negative_balance='{$minimum_negative_balance}', allow_overdraft='{$allow_overdraft}', min_balance_for_interest_calculation='{$min_balance_for_interest_calculation}', auto_renew_on_closure='{$auto_renew}', 
     is_dormancy_tracking_active='{$is_dormancy_tracking_active}',  enable_withdrawal_notice='{$enable_withdrawal_notice}' WHERE int_id = '$sint_id' AND id = '$sav_id'";
     $dfodf = mysqli_query($connection, $qurt);

     if($qurt){
         $sod = "UPDATE savings_acct_rule SET asst_loan_port='{$asst_loan_port}', li_overpayment='{$li_overpayment}', li_suspended_income='{$li_suspended_income}',
          inc_interest='{$inc_interest}', inc_fees='{$inc_fees}', inc_penalties='{$inc_penalties}', inc_recovery='{$inc_recovery}', bvn_income='{$bvn_income}',
          bvn_expense='{$bvn_expense}', exp_loss_written_off='{$exp_loss_written_off}', exp_interest_written_off='{$exp_interest_written_off}', insufficient_repayment='{$insufficient_repayment}'
          WHERE int_id = '$sint_id' AND savings_product_id = '$sav_id'";
          $eiro = mysqli_query($connection, $sod);
          if($eiro){
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
}