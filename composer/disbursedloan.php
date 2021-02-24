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

    function fill_data($connection, $start, $end, $sessint_id, $branch_id) {

      $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
      while ($result = mysqli_fetch_array($getParentID)) {
          $parent_id = $result['parent_id'];
      }

      if($parent_id == 0) {
          // Select loan data from all branches
          $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id FROM loan l JOIN client c ON l.client_id = c.id WHERE l.int_id = $sessint_id AND (l.submittedon_date BETWEEN '$start' AND '$end')";
          $result = mysqli_query($connection, $accountquery);
      } else {
          $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id, b.parent_id FROM loan l JOIN client c ON l.client_id = c.id JOIN branch b ON c.branch_id = b.id WHERE l.int_id = $sessint_id AND (l.submittedon_date BETWEEN '$start' AND '$end') AND b.id = $branch_id";
          $result = mysqli_query($connection, $accountquery);
      }

      $out = '';

      while ($loan = mysqli_fetch_array($result))
      {
        $nae = strtoupper($loan["display_name"]);
        $prina = $loan["principal_amount"];
        $loant = $loan["loan_term"];
        $disb = $loan["disbursement_date"];
        $repay = $loan["repayment_date"];
        $intrate = $loan["interest_rate"];
        $intr = $loan['interest_rate'] / 100;
        $total_interest = $loan['loan_term'] * $intr * $loan['principal_amount'];
        // the code below is as a result of the total_outstanding_derived column in the loan table not been updated at the moment
        $total_outstanding_bal = $loan['total_outstanding_derived'] + $total_interest;
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

    // $accountquery = "SELECT * FROM loan WHERE int_id = $sessint_id AND submittedon_date BETWEEN '$start' AND '$end'";
    // $result = mysqli_query($connection, $accountquery);
    // $out = '';

    // while ($loan = mysqli_fetch_array($result))
    // {
    //   $name = $loan['client_id'];
    //   $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
    //   $f = mysqli_fetch_array($anam);
    //   $nae = strtoupper($f["firstname"]." ".$f["lastname"]);

    //   $prina = $loan["principal_amount"];
    //   $loant = $loan["loan_term"]; 
    //   $disb = $loan["disbursement_date"]; 
    //   $repay = $loan["repayment_date"]; 
    //   $intrate = $loan["interest_rate"]; 
    //   $intr = $intrate/100;
    //   $final = $intr * $prina;
    //   $total = $loant * $final;
    //   $outbal = $loan["total_outstanding_derived"];

    //   $ttlintamount += $final;
    //   $covi += $total;
    //   $offg += $outbal;
    // }

    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
    $mpdf->showWatermarkImage = true;
    $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
    <header class="clearfix">
      <div id="logo">
        <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
      </div>
      <h1>Disbursed Loan Report</h1>
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
            <th style = "font-size:20px;">Total Outstanding Balance</th>
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
        $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id FROM loan l JOIN client c ON l.client_id = c.id WHERE l.int_id = $sessint_id AND (l.submittedon_date BETWEEN '$start' AND '$end')";
        $result = mysqli_query($connection, $accountquery);
    } else {
        $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id, b.parent_id FROM loan l JOIN client c ON l.client_id = c.id JOIN branch b ON c.branch_id = b.id WHERE l.int_id = $sessint_id AND (l.submittedon_date BETWEEN '$start' AND '$end') AND b.id = $branch_id";
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
    $active_sheet->setCellValue('H1', 'Total Outstanding Balance');

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
      // the code below is as a result of the total_outstanding_derived column in the loan table not been updated at the moment
      $total_outstanding_bal = $loan['total_outstanding_derived'] + $total_interest;

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