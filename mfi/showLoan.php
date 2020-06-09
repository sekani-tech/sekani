<?php

$page_title = "Approve Loan";
$destination = "disbursement_approval.php";
    include("header.php");
?>
<?php
if (isset($_GET['approve']) && $_GET['approve'] !== '') {
  $appod = $_GET['approve'];
  $checkm = mysqli_query($connection, "SELECT * FROM loan_disbursement_cache WHERE id = '$appod' && int_id = '$sessint_id' && status = 'Pending'");
  if (count([$checkm]) == 1) {
      $x = mysqli_fetch_array($checkm);
      $ssint_id = $_SESSION["int_id"];
      $client_id = $x["client_id"];
      $sub_user_id = $x["submittedon_userid"];
      $cn = $x['display_name'];
      $loan_product = $x["product_id"];
      $loan_sector = $x["loan_sub_status_id"];
      $account_officer = $x["loan_officer"];
      $acct_no = $x["account_no"];
      $dis_cache_status = $x["status"];
      // here are the things
      $interest = $x["interest_rate"];
      $prin_amt = $x["approved_principal"];
      $loan_term = $x["loan_term"];
      $repay_eve = $x["repay_every"];
      $no_repayment = $x["number_of_repayments"];
      $disburse_date = $x["disbursement_date"];
      $repayment_date = $x["repayment_date"];
      $date = date('d, D, F, Y', strtotime($disburse_date));
      $date2 = date('d, D, F, Y', strtotime($repayment_date));
      // calculation
      $tot_int = ($interest/100) * $prin_amt;
      $prin_due = $tot_int + $prin_amt;
      // get off
      $get_off = mysqli_query($connection, "SELECT * FROM staff WHERE id = '$account_officer'");
      $cx = mysqli_fetch_assoc($get_off);
      $off_dis = strtoupper($cx["display_name"]);
      // sector
      $me = "";
      if ($loan_sector == 0) {
        $me = "";
      } else if ($loan_sector == 1) {
        $me = "Education";
      } else if ($loan_sector == 2) {
        $me = "Finance";
      } else if ($loan_sector == 3) {
        $me = "Agriculture";
      } else if ($loan_sector == 4) {
        $me = "Manufacturing";
      } else if ($loan_sector == 5) {
        $me = "Construction";
      } else if ($loan_sector == 6) {
        $me = "Others";
      }
      // get the product
      $ln_prod =  mysqli_query($connection, "SELECT * FROM product WHERE id = '$loan_product' && int_id = '$sessint_id'");
      $pd = mysqli_fetch_array($ln_prod);
      $ln_prod_name = $pd["name"];
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
    $col_va = $cm["type"];
    $agex = $kq1["date_of_birth"];
    $age = (date('Y') - date('Y',strtotime($agex)));

    $k_in = $kq["income"];
    $k_yb = $kq["years_in_job"];
    $k_mart = $kq["marital_status"];
    $k_dep = $kq["no_of_dependent"];
    $k_edu = $kq["level_of_ed"];
    // meaning
    $yicj = "";
    $mst = "";
    $nod = "";
    $loe = "";
    if ($k_yb == "1") {
      $yicj = "1 - 3 years";
    } else if ($k_yb == "2") {
      $yicj = "3 - 5 years";
    } else if ($k_yb == "3") {
      $yicj = "5 - 10 years";
    } else if ($k_yb == "4") {
      $yicj = "10 - 20 years";
    } else if ($k_yb == "5") {
      $yicj = "More than 20 years";
    }

    if ($k_mart == "1") {
      $mst = "Single";
    } else {
      $mst = "Married";
    }

    if ($k_dep == "0") {
      $nod = "Nobody";
    } else if ($k_dep == "1") {
      $nod = "1";
    } else if ($k_dep == "2") {
      $nod = "2";
    } else if ($k_dep == "3") {
      $nod = "3";
    } else if ($k_dep == "4") {
      $nod = "4 or More";
    }

    if ($k_edu == "0") {
      $loe = "Non";
    } else if ($k_edu == "1") {
      $loe = "Primary";
    } else if ($k_edu == "2") {
      $loe = "Seconday";
    } else if ($k_edu == "3") {
      $loe = "Graduate";
    } else if ($k_edu == "4") {
      $loe = "Post-Graduate";
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
    $mxx = ($early_rep/$gen1) * 100;
    $mxx1 = ($imm_rep/$gen1) * 100;
    $mxx2 = ($late_rep/$gen1) * 100;
    if ($mxx >= 0 && $mxx <= 30 ) {
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
    if ($mxx1 >= 0 && $mxx1 <= 30 ) {
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
    if ($mxx2 >= 0 && $mxx2 <= 30 ) {
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
    }  else if ($total_imm > $total_early && $total_imm > $total_bad) {
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
    $get_col_meet = ((120/100) * $prin_amt);
    $get_col_val = ((120/100) * $col_va);
    // a value amount
    $prec = ($col_va/$prin_amt) * 100;
    if ($prec >= 0 && $prec <= 50 ) {
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
    }  else if ($warn1 > $good1 && $warn1 > $bad1) {
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
    $prec1 = ($s1x/$prin_amt) * 100;
    if ($prec1 >= 0 && $prec1 <= 30 ) {
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
    $prec2 = ($s2x/$prin_amt) * 100;
    if ($prec2 >= 0 && $prec2 <= 30 ) {
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
    }  else if ($warn3 > $good3 && $warn1 > $bad1) {
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
        $branch_id = $_SESSION["branch_id"];
        $v_query = mysqli_query($connection, "SELECT * FROM int_vault WHERE int_id = '$sessint_id' && branch_id = '$branch_id'");
        $ivb = mysqli_fetch_array($v_query);
        $vault_bal = $ivb["balance"];
        $new_vault_run_bal = $vault_bal - $loan_amount;
        // take out the amount from the vualt balance for the transaction balance
        if ($vault_bal >= $loan_amount) {
          // TAKE OUT THE CHRAGES at the Disbursment point
          // a query to select charges
          $charge_query= mysqli_query($connection, "SELECT * FROM `product_loan_charge` WHERE product_loan_id = '$loan_product' && int_id = '$sessint_id'");
          $cqb = mysqli_fetch_array($charge_query);
          // charge application start.
          if (mysqli_num_rows($charge_query) > 0 ) {
            while ($cxr = mysqli_fetch_array($charge_query, MYSQLI_ASSOC)) {
              $c_id = $cxr["charge_id"];
              $select_flat = mysqli_query($connection, "");
              $select_per = mysqli_query($connection, "");
              // qwerty
              $select_each_charge = mysqli_query($connection, "SELECT * FROM charge WHERE id = '$c_id' && int_id = '$sessint_id'");
              while ($ex = mysqli_fetch_assoc($select_each_charge)) {
                $values = $ex["charge_time_enum"];
                $nameofc = $ex["name"];
                $amt = '';
                $amt2 = '';
                $zzzzz = 0;
                $forp = $ex["charge_calculation_enum"];
                $rmt = $loan_amount;
                if ($forp == 1) {
                  $zzzzz = $ex["amount"];
                  $chg2 = $amt;
                } else {
                  $calc = ($forp / 100) * $rmt;
                }
                $pay_charge += $zzzzz;
                $pay_charge2 += $calc;
                echo $chg2."All Flat ----";
                echo $calc."All Percentage";
              }
            }
            echo $pay_charge."SUM of Flat ----"; 
            echo $pay_charge2."SUM of Percentage"; 
          }
        }  else {
          // echo insufficient fund from vualt
          echo "insufficient fund from vualt";
        }
      } else if ($but_type == "reject") {
        // reject the loan
        // store the rejected loan status in cache - to rejecteds
        echo "you rejected the loan";
      } else {
        // push out an error to the person approving
        echo "error on approval";
      }
    } else if ($dis_cache_status == "Rejected") {
      // echo already rejected
      echo "rejected already";
    } else {
      // already approved
      echo "Already Approved";
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
                          <input type="text" class="form-control" name="phone" value="<?php echo strtoupper($me); ?>" readonly>
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
                          <input type="text" class="form-control" name="phone" value="<?php echo $acct_no; ?>" readonly>
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
                          <input type="text" class="form-control" name="transidddd" value="<?php echo $loan_term. " - " .$repay_eve."(s)"; ?>" readonly>
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
                          <label class="bmd-label-floating">Principal Due (0.00)</label>
                          <input type="text" class="form-control" name="location" value="<?php echo number_format($prin_due, 2); ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="bmd-label-floating">Repayment Every</label>
                          <input type="text" class="form-control" name="transidddd" value="<?php echo $no_repayment." Time(s) Every ". $repay_eve; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Repayment Date</label>
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
                           <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $total_early."%"; ?>;" aria-valuenow="<?php echo $total_early; ?>" aria-valuemin="0" aria-valuemax="100">
                           Good
                          </div>
                          </div>
                        </div>
                      </li>
                        <li class="list-group-item">UnHealthy Repayment: <?php echo $imm_rep; ?>
                        <div class="progress-container progress-success">
                          <span class="progress-badge">Warning</span>
                          <div class="progress">
                           <div class="progress-bar  bg-warning" role="progressbar" style="width: <?php echo $total_imm."%"; ?>;" aria-valuenow="<?php echo $total_imm; ?>" aria-valuemin="0" aria-valuemax="100">
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
                           <div class="progress-bar  bg-danger" role="progressbar" style="width: <?php echo $total_bad."%"; ?>" aria-valuenow="<?php echo $total_bad; ?>" aria-valuemin="0" aria-valuemax="100">
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
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $bad."%"; ?>" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                         Danger
                        </div>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $warn."%"; ?>" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                        Warning
                        </div>
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $good."%"; ?>" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
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
                        <li class="list-group-item">Collateral Value: <?php echo number_format($prec, 2)."% of principal amount"; ?></li>
                        <li class="list-group-item">
                        <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $bad1."%"; ?>" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                         Danger
                        </div>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $warn1."%"; ?>" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                        Warning
                        </div>
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $good1."%"; ?>" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
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
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $bad2."%"; ?>" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                         Danger
                        </div>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $warn2."%"; ?>" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                         Warning
                        </div>
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $good2."%"; ?>" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
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
                         <div class="col-md-6">
                           <div class="card card-pricing bg-success"><div class="card-body ">
                           <div class="card-icon">
                             <i class="material-icons">money</i>
                           </div>
                            <h3 class="card-title">&#x20a6; <?php echo number_format($comp_amt, 2); ?> </h3>
                           <p class="card-description">
                           System computation <?php echo $auto_perc ?>% of the principal amount.
                           </p>
                            <button type="submit" value="submit" name="submit" class="btn btn-white btn-round">Approve Plan</button>
                          </div>
                          </div>
                         </div>
                         <!-- saving -->
                         <div class="col-md-6">
                           <div class="card card-pricing bg-warning"><div class="card-body ">
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