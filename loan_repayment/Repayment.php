<?php
// START
include("DB/connect.php");
// GET THE LOAN DISBURSMENT CACHE CHECK BY DISBURSMENT CHACHE ID
// GET THE LOAN
// WIRTE A CODE FOR THE REPAYMENT FUNCTION - IF
// END
$select_all_disbursment_cache = mysqli_query($connection, "SELECT * FROM `loan_disbursement_cache` WHERE status = 'Approved'");
while($x = mysqli_fetch_array($select_all_disbursment_cache)) {
    // Get the client ID, Status, Product_id.
    $client_id = $x["client_id"];
    $product_id = $x["product_id"];
    $int_id = $x["int_id"];
    // NOW CHECK THE ACCOUNT
    $select_loan_client = mysqli_query($connection, "SELECT * FROM `loan` WHERE client_id = '$client_id' AND $product_id = '$product_id' AND int_id = '$int_id'");
    while ($y = mysqli_fetch_array($select_loan_client)) {
        // GET THE LOAN DETAILS FOR THE REPAYMENT
        // SELECT THE REPAYMENT SCH. IF IT IS ZERO - DO A REPAYMENT, IF IT IS MORE THAN.
        $loan_id = $y["id"];
        $acct_no = $y["account_no"];
        $client_id = $y["client_id"];
        $product_id = $y["product_id"];
        // DISPLAY THE REPAYMENT STUFFS
        $pincpal_amount = $y["principal_amount"];
        $loan_term = $y["loan_term"];
        $interest_rate = $y["interest_rate"];
        $no_of_rep = $y["number_of_repayments"];
        $rep_every = $y["repay_every"];
        // DATE
        $disburse_date = $y["disbursement_date"];
        $offical_repayment = $y["repayment_date"];
        $repayment_start = $y["repayment_date"];
        // GET THE REPAYMENT END DATE
        $sch_date = date("Y-m-d");
        // SECHDULE DATE
        $approved_by = $y["approvedon_userid"];
        // END OF OFFICAL INFO
        $loan_term1 = $loan_term - 1;
        $loan_term2 = $loan_term;
        if($rep_every == "month"){
            $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." months", strtotime($repayment_start)));
            $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." months", strtotime($repayment_start)));
        }else if($rep_every == "day"){
            $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." days", strtotime($repayment_start)));
            $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." days", strtotime($repayment_start)));
        }else if($rep_every == "year"){
            $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." years", strtotime($repayment_start)));
            $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." years", strtotime($repayment_start)));
        } else if($rep_every == "week"){
            $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." weeks", strtotime($repayment_start)));
            $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." weeks", strtotime($repayment_start)));
        }
        // GET THE END DATE OF THE LOAN
        $matured_date = $actualend_date;
        $matured_date2 = $actualend_date1;
        // GET THE END DATE OF THE LOAN
        $matured_date = $actualend_date;
        // echo "EVERY LOAN START AND END DATE "."CLIENT ".$client_id." -". $repayment_start." - ".$matured_date;
        // REPAYMENT SCHEDULE
        // -----------------
        // IF IT IS NULL 
        $select_repayment_sch = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND client_id = '$client_id' AND int_id = '$int_id'");
        $dm = mysqli_fetch_array($select_repayment_sch);
        // dman
        if ($dm <= 0) {
            // NOTHING
        while (strtotime("+1 ".$rep_every, strtotime($repayment_start)) <= strtotime($matured_date2)) {
           $rep_client_id =  $client_id;
           $rep_fromdate =  $repayment_start;
           $rep_duedate = $matured_date;
            $rep_install = $no_of_rep;
           $rep_comp_derived =  $pincpal_amount / $loan_term;
           $rep_int_amt = ((($interest_rate / 100) * $pincpal_amount) * $loan_term) / $loan_term;
        //    WE DO A NEXT STUFF
        $insert_into_repsch = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
            `principal_amount`, `principal_completed_derived`, `principal_writtenoff_derived`, `interest_amount`, `interest_completed_derived`, `interest_writtenoff_derived`, 
            `interest_waived_derived`, `accrual_interest_derived`, `suspended_interest_derived`, `fee_charges_amount`, `fee_charges_completed_derived`, `fee_charges_writtenoff_derived`, 
            `fee_charges_waived_derived`, `accrual_fee_charges_derived`, `suspended_fee_charges_derived`, `penalty_charges_amount`, `penalty_charges_completed_derived`, 
            `penalty_charges_writtenoff_derived`, `penalty_charges_waived_derived`, `accrual_penalty_charges_derived`, `suspended_penalty_charges_derived`, 
            `total_paid_in_advance_derived`, `total_paid_late_derived`, `completed_derived`, `obligations_met_on_date`, `createdby_id`, `created_date`, `lastmodified_date`, 
            `lastmodifiedby_id`, `recalculated_interest_component`) 
            VALUES ('{$int_id}', '{$loan_id}', '{$rep_client_id}', '{$offical_repayment}', '{$rep_fromdate}', '{$rep_install}', 
            '{$rep_comp_derived}', '{$rep_comp_derived}', '0', '{$rep_int_amt}', '{$rep_int_amt}', '0',
            NULL, '0', '0', '0', '0', '0',
            NULL, '0', '0', '0', '{0}',
            '0', '0', '0', '0', 
            '0', '0', '0', NULL, '{$approved_by}', '{$sch_date}', '{$sch_date}',
            '{$approved_by}', '0')");
            if ($insert_into_repsch) {
                echo "WE GOOD";
            } else {
                echo "WE BAD";
            }
        // END OF WE DO A NEXT STUFF
        $repayment_start = date ("Y-m-d", strtotime("+1 ".$rep_every, strtotime($repayment_start)));
        }
        
        } else {
        // IF THE QUERY IS NOT NULL RUN THE REPAYMENT CODE
        $select_repayment_sch = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND client_id = '$client_id' AND id IS NOT NULL");
        // CHECK THE LAST REPAYMENT DATE THAT IS NOT DONE - COMPLETED DERIVED.
        echo "QWERTY";
        // SHOWING ME NEW
        }
    }
}
?>
