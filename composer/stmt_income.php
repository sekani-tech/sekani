<?php
include("../functions/connect.php");
session_start();

require_once __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if(isset($_POST["downloadPDF"])) {

  if (!empty($_POST["start"]) && !empty($_POST["end"]) && !empty($_POST["branch_id"])) {

    $start = $_POST["start"];
    $end = $_POST["end"];
    $sessint_id = $_SESSION['int_id'];
    $branch_id = $_POST["branch_id"];

    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '$sessint_id' AND id = '$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
      $branch_email = $ans['email'];
      $branch_location = $ans['location'];
      $branch_phone = $ans['phone'];
    }

    function fill_op_rev($connection, $start, $end, $sessint_id, $branch_id) {

      $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
      while ($result = mysqli_fetch_array($getParentID)) {
        $parent_id = $result['parent_id'];
      }

      if ($parent_id == 0) {
        $op_inc_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id <> '0' AND classification_enum = '4'");
      } else {
        $op_inc_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND parent_id <> '0' AND classification_enum = '4'");
      }
    
      $gl_acc_op_inc = '';
      $GLOBALS['sub_total_inc'] = 0;

      while($op_inc_type = mysqli_fetch_array($op_inc_list)) {
        $op_inc_cost = mysqli_query($connection, "SELECT SUM(credit) as credit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$op_inc_type['gl_code']} AND transaction_date BETWEEN '$start' AND '$end'");
        $op_inc_cost = mysqli_fetch_array($op_inc_cost);
        $op_inc_cost = $op_inc_cost['credit'];
    
        $GLOBALS['sub_total_inc'] += $op_inc_cost;
    
        $gl_acc_op_inc .= '
          <tr>
            <td>'.ucfirst(strtolower($op_inc_type['name'])).'</td>
            <td style="text-align: center">₦ '.number_format($op_inc_cost, 2).'</td>
          </tr>
        ';
      }

      $gl_acc_op_inc .='
        <tr>
          <td style="font-weight:bold;"><b>TOTAL OPERATING INCOME</b></td>
          <td style="text-align: center"><b>₦ '.number_format($GLOBALS['sub_total_inc'], 2).'</b></td>
        </tr>
      ';

      return $gl_acc_op_inc;
    }

    function fill_op_exp($connection, $start, $end, $sessint_id, $branch_id) {

      $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
      while ($result = mysqli_fetch_array($getParentID)) {
          $parent_id = $result['parent_id'];
      }

      if ($parent_id == 0) {
        $op_exp_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id <> '0' AND classification_enum = '5'");
      } else {
        $op_exp_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND parent_id <> '0' AND classification_enum = '5'");
      }
    
      $gl_acc_op_exp = '';
      $GLOBALS['sub_total_exp'] = 0;

      while($op_exp_type = mysqli_fetch_array($op_exp_list)) {
        $op_exp_cost = mysqli_query($connection, "SELECT SUM(credit) as credit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$op_exp_type['gl_code']} AND transaction_date BETWEEN '$start' AND '$end'");
        $op_exp_cost = mysqli_fetch_array($op_exp_cost);
        $op_exp_cost = $op_exp_cost['credit'];
    
        $GLOBALS['sub_total_exp'] += $op_exp_cost;
    
        $gl_acc_op_exp .= '
          <tr>
            <td>'.ucwords(strtolower($op_exp_type['name'])).'</td>
            <td style="text-align: center">₦ '.number_format($op_exp_cost, 2).'</td>
          </tr>
        ';
      }

      $gl_acc_op_exp .='
        <tr>
          <td style="font-weight:bold;"><b>TOTAL OPERATING EXPENSE</b></td>
          <td style="text-align: center"><b>₦ '.number_format($GLOBALS['sub_total_exp'], 2).'</b></td>
        </tr>
      ';

      return $gl_acc_op_exp;
    }

    $op_rev = fill_op_rev($connection, $start, $end, $sessint_id, $branch_id);
    $op_exp = fill_op_exp($connection, $start, $end, $sessint_id, $branch_id);
    $net_profit_or_loss = $sub_total_inc - $sub_total_exp;
    
    if($net_profit_or_loss < 0) {
      $net_profit_or_loss = '('.number_format(abs($net_profit_or_loss), 2).')';
    } else {
      $net_profit_or_loss = number_format($net_profit_or_loss, 2);
    }


    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
    $mpdf->showWatermarkImage = true;
    $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
    <header class="clearfix">
      <div id="logo">
        <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
      </div>
      <h1>'.$_SESSION["int_full"].' <br/>Statement of Income Report</h1>
      <div id="company" class="clearfix">
        <div>'.$branch.'</div>
        <div>'.$branch_location.'</div>
        <div>(+234) '.$branch_phone.'</div>
        <div><a href="mailto:'.$branch_email.'">'.$branch_email.'</a></div>
      </div>
      <div id="project">
        <div><span>BRANCH</span> '.$branch.' </div>
      </div>
    </header>
    <main>
      <h1>Operating Revenue</h1>
      <table>
        <thead>
          <tr class="table100-head">
            <th style="font-size:20px;">GL Account</th>
            <th style="font-size:20px;"></th>
          </tr>
        </thead>
        <tbody>
          "'.$op_rev.'"
        </tbody>
      </table>

      <h1>Operating Expenses</h1>
      <table>
        <thead>
          <tr class="table100-head">
            <th style="font-size:20px;">GL Account</th>
            <th style="font-size:20px;"></th>
          </tr>
        </thead>
        <tbody>
          "'.$op_exp.'"
          <tr>
            <td style="font-weight:bold;">NET PROFIT/(LOSS)</td>
            <td style="font-weight:bold; text-align: center">₦ '.$net_profit_or_loss.'</td>
          </tr>
        </tbody>
      </table>
    </main>
    ');

    $file_name = 'statement-of-income-' . date('d-m-Y', time()) . '.pdf';
    $mpdf->Output($file_name, 'D');

  } else {
    echo 'Not Seeing Data';
  }
}



