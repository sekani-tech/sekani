<?php
include("connect.php");
session_start();

$sessint_id = $_SESSION["int_id"];
$userid = $_SESSION["user_id"];
$client_id = $_POST["client_id"];
$goacctn = mysqli_query($connection, "SELECT account_no FROM client WHERE id = '$client_id' ");
if (count([$goacctn]) == 1) {
    $a = mysqli_fetch_array($goacctn);
    $acct_no = $a['account_no'];
}
// Part for Product
$product_id = $_POST['product_id'];
$principal_amount = $_POST['principal_amount'];
$loan_term = $_POST['loan_term'];
$loan_no_rep = $_POST['repay_every_no'];
$repay_every = $_POST['repay_every'];
$interest_rate = $_POST['interest_rate'];
$disbursement_date = $_POST['disbursement_date'];
$grace_on_principal = $_POST['grace_on_principal'];
$grace_on_interest = $_POST['grace_on_interest'];
$loan_officer = $_POST['loan_officer'];
$loan_purpose = $_POST['loan_purpose'];
$standing_instruction = $_POST['standing_instruction'];
$linked_savings_acct = $_POST['linked_savings_acct'];
$repay_start =  $_POST["repay_start"];
if ($repay_start == NULL || $repay_start == "") {
    echo $repay_start;
    echo $repay_every;
} else {
    $repay_every = $_POST["repay_eve"];
    $repay_st1 =  $_POST["repay_start"];
$date = str_replace('/', '-', $repay_st1);
$repay_st =  date('Y-m-d', strtotime($date));
    // echo "Repayement Datw".$repay_st;
    // echo "XDisgb Datw".$disbursement_date;
// Part for Charges
$charges = $_POST['charge'];
// Part for collateral
$col_id = $_POST['col_id'];
$col_type = $_POST['col_name'];
$col_description = $_POST['col_description'];
$col_val = $_POST['col_value'];
// Part for Gaurantors
$first_name = $_POST['gau_first_name'];
$last_name = $_POST['gau_last_name'];
$phone = $_POST['gau_phone'];
$phone2 = $_POST['gau_phone2'];
$home_address = $_POST['gau_home_address'];
$office_address = $_POST['gau_office_address'];
$position_held = $_POST['gau_position_held'];
$email = $_POST['gau_email'];
// date of submitted
// lc
$r = $interest_rate;
$prina = $principal_amount;
$gi = $r * $prina;
$pd = $gi + $prina;
// term frequency
$fund_id = $_POST["fund_source"];
$loan_sector = $_POST["loan_sector"];
$tff = $loan_term - 1;

$submitted_on = date("Y-m-d");
$currency = "NGN";
$cd = 2;
// stopped at principal amount
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// first test client loan status then test the running balance in the institution acct.
$verify = mysqli_query($connection, "SELECT * FROM `int_vault` WHERE int_id = '$sessint_id'");
    if (count([$verify]) == 1) {
        $x = mysqli_fetch_array($verify);
        $int_acct_bal = $x['balance'];
        $calprinamt = $principal_amount;
        $acctprin = $int_acct_bal - $calprinamt;
        $branchhl = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id'");
                if (count([$branchhl]) == 1) {
                    $yxx = mysqli_fetch_array($branchhl);
                    $lsff = $yxx['loan_status'];
                    $cdn = $yxx['display_name'];
                }
        if ($acctprin >= 0) {
            if ($lsff == "Not Active" || $lsff == "") {
                $stt = "Pending";
                $query = "INSERT INTO loan_disbursement_cache (int_id, account_no, client_id,
                    display_name, product_id, fund_id, col_id, col_name, col_description,
                    loan_officer, loan_purpose, currency_code,
                    currency_digits, principal_amount_proposed, principal_amount,
                    loan_term, interest_rate, approved_principal, repayment_date,
                    term_frequency, repay_every, number_of_repayments, submittedon_date,
                    submittedon_userid, approvedon_date, approvedon_userid,
                    expected_disbursedon_date, expected_firstrepaymenton_date, disbursement_date,
                    disbursedon_userid, repay_principal_every, repay_interest_every, status, loan_sub_status_id) 
                    VALUES ('{$sessint_id}', '{$acct_no}', '{$client_id}',
                    '{$cdn}', '{$product_id}', '{$fund_id}', '{$col_id}', '{$col_name}', '{$col_description}',
                    '{$loan_officer}', '{$loan_purpose}', '{$currency}', 
                    '{$cd}', '{$principal_amount}', '{$pd}', 
                    '{$loan_term}', '{$interest_rate}', '{$principal_amount}', '{$repay_st}',
                    '{$tff}', '{$repay_every}',
                    '{$loan_no_rep}', '{$submitted_on}', '{$userid}', '{$submitted_on}', '{$userid}',
                    '{$disbursement_date}', '{$repay_st}', '{$disbursement_date}',
                    '{$userid}', '{$loan_term}', '{$loan_term}', '{$stt}', '{$loan_sector}')";
            $res = mysqli_query($connection, $query);
            if ($res) {
                $colkt = mysqli_query($connection, "SELECT * FROM loan_disbursement_cache where client_id = '$client_id'");
                                if (count([$colkt]) == 1) {
                                    $marital_stat = $_POST["marital_status"];
                                    $no_dep = $_POST["no_of_dep"];
                                    $ed_level = $_POST["ed_level"];
                                    $emp_stat = $_POST["emp_stat"];
                                    $emp_bus_name = $_POST["emp_bus_name"];
                                    $income = $_POST["income"];
                                    $years_in_job = $_POST["years_in_job"];
                                    $res_type = $_POST["res_type"];
                                    $rent_per_year = $_POST["rent_per_year"];
                                    $years_in_res = $_POST["years_in_res"];
                                   $kyc_query = mysqli_query($connection, "INSERT INTO `kyc` (`int_id`, `client_id`, `marital_status`, `no_of_dependent`, `level_of_ed`, `emp_stat`, `emp_bus_name`, `income`, `years_in_job`, `res_type`, `rent_per_year`, `year_in_res`)
                                   VALUES ('{$sessint_id}', '{$client_id}', '{$marital_stat}', '{$no_dep}', 
                                   '{$ed_level}', '{$emp_stat}', '{$emp_bus_name}', '{$income}',
                                   '{$years_in_job}', '{$res_type}', '{$rent_per_year}', '{$years_in_res}')");
                                   if ($kyc_query) {
                                    $_SESSION["Lack_of_intfund_$randms"] = "Successfully Uploaded, Awaiting Disbursement Approval";
                                    header ("Location: ../mfi/lend.php?message=$randms");
    //                                 if ($connection->error) {
    //     try {   
    //         throw new Exception("MySQL error $connection->error <br> Query:<br> $colkt", $mysqli->error);   
    //     } catch(Exception $e ) {
    //         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
    //         echo nl2br($e->getTraceAsString());
    //     }
    // }
                                   } else {
                                    $_SESSION["Lack_of_intfund_$randms"] = "Error in Posting For Approval";
                                    header ("Location: ../mfi/lend.php?message2=$randms");
                                   }
                                }
            } else {
                $_SESSION["Lack_of_intfund_$randms"] = "Error in Posting For Approval";
                header ("Location: ../mfi/lend.php?message2=$randms");
            }
            } else {
                $_SESSION["Lack_of_intfund_$randms"] = "This Client Has Been Given Loan Before";
        header ("Location: ../mfi/lend.php?message3=$randms");
            }
    }  else {
        $_SESSION["Lack_of_intfund_$randms"] = "Insufficent Fund From Institution Account!";
        header ("Location: ../mfi/lend.php?message4=$randms");
}
// if ($connection->error) {
//     try {   
//         throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
//     } catch(Exception $e ) {
//         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//         echo nl2br($e->getTraceAsString());
//     }
// }
}
}
?>