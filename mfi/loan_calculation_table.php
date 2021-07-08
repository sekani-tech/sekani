
<?php
// Assign Variables
$result = "";
$principal_amount = $_POST["prina"];
$loan_term = $_POST["loant"];
$int_rate = $_POST["intr"] / 100;
$repayment_start = $_POST["repay_start"];
$rep_every = strtolower($_POST["repay"]);
$disburse_date = $_POST["disbd"];
$total_fee_amount = $_POST["total_charge_amount"];

if ($rep_every == "day" || $rep_every == "days") {
    $table_day = "Days";
    $t_d = "Day";
    $add_days = "1";
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term." days", strtotime($disburse_date)));

} else if ($rep_every == "week" || $rep_every == "weeks") {
    $table_day = "Weeks";
    $t_d = "Week";
    $add_days = "7";
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term." weeks", strtotime($disburse_date)));

} else if ($rep_every == "month" || $rep_every == "months") {
    $table_day = "Months";
    $t_d = "Month";
    $add_days = "30";
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term." months", strtotime($disburse_date)));

} else if ($rep_every == "year" || $rep_every == "years") {
    $table_day = "Years";
    $t_d = "Year";
    $add_days = "365";
    $actualend_date = date('Y-m-d', strtotime("+".$loan_term." years", strtotime($disburse_date)));
}

echo '
    <thead>
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
    </thead>
';

$first_date = date('Y-m-d', strtotime($disburse_date));

echo '
    <tbody>
        <tr>
            <td></td>
            <td>'.$first_date.'</td>
            <td></td>
            <td></td>
            <td>'.number_format($principal_amount, 2).'</td>
            <td></td>
            <td>'.number_format($principal_amount, 2).'</td>
            <td></td>
            <td>'.number_format($total_fee_amount, 2).'</td>
            <td></td>
            <td>0.00</td>
            <td>0.00</td>
            <td></td>
        </tr>
    </tbody>
';

$i = 0;

while (strtotime($repayment_start) <= strtotime($actualend_date)) {
    // Date Calculation
    $serial = $i + 1;
    $no_of_days = $serial * $add_days;
    $start_date = date('d/m/Y', strtotime($disburse_date . ' + ' . $no_of_days.' days'));
    $diff = $t_d . " " . $serial;

    if ($rep_every == "month" || $rep_every == "months") {
        $inter_due = $principal_amount * ($int_rate);

    } else if ($rep_every == "week" || $rep_every == "weeks") {
        $inter_due = $principal_amount * ($int_rate) * ($loan_term / 4) / $loan_term;

    } else if ($rep_every == "day" || $rep_every == "days") {
        $inter_due = $principal_amount * ($int_rate) * ($loan_term / 30) / $loan_term;
    } 
    
    $princi_due = $principal_amount / $loan_term;
    $princi_bal = $principal_amount - ($princi_due * ($i + 1));
    $total_due = $inter_due + $princi_due;

    echo '
        <tr>
            <td>'.$serial.'</td>
            <td>'.$repayment_start.'</td>
            <td>'.$diff.'</td>
            <td></td>
            <td>'.number_format($principal_amount, 2).'</td>
            <td>'.number_format($princi_due, 2).'</td>
            <td>'.number_format($princi_bal, 2).'</td>
            <td>'.number_format($inter_due, 2).'</td>
            <td>0.00</td>
            <td>0.00</td>
            <td>'.number_format($total_due, 2).'</td>
            <td>0.00</td>
            <td>'.number_format($total_due, 2).'</td>
        </tr>
    ';

    $repayment_start = date("Y-m-d", strtotime("+1 ".$rep_every, strtotime($repayment_start)));
    $i++;
}

$princi_due_total = $princi_due * $loan_term;
$inter_due_total = $inter_due * $loan_term;
$total_due_total = $total_due * $loan_term;

echo '
    <tr>
        <td></td>
        <td><b><b><b>Total</b></b></b></td>
        <td><b><b><b>'.$loan_term.'</b></b></b></td>
        <td></td>
        <td><b><b><b>'.number_format($principal_amount).'</b></b></b></td>
        <td><b><b><b>'.number_format($princi_due_total).'</b></b></b></td>
        <td><b><b><b>0.00</b></b></b></td>
        <td><b><b><b>'.number_format($inter_due_total).'</b></b></b></td>
        <td><b><b><b>'.number_format($total_fee_amount).'</b></b></b></td>
        <td><b><b><b>0.00</b></b></b></td>
        <td><b><b><b>'.number_format($total_due_total).'</b></b></b></td>
        <td><b><b><b>0.00</b></b></b></td>
        <td><b><b><b>'.number_format($total_due_total).'</b></b></b></td>
    </tr>

    <input type="hidden" name="total_outstanding_loan" value="'.$total_due_total.'"/>
';
?>
