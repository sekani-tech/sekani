<?php include("connect.php") ?>
<?php
session_start();
$sint_id = $_SESSION['int_id'];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
if (isset($_POST['ftd_id'])) {
  $ftd_id = $_POST['ftd_id'];
  $name = $_POST['name'];
  $short_name = $_POST['short_name'];
  $description = $_POST['description'];
  $accounting_type = $_POST['product_type'];
  $deposit = $_POST['deposita'];
  $depositmin = $_POST['deposita_min'];
  $depositmax = $_POST['deposita_max'];
  $interest_compounding_period_enum = $_POST['compound_period'];
  $interest_posting_period_enum = $_POST['int_post_type'];
  $interest_calculation_type_enum = $_POST['int_cal_type'];
  $interest_calculation_days_in_year_type_enum = $_POST['int_cal_days'];
  $lockin_period_frequency = $_POST['lock_per_freq'];
  $lockin_period_frequency_enum = $_POST['lock_per_freq_time'];
  $minimum_deposit_term = $_POST['minimum_dep_term'];
  $minimum_deposit_term_time = $_POST['minimum_dep_term_time'];
  $maximum_deposit_term = $_POST['maximum_dep_term'];
  $maximum_deposit_term_time = $_POST['maximum_dep_term_time'];
  $in_multiples_deposit_term = $_POST['inmultiples_dep_term'];
  $in_multiples_deposit_term_time = $_POST['inmultiples_dep_term_time'];
  $auto_renew = $_POST['auto_renew'];

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
  $glCode = $_POST['glCode'];
  $expenseGl = $_POST['expense_gl'];

  $qurt = "UPDATE savings_product SET name = '{$name}', short_name = '{$short_name}', description = '{$description}',
    interest_compounding_period_enum = '{$interest_compounding_period_enum}', interest_posting_period_enum = '{$interest_posting_period_enum}',
    interest_calculation_type_enum = '{$interest_calculation_type_enum}', interest_calculation_days_in_year_type_enum = '{$interest_calculation_days_in_year_type_enum}',
    lockin_period_frequency = '{$lockin_period_frequency}', lockin_period_frequency_enum = '{$lockin_period_frequency_enum}', accounting_type = '{$accounting_type}',
    deposit_amount = '{$deposit}', min_deposit_amount = '{$depositmin}', max_deposit_amount = '{$depositmax}', minimum_deposit_term = '{$minimum_deposit_term}',
    minimum_deposit_term_time = '{$minimum_deposit_term_time}', maximum_deposit_term = '{$maximum_deposit_term}', maximum_deposit_term_time = '{$maximum_deposit_term_time}',
    in_multiples_deposit_term = '{$in_multiples_deposit_term}', in_multiples_deposit_term_time = '{$in_multiples_deposit_term_time}', auto_renew_on_closure = '{$auto_renew}',
    'expense_glcode' = '{$expenseGl}', gl_Code = '{$glCode}'
    WHERE int_id = '$sint_id' AND id = '$ftd_id'";
  $dfodf = mysqli_query($connection, $qurt);

  if ($dfodf) {
    $dfdi = "SELECT * FROM ftd_acct_rule WHERE int_id = '$sint_id' AND ftd_id = '$ftd_id'";
    $iofd = mysqli_query($connection, $dfdi);
    $f = mysqli_fetch_array($iofd);
    $dos = $f['ftd_id'];
    if ($dos == $ftd_id) {
      $sod = "UPDATE ftd_acct_rule SET asst_loan_port='{$asst_loan_port}', li_overpayment='{$li_overpayment}', li_suspended_income='{$li_suspended_income}',
          inc_interest='{$inc_interest}', inc_fees='{$inc_fees}', inc_penalties='{$inc_penalties}', inc_recovery='{$inc_recovery}', bvn_income='{$bvn_income}',
          bvn_expense='{$bvn_expense}', exp_loss_written_off='{$exp_loss_written_off}', exp_interest_written_off='{$exp_interest_written_off}', insufficient_repayment='{$insufficient_repayment}'
          WHERE int_id = '$sint_id' AND ftd_id = '$ftd_id'";
      $eiro = mysqli_query($connection, $sod);
    } else {
      $eiro = mysqli_query($connection, "INSERT INTO ftd_acct_rule (int_id, ftd_id,
          asst_loan_port, li_overpayment, li_suspended_income, inc_interest, inc_fees, inc_penalties,
          inc_recovery, exp_loss_written_off, exp_interest_written_off, insufficient_repayment, bvn_income, bvn_expense)
        VALUES ('{$sint_id}', '{$ftd_id}', '{$asst_loan_port}', '{$li_overpayment}', '{$li_suspended_income}',
          '{$inc_interest}', '{$inc_fees}', '{$inc_penalties}', '{$inc_recovery}', '{$exp_loss_written_off}',
          '{$exp_interest_written_off}', '{$insufficient_repayment}', '{$bvn_income}', '{$bvn_expense}')");
    }

    if ($eiro) {
      $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
      echo header("Location: ../mfi/products_config.php?message7=$randms");
    } else {
      $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
      echo "error";
      echo header("Location: ../mfi/products_config.php?message8=$randms");
      // echo header("location: ../mfi/client.php");
    }
  } else {
    $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
    echo "error";
  }
  if ($connection->error) {
    try {
      throw new Exception("MySQL error $connection->error <br> Query:<br> $qurt", $mysqli->error);
    } catch (Exception $e) {
      echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >";
      echo nl2br($e->getTraceAsString());
    }
  }
}
