<?php
$loan_term = $_POST["loant"] - 1;
$repayment_start = $_POST["repay_start"];
$rep_every = $_POST["repay"];
$disburse_date = $_POST["disbd"];
$i = 0;
$table_day = "";
$add_date = "";
if($rep_every == "month"){
    $table_day = "Months";
    // $add_date = "30";
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term." months", strtotime($repayment_start)));
}else if($rep_every == "day"){
    $table_day = "Days";
    // $add_date = "1";
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term." days", strtotime($repayment_start)));
}else if($rep_every == "year"){
    $table_day = "Years";
    $add_date = "365";
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term." years", strtotime($repayment_start)));
} else if($rep_every == "week"){
    $table_day = "Weeks";
    // $add_date = "7";
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term." weeks", strtotime($repayment_start)));
}
else{
    $table_day = "days";
}

//   $date2 = $loan_term * $add_date;
//   $actualend_date = date('d/m/Y', strtotime($repayment_start.' + '.$date2.' days'));

  echo '<label>Loan Maturity Date</label>
  <input type="text" name ="matured_loan_date" readonly class="form-control" id ="ed" value="'.$actualend_date.'">';
?>