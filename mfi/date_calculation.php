<?php

if(!empty($_POST["loant"])) {
    $loan_term = $_POST["loant"];
    $repayment_start = $_POST["repay_start"];
    $rep_every = $_POST["repay"];
    $disburse_date = $_POST["disbd"];
    $loan_term1x = $loan_term - 1;
    if($rep_every == "month"){
        $actualend_date = date('Y-m-d', strtotime("+".$loan_term1x." months", strtotime($repayment_start)));
    }else if($rep_every == "day"){
        $actualend_date = date('Y-m-d', strtotime("+".$loan_term1x." days", strtotime($repayment_start)));
    }else if($rep_every == "year"){
        $actualend_date = date('Y-m-d', strtotime("+".$loan_term1x." years", strtotime($repayment_start)));
    } else if($rep_every == "week"){
        $actualend_date = date('Y-m-d', strtotime("+".$loan_term1x." weeks", strtotime($repayment_start)));
    }

    echo '
        <label>Loan Maturity Date</label>
        <input type="date" name ="matured_loan_date" readonly class="form-control" id ="ed" value="'.$actualend_date.'">
    ';
}

?>