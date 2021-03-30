<?php
include("../../../functions/connect.php");
session_start();

$out = '';

$sessint_id = $_SESSION['int_id'];

$today = date('d/m/Y');

if(!empty($_POST['date'])) {
  $date = $_POST['date'];
  $branch_id = $_POST['branch_id'];

  $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = '$sessint_id' AND id = '$branch_id'");
  while ($result = mysqli_fetch_array($getParentID)) {
    $parent_id = $result['parent_id'];
  }

  if ($parent_id == 0) {
    $current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current asset')");
    $non_current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non current asset' || 'non-current asset')");
  } else {
    $current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current asset')");
    $non_current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non current asset' || 'non-current asset')");
  }

  // Current Assets
  $gl_acc_ca = '';
  $total_ca_value = 0;

  while($ca_type = mysqli_fetch_array($current_assets_list)) {
    $ca = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$ca_type['gl_code']} AND transaction_date <= '$date'");
    $ca = mysqli_fetch_array($ca);
    $ca_credit = $ca['credit'];
    $ca_debit = $ca['debit'];

    $ca_value = $ca_credit - $ca_debit;

    $total_ca_value += $ca_credit - $ca_debit;

    $gl_acc_ca .= '
      <tr>
        <td>'.ucfirst(strtolower($ca_type['name'])).'</td>
        <td style="text-align: center">₦ '.number_format($ca_value, 2).'</td>
      </tr>
    ';
  }


  // Non-Current Assets
  $gl_acc_nca = '';
  $total_nca_value = 0;

  while($nca_type = mysqli_fetch_array($non_current_assets_list)) {
    $nca = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$nca_type['gl_code']} AND transaction_date <= '$date'");
    $nca = mysqli_fetch_array($nca);
    $nca_credit = $nca['credit'];
    $nca_debit = $nca['debit'];

    $nca_value = $nca_credit - $nca_debit;

    $total_nca_value += $nca_credit - $nca_debit;

    $gl_acc_nca .= '
      <tr>
        <td>'.ucfirst(strtolower($nca_type['name'])).'</td>
        <td style="text-align: center">₦ '.number_format($nca_value, 2).'</td>
      </tr>
    ';
  }

  $total_asset_value = $total_ca_value + $total_nca_value;

  $out = '
  <div class="card">

    <div class="card-header card-header-primary">
      <h4 class="card-title">Assets</h4>
    </div>

    <div class="card-body">

      <table class="table">

        <thead>
          <th style="font-weight:bold;">GL Account</th>
          <th></th>
        </thead>

        <tbody>

          <tr>
            <td><b>Current Assets</b></td>
            <td></td>
          </tr>

          '.$gl_acc_ca.'

          <tr style="background-color: #eeeeee">
            <td><b>Total Current Assets</b></td>
            <td style="text-align: center"><b>₦ '.number_format($total_ca_value, 2).'</b></td>
          </tr>

          <tr>
            <td><b>Non-Current Assets</b></td>
            <td></td>
          </tr>

          '.$gl_acc_nca.'

          <tr style="background-color: #eeeeee">
            <td><b>Total Non-Current Assets</b></td>
            <td style="text-align: center"><b>₦ '.number_format($total_nca_value, 2).'</b></td>
          </tr>

          <tr>
            <td><b>Less: Accumulated Depreciation</b></td>
            <td style="text-align: center"><b></b></td>
          </tr>

          <tr>
            <td><b>NPV</b></td>
            <td style="text-align: center"><b></b></td>
          </tr>

          <tr style="background-color: #aaaaaa">
            <td><b>Total Asset</b></td>
            <td style="text-align: center"><b>₦ '.number_format($total_asset_value, 2).'</b></td>
          </tr>

        </tbody>

      </table>

    </div>

  </div>
  ';


  if ($parent_id == 0) {
    $current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current liability')");
    $non_current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non-current liability' || 'non current liability')");
    $equity_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id <> '0' AND classification_enum = '3'");
  } else {
    $current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current liability')");
    $non_current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non-current liability' || 'non current liability')");
    $equity_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND parent_id <> '0' AND classification_enum = '3'");
  }

  // Current Liabilities
  $gl_acc_cl = '';
  $total_cl_value = 0;

  while($cl_type = mysqli_fetch_array($current_liabilities_list)) {
    $cl = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$cl_type['gl_code']} AND transaction_date <= '$date'");
    $cl = mysqli_fetch_array($cl);
    $cl_credit = $cl['credit'];
    $cl_debit = $cl['debit'];

    $cl_value = $cl_credit - $cl_debit;

    $total_cl_value += $cl_credit - $cl_debit;

    $gl_acc_cl .= '
      <tr>
        <td>'.ucfirst(strtolower($cl_type['name'])).'</td>
        <td style="text-align: center">₦ '.number_format($cl_value, 2).'</td>
      </tr>
    ';
  }


  // Non-Current Liabilities
  $gl_acc_ncl = '';
  $total_ncl_value = 0;

  while($ncl_type = mysqli_fetch_array($non_current_liabilities_list)) {
    $ncl = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$ncl_type['gl_code']} AND transaction_date <= '$date'");
    $ncl = mysqli_fetch_array($ncl);
    $ncl_credit = $ncl['credit'];
    $ncl_debit = $ncl['debit'];

    $ncl_value = $ncl_credit - $ncl_debit;

    $total_ncl_value += $ncl_credit - $ncl_debit;

    $gl_acc_ncl .= '
      <tr>
        <td>'.ucfirst(strtolower($ncl_type['name'])).'</td>
        <td style="text-align: center">₦ '.number_format($ncl_value, 2).'</td>
      </tr>
    ';
  }

  $total_cl_ncl_value = $total_cl_value + $total_ncl_value;

  // Equity
  $gl_acc_equity = '';
  $total_equity_value = 0;

  while($equity_type = mysqli_fetch_array($equity_list)) {
    $equity = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$equity_type['gl_code']} AND transaction_date <= '$date'");
    $equity = mysqli_fetch_array($equity);
    $equity_credit = $equity['credit'];
    $equity_debit = $equity['debit'];

    $equity_value = $equity_credit - $equity_debit;

    $total_equity_value += $equity_credit - $equity_debit;

    $gl_acc_equity .= '
      <tr>
        <td>'.ucfirst(strtolower($equity_type['name'])).'</td>
        <td style="text-align: center">₦ '.number_format($equity_value, 2).'</td>
      </tr>
    ';
  }

  $total_cl_ncl_equity_value = $total_cl_value + $total_ncl_value + $total_equity_value;

  $out .= '
  <div class="card" style="margin-top: 60px">

    <div class="card-header card-header-primary">
      <h4 class="card-title">Liabilities & Equity</h4>
    </div>

    <div class="card-body">

      <table class="table">

        <thead>
          <th style="font-weight:bold;">GL Account</th>
          <th></th>
        </thead>

        <tbody>

          <tr>
            <td><b>Current Liabilities</b></td>
            <td></td>
          </tr>

          '.$gl_acc_cl.'

          <tr style="background-color: #eeeeee">
            <td><b>Total Current Liabilities</b></td>
            <td style="text-align: center"><b>₦ '.number_format($total_cl_value, 2).'</b></td>
          </tr>

          <tr>
            <td><b>Non-Current Liabilities</b></td>
            <td></td>
          </tr>

          '.$gl_acc_ncl.'

          <tr style="background-color: #eeeeee">
            <td><b>Total Non-Current Liabilities</b></td>
            <td style="text-align: center"><b>₦ '.number_format($total_ncl_value, 2).'</b></td>
          </tr>

          <tr style="background-color: #cecece">
            <td><b>Total Liabilities</b></td>
            <td style="text-align: center"><b>₦ '.number_format($total_cl_ncl_value, 2).'</b></td>
          </tr>

          <tr>
            <td><b>Shareholders Equity</b></td>
            <td></td>
          </tr>

          '.$gl_acc_equity.'

          <tr style="background-color: #eeeeee">
            <td><b>Total Shareholders Equity</b></td>
            <td style="text-align: center"><b>₦ '.number_format($total_equity_value, 2).'</b></td>
          </tr>

          <tr style="background-color: #aaaaaa">
            <td><b>Total Liabilities and Shareholders Equity</b></td>
            <td style="text-align: center"><b>₦ '.number_format($total_cl_ncl_equity_value, 2).'</b></td>
          </tr>

        </tbody>

      </table>

    </div>
    
  </div>

  <div class="card">
    <div class="card-body">
      <form method="POST" action="../composer/stmt_fp.php">
        <input type="hidden" name="date" value="'.$date.'"/>
        <input type="hidden" name="branch_id" value="'.$branch_id.'"/>
        <button class="btn btn-primary" name="downloadPDF">Download PDF</button>
        <button class="btn btn-primary" name="downloadExcel">Download Excel</button>
      </form>
    </div>
  </div>
  ';

  echo $out;
  
}
?>