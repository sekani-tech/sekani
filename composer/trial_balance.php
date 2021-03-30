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

    function fill_data($connection, $start, $end, $sessint_id, $branch_id) {

        $parent_gl_accounts = mysqli_query($connection, "SELECT id, name FROM `acc_gl_account` where int_id = '$sessint_id' AND parent_id = '0'");

        $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
        while ($result = mysqli_fetch_array($getParentID)) {
            $parent_id = $result['parent_id'];
        }

        $out = '';

        while ($row = mysqli_fetch_array($parent_gl_accounts))
        {
            $group_total = 0;

            $parent_gl_acc_id = $row['id'];
            $parent_gl_acc_name = $row['name'];

            $child_gl_accounts = mysqli_query($connection, "SELECT name, gl_code FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id = '$parent_gl_acc_id'");
            while($row = mysqli_fetch_array($child_gl_accounts)) {
                $child_gl_acc_name = $row['name'];
                $child_gl_acc_code = $row['gl_code'];

                $get_opening_balance = mysqli_query($connection, "SELECT cumulative_balance_derived FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = '$child_gl_acc_code' AND (transaction_date BETWEEN '$start' AND '$end') ORDER BY `transaction_date` ASC LIMIT 1");
                $row = mysqli_fetch_array($get_opening_balance);
                $opening_balance = $row['cumulative_balance_derived'];

                $get_current_balance = mysqli_query($connection, "SELECT cumulative_balance_derived FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = '$child_gl_acc_code' AND (transaction_date BETWEEN '$start' AND '$end') ORDER BY `transaction_date` DESC LIMIT 1");
                $row = mysqli_fetch_array($get_current_balance);
                $current_balance = $row['cumulative_balance_derived'];

                if($parent_id == 0) {
                    $get_credit_debit_movement = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM `gl_account_transaction` where int_id = '$sessint_id' and gl_code = '$child_gl_acc_code'");
                    $row = mysqli_fetch_array($get_credit_debit_movement);
                    $credit_movement = $row['credit'];
                    $debit_movement = $row['debit'];

                } else {
                    $get_credit_debit_movement = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM `gl_account_transaction` where int_id = '$sessint_id' AND branch_id = '$branch_id' and gl_code = '$child_gl_acc_code'");
                    $row = mysqli_fetch_array($get_credit_debit_movement);
                    $credit_movement = $row['credit'];
                    $debit_movement = $row['debit'];
                }
                
                $group_total += $current_balance;

                $out .= '
                    <tr>
                        <td>'.$child_gl_acc_code.'</td>
                        <td>'.ucfirst(strtolower($child_gl_acc_name)).'</td>
                        <td></td>
                        <td>'.number_format($opening_balance, 2).'</td>
                        <td>'.number_format($credit_movement, 2).'</td>
                        <td>'.number_format($debit_movement, 2).'</td>
                        <td>'.number_format($current_balance, 2).'</b></td>
                    </tr>
                ';
            }
            
            $out .= '
            <tr>
                <td></td>
                <td></td>
                <td><b>'.strtoupper($parent_gl_acc_name).'</b></td>
                <td></td>
                <td></td>
                <td>Group total</td>
                <td><b>'.number_format($group_total, 2).'</b></td>
            </tr>
            ';
        }

        return $out;
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
      <h1>'.$_SESSION["int_full"].' <br/>Trial Balance Report</h1>
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
      <table>
        <thead>
          <tr class="table100-head">
            <th><small>Account Number</small></th>
            <th><small>Account Title</small></th>
            <th><small>Groups</small></th>
            <th><small>Opening Balance</small></th>
            <th><small>Credit Movement</small></th>
            <th><small>Debit Movement</small></th>
            <th><small>Current Balance</small></th>
          </tr>
        </thead>
        <tbody>
          "'.fill_data($connection, $start, $end, $sessint_id, $branch_id).'"
        </tbody>
      </table>
    </main>
    ');

    $file_name = 'trial-balance-report-' . date('d-m-Y', time()) . '.pdf';
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

    $parent_gl_accounts = mysqli_query($connection, "SELECT id, name FROM `acc_gl_account` where int_id = '$sessint_id' AND parent_id = '0'");

    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
    while ($result = mysqli_fetch_array($getParentID)) {
        $parent_id = $result['parent_id'];
    }

    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1', 'Account Number');
    $active_sheet->setCellValue('B1', 'Account Title');
    $active_sheet->setCellValue('C1', 'Groups');
    $active_sheet->setCellValue('D1', 'Opening Balance');
    $active_sheet->setCellValue('E1', 'Credit Movement');
    $active_sheet->setCellValue('F1', 'Debit Movement');
    $active_sheet->setCellValue('G1', 'Current Balance');

    $count = 2;

    while ($row = mysqli_fetch_array($parent_gl_accounts))
    {
        $group_total = 0;

        $parent_gl_acc_id = $row['id'];
        $parent_gl_acc_name = $row['name'];

        $child_gl_accounts = mysqli_query($connection, "SELECT name, gl_code FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id = '$parent_gl_acc_id'");
        while($row = mysqli_fetch_array($child_gl_accounts)) {
            $child_gl_acc_name = $row['name'];
            $child_gl_acc_code = $row['gl_code'];

            $get_opening_balance = mysqli_query($connection, "SELECT cumulative_balance_derived FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = '$child_gl_acc_code' AND (transaction_date BETWEEN '$start' AND '$end') ORDER BY `transaction_date` ASC LIMIT 1");
            $row = mysqli_fetch_array($get_opening_balance);
            $opening_balance = $row['cumulative_balance_derived'];

            $get_current_balance = mysqli_query($connection, "SELECT cumulative_balance_derived FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = '$child_gl_acc_code' AND (transaction_date BETWEEN '$start' AND '$end') ORDER BY `transaction_date` DESC LIMIT 1");
            $row = mysqli_fetch_array($get_current_balance);
            $current_balance = $row['cumulative_balance_derived'];

            if($parent_id == 0) {
                $get_credit_debit_movement = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM `gl_account_transaction` where int_id = '$sessint_id' and gl_code = '$child_gl_acc_code'");
                $row = mysqli_fetch_array($get_credit_debit_movement);
                $credit_movement = $row['credit'];
                $debit_movement = $row['debit'];

            } else {
                $get_credit_debit_movement = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM `gl_account_transaction` where int_id = '$sessint_id' AND branch_id = '$branch_id' and gl_code = '$child_gl_acc_code'");
                $row = mysqli_fetch_array($get_credit_debit_movement);
                $credit_movement = $row['credit'];
                $debit_movement = $row['debit'];
            }
            
            $group_total += $current_balance;

            $active_sheet->setCellValue('A' . $count, $child_gl_acc_code);
            $active_sheet->setCellValue('B' . $count, ucfirst(strtolower($child_gl_acc_name)));
            $active_sheet->setCellValue('C' . $count, '');
            $active_sheet->setCellValue('D' . $count, $opening_balance);
            $active_sheet->setCellValue('E' . $count, $credit_movement);
            $active_sheet->setCellValue('F' . $count, $debit_movement);
            $active_sheet->setCellValue('G' . $count, $current_balance);

            $count++;
        }
        
        $active_sheet->setCellValue('A' . $count, '');
        $active_sheet->setCellValue('B' . $count, '');
        $active_sheet->setCellValue('C' . $count, strtoupper($parent_gl_acc_name));
        $active_sheet->setCellValue('D' . $count, '');
        $active_sheet->setCellValue('E' . $count, '');
        $active_sheet->setCellValue('F' . $count, 'Group total');
        $active_sheet->setCellValue('G' . $count, $group_total);

        $count++;
    }


    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

    $file_name = 'trial-balance-report-' . date('d-m-Y', time()) . '.xlsx';

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