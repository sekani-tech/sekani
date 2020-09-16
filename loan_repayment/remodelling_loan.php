<?php
include("../functions/connect.php");
// CODE to remodel old loan imported into the system
$query1 = "SELECT * FROM loan_remodeling WHERE status = '0'";
$queryexec1 = mysqli_query($connection, $query1);
while($a = mysqli_fetch_array($queryexec1)) {
    $id = $a['id'];
    $int_id = $a['int_id'];
    $loan_id = $a['loan_id'];
    $client_id = $a['client_id'];
    $account_no  =$a['account_no'];
    $product_id =  $a['product_id'];
    $loan_officer =  $a['loan_officer'];
    $loan_puporse  =$a['loan_puporse'];
    $principal_amount = $a['principal_amount'];
    $loan_term = $a['loan_term'];
    $disbursement_date = $a['disbursement_date'];
    $interest_rate = $a['interest_rate'];
    $repayment_date = $a['repayment_date'];
    $repay_every = $a['repay_every'];
    $maturedon_date = $a['maturedon_date'];
    $no_of_repayments = $a['no_of_repayments'];
    $amount_paid = $a['amount_paid' ];
    $arrear_amount = $a['arrear_amount'];
    $status = $a['status'];
    $loan_status = $a['loan_status'];
    $outstanding = ($principal_amount + (($interest_rate/100) * $principal_amount)) - $amount_paid;
    $today = date('Y-m-d');

    $query2 = "INSERT INTO `loan` (`id`, `int_id`, `account_no`, `client_id`, `product_id`, `fund_id`, `col_id`, `col_name`, `col_description`, 
    `loan_officer`, `loan_purpose`, `currency_code`, `currency_digits`, `principal_amount_proposed`, `principal_amount`, `loan_term`, `interest_rate`, 
    `approved_principal`, `repayment_date`, `arrearstolerance_amount`, `is_floating_interest_rate`, `interest_rate_differential`, `nominal_interest_rate_per_period`, 
    `interest_period_frequency_enum`, `annual_nominal_interest_rate`, `interest_method_enum`, `interest_calculated_in_period_enum`, 
    `allow_partial_period_interest_calcualtion`, `term_frequency`, `term_period_frequency_enum`, `repay_every`, `repayment_period_frequency_enum`, 
    `number_of_repayments`, `grace_on_principal_periods`, `recurring_moratorium_principal_periods`, `grace_on_interest_periods`, 
    `grace_interest_free_periods`, `amortization_method`, `submittedon_date`, `submittedon_userid`, `approvedon_date`, `approvedon_userid`, 
    `expected_disbursedon_date`, `expected_firstrepaymenton_date`, `interest_calculated_from_date`, `disbursement_date`, `disbursedon_userid`, 
    `expected_maturedon_date`, `maturedon_date`, `closedon_date`, `closedon_userid`, `total_charges_due_at_disbursement_derived`, `principal_disbursed_derived`, 
    `principal_repaid_derived`, `principal_writtenoff_derived`, `principal_outstanding_derived`, `interest_charged_derived`, `interest_repaid_derived`, 
    `interest_waived_derived`, `interest_writtenoff_derived`, `interest_outstanding_derived`, `fee_charges_charged_derived`, `fee_charges_repaid_derived`, 
    `fee_charges_waived_derived`, `fee_charges_writtenoff_derived`, `fee_charges_outstanding_derived`, `penalty_charges_charged_derived`, 
    `penalty_charges_repaid_derived`, `penalty_charges_waived_derived`, `penalty_charges_writtenoff_derived`, `penalty_charges_outstanding_derived`, 
    `total_expected_repayment_derived`, `total_repayment_derived`, `total_expected_costofloan_derived`, `total_costofloan_derived`, 
    `total_waived_derived`, `total_writtenoff_derived`, `total_outstanding_derived`, `total_overpaid_derived`, `rejectedon_date`, `rejectedon_userid`, 
    `rescheduledon_date`, `rescheduledon_userid`, `withdrawnon_date`, `withdrawnon_userid`, `writtenoffon_date`, `loan_transaction_strategy_id`, 
    `sync_disbursement_with_meeting`, `loan_counter`, `loan_product_counter`, `fixed_emi_amount`, `max_outstanding_loan_balance`, `grace_on_arrears_ageing`, 
    `is_npa`, `is_in_duplum`, `is_suspended_income`, `total_recovered_derived`, `accrued_till`, `interest_recalcualated_on`, `days_in_month_enum`, 
    `days_in_year_enum`, `interest_recalculation_enabled`, `guarantee_amount_derived`, `create_standing_instruction_at_disbursement`, `version`, 
    `writeoff_reason_cv_id`, `loan_sub_status_id`, `is_topup`, `repay_principal_every`, `repay_interest_every`, `restrict_linked_savings_product_type`, 
    `mandatory_savings_percentage`, `internal_rate_of_return`) VALUES ('$loan_id', '$int_id', '$account_no', '$client_id', '$product_id', NULL, NULL, NULL, NULL, '$loan_officer', 
    '$loan_puporse', 'NGN', '2', '$principal_amount', '$principal_amount', '$loan_term', '$interest_rate', '$principal_amount', '$repayment_date', NULL, '0', '0.00', 
    NULL, NULL, NULL, NULL, '1', '0', '1', '2', '$repay_every', NULL, '$no_of_repayments', NULL, NULL, NULL, NULL, NULL, '$today', NULL, '$today', NULL, NULL, NULL, NULL, 
    '$disbursement_date', NULL, NULL, '$maturedon_date', NULL, NULL, NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 
    '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '$arrear_amount', NULL, NULL, NULL, NULL, NULL, NULL, 
    NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, NULL, NULL, '1', '1', '0', NULL, NULL, '1', NULL, '$loan_status', '', '1', '1', NULL, NULL, '0.00')";
    $queryexec2 = mysqli_query($connection, $query2);

    if($queryexec2){
        echo 'Client no: '.$client_id.' inserted into loan</br>';

        $query3 = "INSERT INTO loan_disbursement_cache (int_id, status, account_no, client_id, product_id, fund_id, col_id, col_name, col_description, loan_officer, 
        loan_purpose, currency_code, currency_digits, principal_amount_proposed, principal_amount, loan_term, interest_rate, approved_principal, repayment_date,
        term_frequency, repay_every, number_of_repayments, submittedon_date, submittedon_userid, approvedon_date, approvedon_userid, expected_disbursedon_date, 
        expected_firstrepaymenton_date, disbursement_date, disbursedon_userid, repay_principal_every, repay_interest_every, loan_sub_status_id, 
        expected_maturedon_date, maturedon_date, flag) VALUES ('$int_id', 'Approved', '$account_no', '$client_id', '$product_id', NULL, NULL, NULL, NULL, '$loan_officer','$loan_puporse', 
        'NGN', '2', '$principal_amount', '$principal_amount', '$loan_term', '$interest_rate', '$principal_amount', '$repayment_date', '0', '$repay_every', '$no_of_repayments',
        '$today', NULL, '$today', NULL, NULL, NULL, '$disbursement_date', NULL, '0', '0', '$loan_status', '$maturedon_date', '$maturedon_date', 'old')";
        $queryexec3 = mysqli_query($connection, $query3);

if ($connection->error) {
    try {   
        throw new Exception("MySQL error $connection->error <br> Query:<br> $query1", $mysqli->error);   
    } catch(Exception $e ) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
}
        if($queryexec3){
            echo 'Client no: '.$client_id.' inserted into loan_disbursement_cache</br>';
            $query4 = "UPDATE loan_remodeling SET status = '1' WHERE id = '$id'";
            $queryexec4 = mysqli_query($connection, $query4);
            if($queryexec4){
                echo 'Client no: '.$client_id.' updated in loan_remodeling</br>';
                $query5 = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$client_id' AND account_no = '$account_no'");
                if($query5){
                    $do = mysqli_fetch_array($query5);
                    $account = $do['account_balance_derived'];
                    $new_account = $account + $amount_paid;
                    $query6 = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_account' WHERE client_id = '$client_id' AND account_no = '$account_no'");
                    if($query6){
                        echo 'Client no: '.$client_id.' updated arrear amount to balance</br></br>';
                    }
                }
                else{
                    echo "ERROR finding matching account</br></br>";

                }
            } else {

                echo "EOOR";
            }
        }
    }
}
?>