if(isset($_POST["downloadExcel"])) {

  if (!empty($_POST["start"]) && !empty($_POST["end"]) && !empty($_POST["branch_id"])) {

    $start = $_POST["start"];
    $end = $_POST["end"];
    $sessint_id = $_SESSION['int_id'];
    $branch_id = $_POST["branch_id"];

    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
    while ($result = mysqli_fetch_array($getParentID)) {
      $parent_id = $result['parent_id'];
    }

    if ($parent_id == 0) {
      $op_inc_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id <> '0' AND classification_enum = '4'");
    } else {
      $op_inc_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND parent_id <> '0' AND classification_enum = '4'");
    }

    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1', 'OPERATING REVENUE');
    $active_sheet->setCellValue('A2', 'Gl Account');

    $count = 3;

    // $GLOBALS['sub_total_inc'] = 0;
    
    while($op_inc_type = mysqli_fetch_array($op_inc_list)) {
      $op_inc_cost = mysqli_query($connection, "SELECT SUM(credit) as credit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$op_inc_type['gl_code']} AND transaction_date BETWEEN '$start' AND '$end'");
      $op_inc_cost = mysqli_fetch_array($op_inc_cost);
      $op_inc_cost = $op_inc_cost['credit'];
  
      // $GLOBALS['sub_total_inc'] += $op_inc_cost;

      $active_sheet->setCellValue('A' . $count, ucfirst(strtolower($op_inc_type['name'])));
      $active_sheet->setCellValue('B' . $count, $op_inc_cost);

      $count++;
    }


    if ($parent_id == 0) {
      $op_exp_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id <> '0' AND classification_enum = '5'");
    } else {
      $op_exp_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND parent_id <> '0' AND classification_enum = '5'");
    }

    $active_sheet->setCellValue('D1', 'OPERATING EXPENSES');
    $active_sheet->setCellValue('D2', 'Gl Account');

    $count2 = 3;
  
    // $GLOBALS['sub_total_exp'] = 0;

    while($op_exp_type = mysqli_fetch_array($op_exp_list)) {
      $op_exp_cost = mysqli_query($connection, "SELECT SUM(credit) as credit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$op_exp_type['gl_code']} AND transaction_date BETWEEN '$start' AND '$end'");
      $op_exp_cost = mysqli_fetch_array($op_exp_cost);
      $op_exp_cost = $op_exp_cost['credit'];
  
      // $GLOBALS['sub_total_exp'] += $op_exp_cost;
  
      $active_sheet->setCellValue('D' . $count2, ucwords(strtolower($op_exp_type['name'])));
      $active_sheet->setCellValue('E' . $count2, $op_exp_cost);

      $count2++;
    }

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

    $file_name = 'statement-of-income-' . date('d-m-Y', time()) . '.xlsx';

    $writer->save($file_name);

    header('Content-Type: application/x-www-form-urlencoded');

    header('Content-Transfer-Encoding: Binary');

    header("Content-disposition: attachment; filename=\"".$file_name."\"");

    readfile($file_name);

    unlink($file_name);

    exit;

  }

}
?>