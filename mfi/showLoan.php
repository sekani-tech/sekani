<?php

$page_title = "Approve Loan";
$destination = "disbursement_approval.php";
include("header.php");
include("ajaxcall.php");

// call
require_once "../bat/phpmailer/PHPMailerAutoload.php";
// qwertyuiop
// CHECK HTN APPROVAL
$sender_id = $_SESSION["sender_id"];
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$sessuser_id = $_SESSION["user_id"];
// writing a new code syn here
?>
<?php
if (isset($_GET['approve']) && $_GET['approve'] !== '') {
  $appod = $_GET['approve'];
  $checkm = mysqli_query($connection, "SELECT * FROM loan_disbursement_cache WHERE id = '$appod' AND int_id = '$sessint_id' && status = 'Pending'");
  if (count([$checkm]) == 1) {
    $x = mysqli_fetch_array($checkm);
    $ssint_id = $_SESSION["int_id"];
    $client_id = $x["client_id"];
    // GET CLIENT DETAILS LIKE EMAIL
    $get_client_degtails = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id' AND int_id = '$sessint_id'");
    // GET IT
    $cxp = mysqli_fetch_array($get_client_degtails);
    $client_email = $cxp["email_address"];
    $crn = $cxp["firstname"] . " " . $cxp["lastname"];
    $client_phone = $cxp["mobile_no"];
    $client_sms = $cxp["SMS_ACTIVE"];
    $state = strtolower($cxp["STATE_OF_ORIGIN"]);
    $state_ai = "other";
    if ($state == "akute"  || $state == "agege" || $state == "abuja" || $state == "ayobo" || $state == "agbado" || $state == "akure" || $state == "badagry" || $state == "ibadan" || $state == "jos" || $state == "kaduna" || $state == "lagosisland" || $state == "lagos" || $state == "lekki" || $state == "nassarawa" || $state == "ogun" || $state == "oyo" || $state == "ondo") {
      $state_ai = $state;
    } else if ($state == "oshodi" || $state == "surulere" || $state == "zamfara") {
      $state_ai = $state;
    } else {
      $state_ai = "other";
    }
    $gender = ucfirst(strtolower($cxp["gender"]));
    $pint = date('Y-m-d H:i:s');
    // phone for email
    $client_phone = $cxp["mobile_no"];
    // end client
    $sub_user_id = $x["submittedon_userid"];
    $sub_user_date = $x["submittedon_date"];
    $cn = $x['display_name'];
    $loan_product = $x["product_id"];
    $loan_sector = $x["loan_sub_status_id"];
    $account_officer = $x["loan_officer"];
    $acct_no = $x["account_no"];
    $dis_cache_status = $x["status"];
    // GET THE GL _ MONEY WILL COME OUT FROM

    $exp_mature_date = $x["expected_maturedon_date"];
    $pay_id = $x["fund_id"];
    $loan_purpose = $x["loan_purpose"];
    $branch_id = $_SESSION["branch_id"];
    $app_user = $_SESSION["staff_id"];
    $get_payment_gl = mysqli_query($connection, "SELECT * FROM acct_rule WHERE loan_product_id = '$loan_product' AND int_id = '$sessint_id'");
    $fool = mysqli_fetch_array($get_payment_gl);
    $ggl = $fool["asst_loan_port"];
    // Get the GL and the balance
    $get_gl = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE gl_code = '$ggl' AND int_id = '$sessint_id'");
    $fool1 = mysqli_fetch_array($get_gl);
    $running_gl_balance = $fool1["organization_running_balance_derived"];
    // END GL_BALANCE

    // here are the things
    $interest = $x["interest_rate"];
    $prin_amt = $x["approved_principal"];
    $loan_term = $x["loan_term"];
    $repay_eve = $x["repay_every"];
    $no_repayments = $x["number_of_repayments"];
    $disburse_date = $x["disbursement_date"];
    $repayment_date = $x["repayment_date"];
    $term_frequency = $x["term_frequency"];
    $date = date('d, D, F, Y', strtotime($disburse_date));
    $date2 = date('d, D, F, Y', strtotime($repayment_date));
    // calculation
    if (strtolower($repay_eve) == "month") {
      $tot_int = ((($interest / 100) * $prin_amt) * $loan_term);
      $prin_due = $tot_int + $prin_amt;
    } else if (strtolower($repay_eve) == "week") {
      $term = $loan_term / 4;
      $tot_int = ((($interest / 100) * $prin_amt) * $term);
      $prin_due = $tot_int + $prin_amt;
    } else if (strtolower($repay_eve) == "day") {
      $term = $loan_term / 30;
      $tot_int = ((($interest / 100) * $prin_amt) * $term);
      $prin_due = $tot_int + $prin_amt;
    }
    // get off
    $get_off = mysqli_query($connection, "SELECT * FROM staff WHERE id = '$account_officer'");
    $cx = mysqli_fetch_assoc($get_off);
    $off_dis = strtoupper($cx["display_name"]);
    $account_display = substr("$acct_no", 7) . "*****" . substr("$acct_no", 8);
    // sector
    $me = "";
    if ($loan_sector == 1) {
      $loan_sec = "Agriculture, Mining & Quarry";
    } else if ($loan_sector == 2) {
      $loan_sec = "Manufacturing";
    } else if ($loan_sector == 3) {
      $loan_sec = "Agricultural sector";
    } else if ($loan_sector == 4) {
      $loan_sec = "Banking";
    } else if ($loan_sector == 5) {
      $loan_sec = "Public Service";
    } else if ($loan_sector == 6) {
      $loan_sec = "Health";
    } else if ($loan_sector == 7) {
      $loan_sec = "Education";
    } else if ($loan_sector == 8) {
      $loan_sec = "Tourism";
    } else if ($loan_sector == 9) {
      $loan_sec = "Civil Service";
    } else if ($loan_sector == 10) {
      $loan_sec = "Trade & Commerce";
    } else if ($loan_sector == 11) {
      $loan_sec = "Others";
    } else {
      $loan_sec = "Others";
    }

    // get the product
    $ln_prod =  mysqli_query($connection, "SELECT * FROM product WHERE id = '$loan_product' && int_id = '$sessint_id'");
    $pd = mysqli_fetch_array($ln_prod);
    $ln_prod_name = $pd["name"];
    $ln_prod_repay_frequency = $pd["repayment_frequency"];
    // app staff id.
    $check_users = mysqli_query($connection, "SELECT * FROM users WHERE id = '$sub_user_id' && int_id = '$sessint_id'");
    $mx = mysqli_fetch_array($check_users);
    $user_fullname = $mx["fullname"];
    // we will start the computation for the credit check
    $general1 = mysqli_query($connection, "SELECT * FROM `loan_repayment_status` WHERE int_id = '$sessint_id' && client_id = '$client_id'");
    $gen1 = mysqli_num_rows($general1);
    // repayment
    $get_delin1 = mysqli_query($connection, "SELECT * FROM `loan_repayment_status` WHERE int_id = '$sessint_id' && client_id = '$client_id' && status = '0'");
    $early_rep = mysqli_num_rows($get_delin1);
    $get_delin2 = mysqli_query($connection, "SELECT * FROM `loan_repayment_status` WHERE int_id = '$sessint_id' && client_id = '$client_id' && status = '1'");
    $imm_rep = mysqli_num_rows($get_delin2);
    $get_delin3 = mysqli_query($connection, "SELECT * FROM `loan_repayment_status` WHERE int_id = '$sessint_id' && client_id = '$client_id' && status = '2'");
    $late_rep = mysqli_num_rows($get_delin3);
    //  get the query row calculated

    // loan behaviour
    $get_loan1 = mysqli_query($connection, "SELECT * FROM `loan_repayment_status` WHERE int_id = '$sessint_id' && client_id = '$client_id' && loan_status = '0'");
    // give the row
    $atv_loan = mysqli_num_rows($get_loan1);
    $get_loan2 = mysqli_query($connection, "SELECT * FROM `loan_repayment_status` WHERE int_id = '$sessint_id' && client_id = '$client_id' && loan_status = '1'");
    // give the row
    $bad_loan = mysqli_num_rows($get_loan2);
    $get_loan3 = mysqli_query($connection, "SELECT * FROM `loan_repayment_status` WHERE int_id = '$sessint_id' && client_id = '$client_id' && loan_status = '2'");
    // give the row
    $wrt_loan = mysqli_num_rows($get_loan3);
    $get_loan4 = mysqli_query($connection, "SELECT * FROM `loan` WHERE (int_id = '$sessint_id' AND client_id = '$client_id') AND (total_outstanding_derived > '0' OR total_outstanding_derived > 0)");
    // Loan Behaviour
    $out_loan = mysqli_num_rows($get_loan4);

    // clients KYC
    $kyc_query = mysqli_query($connection, "SELECT * FROM kyc WHERE int_id = '$sessint_id' && client_id = '$client_id' ORDER BY id DESC LIMIT 1");
    $kyc_query1 = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '$sessint_id' && id = '$client_id'");
    // the computation comes in
    // new
    $kyc_col = mysqli_query($connection, "SELECT * FROM collateral WHERE int_id = '$sessint_id' && client_id = '$client_id' ORDER BY id DESC LIMIT 1");
    $cm = mysqli_fetch_assoc($kyc_col);
    $kq = mysqli_fetch_assoc($kyc_query);
    $kq1 = mysqli_fetch_assoc($kyc_query1);
    $col_va = $cm["value"];
    $agex = $kq1["date_of_birth"];
    $age = (date('Y') - date('Y', strtotime($agex)));

    $k_in = $kq["income"];
    $k_yb = $kq["years_in_job"];
    $k_mart = $kq["marital_status"];
    $k_dep = $kq["no_of_dependent"];
    $k_edu = $kq["level_of_ed"];
    $k_other_bank = str_replace(' ', '%20', $kq["other_bank"]);
    $k_emp_category = $name = str_replace(' ', '%20', $kq["emp_category"]);
    // meaning
    $yicj = "";
    $mst = "";
    $nod = "";
    $loe = "";
    if ($k_yb != "") {
      $yicj = $k_yb . " years";
    } else {
      echo "Non";
    }

    if ($k_mart == "1") {
      $mst = "Single";
    } else {
      $mst = "Married";
    }

    if ($k_dep != "") {
      $nod = $k_dep;
    } else if ($k_dep == "7") {
      $nod = "7 or More";
    }

    if ($k_edu != "") {
      $loe = $k_edu;
    } else {
      $loe = "Unknown";
    }


    // Savings Behaviour
    $savings_query1 = mysqli_query($connection, "SELECT AVG(running_balance_derived) AS av_one FROM account_transaction WHERE int_id = '$sessint_id' AND client_id = '$client_id'");
    // show a figure
    $s1 = mysqli_fetch_assoc($savings_query1);
    $s1x = $s1["av_one"];
    $savings_query2 = mysqli_query($connection, "SELECT MAX(running_balance_derived) AS mx_one FROM account_transaction WHERE int_id = '$sessint_id' AND client_id = '$client_id'");
    // show a figure
    $s2 = mysqli_fetch_assoc($savings_query2);
    $s2x = $s2["mx_one"];
    $savings_query3 = mysqli_query($connection, "SELECT * FROM account_transaction WHERE (int_id = '$sessint_id' AND client_id = '$client_id') AND (transaction_type = 'credit' OR transaction_type = 'Credit')");
    // show sum of row
    $acct_credit = mysqli_num_rows($savings_query3);
    $savings_query4 = mysqli_query($connection, "SELECT * FROM account_transaction WHERE (int_id = '$sessint_id' AND client_id = '$client_id') AND (transaction_type = 'debit' OR transaction_type = 'Debit')");
    // show sum of row
    $acct_debit = mysqli_num_rows($savings_query4);

    $savings_query5 = mysqli_query($connection, "SELECT AVG(amount) AS av_two FROM account_transaction WHERE (int_id = '$sessint_id' AND client_id = '$client_id') AND (transaction_type = 'credit' OR transaction_type = 'Credit')");
    // show amount
    $s5 = mysqli_fetch_assoc($savings_query5);
    $s5x = $s5["av_two"];
    $savings_query6 = mysqli_query($connection, "SELECT AVG(amount) AS av_three FROM account_transaction WHERE (int_id = '$sessint_id' AND client_id = '$client_id') AND (transaction_type = 'debit' OR transaction_type = 'Debit')");
    // show amount
    $s6 = mysqli_fetch_assoc($savings_query6);
    $s6x = $s6["av_three"];

    // let the system take the pricing descision
    // before descision making do some percentage risk analysis
    // AUTOMATED PRINCIAPL SUGGESTION
    $automated_principal = $prin_amt;
    $auto_perc = 100;
    // we will have a reducing percentage and also individual
    // FIRST REPAYMENT
    $total_early = 100 + 30;
    $total_imm = 100 + 30;
    $total_bad = 100 + 30;

    // GENERAL critarial - BASED ON BIG 100
    $mxx = $early_rep != 0 ? ($early_rep / $gen1) * 100 : 0;
    $mxx1 = $imm_rep != 0 ? ($imm_rep / $gen1) * 100 : 0;
    $mxx2 = $late_rep != 0 ? ($late_rep / $gen1) * 100 : 0;

    if ($mxx >= 0 && $mxx <= 30) {
      $total_early -= 40;
      $total_imm -= 10;
      $total_bad -= 20;
    } else if ($mxx > 30 && $mxx <= 50) {
      $total_early -= 30;
      $total_imm -= 40;
      $total_bad -= 40;
    } else if ($mxx > 50 && $mxx <= 80) {
      $total_early -= 20;
      $total_imm -= 50;
      $total_bad -= 50;
    } else if ($mxx > 80 && $mxx < 100) {
      $total_early -= 10;
      $total_imm -= 60;
      $total_bad -= 70;
    } else if ($mxx >= 100) {
      $total_early -= 8;
      $total_imm -= 69;
      $total_bad -= 78;
    }
    // END OF 
    if ($mxx1 >= 0 && $mxx1 <= 30) {
      $total_early -= 10;
      $total_imm -= 40;
      $total_bad -= 20;
      // you stopped here
    } else if ($mxx1 > 30 && $mxx1 <= 50) {
      $total_early -= 40;
      $total_imm -= 30;
      $total_bad -= 40;
    } else if ($mxx1 > 50 && $mxx1 <= 80) {
      $total_early -= 50;
      $total_imm -= 20;
      $total_bad -= 40;
    } else if ($mxx1 > 80 && $mxx1 < 100) {
      $total_early -= 70;
      $total_imm -= 10;
      $total_bad -= 60;
    } else if ($mxx1 >= 100) {
      $total_early -= 79;
      $total_imm -= 8;
      $total_bad -= 60;
      // DAMN
    }
    // END
    if ($mxx2 >= 0 && $mxx2 <= 30) {
      $total_early -= 10;
      $total_imm -= 20;
      $total_bad -= 40;
    } else if ($mxx2 > 30 && $mxx2 <= 50) {
      $total_early -= 40;
      $total_imm -= 40;
      $total_bad -= 30;
    } else if ($mxx2 > 50 && $mxx2 <= 80) {
      $total_early -= 50;
      $total_imm -= 40;
      $total_bad -= 20;
    } else if ($mxx2 > 80 && $mxx2 < 100) {
      $total_early -= 70;
      $total_imm -= 60;
      $total_bad -= 10;
      $auto_perc -= 0.4;
    } else if ($mxx2 >= 100) {
      $total_early -= 79;
      $total_imm -= 60;
      $total_bad -= 8;
    }
    // FOR LOAN STAT
    // REPAYMENT COLOR
    $color = "";
    if ($total_early > $total_imm && $total_early > $total_bad) {
      $color = "success";
      $auto_perc -= 0.02;
    } else if ($total_imm > $total_early && $total_imm > $total_bad) {
      $color = "warning";
      $auto_perc -= 1;
    } else {
      $color = "danger";
      $auto_perc -= 2;
    }
    // LOAN STAT
    $col_2 = "";
    if ($out_loan >= $atv_loan || $wrt_loan > $wrt_loan && $out_loan > 0) {
      $bad = 40;
      $warn = 40;
      $good = 20;
      $col_2 = "warning";
      $auto_perc -= 1;
    } else if ($out_loan == $atv_loan && $wrt_loan == $wrt_loan && $out_loan > 0) {
      $bad = 48;
      $warn = 26;
      $good = 26;
      $col_2 = "danger";
      $auto_perc -= 2;
    } else if ($out_loan <= $atv_loan || $wrt_loan >= $atv_loan && $out_loan > 0) {
      $bad = 30;
      $warn = 40;
      $col_2 = "warning";
      $good = 30;
      $auto_perc -= 1;
    } else {
      $bad = 20;
      $warn = 30;
      $good = 50;
      $col_2 = "success";
      $auto_perc -= 0.02;
      // new computation
    }
    // KYC LOAN
    // DEFINE WARN, BAD, GOOD TO ZERO
    $warn1 = 0;
    $bad1 = 0;
    $good1 = 0;
    // logic GET THE AGE - 18 - 25 = WARN (50) - BAD (30) - GOOD (20)
    if ($age >= 18 && $age <= 25) {
      // wanr
      $wa = 50;
      $ba = 30;
      $ga = 20;
    } else if ($age > 25 && $age <= 80) {
      // cool
      $wa = 30;
      $ba = 20;
      $ga = 50;
    } else {
      // bad
      $wa = 40;
      $ba = 50;
      $ga = 10;
    }
    // INCOME - GREATER THEN PRIN = WARN (20) - BAD (20) - GOOD (60)
    if ($k_in >= $prin_amt) {
      $wa1 = 30;
      $ba1 = 10;
      $ga1 = 60;
    } else if ($k_in < $prin_amt) {
      $wa1 = 40;
      $ba1 = 50;
      $ga1 = 10;
    } else {
      $wa1 = 50;
      $ba1 = 40;
      $ga1 = 10;
    }
    // YEARS IN - GREATER THEN
    if ($k_yb >= 4 && $k_yb < 5) {
      $wa2 = 30;
      $ba2 = 10;
      $ga2 = 60;
    } else if ($k_yb >= 2 && $k_yb < 4) {
      $wa2 = 40;
      $ba2 = 50;
      $ga2 = 10;
    } else if ($k_yb < 2) {
      $wa2 = 50;
      $ba2 = 40;
      $ga2 = 10;
    }
    // DMAN
    if ($k_edu >= 4) {
      $wa3 = 30;
      $ba3 = 10;
      $ga3 = 60;
    } else if ($k_yb >= 2 && $k_yb <= 3) {
      $wa3 = 40;
      $ba3 = 50;
      $ga3 = 10;
    } else if ($k_yb < 2) {
      $wa3 = 50;
      $ba3 = 40;
      $ga3 = 10;
    }
    // ARRANGE EVERY - WARN > BAD
    $warn1 = $wa + $wa1 + $wa2;
    $bad1 = $ba + $ba1 + $ba2;
    $good1 = $ga + $ga1 + $ga2;
    if ($bad1 >= $good1 && $bad1 > $warn1) {
      $warn1 = 30;
      $bad1 = 40;
      $good1 = 30;
    } else if ($warn1 > $bad1 && $warn1 >= $good1) {
      $warn1 = 40;
      $bad1 = 30;
      $good1 = 30;
    } else if ($warn1 == $bad1) {
      $warn1 = 40;
      $bad1 = 40;
      $good1 = 20;
    } else {
      $warn1 = 30;
      $bad1 = 20;
      $good1 = 50;
    }
    // collateral calculation
    $get_col_meet = ((120 / 100) * $prin_amt);
    $get_col_val = ((120 / 100) * $col_va);
    // a value amount
    $prec = ($col_va / $prin_amt) * 100;
    if ($prec >= 0 && $prec <= 50) {
      $warn1 += 10;
      $bad1 += 10;
      $good1 -= 10;
    } else if ($prec > 50 && $prec <= 100) {
      $warn1 += 10;
      $bad1 += 8;
      $good1 += 12;
    } else if ($prec > 100 && $prec < 120) {
      $warn1 -= 10;
      $bad1 -= 8;
      $good1 += 10;
    } else if ($prec >= 120) {
      $warn1 -= 10;
      $bad1 -= 8;
      $good1 += 20;
    }
    $color3 = "";
    if ($good1 > $warn1 && $good1 > $bad1) {
      $color3 = "success";
      $auto_perc -= 0.02;
    } else if ($warn1 > $good1 && $warn1 > $bad1) {
      $color3 = "warning";
      $auto_perc -= 1;
    } else {
      $color3 = "danger";
      $auto_perc -= 2;
    }
    // savings behaviour
    $warn2 = 100;
    $bad2 = 100;
    $good2 = 100;
    // avg. savings bal
    $prec1 = ($s1x / $prin_amt) * 100;
    if ($prec1 >= 0 && $prec1 <= 30) {
      $warn2 -= 10;
      $bad2 -= 10;
      $good2 -= 30;
    } else if ($prec1 > 30 && $prec1 <= 50) {
      $warn2 -= 10;
      $bad2 -= 10;
      $good2 -= 20;
    } else if ($prec1 > 50 && $prec1 <= 80) {
      $warn2 -= 10;
      $bad2 -= 10;
      $good2 += 15;
    } else if ($prec1 > 80 && $prec1 < 100) {
      $warn2 -= 12;
      $bad2 -= 12;
      $good2 += 14;
    } else if ($prec1 >= 100) {
      $warn2 -= 15;
      $bad2 -= 15;
      $good2 += 20;
    }
    // End Savings
    $prec2 = ($s2x / $prin_amt) * 100;
    if ($prec2 >= 0 && $prec2 <= 30) {
      $warn2 -= 10;
      $bad2 -= 10;
      $good2 -= 30;
    } else if ($prec2 > 30 && $prec2 <= 50) {
      $warn2 -= 10;
      $bad2 -= 10;
      $good2 -= 20;
    } else if ($prec2 > 50 && $prec2 <= 80) {
      $warn2 -= 10;
      $bad2 -= 10;
      $good2 += 15;
    } else if ($prec2 > 80 && $prec2 < 100) {
      $warn2 -= 12;
      $bad2 -= 12;
      $good2 += 14;
    } else if ($prec2 >= 100) {
      $warn2 -= 15;
      $bad2 -= 15;
      $good2 += 40;
    }
    // FOR MAX BALANCE
    if ($acct_credit > $acct_debit) {
      $warn2 -= 15;
      $bad2 -= 15;
      $good2 += 10;
    } else if ($acct_credit == $acct_debit) {
      $warn2 -= 15;
      $bad2 -= 15;
      $good2 += 15;
    } else if ($acct_debit > $acct_credit) {
      $warn2 += 15;
      $bad2 += 15;
      $good2 -= 30;
    }
    $color4 = "";
    if ($good2 > $warn2 && $good2 > $bad2) {
      $color4 = "success";
      $auto_perc -= 0.2;
    } else if ($warn3 > $good3 && $warn1 > $bad1) {
      $color4 = "warning";
      $auto_perc -= 1;
    } else {
      $color4 = "danger";
      $auto_perc -= 2;
    }
    // camp
    $comp_amt = ($auto_perc / 100) * $automated_principal;
  }
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // here we will be posting
  // TAKE DISPLAYED DATA
  // check if approved or declined
  // if System Computation or the Original Loan Principal
  // check if the gl payment source have the balance if its more or less
  // take out the charges at the point of disbursement
  // post the loan out to loan
?>
  <input type="text" id="s_int_id" value="<?php echo $sessint_id; ?>" hidden>
  <input type="text" id="s_branch_id" value="<?php echo $branch_id; ?>" hidden>
  <input type="text" id="s_sender_id" value="<?php echo $sender_id; ?>" hidden>
  <input type="text" id="s_phone" value="<?php echo $client_phone; ?>" hidden>
  <input type="text" id="s_client_id" value="<?php echo $client_id; ?>" hidden>
  <input type="text" id="s_acct_nox" value="<?php echo $acct_no; ?>" hidden>
  <div id="make_display"></div>
  <?php
  // record the loan in the loan transaction table
  // Take the loan principal out of the Vualt(Gl payment Type)
  // Record the Vualt Transaction (Gl Transaction in future)
  // reflect the transaction on the clients account
  // and the client account transction.
  // EMAIL FOR BOTH SIDES

  // END ALGORITHM END
  // 1. DISPLAY DATA
  $but_type = $_POST["submit"];
  // if the status is rejected or one
  if ($dis_cache_status == "Pending") {
    if ($but_type == "submit" || $but_type == "submit_b") {
      // 2. check it its system computation or intial principal
      if ($but_type == "submit") {
        // MEANS SYSTEM COMPUTATION
        $loan_amount = $comp_amt;
      } else {
        // MEANS ORIGINAL LOAN PRICIPAL
        $loan_amount = $prin_amt;
      }
      // get the data of the amount that will be disbursed
      // 3. CHECK IF VAULT HAVE THAT AMOUNT
      // query vault to get the balance of the institution
      // $branch_id = $_SESSION["branch_id"];
      // $v_query = mysqli_query($connection, "SELECT * FROM int_vault WHERE int_id = '$sessint_id' && branch_id = '$branch_id'");
      // $ivb = mysqli_fetch_array($v_query);
      $new_gl_run_bal = $running_gl_balance + $loan_amount;
      // take out the amount from the vualt balance for the transaction balance
      if ($new_gl_run_bal >= $loan_amount) {
        // $cqb = mysqli_fetch_array($charge_query);
        $charge_query = mysqli_query($connection, "SELECT * FROM `product_loan_charge` WHERE product_loan_id = '$loan_product' && int_id = '$sessint_id'");
        // $cqb = mysqli_fetch_array($charge_query);
        // charge application start.
        if (mysqli_num_rows($charge_query) > 0) {
          $get_client_account = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' AND client_id = '$client_id' AND int_id = '$sessint_id'");
          $fct = mysqli_fetch_array($get_client_account);
          $client_running_bal = $fct["account_balance_derived"];
          $account_id = $fct["id"];
          $client_charge_bal = $fct["total_fees_charge_derived"];
          // be useful at the point of charges
          $new_client_running_bal = $client_running_bal + $loan_amount;

          $insert_client_trans1 = "";
          // update the PAYMENT GL.
          // record the gl transaction
          // we get client current balance, email..
          // we make this transaction..
          // we store this transaction in account transaction..
          // hit this client mail

          $update_acct_gl = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$new_gl_run_bal' WHERE int_id = '$sessint_id' && gl_code = '$ggl'");
          if ($update_acct_gl) {
            // echo "UPDATED FIRST CODE";
            // record gl transaction
            $digits = 6;
            $trans_id = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
            $gends = $disburse_date;
            $gen_date = $disburse_date;
            $crd_d = date('Y-m-d h:i:sa');
            $insert_gl_trans = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`,
              `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `gl_account_balance_derived`,
              `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`,
              `manually_adjusted_or_reversed`, `credit`, `debit`) 
              VALUES ('{$sessint_id}', '{$branch_id}', '{$ggl}', '{$trans_id}',
              'Loan Disbursement', 'loan_disbursement', '{$client_id}', '0', '{$gends}', '{$loan_amount}', '{$new_gl_run_bal}',
              '{$new_gl_run_bal}', '{$gends}', '0', '{$new_gl_run_bal}', '{$crd_d}',
              '0', '0.00', '{$loan_amount}')");
            // you can send EMAIL HERE FOR GL TRANSACTION FROM BANK
            if ($insert_gl_trans) {
              // echo "INSERTED INTO GL ACCOUNT TRANSACTION";
              // get client running balance
              $client_loan_status = mysqli_query($connection, "UPDATE client SET loan_status = 'ACTIVE' WHERE account_no = '$acct_no' AND id = '$client_id' AND int_id = '$sessint_id'");

              $update_client_bal = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_client_running_bal' WHERE account_no = '$acct_no' AND client_id = '$client_id' AND int_id = '$sessint_id'");
              if ($update_client_bal) {
                // echo "UPDATED ACCOUNT";
                $insert_client_trans = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
                  `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
                  `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
                  `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
                  `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
                  VALUES ('{$sessint_id}', '{$branch_id}', '0', '{$account_id}', '$acct_no', '{$client_id}', '0', '{$trans_id}',
                  'Loan Disbursement', 'loan_disbursement', '0', '{$gen_date}', '{$loan_amount}', '{$loan_amount}',
                  '{$gends}', '0', '{$new_client_running_bal}',
                  '{$new_client_running_bal}', '{$crd_d}', '{$app_user}', '0', '0.00', '{$loan_amount}')");
                // store the transaction
                if ($insert_client_trans) {
                  // echo "INSERTED INTO ACCTOUNT TRANSACTION";
                  if ($client_sms == "1") {
  ?>
                    <input type="text" id="s_int_name" value="<?php echo $int_name; ?>" hidden>
                    <input type="text" id="s_acct_no" value="<?php echo appendAccountNo($acct_no, 6); ?>" hidden>
                    <input type="text" id="s_amount" value="<?php echo number_format($loan_amount, 2); ?>" hidden>
                    <input type="text" id="s_desc" value="<?php echo "Loan Disbursement"; ?>" hidden>
                    <input type="text" id="s_date" value="<?php echo $pint; ?>" hidden>
                    <input type="text" id="s_balance" value="<?php echo number_format($new_client_running_bal, 2); ?>" hidden>
                    <script>
                      $(document).ready(function() {
                        var int_id = $('#s_int_id').val();
                        var branch_id = $('#s_branch_id').val();
                        var sender_id = $('#s_sender_id').val();
                        var phone = $('#s_phone').val();
                        var client_id = $('#s_client_id').val();
                        var account_no = $('#s_acct_nox').val();
                        // function
                        var amount = $('#s_amount').val();
                        var acct_no = $('#s_acct_no').val();
                        var int_name = $('#s_int_name').val();
                        var trans_type = "Credit";
                        var desc = $('#s_desc').val();
                        var date = $('#s_date').val();
                        var balance = $('#s_balance').val();
                        // now we work on the body.
                        // var msg = int_name + " " + trans_type + " \n" + "Amt: NGN " + amount + " \n Acct: " + acct_no + "\nDesc: " + desc + " \nBal: " + balance + " \nAvail: " + balance + "\nDate: " + date + "\nThank you for Banking with Us!";
                        var msg = "Acct: " + acct_no + "\nAmt: NGN " + amount + " Credit \nDesc: " + desc + "\nAvail Bal: " + balance + "\nDate: " + date;
                        $.ajax({
                          url: "ajax_post/sms/sms.php",
                          method: "POST",
                          data: {
                            int_id: int_id,
                            branch_id: branch_id,
                            sender_id: sender_id,
                            phone: phone,
                            msg: msg,
                            client_id: client_id,
                            account_no: account_no
                          },
                          success: function(data) {
                            $('#make_display').html(data);
                          }
                        });
                      });
                    </script>
                    <script>
                      $(document).ready(function() {
                        var int_id = $('#s_int_id').val();
                        var branch_id = $('#s_branch_id').val();
                        var sender_id = $('#s_sender_id').val();
                        var phone = $('#s_phone').val();
                        var client_id = $('#s_client_id').val();
                        var account_no = $('#s_acct_nox').val();
                        // function
                        var amount = $('#s_amount').val();
                        var acct_no = $('#s_acct_no').val();
                        var int_name = $('#s_int_name').val();
                        var trans_type = "Credit";
                        var desc = $('#s_desc').val();
                        var date = $('#s_date').val();
                        var balance = $('#s_balance').val();
                        // now we work on the body.
                        var msg = "Dear Customer,\nYour loan applcation of NGN" + amount + " was successful and has been deposited in your account.\nRemember, early repayment brings great credit scores!";
                        $.ajax({
                          url: "ajax_post/sms/sms.php",
                          method: "POST",
                          data: {
                            int_id: int_id,
                            branch_id: branch_id,
                            sender_id: sender_id,
                            phone: phone,
                            msg: msg,
                            client_id: client_id,
                            account_no: account_no
                          },
                          success: function(data) {
                            $('#make_display2').html(data);
                          }
                        });
                      });
                    </script>
                    <?php
                  }
                  // sends a mail first
                  // HERE YOU CAN HIT THE MAIL
                  $get_client_account1 = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' AND client_id = '$client_id' AND int_id = '$sessint_id'");
                  $fct1 = mysqli_fetch_array($get_client_account1);
                  $client_running_bal1 = $fct1["account_balance_derived"];
                  // be useful at the point of charges
                  $mail = new PHPMailer;
                  $mail->From = $int_email;
                  $mail->FromName = $int_name;
                  $mail->addAddress($client_email);
                  $mail->addReplyTo($int_email, "No Reply");
                  $mail->isHTML(true);
                  $mail->Subject = "Transaction Alert from $int_name";
                  $mail->Body = "<!DOCTYPE html>
                    <html>
                        <head>
                        <style>
                        .lon{
                          height: 100%;
                            background-color: #eceff3;
                            font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        }
                        .main{
                            margin-right: auto;
                            margin-left: auto;
                            width: 550px;
                            height: auto;
                            background-color: white;
            
                        }
                        .header{
                            margin-right: auto;
                            margin-left: auto;
                            width: 550px;
                            height: auto;
                            background-color: white;
                        }
                        .logo{
                            margin-right:auto;
                            margin-left: auto;
                            width:auto;
                            height: auto;
                            background-color: white;
            
                        }
                        .text{
                            padding: 20px;
                            font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        }
                        table{
                            padding:30px;
                            width: 100%;
                        }
                        table td{
                            font-size: 15px;
                            color:rgb(65, 65, 65);
                        }
                    </style>
                        </head>
                        <body>
                          <div class='lon'>
                            <div class='header'>
                              <div class='logo'>
                              <img  style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src= '$int_logo'/>
                          </div>
                      </div>
                          <div class='main'>
                              <div class='text'>
                                  Dear $cn,
                                  <h2 style='text-align:center;'>Notification of Credit Alert</h2>
                                  this is to notify you of an incoming credit to your account $acct_no,
                                  Kindly confirm with your bank.<br/><br/>
                                   Please see the details below
                              </div>
                              <table>
                                  <tbody>
                                      <div>
                                    <tr>
                                      <td> <b >Account Number</b></td>
                                      <td >$account_display</td>
                                    </tr>
                                    <tr>
                                      <td > <b>Account Name</b></td>
                                      <td >$cn</td>
                                    </tr>
                                    <tr>
                                      <td > <b>Reference</b></td>
                                      <td >Loan Disbursment</td>
                                    </tr>
                                    <tr>
                                      <td > <b>Reference Id</b></td>
                                      <td >$trans_id</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Transaction Amount</b></td>
                                      <td>$loan_amount</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Transaction Date/Time</b></td>
                                      <td>$gen_date</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Value Date</b></td>
                                      <td>$gends</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Account Balance</b></td>
                                      <td>&#8358; $client_running_bal1</td>
                                    </tr>
                                  </tbody>
                                  <!-- Optional JavaScript -->
                                  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                                  <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
                                  <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
                                  <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
                                </body>
                              </table>
                          </div>
                          </div>
                        </body>
                    </html>";
                  $mail->AltBody = "This is the plain text version of the email content";
                  // mail system
                  if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                    //  $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                    //  echo header ("Location: ../mfi/transact.php?message0=$randms");
                  } else {
                    echo "Email Successful";
                  }
                  // $new_client_running_bal1 = $client_running_bal1 + $loan_amount;
                  // TAKE OUT THE CHRAGES at the Disbursment point
                  // a query to select charges
                  $charge_query = mysqli_query($connection, "SELECT * FROM `product_loan_charge` WHERE product_loan_id = '$loan_product' && int_id = '$sessint_id'");
                  // THEN TEST FOR THE LOAN
                  while ($cxr = mysqli_fetch_array($charge_query)) {
                    //  echo "<P>PRODUCT LOAN CHARGE</P>";
                    $final[] = $cxr;
                    $c_id = $cxr["charge_id"];
                    $pay_charge1 = 0;
                    $pay_charge2 = 0;
                    $calc = 0;
                    $chg2 = 0;
                    // qwerty

                    $select_each_charge = mysqli_query($connection, "SELECT * FROM charge WHERE id = '$c_id' AND int_id = '$sessint_id' AND charge_time_enum = '1' ");
                    while ($ex = mysqli_fetch_array($select_each_charge)) {
                      // echo "<P>CHARGE WHILE LOOP</P>";
                      $values = $ex["charge_time_enum"];
                      $nameofc = $ex["name"];
                      $amt = 0;
                      $forx = $ex["charge_calculation_enum"];
                      $rmt = $loan_amount;
                      $amt_2 = $ex["amount"];
                      if ($forx == '1') {
                        $amt = $ex["amount"];
                        $charge_name1 = $ex["name"];
                        $gl_code1 = $ex["gl_code"];
                        // ACCOUNT
                        $get_client_account1 = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' AND client_id = '$client_id' AND int_id = '$sessint_id'");
                        while ($fct1 = mysqli_fetch_array($get_client_account1)) {
                          // echo "<P>FLAT WHILE LOOP</P>";
                          $client_running_bal1 = $fct1["account_balance_derived"];
                          if (isset($client_running_bal1)) {
                            // echo "AMOUNT".$amt;
                            $get_gl2xx = "SELECT * FROM `acc_gl_account` WHERE gl_code = '$gl_code1' AND int_id = '$sessint_id'";
                            // echo "GL NUMBER".$gl_code1;
                            //   if ($connection->error) {
                            //     try {   
                            //         throw new Exception("MySQL error $connection->error <br> Query:<br> $get_gl_2xx", $mysqli->error);   
                            //     } catch(Exception $e ) {
                            //         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                            //         echo nl2br($e->getTraceAsString());
                            //     }
                            // }
                            $get_gl2 = mysqli_query($connection, $get_gl2xx);
                            while ($fool2 = mysqli_fetch_array($get_gl2)) {
                              // echo "<P>SELECT ACCT GL WHILE LOOP</P>";
                              $running_gl_balance2 = $fool2["organization_running_balance_derived"];
                              // DONE WITH GL MOVE TO ACCOUNT
                              $ultimate_client_running_balance = $client_running_bal1 - $amt;
                              $ultimate_gl_bal = $running_gl_balance2 + $amt;
                              // WE WILL HAVE TO UPDATE THE GL AND CLIENT ACCOUNT WITH THE TRANSACTION



                              // START
                              if ($amt > 0) {
                                $update_acct_gl1 = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$ultimate_gl_bal' WHERE int_id = '$sessint_id' && gl_code = '$gl_code1'");
                                if ($update_acct_gl1) {
                                  $trans_id = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                                  $gends = $disburse_date;
                                  $gen_date = $disburse_date;
                                  $crd_d = date('Y-m-d h:i:sa');
                                  // transaction
                                  $insert_charge_gl = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`,
              `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `gl_account_balance_derived`,
              `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`,
              `manually_adjusted_or_reversed`, `credit`, `debit`) 
              VALUES ('{$sessint_id}', '{$branch_id}', '{$gl_code1}', '{$trans_id}',
              'Loan_Charge - {$nameofc} / {$crn}', 'flat_charge', '{$client_id}', '0', '{$gends}', '{$amt}', '{$ultimate_gl_bal}',
              '{$ultimate_gl_bal}', '{$gends}', '0', '{$ultimate_gl_bal}', '{$crd_d}',
              '0', '{$amt}', '0.00')");
                                  // SEND THE REST
                                  if ($insert_charge_gl) {
                                    $update_client_bal1 = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$ultimate_client_running_balance' WHERE account_no = '$acct_no' AND client_id = '$client_id' AND int_id = '$sessint_id'");
                                    if ($update_client_bal1) {
                                      $insert_client_trans1 = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
                  `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
                  `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
                  `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
                  `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
                  VALUES ('{$sessint_id}', '{$branch_id}', '0', '{$account_id}', '$acct_no', '{$client_id}', '0', '{$trans_id}',
                  'Loan_Charge - {$nameofc} / {$crn}', 'flat_charge', '0', '{$gen_date}', '{$amt}', '{$amt}',
                  '{$gends}', '0', '{$ultimate_client_running_balance}',
                  '{$ultimate_client_running_balance}', '{$crd_d}', '{$app_user}', '0', '{$amt}', '0.00')");
                                      // END CLIENT TRANSACTION
                                      if ($insert_client_trans1) {
                                        // SEND THE EMAIL
                                        if ($client_sms == "1") {
                    ?>
                                          <input type="text" id="s_int_name" value="<?php echo $int_name; ?>" hidden>
                                          <input type="text" id="s_acct_no" value="<?php echo $account_display; ?>" hidden>
                                          <input type="text" id="s_amount" value="<?php echo number_format($amt, 2); ?>" hidden>
                                          <input type="text" id="s_desc" value="<?php echo "Loan Charge " . $nameofc; ?>" hidden>
                                          <input type="text" id="s_date" value="<?php echo $pint; ?>" hidden>
                                          <input type="text" id="s_balance" value="<?php echo number_format($ultimate_client_running_balance, 2); ?>" hidden>
                                          <script>
                                            $(document).ready(function() {
                                              var int_id = $('#s_int_id').val();
                                              var branch_id = $('#s_branch_id').val();
                                              var sender_id = $('#s_sender_id').val();
                                              var phone = $('#s_phone').val();
                                              var client_id = $('#s_client_id').val();
                                              var account_no = $('#s_acct_nox').val();
                                              // function
                                              var amount = $('#s_amount').val();
                                              var acct_no = $('#s_acct_no').val();
                                              var int_name = $('#s_int_name').val();
                                              var trans_type = "Debit";
                                              var desc = $('#s_desc').val();
                                              var date = $('#s_date').val();
                                              var balance = $('#s_balance').val();
                                              // now we work on the body.
                                              var msg = int_name + " " + trans_type + " \n" + "Amt: NGN " + amount + " \n Acct: " + acct_no + "\nDesc: " + desc + " \nBal: " + balance + " \nAvail: " + balance + "\nDate: " + date + "\nThank you for Banking with Us!";
                                              $.ajax({
                                                url: "ajax_post/sms/sms.php",
                                                method: "POST",
                                                data: {
                                                  int_id: int_id,
                                                  branch_id: branch_id,
                                                  sender_id: sender_id,
                                                  phone: phone,
                                                  msg: msg,
                                                  client_id: client_id,
                                                  account_no: account_no
                                                },
                                                success: function(data) {
                                                  $('#make_display').html(data);
                                                }
                                              });
                                            });
                                          </script>
                                        <?php
                                        }
                                        // END IT HERE
                                        $mail = new PHPMailer;
                                        $mail->From = $int_email;
                                        $mail->FromName = $int_name;
                                        $mail->addAddress($client_email);
                                        $mail->addReplyTo($int_email, "No Reply");
                                        $mail->isHTML(true);
                                        $mail->Subject = "Transaction Alert from $int_name";
                                        $mail->Body = "<!DOCTYPE html>
                    <html>
                        <head>
                        <style>
                        .lon{
                          height: 100%;
                            background-color: #eceff3;
                            font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        }
                        .main{
                            margin-right: auto;
                            margin-left: auto;
                            width: 550px;
                            height: auto;
                            background-color: white;
            
                        }
                        .header{
                            margin-right: auto;
                            margin-left: auto;
                            width: 550px;
                            height: auto;
                            background-color: white;
                        }
                        .logo{
                            margin-right:auto;
                            margin-left: auto;
                            width:auto;
                            height: auto;
                            background-color: white;
            
                        }
                        .text{
                            padding: 20px;
                            font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        }
                        table{
                            padding:30px;
                            width: 100%;
                        }
                        table td{
                            font-size: 15px;
                            color:rgb(65, 65, 65);
                        }
                    </style>
                        </head>
                        <body>
                          <div class='lon'>
                            <div class='header'>
                              <div class='logo'>
                              <img  style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src= '$int_logo'/>
                          </div>
                      </div>
                          <div class='main'>
                              <div class='text'>
                                  Dear $cn,
                                  <h2 style='text-align:center;'>Notification of Debit Alert</h2>
                                  this is to notify you of an incoming credit to your account $acct_no,
                                  Kindly confirm with your bank.<br/><br/>
                                   Please see the details below
                              </div>
                              <table>
                                  <tbody>
                                      <div>
                                    <tr>
                                      <td> <b >Account Number</b></td>
                                      <td >$account_display</td>
                                    </tr>
                                    <tr>
                                      <td > <b>Account Name</b></td>
                                      <td >$cn</td>
                                    </tr>
                                    <tr>
                                      <td > <b>Reference</b></td>
                                      <td >Loan Disbursment Charge - Flat</td>
                                    </tr>
                                    <tr>
                                      <td > <b>Reference Id</b></td>
                                      <td >$trans_id</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Transaction Amount</b></td>
                                      <td>$amt</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Transaction Date/Time</b></td>
                                      <td>$gen_date</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Value Date</b></td>
                                      <td>$gends</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Account Balance</b></td>
                                      <td>&#8358; $ultimate_client_running_balance</td>
                                    </tr>
                                  </tbody>
                                  <!-- Optional JavaScript -->
                                  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                                  <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
                                  <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
                                  <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
                                </body>
                              </table>
                          </div>
                          </div>
                        </body>
                    </html>";
                                        $mail->AltBody = "This is the plain text version of the email content";
                                        // mail system
                                        if (!$mail->send()) {
                                          echo "Mailer Error: " . $mail->ErrorInfo;
                                          //  $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                                          //  echo header ("Location: ../mfi/transact.php?message0=$randms");
                                        } else {
                                          echo "Email Successful";
                                        }
                                        //  ACCOUNT BALANCE
                                      } else {
                                        // echo the client transaction
                                        // echo "Error in Client Transaction";
                                        echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "error",
                            title: "Client Transaction",
                            text: "Charge Flat GL",
                            showConfirmButton: false,
                            timer: 4000
                        })
                    });
                    </script>
                    ';
                                      }
                                    } else {
                                      // echo error updating client account
                                      // echo "Error in Update Client Account";
                                      echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Client Account Error",
                        text: "Charge Flat GL",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                                    }
                                  } else {
                                    // echo error in charge gl error
                                    // echo "Error in Charge GL";
                                    echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Charge Flat Gl2",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                                  }
                                } else {
                                  // echo error in update of the charge gl
                                  // echo "Error in Update Charge GL";
                                  echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Charge Flat GL",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                                }
                              } else {
                                // echo empty
                                // echo "Error in Emoty";
                              }
                              // end while loop
                            }
                          } else {
                            echo "NO CODE";
                          }
                        }

                        // ENDING
                        // ALSO SEND A MAIL
                      } else {
                        $charge_name2 = $ex["name"];
                        $calc = ($amt_2 / 100) * $rmt;
                        $charge_name2 = $ex["name"];
                        $gl_code2 = $ex["gl_code"];
                        // echo "<P>PERCENTAGE WHILE LOOP</P>";
                        // ACCOUNT
                        $get_client_account2 = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' AND client_id = '$client_id' AND int_id = '$sessint_id'");
                        while ($fct2 = mysqli_fetch_array($get_client_account2)) {
                          // echo "<P>ANOTHER PERC WHILE LOOP</P>";
                          $client_running_bal2 = $fct2["account_balance_derived"];
                          // echo "AMOUNT".$amt;
                          $get_gl3 = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE gl_code = '$gl_code2' AND int_id = '$sessint_id'");
                          while ($fool3 = mysqli_fetch_array($get_gl3)) {
                            $running_gl_balance3 = $fool3["organization_running_balance_derived"];
                            // DONE WITH GL MOVE TO ACCOUNT
                            $ultimate_client_running_balance1 = $client_running_bal2 - $calc;
                            $ultimate_gl_bal1 = $running_gl_balance3 + $calc;
                            // WE WILL HAVE TO UPDATE THE GL AND CLIENT ACCOUNT WITH THE TRANSACTION

                            // SENDING FOR PERCENTAGE
                            if ($calc > 0) {
                              $update_acct_gl1 = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$ultimate_gl_bal1' WHERE int_id = '$sessint_id' && gl_code = '$gl_code2'");
                              if ($update_acct_gl1) {
                                $trans_id = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                                $gends = $disburse_date;
                                $gen_date = $disburse_date;
                                $app_on = date('Y-m-d h:i:sa');
                                // transaction
                                $insert_charge_gl5 = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`,
              `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `gl_account_balance_derived`,
              `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`,
              `manually_adjusted_or_reversed`, `credit`, `debit`) 
              VALUES ('{$sessint_id}', '{$branch_id}', '{$gl_code2}', '{$trans_id}',
              'Loan_Charge - {$charge_name2} / {$crn}', 'percentage_charge', '{$client_id}', '0', '{$gends}', '{$calc}', '{$ultimate_gl_bal1}',
              '{$ultimate_gl_bal1}', '{$gends}', '0', '{$ultimate_gl_bal1}', '{$app_on}',
              '0', '{$calc}', '0.00')");
                                // SEND THE REST
                                if ($insert_charge_gl5) {
                                  $update_client_bal5 = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$ultimate_client_running_balance1' WHERE account_no = '$acct_no' AND client_id = '$client_id' AND int_id = '$sessint_id'");
                                  if ($update_client_bal5) {
                                    $insert_client_trans1 = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
                  `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
                  `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
                  `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
                  `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
                  VALUES ('{$sessint_id}', '{$branch_id}', '0', '{$account_id}', '$acct_no', '{$client_id}', '0', '{$trans_id}',
                  'Loan_Charge - {$charge_name2} / {$crn}', 'percentage_charge', '0', '{$gen_date}', '{$calc}', '{$calc}',
                  '{$gends}', '0', '{$ultimate_client_running_balance1}',
                  '{$ultimate_client_running_balance1}', '{$app_on}', '{$app_user}', '0', '{$calc}', '0.00')");
                                    // END CLIENT TRANSACTION
                                    if ($insert_client_trans1) {
                                      // SEND THE EMAIL
                                      if ($client_sms == "1") {
                                        ?>
                                        <input type="text" id="s_int_name" value="<?php echo $int_name; ?>" hidden>
                                        <input type="text" id="s_acct_no" value="<?php echo $account_display; ?>" hidden>
                                        <input type="text" id="s_amount" value="<?php echo number_format($calc, 2); ?>" hidden>
                                        <input type="text" id="s_desc" value="<?php echo "Loan Charge " . $charge_name2; ?>" hidden>
                                        <input type="text" id="s_date" value="<?php echo $pint; ?>" hidden>
                                        <input type="text" id="s_balance" value="<?php echo number_format($ultimate_client_running_balance1, 2); ?>" hidden>
                                        <script>
                                          $(document).ready(function() {
                                            var int_id = $('#s_int_id').val();
                                            var branch_id = $('#s_branch_id').val();
                                            var sender_id = $('#s_sender_id').val();
                                            var phone = $('#s_phone').val();
                                            var client_id = $('#s_client_id').val();
                                            var account_no = $('#s_acct_nox').val();
                                            // function
                                            var amount = $('#s_amount').val();
                                            var acct_no = $('#s_acct_no').val();
                                            var int_name = $('#s_int_name').val();
                                            var trans_type = "Debit";
                                            var desc = $('#s_desc').val();
                                            var date = $('#s_date').val();
                                            var balance = $('#s_balance').val();
                                            // now we work on the body.
                                            var msg = int_name + " " + trans_type + " \n" + "Amt: NGN " + amount + " \n Acct: " + acct_no + "\nDesc: " + desc + " \nBal: " + balance + " \nAvail: " + balance + "\nDate: " + date + "\nThank you for Banking with Us!";
                                            $.ajax({
                                              url: "ajax_post/sms/sms.php",
                                              method: "POST",
                                              data: {
                                                int_id: int_id,
                                                branch_id: branch_id,
                                                sender_id: sender_id,
                                                phone: phone,
                                                msg: msg,
                                                client_id: client_id,
                                                account_no: account_no
                                              },
                                              success: function(data) {
                                                $('#make_display').html(data);
                                              }
                                            });
                                          });
                                        </script>
<?php
                                      }
                                      // SMS
                                      $mail = new PHPMailer;
                                      $mail->From = $int_email;
                                      $mail->FromName = $int_name;
                                      $mail->addAddress($client_email);
                                      $mail->addReplyTo($int_email, "No Reply");
                                      $mail->isHTML(true);
                                      $mail->Subject = "Transaction Alert from $int_name";
                                      $mail->Body = "<!DOCTYPE html>
                    <html>
                        <head>
                        <style>
                        .lon{
                          height: 100%;
                            background-color: #eceff3;
                            font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        }
                        .main{
                            margin-right: auto;
                            margin-left: auto;
                            width: 550px;
                            height: auto;
                            background-color: white;
            
                        }
                        .header{
                            margin-right: auto;
                            margin-left: auto;
                            width: 550px;
                            height: auto;
                            background-color: white;
                        }
                        .logo{
                            margin-right:auto;
                            margin-left: auto;
                            width:auto;
                            height: auto;
                            background-color: white;
            
                        }
                        .text{
                            padding: 20px;
                            font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        }
                        table{
                            padding:30px;
                            width: 100%;
                        }
                        table td{
                            font-size: 15px;
                            color:rgb(65, 65, 65);
                        }
                    </style>
                        </head>
                        <body>
                          <div class='lon'>
                            <div class='header'>
                              <div class='logo'>
                              <img  style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src= '$int_logo'/>
                          </div>
                      </div>
                          <div class='main'>
                              <div class='text'>
                                  Dear $cn,
                                  <h2 style='text-align:center;'>Notification of Debit Alert</h2>
                                  this is to notify you of an incoming credit to your account $acct_no,
                                  Kindly confirm with your bank.<br/><br/>
                                   Please see the details below
                              </div>
                              <table>
                                  <tbody>
                                      <div>
                                    <tr>
                                      <td> <b >Account Number</b></td>
                                      <td >$account_display</td>
                                    </tr>
                                    <tr>
                                      <td > <b>Account Name</b></td>
                                      <td >$cn</td>
                                    </tr>
                                    <tr>
                                      <td > <b>Reference</b></td>
                                      <td >Loan Disbursment Charge - Flat</td>
                                    </tr>
                                    <tr>
                                      <td > <b>Reference Id</b></td>
                                      <td >$trans_id</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Transaction Amount</b></td>
                                      <td>$calc</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Transaction Date/Time</b></td>
                                      <td>$gen_date</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Value Date</b></td>
                                      <td>$gends</td>
                                    </tr>
                                    <tr>
                                      <td> <b>Account Balance</b></td>
                                      <td>&#8358; $ultimate_client_running_balance1</td>
                                    </tr>
                                  </tbody>
                                  <!-- Optional JavaScript -->
                                  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                                  <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
                                  <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
                                  <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
                                </body>
                              </table>
                          </div>
                          </div>
                        </body>
                    </html>";
                                      $mail->AltBody = "This is the plain text version of the email content";
                                      // mail system
                                      if (!$mail->send()) {
                                        echo "Mailer Error: " . $mail->ErrorInfo;
                                        //  $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                                        //  echo header ("Location: ../mfi/transact.php?message0=$randms");
                                      } else {
                                        echo "Email Successful";
                                      }
                                      // MAILING SYSTEM
                                    } else {
                                      // echo the client transaction
                                      // echo "Error in Client Transaction";
                                      echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Client Transaction",
                        text: "Charge Percentage GL",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                                    }
                                  } else {
                                    // echo error updating client account
                                    // echo "Error in Update Client Account";
                                    echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Client Account Error",
                        text: "Charge Percentage GL",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                                  }
                                } else {
                                  // echo error in charge gl error
                                  // echo "Error in Charge GL";
                                  echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Charge Percentage Gl2",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                                }
                              } else {
                                // echo error in update of the charge gl
                                // echo "Error in Update Charge GL";
                                echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Charge Percentage GL",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                              }
                            } else {
                              // echo empty
                              // echo "Empt";
                              //   echo '<script type="text/javascript">
                              // $(document).ready(function(){
                              //     swal({
                              //         type: "error",
                              //         title: "",
                              //         text: "",
                              //         showConfirmButton: false,
                              //         timer: 4000
                              //     })
                              // });
                              // </script>
                              // ';
                            }


                            // END LOOP
                          }
                        }
                        // LOOP
                        // ENDING
                      }
                      // $pay_charge2 += $calc;
                      // $pay_charge1 += $amt;
                    }
                  }
                  // YOU NEED TO TEST THE QUERY HERE THEN TAKE OFF
                  // DISBUSE TO LOAN
                  $check_charge = 1;
                  if ($insert_client_trans1 || $check_charge == 1) {
                    // OK MAKE MOVE
                    // loan inputting
                    $l_d_m = "INSERT INTO `loan` (`int_id`, `account_no`, `client_id`, `product_id`,
            `fund_id`, `col_id`, `col_name`, `col_description`, `loan_officer`, `loan_purpose`, `currency_code`,
            `currency_digits`, `principal_amount_proposed`, `principal_amount`, `loan_term`, `interest_rate`,
            `approved_principal`, `repayment_date`, `arrearstolerance_amount`, `is_floating_interest_rate`, 
            `interest_rate_differential`, `nominal_interest_rate_per_period`, `interest_period_frequency_enum`,
            `annual_nominal_interest_rate`, `interest_method_enum`, `interest_calculated_in_period_enum`,
            `allow_partial_period_interest_calcualtion`, `term_frequency`, `term_period_frequency_enum`, `repay_every`,
            `repayment_period_frequency_enum`, `number_of_repayments`,
            `grace_on_principal_periods`, `recurring_moratorium_principal_periods`, `grace_on_interest_periods`, `grace_interest_free_periods`, `amortization_method`,
            `submittedon_date`, `submittedon_userid`, `approvedon_date`, `approvedon_userid`, `expected_disbursedon_date`,
            `expected_firstrepaymenton_date`, `interest_calculated_from_date`, `disbursement_date`, `disbursedon_userid`,
            `expected_maturedon_date`, `maturedon_date`, `closedon_date`, `closedon_userid`, `total_charges_due_at_disbursement_derived`,
            `principal_disbursed_derived`, `principal_repaid_derived`, `principal_writtenoff_derived`, `principal_outstanding_derived`,
            `interest_charged_derived`, `interest_repaid_derived`, `interest_waived_derived`, `interest_writtenoff_derived`,
            `interest_outstanding_derived`, `fee_charges_charged_derived`, `fee_charges_repaid_derived`, `fee_charges_waived_derived`,
            `fee_charges_writtenoff_derived`, `fee_charges_outstanding_derived`, `penalty_charges_charged_derived`, `penalty_charges_repaid_derived`, `penalty_charges_waived_derived`, `penalty_charges_writtenoff_derived`, `penalty_charges_outstanding_derived`,
            `total_expected_repayment_derived`, `total_repayment_derived`, `total_expected_costofloan_derived`, `total_costofloan_derived`, `total_waived_derived`, `total_writtenoff_derived`,
            `total_outstanding_derived`, `total_overpaid_derived`,
            `version`, `writeoff_reason_cv_id`, `loan_sub_status_id`,
            `is_topup`, `repay_principal_every`, `repay_interest_every`,
            `restrict_linked_savings_product_type`, `mandatory_savings_percentage`, `internal_rate_of_return`)
            VALUES ('{$sessint_id}', '{$acct_no}', '{$client_id}', '{$loan_product}',
            '{$pay_id}', '..', '..', '..', '{$account_officer}', '{$loan_purpose}', 'NGN',
            '2', '{$loan_amount}', '{$loan_amount}', '{$loan_term}', '{$interest}',
            '{$loan_amount}', '{$repayment_date}', '0', '0', 
            '0', '0', '0',
            '0', '0', '1',
            '0', '{$term_frequency}', '2', '{$repay_eve}',
            '0', '{$no_repayments}',
            '0', '0', '0', '0', '0',
            '{$sub_user_date}', '{$sub_user_id}', '{$gends}', '{$app_user}', '{$disburse_date}',
            '{$repayment_date}', '0', '{$disburse_date}', '{$sub_user_id}',
            '{$exp_mature_date}', '{$exp_mature_date}', NULL, NULL, '0',
            '{$loan_amount}', '0.000000', '0.000000', '{$loan_amount}',
            '0.000000', '0.000000', '0.000000', '0.000000',
            '{$tot_int}', '0.000000', '0.000000', '0.000000',
            '0.000000', '0.000000', '0.000000', '0.000000', '0.000000', '0.000000', '0.000000',
            '{$prin_due}', '0.000000', '0.000000', '0.000000', '0.000000', '0.000000',
            '{$prin_due}', '0.000000',
            '1', NULL, '{$loan_sector}',
            '0', '1', '1', NULL, NULL, '0.00')";
                    $loan_disb = mysqli_query($connection, $l_d_m);
                    if ($loan_disb) {

                      $update_loan_cache = mysqli_query($connection, "UPDATE loan_disbursement_cache SET status = 'Approved' WHERE id = '$appod' AND int_id = '$sessint_id'");

                      $dfofi = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND account_no = '$acct_no' AND client_id = '$client_id'");
                      $fdo = mysqli_fetch_array($dfofi);
                      $loan_id = $fdo['id'];
                      $dfei = mysqli_query($connection, "UPDATE loan_charge SET loan_id = '$loan_id', loan_cache_id = '0' WHERE int_id = '$sessint_id' AND client_id = '$client_id' ORDER BY id DESC LIMIT 1");


                      /**
                       * Update loan id for collateral
                       */
                      $update_coll_loan_id = mysqli_query($connection, "UPDATE collateral SET loan_id = '$loan_id' WHERE int_id = '$sessint_id' AND client_id = '$client_id' ORDER BY id DESC LIMIT 1");

                      /**
                       * Update loan id for guarantor
                       */
                      $update_gua_loan_id = mysqli_query($connection, "UPDATE loan_gaurantor SET loan_id = '$loan_id' WHERE int_id = '$sessint_id' AND client_id = '$client_id' ORDER BY id DESC LIMIT 1");


                      if ($update_loan_cache) {
                        include '../functions/loans/schedule.php';

                        echo '<script type="text/javascript">
                                $(document).ready(function(){
                                    swal({
                                        type: "success",
                                        title: "Loan Disbursed Successfully",
                                        text: "Approved",
                                        showConfirmButton: false,
                                        timer: 4000
                                    })
                                });
                                </script>
                        ';
                        $URL = "disbursement_approval.php";
                        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                      } else {
                        // error in loan cache
                        // echo "Error in Update Loan gl";
                        echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Loan Disbursement Error",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                      }
                    } else {
                      // error  in loan
                      // echo "Error in Loan sir";
                      echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Loan Disbursement Error",
                        text: "Database Error at Loan",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                    }
                  } else {
                    // echo nothing
                    // echo "God full of wisloan_sector";
                    echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Loan Error - No Charge",
                        text: "DB",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                  }
                  if ($connection->error) {
                    try {
                      throw new Exception("MySQL error $connection->error <br> Query:<br> $l_d_m", $mysqli->error);
                    } catch (Exception $e) {
                      echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >";
                      echo nl2br($e->getTraceAsString());
                    }
                  }
                  // UPDATE THE DISBURSMENT CACHE
                  // WE TALK ABOUT LOAN STAUS
                } else {
                  // error in client transaction
                  // echo "Error in Client Transaction";
                  echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Client Transaction",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
                }
              } else {
                // echo error in client balance update
                // echo "Error in Client Bal Update";
                echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Client Balance",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
              }
            } else {
              // echo error in gl account transaction
              // echo "Error Gl trans";
              echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Gl Transaction Error",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
            }
          } else {
            // error in update gl ACCOUNT
            // echo "Error in Update GL";
            echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Gl Update Error",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
          }
        } else {
          // echo not up to
          // echo "Noot Up to";
          echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "No Charge..",
                        text: "Charge Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
        }
      } else {
        // echo insufficient fund from vualt
        // echo "insufficient fund from the payment method";
        echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Insufficient Fund from the Gl",
                        text: "This Gl Lack Fund",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
      }
    } else if ($but_type == "reject") {
      // reject the loan
      // store the rejected loan status in cache - to rejecteds
      $update_loan_cache = mysqli_query($connection, "UPDATE loan_disbursement_cache SET status = 'Rejected' WHERE id = '$appod' AND int_id = '$sessint_id'");
      if ($update_loan_cache) {
        // echo "Done";
        echo '<script type="text/javascript">
          $(document).ready(function(){
              swal({
                  type: "success",
                  title: "Loan Rejection Successful",
                  text: "Thank you!",
                  showConfirmButton: false,
                  timer: 4000
              })
          });
          </script>
          ';
        $URL = "disbursement_approval.php";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
      } else {
        // error in loan cache
        echo '<script type="text/javascript">
          $(document).ready(function(){
              swal({
                  type: "error",
                  title: "Rejection Error",
                  text: "Kindly Call For Support if You didnt want to reject",
                  showConfirmButton: false,
                  timer: 4000
              })
          });
          </script>
          ';
      }
      // echo "you rejected the loan";
    } else {
      // push out an error to the person approving
      // echo "error on approval";
      echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Rejection Error",
                        text: "Error",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
    }
  } else if ($dis_cache_status == "Rejected") {
    // echo already rejected
    $update_loan_cache = mysqli_query($connection, "UPDATE loan_disbursement_cache SET status = 'Rejected' WHERE id = '$appod' AND int_id = '$sessint_id'");
    if ($update_loan_cache) {
      // echo "Done";
      echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "success",
                        title: "Loan Rejected Before",
                        text: "Kindly Call For Support if you dont want it rejected",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
      $URL = "disbursement_approval.php";
      echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    } else {
      // error in loan cache
      echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Rejection Error",
                        text: "Kindly Call For Support if You didnt want to reject",
                        showConfirmButton: false,
                        timer: 4000
                    })
                });
                </script>
                ';
    }
  } else {
    // already approved
    // echo "Already Approved";
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Loan Has Been Approved",
            text: "This Loan has been Approved Before",
            showConfirmButton: false,
            timer: 5000
        })
    });
    </script>
    ';
  }
}
?>
<!-- Content added here -->
<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Loan Approval - Summary</h4>
            <p class="card-category">Make sure everything is in order</p>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Client Name:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $cn; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Posted By</label>
                    <input type="text" class="form-control" name="email" value="<?php echo strtoupper($user_fullname); ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Loan Product</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo strtoupper($ln_prod_name); ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Loan Sector</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo strtoupper($loan_sec); ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Account Officer</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $off_dis; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Linked Account</label>
                    <?php
                    $pen = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' && client_id = '$client_id' && int_id = '$sessint_id'");
                    $np = mysqli_fetch_array($pen);
                    $product_type = $np["product_id"];
                    $get_product = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$product_type' AND int_id = '$sessint_id'");
                    $mer = mysqli_fetch_array($get_product);
                    $p_n = $mer["name"];
                    ?>
                    <input type="text" class="form-control" name="phone" value="<?php echo $acct_no . " - " . $p_n; ?>" readonly>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="bmd-label-floating">Interest (%)</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo number_format($interest, 2); ?>" readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="bmd-label-floating">Principal Amount (0.00)</label>
                    <input type="text" class="form-control" name="location" value="<?php echo number_format($prin_amt, 2); ?>" readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="bmd-label-floating">Loan Term</label>
                    <input type="text" class="form-control" name="transidddd" value="<?php echo $loan_term . " - " . $repay_eve . "(s)"; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Disbursement Date</label>
                    <input type="text" class="form-control" name="transidddd" value="<?php echo $date; ?>" readonly>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="bmd-label-floating">Total Interest (0.00)</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo number_format($tot_int, 2); ?>" readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="bmd-label-floating">Total Repayment Due (0.00)</label>
                    <input type="text" class="form-control" name="location" value="<?php echo number_format($prin_due, 2); ?>" readonly>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="bmd-label-floating">Repayment Every</label>
                    <input type="text" class="form-control" name="transidddd" value="<?php echo $ln_prod_repay_frequency . " Time(s) Every " . $repay_eve; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">1st Repayment Date</label>
                    <input type="text" class="form-control" name="transidddd" value="<?php echo $date2; ?>" readonly>
                  </div>
                </div>
              </div>
              <br>
              <p>Run Credit Check - Statistic Scoring</p>
              <div class="row">
                <div class="col-md-6">
                  <div class="card card-nav-tabs" style="width: 30rem;">
                    <div class="card-header card-header-<?php echo $color; ?>">
                      Delinquency Counter
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">Healthy Repayment: <?php echo $early_rep; ?>
                        <div class="progress-container progress-success">
                          <span class="progress-badge">Good</span>
                          <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $total_early . "%"; ?>;" aria-valuenow="<?php echo $total_early; ?>" aria-valuemin="0" aria-valuemax="100">
                              Good
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item">UnHealthy Repayment: <?php echo $imm_rep; ?>
                        <div class="progress-container progress-success">
                          <span class="progress-badge">Warning</span>
                          <div class="progress">
                            <div class="progress-bar  bg-warning" role="progressbar" style="width: <?php echo $total_imm . "%"; ?>;" aria-valuenow="<?php echo $total_imm; ?>" aria-valuemin="0" aria-valuemax="100">
                              Warning
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item">Late Repayment: <?php echo $late_rep; ?></li>
                      <li class="list-group-item">

                        <div class="progress-container progress-success">
                          <span class="progress-badge">Bad</span>
                          <div class="progress">
                            <div class="progress-bar  bg-danger" role="progressbar" style="width: <?php echo $total_bad . "%"; ?>" aria-valuenow="<?php echo $total_bad; ?>" aria-valuemin="0" aria-valuemax="100">
                              Bad
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- Next -->
                <div class="col-md-6">
                  <div class="card card-nav-tabs" style="width: 30rem;">
                    <div class="card-header card-header-<?php echo $col_2; ?>">
                      Loan Behaviour
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">Active Loan: <?php echo $atv_loan; ?></li>
                      <li class="list-group-item">Bad Loan: <?php echo $bad_loan; ?></li>
                      <li class="list-group-item">Written Off Loan: <?php echo $wrt_loan; ?></li>
                      <li class="list-group-item">Same Product Outstanding: <?php echo $out_loan; ?></li>
                      <li class="list-group-item">
                        <div class="progress">
                          <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $bad . "%"; ?>" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                            Danger
                          </div>
                          <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $warn . "%"; ?>" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                            Warning
                          </div>
                          <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $good . "%"; ?>" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                            Good
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- Next -->
              <div class="row">
                <!-- new -->
                <div class="col-md-6">
                  <div class="card card-nav-tabs" style="width: 30rem;">
                    <div class="card-header card-header-<?php echo $color3; ?>">
                      Clients KYC
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">Age: <?php echo $age; ?></li>
                      <li class="list-group-item">Income: <?php echo number_format($k_in, 2); ?></li>
                      <li class="list-group-item">Years in current Job/Business: <?php echo $yicj; ?></li>
                      <li class="list-group-item">Marital Status: <?php echo $mst; ?></li>
                      <li class="list-group-item">Level of Education: <?php echo $loe; ?></li>
                      <li class="list-group-item">Number of Dependents: <?php echo $nod; ?></li>
                      <li class="list-group-item">Collateral Value: <?php echo number_format($prec, 2) . "% of principal amount"; ?></li>
                      <li class="list-group-item">
                        <div class="progress">
                          <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $bad1 . "%"; ?>" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                            Danger
                          </div>
                          <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $warn1 . "%"; ?>" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                            Warning
                          </div>
                          <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $good1 . "%"; ?>" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                            Good
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- new -->
                <div class="col-md-6">
                  <div class="card card-nav-tabs" style="width: 30rem;">
                    <div class="card-header card-header-<?php echo $color4; ?>">
                      Savings Behaviour
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">Average Savings Balance: <?php echo number_format($s1x, 2); ?></li>
                      <li class="list-group-item">Maximum Savings Balance: <?php echo number_format($s2x, 2); ?></li>
                      <li class="list-group-item">Number of Deposit: <?php echo $acct_credit; ?></li>
                      <li class="list-group-item">Number of Withdrawals: <?php echo $acct_debit; ?></li>
                      <li class="list-group-item">Average Deposit Amount: <?php echo number_format($s5x, 2); ?></li>
                      <li class="list-group-item">Average Withdrawal Amount: <?php echo number_format($s6x, 2); ?></li>
                      <li class="list-group-item">
                        <div class="progress">
                          <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $bad2 . "%"; ?>" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                            Danger
                          </div>
                          <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $warn2 . "%"; ?>" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                            Warning
                          </div>
                          <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $good2 . "%"; ?>" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                            Success
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- hyped -->
                <br>
                <!-- never be -->
                <!-- saving -->

                <!-- saving -->
                <div class="col-md-6">
                  <div class="card card-pricing bg-warning">
                    <div class="card-body ">
                      <div class="card-icon">
                        <i class="material-icons">money</i>
                      </div>
                      <h3 class="card-title">&#x20a6; <?php echo number_format($prin_amt, 2); ?> </h3>
                      <p class="card-description">
                        100% of the principal amount.
                      </p>
                      <button type="submit" value="submit_b" name="submit" class="btn btn-white btn-round">Approve Plan</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <hr>
                  <div>
                    <a href="#" class="btn btn-success btn-round pull-left">Print Credit Score</a>
                    <button type="submit" value="reject" name="submit" class="btn btn-danger btn-round pull-right">Reject Loan</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- /content -->
</div>
</div>

<?php

include("footer.php");

?>