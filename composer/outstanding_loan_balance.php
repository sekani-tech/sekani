<?php
include("../functions/connect.php");
session_start();

$int_id = $_SESSION['int_id'];
$branch_id = $_SESSION["branch_id"];

require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

if(isset($_POST['downloadPDF'])) {

    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
        $ans = mysqli_fetch_array($branchquery);
        $branch = $ans['name'];
        $branch_email = $ans['email'];
        $branch_location = $ans['location'];
        $branch_phone = $ans['phone'];
    }

    function fill_report($connection, $int_id)
    {
        $out = '';
        $query = "SELECT * FROM loan WHERE int_id = '$int_id' AND (total_outstanding_derived <> 0)";
        $result = mysqli_query($connection, $query);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $clientId = $row['client_id'];
                $clientName = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$clientId'");
                $clientName = mysqli_fetch_array($clientName);
                $clientName = strtoupper($clientName["firstname"] . " " . $clientName["lastname"]);
                $accountNo = $row["account_no"];
                $principalAmount = $row["principal_amount"];
                $disbursementDate = $row["disbursement_date"];
                $repaymentDate = $row["repayment_date"];
                $outstandingBalance = $row['total_outstanding_derived'];

                $out .= '
                    <tr>
                        <th style="font-size: 30px;" class="column1">'.$clientName.'</th>
                        <th style="font-size: 30px;" class="column1">'.$accountNo.'</th>
                        <th style="font-size: 30px;" class="column1">'.number_format($principalAmount, 2).'</th>
                        <th style="font-size: 30px;" class="column1">'.$disbursementDate.'</th>
                        <th style="font-size: 30px;" class="column1">'.$repaymentDate.'</th>
                        <th style="font-size: 30px;" class="column1">'.number_format($outstandingBalance, 2).'</th>
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

        <h1>'.$_SESSION["int_full"].' <br/> Outstanding Loans Balance Report</h1>

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
                        Client Name
                    </th>
                    <th style="font-size: 30px;" class="column1">
                        Account No
                    </th>
                    <th style="font-size: 30px;" class="column1">
                        Principal Amount
                    </th>
                    <th style="font-size: 30px;" class="column1">
                        Disbursement Date
                    </th>
                    <th style="font-size: 30px;" class="column1">
                        Maturity Date
                    </th>
                    <th style="font-size: 30px;" class="column1">
                        Outstanding Balances
                    </th>
                </tr>
            </thead>
            <tbody>
            "'.fill_report($connection, $int_id).'"
            </tbody>
        </table>
    </main>
    ');

    $file_name = 'outstanding-loans-balance-report-' . time() . '.pdf';
    $mpdf->Output($file_name, 'D');
}



if(isset($_POST['downloadExcel'])) {

    $query = "SELECT * FROM loan WHERE int_id = '$int_id' AND (total_outstanding_derived <> 0)";
    $result = mysqli_query($connection, $query);
    
    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1', 'Client Name');
    $active_sheet->setCellValue('B1', 'Account No');
    $active_sheet->setCellValue('C1', 'Principal Amount');
    $active_sheet->setCellValue('D1', 'Disbursement Date');
    $active_sheet->setCellValue('E1', 'Maturity Date');
    $active_sheet->setCellValue('F1', 'Outstanding Balances');

    $count = 2;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $clientId = $row['client_id'];
            $clientName = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$clientId'");
            $clientName = mysqli_fetch_array($clientName);
            $clientName = strtoupper($clientName["firstname"] . " " . $clientName["lastname"]);
            $active_sheet->setCellValue('A' . $count, $clientName);

            $accountNo = $row["account_no"];
            $active_sheet->setCellValue('B' . $count, $accountNo);

            $principalAmount = $row["principal_amount"];
            $active_sheet->setCellValue('C' . $count, $principalAmount);

            $disbursementDate = $row["disbursement_date"];
            $active_sheet->setCellValue('D' . $count, $disbursementDate);

            $repaymentDate = $row["repayment_date"];
            $active_sheet->setCellValue('E' . $count, $repaymentDate);

            $outstandingBalance = $row["total_outstanding_derived"];
            $active_sheet->setCellValue('F' . $count, $outstandingBalance);

            $count++;
        }
    }

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

    $file_name = 'outstanding-loans-balance-report-' . time() . '.xlsx';

    $writer->save($file_name);

    header('Content-Type: application/x-www-form-urlencoded');

    header('Content-Transfer-Encoding: Binary');

    header("Content-disposition: attachment; filename=\"".$file_name."\"");

    readfile($file_name);

    unlink($file_name);

    exit;
}