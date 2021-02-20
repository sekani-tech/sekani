<?php
include("../functions/connect.php");
session_start();

$int_id = $_SESSION['int_id'];
$branch_id = $_SESSION["branch_id"];

require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

if(isset($_POST['exportPDF'])) {

    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
        $ans = mysqli_fetch_array($branchquery);
        $branch = $ans['name'];
        $branch_email = $ans['email'];
        $branch_location = $ans['location'];
        $branch_phone = $ans['phone'];
    }

    function fill_report($connection)
    {
        $out = '';
        $savingsProducts = mysqli_query($connection, "SELECT * FROM `savings_product`");
        
        foreach($savingsProducts as $savingsProduct) {
            $productID = $savingsProduct['id'];

            $accountType = $savingsProduct['name'];

            $query = "SELECT count(account_no) FROM `account` WHERE product_id = $productID AND account_balance_derived LIKE '%-%'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $accountsInDebit = $row[0];

            $query = "SELECT count(account_no) FROM `account` WHERE (product_id = $productID) AND (account_balance_derived NOT LIKE '%-%' AND account_balance_derived <> 0.00 AND account_balance_derived <> 0)";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $accountsInCredit = $row[0];

            $query = "SELECT count(account_no) FROM `account` WHERE (product_id = $productID) AND (account_balance_derived = 0.00 OR account_balance_derived = 0)";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $accountsInZero = $row[0];

            $query = "SELECT count(account_no) FROM `account` WHERE (product_id = $productID)";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $totalAccounts = $row[0];

            $out .= '
                <tr>
                    <th style="font-size: 30px;" class="column1">'.$accountType.'</th>
                    <th style="font-size: 30px;" class="column1">'.$accountsInDebit.'</th>
                    <th style="font-size: 30px;" class="column1">'.$accountsInCredit.'</th>
                    <th style="font-size: 30px;" class="column1">'.$accountsInZero.'</th>
                    <th style="font-size: 30px;" class="column1">'.$totalAccounts.'</th>
                </tr>
            ';
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

        <h1>'.$_SESSION["int_full"].' <br/> Account Analysis Report</h1>

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
                    <th style="font-size: 30px;" class="column1">
                        Account Types
                    </th>
                    <th style="font-size: 30px;" class="column1">
                        Accounts in debit
                    </th>
                    <th style="font-size: 30px;" class="column1">
                        Accounts in credit
                    </th>
                    <th style="font-size: 30px;" class="column1">
                        Accounts with zero balance
                    </th>
                    <th style="font-size: 30px;" class="column1">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody>
            "'.fill_report($connection).'"
            </tbody>
        </table>
    </main>
    ');

    $file_name = 'account-analysis-report-' . time() . '.pdf';
    $mpdf->Output($file_name, 'D');
}



if(isset($_POST['exportExcel'])) {

    $savingsProducts = mysqli_query($connection, "SELECT * FROM `savings_product`");
    
    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1', 'Account Types');
    $active_sheet->setCellValue('B1', 'Accounts in debit');
    $active_sheet->setCellValue('C1', 'Accounts in credit');
    $active_sheet->setCellValue('D1', 'Accounts with zero balance');
    $active_sheet->setCellValue('E1', 'Total');

    $count = 2;

    foreach($savingsProducts as $savingsProduct) {
        $productID = $savingsProduct['id'];

        $active_sheet->setCellValue('A' . $count, $savingsProduct['name']);

        $query = "SELECT count(account_no) FROM `account` WHERE product_id = $productID AND account_balance_derived LIKE '%-%'";
        $accountsInDebit = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($accountsInDebit);
        $active_sheet->setCellValue('B' . $count, $row[0]);

        $query = "SELECT count(account_no) FROM `account` WHERE (product_id = $productID) AND (account_balance_derived NOT LIKE '%-%' AND account_balance_derived <> 0.00 AND account_balance_derived <> 0)";
        $accountsInCredit = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($accountsInCredit);
        $active_sheet->setCellValue('C' . $count, $row[0]);

        $query = "SELECT count(account_no) FROM `account` WHERE (product_id = $productID) AND (account_balance_derived = 0.00 OR account_balance_derived = 0)";
        $accountsInZero = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($accountsInZero);
        $active_sheet->setCellValue('D' . $count, $row[0]);

        $query = "SELECT count(account_no) FROM `account` WHERE (product_id = $productID)";
        $totalAccounts = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($totalAccounts);
        $active_sheet->setCellValue('E' . $count, $row[0]);

        $count++;
    }

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

    $file_name = 'account-analysis-report-' . time() . '.xlsx';

    $writer->save($file_name);

    header('Content-Type: application/x-www-form-urlencoded');

    header('Content-Transfer-Encoding: Binary');

    header("Content-disposition: attachment; filename=\"".$file_name."\"");

    readfile($file_name);

    unlink($file_name);

    exit;
}