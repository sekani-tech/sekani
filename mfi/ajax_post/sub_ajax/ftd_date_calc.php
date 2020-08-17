<?php
$term = $_POST["term"];

$curr_date = $_POST["repay"];
$actualend_date = date('Y-m-d', strtotime("+".$term." days", strtotime($curr_date)));
//   $date2 = $loan_term * $add_date;
//   $actualend_date = date('d/m/Y', strtotime($repayment_start.' + '.$date2.' days'));

  echo '<label>Maturity Date</label>
  <input type="text" name ="mat_date" readonly class="form-control" id ="ed" value="'.$actualend_date.'">';
?>