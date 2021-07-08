<?php
include("../functions/connect.php");
session_start();

require_once __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if(isset($_POST['exportPDF'])) {
    $sessint_id = $_SESSION['int_id'];
    $branch_id = $_SESSION["branch_id"];
    

    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1', 'int_id');
    $active_sheet->setCellValue('B1', 'int_id_no');
    $active_sheet->setCellValue('C1', 'branch_id');
    $active_sheet->setCellValue('D1', 'name');
    $active_sheet->setCellValue('E1', 'parent_id');
    $active_sheet->setCellValue('F1', 'hierarchy');
    $active_sheet->setCellValue('G1', 'gl_code');
    $active_sheet->setCellValue('H1', 'disabled');
    $active_sheet->setCellValue('I1', 'manual_journal_entries_allowed');
    $active_sheet->setCellValue('J1', 'account_usage');
    $active_sheet->setCellValue('K1', 'classification_enum');
    $active_sheet->setCellValue('L1', 'tag_id');
    $active_sheet->setCellValue('M1', 'description');
    $active_sheet->setCellValue('N1', 'reconciliation_enabled');
    $active_sheet->setCellValue('O1', 'organization_running_balance_derived');
    $active_sheet->setCellValue('P1', 'last_entry_id_derived');


    $count = 2;
  
    $query = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id'";
    $result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $active_sheet->setCellValue('A' . $count, $row["int_id"]);
        $active_sheet->setCellValue('B' . $count, $row["int_id_no"]);
        $active_sheet->setCellValue('C' . $count, $row["branch_id"]);
        $active_sheet->setCellValue('D' . $count, $row["name"]);
        $active_sheet->setCellValue('E' . $count, $row["parent_id"]);
        $active_sheet->setCellValue('F' . $count, $row["hierarchy"]);
        $active_sheet->setCellValue('G' . $count, $row["gl_code"]);
        $active_sheet->setCellValue('H' . $count, $row["disabled"]);
        $active_sheet->setCellValue('I' . $count, $row["manual_journal_entries_allowed"]);
        $active_sheet->setCellValue('J' . $count, $row["account_usage"]);
        $active_sheet->setCellValue('K' . $count, $row["classification_enum"]);
        $active_sheet->setCellValue('L' . $count, $row["tag_id"]);
        $active_sheet->setCellValue('M' . $count, $row["description"]);
        $active_sheet->setCellValue('N' . $count, $row["reconciliation_enabled"]);
        $active_sheet->setCellValue('O' . $count, $row["organization_running_balance_derived"]);
        $active_sheet->setCellValue('P' . $count, $row["last_entry_id_derived"]);
    
        $count++;

    } 
                                                        
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

    $file_name = 'gl_account_migration-' . time() . '.xlsx';

    $writer->save($file_name);

    header('Content-Type: application/x-www-form-urlencoded');

    header('Content-Transfer-Encoding: Binary');

    header("Content-disposition: attachment; filename=\"".$file_name."\"");

    readfile($file_name);

    unlink($file_name);

    exit;
}
   
?>



    
            
