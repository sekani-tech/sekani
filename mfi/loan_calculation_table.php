
<?php
// Assign Variables
$result = '';
$principal_amount = $_POST["prina"];
$loan_term = $_POST["loant"];
$int_rate = $_POST["intr"] / 100;
$repayment_start = $_POST["repay_start"];
$rep_every = $_POST["repay"];
$disburse_date = $_POST["disbd"];
// $repay_no = $_POST["repay_no"];

$disburse = $principal_amount;

// To check what format calculation will be in 
$table_day = "";
$add_date = "";
$t_d = "";
// loan term
$loan_term1 = $loan_term - 1;
$loan_term2 = $loan_term;
if($rep_every == "month"){
    $table_day = "Months";
    $t_d = "Month";
    // replace add date
    $add_date = "30";
    // replace add date
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." months", strtotime($repayment_start)));
    $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." months", strtotime($repayment_start)));
} else if($rep_every == "day") {
    $table_day = "Days";
    $t_d = "Day";
    // replace add date
    $add_date = "1";
    // replace code below
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." days", strtotime($repayment_start)));
    $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." days", strtotime($repayment_start)));
} else if($rep_every == "year"){
    $table_day = "Years";
    // replace in years
    $add_date = "365";
    // replace here
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." years", strtotime($repayment_start)));
    $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." years", strtotime($repayment_start)));
    $t_d = "Year";
} else if($rep_every == "week"){
  $table_day = "Weeks";
  $t_d = "Week";
  // final replace
  $add_date = "7";
  // end the replace
  $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." weeks", strtotime($repayment_start)));
  $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." weeks", strtotime($repayment_start)));
}
else{
    $table_day = "days";
}
// else
$matured_date = $actualend_date;
$matured_date2 = $actualend_date1;
// GET THE END DATE OF THE LOAN
$matured_date = $actualend_date;
echo '<thead>
<tr>
  <th>#</th>
  <th>Date</th>
  <th>'.$table_day.'</th>
  <th>Paid by</th>
  <th>Disbursement</th>
  <th>Principal Due</th>
  <th>Principal Balance</th>
  <th>Interest Due</th>
  <th>Fees</th>
  <th>Penalties</th>
  <th>Total Due</th>
  <th>Total Paid</th>
  <th>Total Outstanding</th>
</tr>
</thead>';
$first_date = date('d/m/Y', strtotime($disburse_date));
$i = 0;
echo '
<tbody>
<tr>
<td></td>
<td>'.$first_date.'</td>
<td></td>
<td></td>
<td>'.number_format($disburse, 2).'</td>
<td></td>
<td>'.number_format($disburse, 2).'</td>
<td></td>
<td>0.00</td>
<td></td>
<td>0.00</td>
<td>0.00</td>
<td></td>
</tr>
</tbody>
';
$i = 0;
while (strtotime("+1 ".$rep_every, strtotime($repayment_start)) <= strtotime($matured_date2)) {
  // if($i % 10 == 0){
  //   echo '<tr>'.PHP_EOL;
  // }

  // Date Calculation
  $serial = $i + 1;
  // $date = $i * $add_date;
  // $date2 = $loan_term * $add_date;
  $actualend_date = date('d/m/Y', strtotime($repayment_start.' + '.$date2.' days'));
  $start_date = date('d/m/Y', strtotime($disburse_date.' + '.$date.' days'));
  $end_date = $repayment_start;
  $diff = $t_d." " .$serial;

  // Table Calculation
  $minus = $loan_term - 1;
  $disburse = $principal_amount;
  $percent = $int_rate / 100;
  if ($rep_every == "month") {
    $inter_due = $principal_amount * ($int_rate) * $loan_term;
  } else if ($rep_every == "week") {
    $inter_due = $principal_amount * ($int_rate) * ($loan_term / 4) / $loan_term;
  } else if ($rep_every == "day") {
    $inter_due = $principal_amount * ($int_rate) * ($loan_term / 30) / $loan_term;
  } 
  
  $princi_due = $disburse / $loan_term;
  $princi_due2 = $princi_due * ($i + 1);
  $princi_bal = $disburse - $princi_due2;
  $total_due = $inter_due + $princi_due;
  echo '
  <tr>
    <td>'.$serial.'</td>
    <td>'.$end_date.'</td>
    <td>'.$diff.'</td>
    <td></td>
    <td>'.number_format($disburse, 2).'</td>
    <td>'.number_format($princi_due, 2).'</td>
    <td>'.number_format($princi_bal, 2).'</td>
    <td>'.number_format($inter_due, 2).'</td>
    <td>0.00</td>
    <td>0.00</td>
    <td>'.number_format($total_due, 2).'</td>
    <td>0.00</td>
    <td>'.number_format($total_due, 2).'</td>
  </tr>';
  // echo "<td>".$i."</td>".PHP_EOL;
  // if($i % 10 == 0){
  //   echo '</tr>'.PHP_EOL;
  // }
  $repayment_start = date ("Y-m-d", strtotime("+1 ".$rep_every, strtotime($repayment_start)));
  $i++;
}
 $princi_due_total = $princi_due * $loan_term;
  $inter_due_total = $inter_due * $loan_term;
  $total_due_total = $total_due * $loan_term;
echo '<tr>
<td></td>
<td><b><b><b>Total</b></b></b></td>
<td><b><b><b>'.$loan_term.'</b></b></b></td>
<td></td>
<td><b><b><b>'.number_format($disburse).'</b></b></b></td>
<td><b><b><b>'.number_format($princi_due_total).'</b></b></b></td>
<td><b><b><b>0.00</b></b></b></td>
<td><b><b><b>'.number_format($inter_due_total).'</b></b></b></td>
<td><b><b><b>0.00</b></b></b></td>
<td><b><b><b>0.00</b></b></b></td>
<td><b><b><b>'.number_format($total_due_total).'</b></b></b></td>
<td><b><b><b>0.00</b></b></b></td>
<td><b><b><b>'.number_format($total_due_total).'</b></b></b></td>
</tr>
<input class="form-control" type="date" value="'.$actualend_date.'"/>
';
?>
