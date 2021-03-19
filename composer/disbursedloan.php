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

      $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
      while ($result = mysqli_fetch_array($getParentID)) {
          $parent_id = $result['parent_id'];
      }

      if($parent_id == 0) {
          // Select loan data from all branches
          $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id FROM loan l JOIN client c ON l.client_id = c.id WHERE l.int_id = $sessint_id AND (l.disbursement_date  BETWEEN '$start' AND '$end')";
          $result = mysqli_query($connection, $accountquery);
      } else {
          $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id, b.parent_id FROM loan l JOIN client c ON l.client_id = c.id JOIN branch b ON c.branch_id = b.id WHERE l.int_id = $sessint_id AND (l.disbursement_date  BETWEEN '$start' AND '$end') AND b.id = $branch_id";
          $result = mysqli_query($connection, $accountquery);
      }

      $out = '';

      while ($loan = mysqli_fetch_array($result))
      {
        $nae = strtoupper($loan["display_name"]);
        $prina = number_format($loan["principal_amount"], 2);
        $loant = $loan["loan_term"];
        $disb = $loan["disbursement_date"];
        $repay = $loan["repayment_date"];
        $intrate = $loan["interest_rate"];
        $intr = $loan['interest_rate'] / 100;
        $total_interest = $loan['loan_term'] * $intr * $loan['principal_amount'];
        $total_outstanding_bal = number_format(round($loan['total_outstanding_derived']), 2);
        $out .= '
        <tr>
            <td style = "font-size:20px;">'.$nae.'</td>
            <td style = "font-size:20px;">&#8358; '.$prina.'</td>
            <td style = "font-size:20px;">'.$loant.'</td>
            <td style = "font-size:20px;">'.$disb.'</td>
            <td style = "font-size:20px;">'.$repay.'</td>
            <td style = "font-size:20px;">'.$intrate.'</td>
            <td style = "font-size:20px;">&#8358; '.$total_interest.'</td>
            <td style = "font-size:20px;">&#8358; '.$total_outstanding_bal.'</td>
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
      <h1>'.$_SESSION["int_full"].' <br/>Disbursed Loan Report</h1>
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
            <th style = "font-size:20px;">Client Name</th>
            <th style = "font-size:20px;">Principal Amount</th>
            <th style = "font-size:20px;">Loan Term</th>
            <th style = "font-size:20px;">Disbursement Date</th>
            <th style = "font-size:20px;">Maturity Date</th>
            <th style = "font-size:20px;">Interest Rate</th>
            <th style = "font-size:20px;">Cumulative Interest Amt</th>
            <th style = "font-size:20px;">Outstanding Balances</th>
          </tr>
        </thead>
        <tbody>
          "'.fill_data($connection, $start, $end, $sessint_id, $branch_id).'"
        </tbody>
      </table>
    </main>
    ');

    $file_name = 'disbursed-loan-accounts-report-' . date('d-m-Y', time()) . '.pdf';
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

    if($parent_id == 0) {
        // Select loan data from all branches
        $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id FROM loan l JOIN client c ON l.client_id = c.id WHERE l.int_id = $sessint_id AND (l.disbursement_date  BETWEEN '$start' AND '$end')";
        $result = mysqli_query($connection, $accountquery);
    } else {
        $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id, b.parent_id FROM loan l JOIN client c ON l.client_id = c.id JOIN branch b ON c.branch_id = b.id WHERE l.int_id = $sessint_id AND (l.disbursement_date  BETWEEN '$start' AND '$end') AND b.id = $branch_id";
        $result = mysqli_query($connection, $accountquery);
    }

    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1', 'Client Name');
    $active_sheet->setCellValue('B1', 'Principal Amount');
    $active_sheet->setCellValue('C1', 'Loan Term');
    $active_sheet->setCellValue('D1', 'Disbursement Date');
    $active_sheet->setCellValue('E1', 'Maturity Date');
    $active_sheet->setCellValue('F1', 'Interest Rate');
    $active_sheet->setCellValue('G1', 'Cumulative Interest Amount');
    $active_sheet->setCellValue('H1', 'Outstanding Balances');

    $count = 2;

    while ($loan = mysqli_fetch_array($result)) {
      $active_sheet->setCellValue('A' . $count, strtoupper($loan["display_name"]));
      $active_sheet->setCellValue('B' . $count, $loan["principal_amount"]);
      $active_sheet->setCellValue('C' . $count, $loan["loan_term"]);
      $active_sheet->setCellValue('D' . $count, $loan["disbursement_date"]);
      $active_sheet->setCellValue('E' . $count, $loan["repayment_date"]);
      $active_sheet->setCellValue('F' . $count, $loan["interest_rate"]);

      $intr = $loan['interest_rate'] / 100;
      $total_interest = $loan['loan_term'] * $intr * $loan['principal_amount'];
      $total_outstanding_bal = round($loan['total_outstanding_derived']);

      $active_sheet->setCellValue('G' . $count, $total_interest);
      $active_sheet->setCellValue('H' . $count, $total_outstanding_bal);
      
      $count++;
    }

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

    $file_name = 'disbursed-loan-accounts-report-' . date('d-m-Y', time()) . '.xlsx';

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