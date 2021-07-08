<?php
include("../functions/connect.php");
session_start();

$institutionId = $_SESSION['int_id'];
$branchId = $_SESSION['branch_id'];

require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (isset($_POST["exportGl"])) {

    $findGl = mysqli_query($connection, "SELECT name, gl_code, organisation_running_balance_derived, branch_id FROM acc_gl_account WHERE int_id = '$institutionId' AND branch_id = '$branchId'");

    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1', 'Name');
    $active_sheet->setCellValue('B1', 'GL Code');
    $active_sheet->setCellValue('C1', 'organisation_running_balance_derived');
    $active_sheet->setCellValue('D1', 'Branch ID');

    $count = 2;

    while ($gl = mysqli_fetch_array($findGl)) {
        $active_sheet->setCellValue('A' . $count, strtoupper($gl["name"]));
        $active_sheet->setCellValue('B' . $count, $gl["gl_code"]);
        $active_sheet->setCellValue('C' . $count, $gl["organisation_running_balance_derived"]);
        $active_sheet->setCellValue('D' . $count, $gl["branch_id"]);

        $count++;
    }

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

    $file_name = 'general-ledger-' . date('d-m-Y', time()) . '.xlsx';

    $writer->save($file_name);

    header('Content-Type: application/x-www-form-urlencoded');

    header('Content-Transfer-Encoding: Binary');

    header("Content-disposition: attachment; filename=\"" . $file_name . "\"");

    readfile($file_name);

    unlink($file_name);

    exit;
}
