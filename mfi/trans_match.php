<?php

$page_title = "Reconciliation";
$destination = "";
include("header.php");

$sessint_id = $_SESSION['int_id'];

include('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btnUploadBankStatement'])) {
    // check for excel file submitted
    if ($_FILES["bankStatementData"]["name"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["bankStatementData"]["name"]);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            try {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['bankStatementData']['tmp_name'], $file_name);
                $file_type = IOFactory::identify($file_name);
                $reader = IOFactory::createReader($file_type);
                $spreadsheet = $reader->load($file_name);

                unlink($file_name);

                // data from excel Sheet
                $data = $spreadsheet->getActiveSheet()->toArray();
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {

            }

            // our data table for insertion
            $uploadedBankStmt = [];
        }

        // Join data with content from the excel sheet
        foreach ($data as $row => $col) {
            $uploadedBankStmt[] = array(
                'date' => $col['0'],
                'transaction_id' => $col['1'],
                'description' => $col['2'],
                'amount' => $col['3']
            );
        }

        if(!empty($_POST['gl_code'])) {
            $gl_code = $_POST['gl_code'];
            $sekaniBankStmt = mysqli_query($connection, "SELECT * FROM `gl_account_transaction` WHERE int_id = {$sessint_id} AND gl_code = {$gl_code}");
        }

    }

}
?>


<div class="content">

    <div class="container-fluid">

        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Bank Reconciliation Matching</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                </div>
            </div>

        </div>

        <?php
        // Check if there are records present in the Sekani Bank Statement and/or Uploaded Bank Statement
        $numOfRecordsInSekaniBankStmt = mysqli_num_rows($sekaniBankStmt);
        $numOfRecordsInUploadedBankStmt = sizeof($uploadedBankStmt);

        $stmtWithMoreRecordsCount = ($numOfRecordsInSekaniBankStmt >= $numOfRecordsInUploadedBankStmt) ? $numOfRecordsInSekaniBankStmt : $numOfRecordsInUploadedBankStmt;
        
        if($numOfRecordsInSekaniBankStmt > 0 || $numOfRecordsInUploadedBankStmt > 0) {
        ?>
        <div class="row">
            <div class="col-md-12 ml-auto mr-auto">
                <div class="card card-pricing bg-primary">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">All Transactions</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">Transaction ID: </h3>
                                <h3 class="card-title">Amount: </h3>
                                <h3 class="card-title">Transaction Date: </h3>
                                <h3 class="card-title">Deposited by: </h3>
                            </div>
                            <div class="col-md-6">
                                <h3 class="card-title">Transaction ID: </h3>
                                <h3 class="card-title">Amount: </h3>
                                <h3 class="card-title">Transaction Date: </h3>
                                <h3 class="card-title">Deposited by: </h3>
                            </div>
                        </div>

                    </div>
                </div>
        <?php
                }
        ?>

        <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <div class="card card-pricing bg-success">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">Found</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Transaction ID: </h3>
                        <h3 class="card-title">Amount: </h3>
                        <h3 class="card-title">Transaction Date: </h3>
                        <h3 class="card-title">Deposited by: </h3>
                    </div>
                </div>

            </div>

            <div class="col-md-6 ml-auto mr-auto">
                <div class="card card-pricing bg-danger">
                    <div class="card-header card-header-danger">
                        <h4 class="card-title">Not Found</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body ">
                        <h3 class="card-title">Transaction ID: </h3>
                        <h3 class="card-title">Amount: </h3>
                        <h3 class="card-title">Transaction Date: </h3>
                        <h3 class="card-title">Deposited by: </h3>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?php
include("footer.php");
?>