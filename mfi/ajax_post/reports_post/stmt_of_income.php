<?php
include("../../../functions/connect.php");
session_start();

$out= '';
$logo = $_SESSION['int_logo'];
$name = $_SESSION['int_full'];
$sessint_id = $_SESSION['int_id'];

$today = date('d/m/Y');

if(!empty($_POST['start']) && !empty($_POST['end'])) {
  $start = $_POST['start'];
  $end = $_POST['end'];
  $branch_id = $_POST['branch_id'];

  $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = '$sessint_id' AND id = '$branch_id'");
  while ($result = mysqli_fetch_array($getParentID)) {
    $parent_id = $result['parent_id'];
  }

  if ($parent_id == 0) {
    $op_inc_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id <> '0' AND classification_enum = '4'");
  } else {
    $op_inc_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND parent_id <> '0' AND classification_enum = '4'");
  }

  $gl_acc_op_inc = '';
  $sub_total_inc = 0;

  while($op_inc_type = mysqli_fetch_array($op_inc_list)) {
    $op_inc_cost = mysqli_query($connection, "SELECT SUM(credit) as credit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$op_inc_type['gl_code']} AND transaction_date BETWEEN '$start' AND '$end'");
    $op_inc_cost = mysqli_fetch_array($op_inc_cost);
    $op_inc_cost = $op_inc_cost['credit'];

    $sub_total_inc += $op_inc_cost;

    $gl_acc_op_inc .= '
      <tr>
        <td>'.ucfirst(strtolower($op_inc_type['name'])).'</td>
        <td style="text-align: center">₦ '.number_format($op_inc_cost, 2).'</td>
      </tr>
    ';
  }

  $out = '
    <div class="">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">Operating Revenue</h4>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
                <tr>
                    <th style="font-weight:bold;">GL Account</th>
                    <th style="text-align: center; font-weight:bold;"></th>
                </tr>
            </thead>
            <tbody>
            '.$gl_acc_op_inc.'
              <tr>
                  <td style="font-weight:bold;"><b>TOTAL OPERATING INCOME</b></td>
                  <td style="text-align: center"><b>₦ '.number_format($sub_total_inc, 2).'</b></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  ';

  if ($parent_id == 0) {
    $op_exp_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id <> '0' AND classification_enum = '5'");
  } else {
    $op_exp_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND parent_id <> '0' AND classification_enum = '5'");
  }

  $gl_acc_op_exp = '';
  $sub_total_exp = 0;
  
  while($op_exp_type = mysqli_fetch_array($op_exp_list)) {
    $op_exp_cost = mysqli_query($connection, "SELECT SUM(credit) as credit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$op_exp_type['gl_code']} AND transaction_date BETWEEN '$start' AND '$end'");
    $op_exp_cost = mysqli_fetch_array($op_exp_cost);
    $op_exp_cost = $op_exp_cost['credit'];

    $sub_total_exp += $op_exp_cost;

    $gl_acc_op_exp .= '
      <tr>
        <td>'.ucwords(strtolower($op_exp_type['name'])).'</td>
        <td style="text-align: center">₦ '.number_format($op_exp_cost, 2).'</td>
      </tr>
    ';
  }

  $net_profit_or_loss = $sub_total_inc - $sub_total_exp;

  if($net_profit_or_loss < 0) {
    $net_profit_or_loss = '('.number_format(abs($net_profit_or_loss), 2).')';
  } else {
    $net_profit_or_loss = number_format($net_profit_or_loss, 2);
  }

  $out .= '

    <div class="">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">Operating Expenses</h4>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
                <tr>
                    <th style="font-weight:bold;">GL Account</th>
                    <th style="text-align: center; font-weight:bold;"></th>
                </tr>
            </thead>
            <tbody>
                '.$gl_acc_op_exp.'
                <tr>
                    <td style="font-weight:bold;">TOTAL OPERATING EXPENSE</td>
                    <td style="text-align: center; font-weight:bold;">₦ '.number_format($sub_total_exp, 2).'</td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">NET PROFIT/(LOSS)</td>
                    <td style="font-weight:bold; text-align: center">₦ '.$net_profit_or_loss.'</td>
                </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <form method="POST" action="../composer/stmt_income.php">
        <input type="hidden" name="start" value="'.$start.'"/>
        <input type="hidden" name="end" value="'.$end.'"/>
        <input type="hidden" name="branch_id" value="'.$branch_id.'"/>
        <button class="btn btn-primary" name="downloadPDF">Download PDF</button>
        <button class="btn btn-success" name="downloadExcel">Download Excel</button>
      </form>
    </div>
  </div>
  ';

  echo $out;
}
?>