<?php
include("../functions/connect.php");
session_start();

require_once __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$intname = $_SESSION['int_name'];
$branch_id = $_POST["branch_id"];
$current_date = date('d-m-Y');

if(isset($_POST["downloadPDF"])) {
    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
      $branch_email = $ans['email'];
      $branch_location = $ans['location'];
      $branch_phone = $ans['phone'];
    }
    
    function fill_report($connection, $branch_id)
    {
      $out = '';
      $sessint_id = $_SESSION['int_id'];
    
      if(!empty($_POST["start"]) && !empty($_POST["end"])) {
        $start = $_POST["start"];
        $end = $_POST["end"];
    
        $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
        while ($result = mysqli_fetch_array($getParentID)) {
            $parent_id = $result['parent_id'];
        }
    
        if ($parent_id == 0) {
            // Select loan collateral schedule data from all branches
            $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id' AND date BETWEEN '$start' AND '$end'";
            $result = mysqli_query($connection, $query);
        } else {
            $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND date BETWEEN '$start' AND '$end'";
            $result = mysqli_query($connection, $query);
        }
    
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
          $date = $q["date"];
          $name = $q['client_id'];
          $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
          $f = mysqli_fetch_array($anam);
          $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
          $value = $q["value"];
          $type = $q["type"];
          $desc = $q["description"];
          $out .= '
            <tr>
              <th style="font-size: 60px;" class="column1">'.$date.'</th>
              <th style="font-size: 60px;" class="column1">'.$nae.'</th>
              <th style="font-size: 60px;" class="column1">'.$value.'</th>
              <th style="font-size: 60px;" class="column1">'.$type.'</th>
              <th style="font-size: 60px;" class="column1">'.$desc.'</th>
            </tr>
          ';
        }
        
        return $out;
      }
    }

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
    $mpdf->showWatermarkImage = true;
    $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
    <header class="clearfix">
      <div id="logo">
        <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
      </div>
      <h1>'.$_SESSION["int_full"].' <br/> Loan Collateral Schedule</h1>
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
        <thead class="text-primary">
          <tr>
            <th style="font-size: 60px; font-weight: bold;" class="column1">
              Date
            </th>
            <th style="font-size: 60px; font-weight: bold;" class="column1">
              Client Name
            </th>
            <th style="font-size: 60px; font-weight: bold;" class="column1">
              Type
            </th>
            <th style="font-size: 60px; font-weight: bold;" class="column1">
              Value
            </th>
            <th style="font-size: 60px; font-weight: bold;" class="column1">
              Description
            </th>
          </tr>
        </thead>
        <tbody>
            "'.fill_report($connection, $branch_id).'"
        </tbody>
      </table>
    </main>
    ');
    $file_name = 'Collateral Schedule Report for '.$intname.'-'.$current_date.'.pdf';
    $mpdf->Output($file_name, 'D');
}


if(isset($_POST["downloadExcel"])) {

  if (!empty($_POST["start"]) && !empty($_POST["end"])) {

    $start = $_POST["start"];
    $end = $_POST["end"];
    $sessint_id = $_SESSION['int_id'];
    $branch_id = $_POST["branch_id"];

    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
    while ($result = mysqli_fetch_array($getParentID)) {
        $parent_id = $result['parent_id'];
    }

    if ($parent_id == 0) {
        // Select loan collateral schedule data from all branches
        $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id' AND date BETWEEN '$start' AND '$end'";
        $result = mysqli_query($connection, $query);
    } else {
        $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND date BETWEEN '$start' AND '$end'";
        $result = mysqli_query($connection, $query);
    }

    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1', 'Date');
    $active_sheet->setCellValue('B1', 'Client Name');
    $active_sheet->setCellValue('C1', 'Type');
    $active_sheet->setCellValue('D1', 'Value');
    $active_sheet->setCellValue('E1', 'Description');

    $count = 2;

    while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $date = $q["date"];
      $name = $q['client_id'];
      $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
      $f = mysqli_fetch_array($anam);
      $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
      $value = $q["value"];
      $type = $q["type"];
      $desc = $q["description"];

      $active_sheet->setCellValue('A' . $count, $date);
      $active_sheet->setCellValue('B' . $count, $nae);
      $active_sheet->setCellValue('C' . $count, $value);
      $active_sheet->setCellValue('D' . $count, $type);
      $active_sheet->setCellValue('E' . $count, $desc);

      $count++;
    }

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

    $file_name = 'Collateral Schedule Report for ' .$intname. '-' .$current_date. '.xlsx';

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