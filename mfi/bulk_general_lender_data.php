<?php

$page_title = "General Lender data";
$destination = "bulk_update";
include("header.php");
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

        $file_name = 'disbursed-loan-accounts-report-' . date('d-m-Y', time()) . '.xlsx';

        $writer->save($file_name);

        header('Content-Type: application/x-www-form-urlencoded');

        header('Content-Transfer-Encoding: Binary');

        header("Content-disposition: attachment; filename=\"" . $file_name . "\"");

        readfile($file_name);

        unlink($file_name);

        exit;
   
}


?>


<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <!-- Begining of Charge Row !-->
        <div class="row">

            <div class="col-md-12">

                <!-- General Lender Account Card Data Begins -->
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">General Lender Account</h4>
                        <p class="category"></p>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title"> <i class="material-icons">info</i> Requirements </h4>

                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Files must be in <b>.csv</b></li>
                                            <li>CSV files should contain all the columns as stated on the Data Sample</li>
                                            <li>The order of the columns should be the same as stated on the Data Sample with the first rows as header</li>
                                            <li>You can upload a maximum of 4,000 rows in 1 file. If you have more rows, please split them into multiple files.</li>
                                        </ul>
                                        <div class="card-body text-center">
                                            <form action="bulk_general_lender_data.php" method="post">
                                                <button class="btn btn-primary btn-lg" type="submit" name="exportGl">
                                                    Download Data Sample</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Upload CSV File(.csv)</h4>
                                        <p class="category"></p>
                                    </div>
                                    <div class="card-body">


                                        <div class="input-group">

                                            <input type="file" class="form-control inputFileVisible" placeholder="Single File">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-fab btn-round btn-primary">
                                                    <i class="material-icons">attach_file</i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- General Lender Account Card Data Ends -->

                <!-- General Lender Transaction Card Data Begins -->
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">General Lender Transaction</h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title"> <i class="material-icons">info</i> Requirements </h4>

                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Files must be in <b>.csv</b></li>
                                            <li>CSV files should contain all the columns as stated on the Data Sample</li>
                                            <li>The order of the columns should be the same as stated on the Data Sample with the first rows as header</li>
                                            <li>You can upload a maximum of 4,000 rows in 1 file. If you have more rows, please split them into multiple files.</li>
                                        </ul>
                                        <div class="card-body text-center">
                                            <button class="btn btn-primary btn-lg ">
                                                Download Data Sample</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Upload CSV File(.csv)</h4>
                                        <p class="category"></p>
                                    </div>
                                    <div class="card-body">


                                        <div class="input-group">
                                            <input type="file" class="form-control inputFileVisible" placeholder="Single File">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-fab btn-round btn-primary">
                                                    <i class="material-icons">attach_file</i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- General Lender Transaction Card Data Begins -->






            </div>
        </div>
    </div>
</div>



<?php

include("footer.php");

?>