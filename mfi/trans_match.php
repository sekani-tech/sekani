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
                <div class="card card-pricing">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Matching Transactions</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>Amount</th>
                                            <th>Transaction Date</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Transaction Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Transaction ID - </b>10234</td>
                                            <td>N30,000</td>
                                            <td>12/04/2021</td>
                                            <td>Fuel</td>
                                            <td>N30,000</td>
                                            <td>12/04/2021</td>
                                            <td>Fuel</td>
                                        </tr>
                                        <tr>
                                            <td><b>Transaction ID - </b>10214</td>
                                            <td>N34,000</td>
                                            <td>12/04/2021</td>
                                            <td>Fuel</td>
                                            <td>N34,000</td>
                                            <td>12/04/2021</td>
                                            <td>Fuel</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
        <?php
                }
        ?>

        <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <div class="card card-pricing">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">Sekani (Not Uploaded)</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                        <div style="float: right;">
                            <button type="button" class="btn btn-info">Discard</button>
                        </div>
                    </div>    
                    <div class="card-body">
                        <div class="col-md-12">
                            <table id="id1" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Amount</th>
                                        <th>Transaction Date</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10234</td>
                                        <td>N30,000</td>
                                        <td>12/04/2021</td>
                                        <td>Fuel</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-6 ml-auto mr-auto">
                <div class="card card-pricing">
                    <div class="card-header card-header-danger">
                        <h4 class="card-title">Uploaded Not Found</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                        <div style="float: right;">
                            <button type="button" class="btn btn-info">Discard</button>
                            <button type="button" class="btn btn-info">Upload</button>
                        </div>
                    </div>
                    <div class="card-body ">
                        <table id="id2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>10234</td>
                                    <td>N30,000</td>
                                    <td>12/04/2021</td>
                                    <td>Fuel</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        var groupColumn = 0;
        var table = $('#example').DataTable({
            select: true,
            "columnDefs": [{
                "visible": false,
                "targets": groupColumn
                
            }],
            "order": [
                [groupColumn, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(groupColumn, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
        });

        var table1 = $('#id1').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": groupColumn
            }],
            "order": [
                [groupColumn, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(groupColumn, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
        });

        var table = $('#id2').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": groupColumn
            }],
            "order": [
                [groupColumn, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(groupColumn, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
        });
        

        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
                table.order([groupColumn, 'desc']).draw();
            } else {
                table.order([groupColumn, 'asc']).draw();
            }
        });
    });
</script>

<?php
include("footer.php");
?>