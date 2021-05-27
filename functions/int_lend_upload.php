<?php
include("connect.php");
session_start();

$sessint_id = $_SESSION["int_id"];
$userid = $_SESSION["user_id"];
$client_id = $_POST["client_id"];

// remove cached charges from loan
// $fdo = mysqli_query($connection, "DELETE FROM loan_charge WHERE client_id = '$client_id'");
// $goacctn = mysqli_query($connection, "SELECT account_no FROM client WHERE id = '$client_id' ");
// if (count([$goacctn]) == 1) {
//     $a = mysqli_fetch_array($goacctn);
// }

// Part for Product
$product_id = $_POST['product_id'];
$principal_amount = $_POST['principal_amount'];
$loan_term = $_POST['loan_term'];
$repay_start = $_POST["repay_start"];
// $loan_no_rep = $_POST['repay_every_no'];         ex. 2 months
$repay_frequency = $_POST['repay_frequency'];   //  ex. 2
$repay_every = $_POST['repay_every'];           //  ex. months  
$no_of_repay = $loan_term / $repay_frequency;
$interest_rate = $_POST['interest_rate'];
$disbursement_date = $_POST['disbursement_date'];
$grace_on_principal = $_POST['grace_on_principal'];
// $grace_on_interest = $_POST['grace_on_interest'];
$loan_officer = $_POST['loan_officer'];
$loan_purpose = preg_replace('/[^\w]/', '', $_POST['loan_purpose']);
// $standing_instruction = $_POST['standing_instruction'];
$acct_no = $_POST['account_no'];
$total_outstanding_derived = $_POST['total_outstanding_loan'];


