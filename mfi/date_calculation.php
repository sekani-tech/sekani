<?php

if(!empty($_POST["loant"]) && !empty($_POST["repay_start"])) {
    $loan_term = $_POST["loant"];
    $repayment_start = $_POST["repay_start"];
    $rep_every = strtolower($_POST["repay"]);
    $disburse_date = $_POST["disbd"];

    if ($rep_every == "year" || $rep_every == "years"){
        $actualend_date = date('Y-m-d', strtotime("+".$loan_term." years", strtotime($disburse_date)));

    } else if ($rep_every == "month" || $rep_every == "months"){
        $actualend_date = date('Y-m-d', strtotime("+".$loan_term." months", strtotime($disburse_date)));

    } else if($rep_every == "week" || $rep_every == "weeks"){
        $actualend_date = date('Y-m-d', strtotime("+".$loan_term." weeks", strtotime($disburse_date)));
        
    } else if($rep_every == "day" || $rep_every == "days"){
        $actualend_date = date('Y-m-d', strtotime("+".$loan_term." days", strtotime($disburse_date)));
    } 

    echo '
        <label>Loan Maturity Date</label>
        <input type="date" name ="matured_loan_date" readonly class="form-control" id="ed" value="'.$actualend_date.'">
    ';
}

?>