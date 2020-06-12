
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
// Test Variables
// $principal_amount = "100000";
// $loan_term = "5";
// $int_rate = "2";
// $repayment_start = '01/13/2020';
// $rep_every ="month";
// $disburse_date = '01/05/2020';

$disburse = $principal_amount;

// To check what format calculation will be in 
$table_day = "";
$add_date = "";
$t_d = "";
if($rep_every == "month"){
    $table_day = "Months";
    $t_d = "Month";
    $add_date = "30";
} else if($rep_every == "day") {
    $table_day = "Days";
    $t_d = "Day";
    $add_date = "1";
} else if($rep_every == "year"){
    $table_day = "Years";
    $add_date = "365";
    $t_d = "Year";
} else if($rep_every == "week"){
  $table_day = "Weeks";
  $t_d = "Week";
  $add_date = "7";
}
else{
    $table_day = "days";
}
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
while ($i < $loan_term){
  // if($i % 10 == 0){
  //   echo '<tr>'.PHP_EOL;
  // }

  // Date Calculation
  $serial = $i + 1;
  $date = $i * $add_date;
  $date2 = $loan_term * $add_date;
  $actualend_date = date('d/m/Y', strtotime($repayment_start.' + '.$date2.' days'));
  $start_date = date('d/m/Y', strtotime($disburse_date.' + '.$date.' days'));
  $end_date = date('d/m/Y', strtotime($repayment_start.' + '.$date.' days'));
  $diff = $t_d." " .$serial;

  // Table Calculation
  $minus = $loan_term - 1;
  $disburse = $principal_amount;
  $percent = $int_rate / 100;
  $inter_due = ((($percent * $disburse) * $loan_term) / $loan_term);
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
