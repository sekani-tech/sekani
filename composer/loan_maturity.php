<?php
include("../functions/connect.php");
session_start();

require_once __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$intname = $_SESSION['int_name'];
$sessint_id = $_SESSION['int_id'];
$branch_id = $_POST["branch_id"];
$currentdate = date('d-m-Y');

if(isset($_POST["downloadPDF"])) {

  $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '$sessint_id' AND id = '$branch_id'");
  if (count([$branchquery]) == 1) {
    $ans = mysqli_fetch_array($branchquery);
    $branch = $ans['name'];
    $branch_email = $ans['email'];
    $branch_location = $ans['location'];
    $branch_phone = $ans['phone'];
  }

  function fill_report($connection, $sessint_id, $branch_id)
  {
    $out = '';

    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
    while ($result = mysqli_fetch_array($getParentID)) {
        $parent_id = $result['parent_id'];
    }

    if ($parent_id == 0) {
        // Select loan data from all branches
        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
        $result = mysqli_query($connection, $query);
    } else {
        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id)";
        $result = mysqli_query($connection, $query);
    }

    while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $std = date("Y-m-d");

      if ($std >= $q["maturedon_date"]) {
        $name = $q['client_id'];
        $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
        $f = mysqli_fetch_array($anam);
        $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
        $principal = number_format($q["principal_amount"]);
        $loant = $q["loan_term"];
        $disb_date = $q["disbursement_date"];
        $repay = $q["maturedon_date"];
        $bal = $q["total_expected_repayment_derived"] - $q["total_repayment_derived"];

        $out .= '
        <tr>
          <th style="font-size: 50px;" class="column1">'.$nae.'</th>
          <th style="font-size: 50px;" class="column1">'.$principal.'</th>
          <th style="font-size: 50px;" class="column1">'.$loant.'</th>
          <th style="font-size: 50px;" class="column1">'.$disb_date.'</th>
          <th style="font-size: 50px;" class="column1">'.$repay.'</th>
          <th style="font-size: 50px;" class="column1">'.$bal.'</th>
        </tr>
        ';
      }
    }

    return $out;
  }

  $mpdf = new \Mpdf\Mpdf();
  $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
  $mpdf->showWatermarkImage = true;
  $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
  <header class="clearfix">
    <div id="logo">
      <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
    </div>
    <h1>'.$_SESSION["int_full"].' <br/>Matured Loans as at '.$currentdate.'</h1>
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
      <thead class=" text-primary">
        <tr>
          <th style="font-size: 50px;" class="column1">
          Client Name
          </th>
          <th style="font-size: 50px;" class="column1">
            Principal Amount
          </th>
          <th style="font-size: 50px;" class="column1">
            Loan Term
          </th>
          <th style="font-size: 50px;" class="column1">
            Disbursement Date
          </th>
          <th style="font-size: 50px;" class="column1">
            Maturity Date
          </th>
          <th style="font-size: 50px;" class="column1">
            Outstanding Loan Balance
          </th>
        </tr>
      </thead>
      <tbody>
      "'.fill_report($connection, $sessint_id, $branch_id).'"
      </tbody>
    </table>
  </main>
  ');
  $file_name = 'Matured loan reports for '.$intname.'-'.$currentdate.'.pdf';
  $mpdf->Output($file_name, 'D');
}


if(isset($_POST["downloadExcel"])) {

  $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
  while ($result = mysqli_fetch_array($getParentID)) {
      $parent_id = $result['parent_id'];
  }

  if ($parent_id == 0) {
      // Select loan data from all branches
      $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND (total_expected_repayment_derived - total_repayment_derived <> 0)";
      $result = mysqli_query($connection, $query);
  } else {
      $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (total_expected_repayment_derived - total_repayment_derived <> 0)";
      $result = mysqli_query($connection, $query);
  }

  $file = new Spreadsheet();
  $active_sheet = $file->getActiveSheet();
  $active_sheet->setCellValue('A1', 'Client Name');
  $active_sheet->setCellValue('B1', 'Principal Amount');
  $active_sheet->setCellValue('C1', 'Loan Term');
  $active_sheet->setCellValue('D1', 'Disbursement Date');
  $active_sheet->setCellValue('E1', 'Maturity Date');
  $active_sheet->setCellValue('F1', 'Outstanding Loan Balance');

  $count = 2;

  while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
    $std = date("Y-m-d");

    if ($std >= $q["maturedon_date"]) {
      $name = $q['client_id'];
      $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
      $f = mysqli_fetch_array($anam);
      $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
      $principal = number_format($q["principal_amount"]);
      $loant = $q["loan_term"];
      $disb_date = $q["disbursement_date"];
      $repay = $q["maturedon_date"];
      $bal = $q["total_expected_repayment_derived"] - $q["total_repayment_derived"];
    }

    $active_sheet->setCellValue('A' . $count, $nae);
    $active_sheet->setCellValue('B' . $count, $principal);
    $active_sheet->setCellValue('C' . $count, $loant);
    $active_sheet->setCellValue('D' . $count, $disb_date);
    $active_sheet->setCellValue('E' . $count, $repay);
    $active_sheet->setCellValue('F' . $count, $bal);

    $count++;
  }

  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

  $file_name = 'Matured loan reports for '.$intname.'-'.$currentdate.'.xlsx';

  $writer->save($file_name);

  header('Content-Type: application/x-www-form-urlencoded');

  header('Content-Transfer-Encoding: Binary');

  header("Content-disposition: attachment; filename=\"".$file_name."\"");

  readfile($file_name);

  unlink($file_name);

  exit;
}

?>