if ($repay_start == NULL || $repay_start == "" || $disbursement_date == "" || $loan_term == "") {
    $_SESSION["Lack_of_intfund_$randms"] = "Please fill some field";
    echo header ("Location: ../mfi/lend.php?messfill=$randms");

} else {
    $repay_every = $_POST["repay_eve"];
    $repay_st1 =  $_POST["repay_start"];
    $date = str_replace('/', '-', $repay_st1);
    $repay_st =  date('Y-m-d h:i:sa', strtotime($date));

    // term frequency
    $fund_id = 0;
    $loan_sector = $_POST["loan_sector"];
    $submitted_on = date("Y-m-d");
    $currency = "NGN";
    $matured_loan_date = $_POST["matured_loan_date"];
    $cd = 2;

    // stopped at principal amount
    $digits = 6;
    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    // first test client loan status then test the running balance in the institution acct.
    // $verify = mysqli_query($connection, "SELECT * FROM `int_vault` WHERE int_id = '$sessint_id'");
    $branch_id = $_SESSION["branch_id"];
    // $get_payment_gl = mysqli_query($connection, "SELECT * FROM payment_type WHERE id = '$fund_id' AND int_id = '$sessint_id' AND branch_id = '$branch_id'");
    // $fool = mysqli_fetch_array($get_payment_gl);
    // $ggl = $fool["gl_code"];
    // Get the GL and the balance
    // $get_gl = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE gl_code = '$ggl' AND int_id = '$sessint_id'");sss
    // $fool1 = mysqli_fetch_array($get_gl);
    if ($fund_id == 0) {
        // $x = mysqli_fetch_array($get_gl);
        // $int_acct_bal = $x["organization_running_balance_derived"];
        // $calprinamt = $principal_amount;
        // $acctprin = $int_acct_bal - $calprinamt;
        $branchhl = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id'");
        if (count([$branchhl]) == 1) {
            $yxx = mysqli_fetch_array($branchhl);
            $lsff = $yxx['loan_status'];
            $cdn = $yxx['display_name'];
        }

        if ($fund_id == 0) {

            if ($lsff != "Active") {

                $stt = "Pending";

                $tempLoanId = str_pad(rand(0, pow(10, 7)-1), 7, '0', STR_PAD_LEFT);

                /**
                 *  Upload Collateral
                 */
                $coldate = date('Y-m-d h:i:sa');
                $colname = $_POST['colname'];
                $colval = $_POST['colval'];
                $coldes = $_POST['coldes']; 

                $collateral_upload = mysqli_query($connection, "INSERT INTO collateral (int_id, loan_id, client_id, date, type, value, description) 
                                    VALUES ('{$sessint_id}', '{$tempLoanId}', '{$client_id}', '{$coldate}', '{$colname}', '{$colval}', '{$coldes}')");

                if($collateral_upload) {
                    /**
                     *  Upload Guarantor
                     */
                    $gau_firstname = $_POST['gau_first_name'];
                    $gau_lastname = $_POST['gau_last_name'];
                    $gau_phone = $_POST['gau_phone'];
                    $gau_phone2 = $_POST['gau_phone2'];
                    $gau_home_address = $_POST['gau_home_address'];
                    $gau_office_address = $_POST['gau_office_address'];
                    $gau_email = $_POST['gau_email'];

                    $guarantor_upload = mysqli_query($connection, "INSERT INTO loan_gaurantor (int_id, loan_id, client_id, first_name, last_name, 
                                        phone, phone2, home_address, office_address, email) 
                                        VALUES ( '{$sessint_id}', '{$tempLoanId}', '{$client_id}', '{$gau_firstname}', '{$gau_lastname}', 
                                        '{$gau_phone}', '{$gau_phone2}', '{$gau_home_address}', '{$gau_office_address}', '{$gau_email}')");

                    if($guarantor_upload) {
                        // Get collateral id
                        $get_col_id = mysqli_query($connection, "SELECT id FROM collateral WHERE int_id = '$sessint_id' AND loan_id = '$tempLoanId'");
                        $col_id = mysqli_fetch_array($get_col_id)['id'];

                        $query = "INSERT INTO loan_disbursement_cache (int_id, branch_id, account_no, client_id, display_name, 
                        product_id, fund_id, col_id, col_name, col_description,
                        loan_officer, loan_purpose, currency_code, currency_digits, 
                        principal_amount_proposed, principal_amount, loan_term, interest_rate, 
                        approved_principal, repayment_date, term_frequency, repay_every, number_of_repayments, 
                        submittedon_date, submittedon_userid, approvedon_date, approvedon_userid,
                        expected_disbursedon_date, expected_firstrepaymenton_date, disbursement_date, disbursedon_userid, 
                        repay_principal_every, repay_interest_every, status, loan_sub_status_id, expected_maturedon_date, total_outstanding_derived) 
                        VALUES ('{$sessint_id}', '{$branch_id}', '{$acct_no}', '{$client_id}', '{$cdn}', 
                        '{$product_id}', '{$fund_id}', '{$col_id}', '{$colname}', '{$coldes}',
                        '{$loan_officer}', '{$loan_purpose}', '{$currency}', '{$cd}', 
                        '{$principal_amount}', '{$principal_amount}', '{$loan_term}', '{$interest_rate}', 
                        '{$principal_amount}', '{$repay_st}', '{$repay_frequency}', '{$repay_every}', '{$no_of_repay}', 
                        '{$submitted_on}', '{$userid}', '{$submitted_on}', '{$userid}',
                        '{$disbursement_date}', '{$repay_st}', '{$disbursement_date}', '{$userid}', 
                        '{$repay_frequency}', '{$repay_frequency}', '{$stt}', '{$loan_sector}', '{$matured_loan_date}', '{$total_outstanding_derived}')";

                        $res = mysqli_query($connection, $query);
        
                        if ($res) {
        
                            $colkt = mysqli_query($connection, "SELECT * FROM loan_disbursement_cache WHERE int_id = '$sessint_id' AND client_id = '$client_id'");
        
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
                                // ORDER
                                $emp_cat = $_POST["emp_category"];
                                $other_bank = $_POST["other_banks"];
        
                                $get_kyc_if_ex = mysqli_query($connection, "SELECT * FROM `kyc` WHERE `kyc`.`client_id` = '$client_id'");
                                if (mysqli_num_rows($get_kyc_if_ex) <= 0) {
        
                                    $kyc_query = mysqli_query($connection, "INSERT INTO `kyc` (`int_id`, `client_id`, `marital_status`, `no_of_dependent`, `level_of_ed`, 
                                                `emp_stat`, `emp_bus_name`, `income`, `years_in_job`, `res_type`, `rent_per_year`, `year_in_res`, `other_bank`, `emp_category`)
                                                VALUES ('{$sessint_id}', '{$client_id}', '{$marital_stat}', '{$no_dep}', '{$ed_level}', '{$emp_stat}', '{$emp_bus_name}', '{$income}',
                                                '{$years_in_job}', '{$res_type}', '{$rent_per_year}', '{$years_in_res}', '{$other_bank}', '{$emp_cat}')");
                                                
                                    if ($kyc_query) {
                                        $_SESSION["Lack_of_intfund_$randms"] = "Successfully Uploaded, Awaiting Disbursement Approval";
                                        header ("Location: ../mfi/lend.php?message=$randms");
                                    } else {
                                        $_SESSION["Lack_of_intfund_$randms"] = "Error in Posting For Approval";
                                        header ("Location: ../mfi/lend.php?message2=$randms");
                                    }
        
                                } else {
                                    $update_kyc = mysqli_query($connection, "UPDATE `kyc` SET `marital_status` = '$marital_stat', `no_of_dependent` = '$no_dep', `level_of_ed` = '$ed_level',
                                    `emp_stat` = '$emp_stat', `emp_bus_name` = '$emp_bus_name', `income` = '$income', `years_in_job` = '$years_in_job' WHERE `kyc`.`client_id` = '$client_id'");
        
                                    if ($update_kyc) {
                                        $_SESSION["Lack_of_intfund_$randms"] = "Successfully Uploaded, Awaiting Disbursement Approval";
                                        header ("Location: ../mfi/lend.php?message=$randms");
                                    } else {
                                        $_SESSION["Lack_of_intfund_$randms"] = "Error in Posting For Approval";
                                        header ("Location: ../mfi/lend.php?message2=$randms");
                                    }
                                }
                            }
        
                        } else {
                            $_SESSION["Lack_of_intfund_$randms"] = "Error in Posting For Approval";
                            header ("Location: ../mfi/lend.php?message2=$randms");
                        }
                    }
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
