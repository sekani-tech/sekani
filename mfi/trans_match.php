<?php

$page_title = "Reconciliation";
$destination = "";
include("header.php");

$sessint_id = $_SESSION['int_id'];

include('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_SESSION["upload_successful"])) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Transactions Uploaded Successfully!",
            showConfirmButton: false,
            timer: 3000
        })
    });
    </script>
    ';
    unset($_SESSION["upload_successful"]);
}

if(isset($_SESSION["upload_failed"])) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Failed",
            text: "Transactions Upload Failed!",
            showConfirmButton: false,
            timer: 3000
        })
    });
    </script>
    ';
    unset($_SESSION["upload_failed"]);
}

if(isset($_SESSION["delete_successful"])) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Transactions Deleted Successfully!",
            showConfirmButton: false,
            timer: 3000
        })
    });
    </script>
    ';
    unset($_SESSION["delete_successful"]);
}

if(isset($_SESSION["delete_failed"])) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Failed",
            text: "Transactions Could Not Be Deleted!",
            showConfirmButton: false,
            timer: 3000
        })
    });
    </script>
    ';
    unset($_SESSION["delete_failed"]);
}



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
                'amount' => $col['3'],
                'type' => $col['4']
            );
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
                                <div style="float: right;">
                                <button type="button" class="btn btn-success">Reconcile</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php
                $matchingTransactionsArray = array();

                if(!empty($_POST['gl_code'])) {
                    $gl_code = $_POST['gl_code'];
                    $sekaniBankStmt = mysqli_query($connection, "SELECT * FROM `gl_account_transaction` WHERE int_id = {$sessint_id} AND gl_code = {$gl_code}");
                }
        
                $numOfRecordsInSekaniBankStmt = mysqli_num_rows($sekaniBankStmt);
                $numOfRecordsInUploadedBankStmt = sizeof($uploadedBankStmt);

                if($numOfRecordsInSekaniBankStmt > 0 && $numOfRecordsInUploadedBankStmt > 0) {
                    while($row = mysqli_fetch_array($sekaniBankStmt)) {
                        extract($row);

                        $amount = number_format($amount, 2);
                        $transaction_date = date('d-m-Y', strtotime($transaction_date));

                        for ($i = 1; $i < $numOfRecordsInUploadedBankStmt; $i++) {
                            $uploadedTransID = $uploadedBankStmt[$i]['transaction_id'];
                            $uploadedAmount = number_format($uploadedBankStmt[$i]['amount'], 2);
                            $uploadedTransDate = date('d-m-Y', strtotime($uploadedBankStmt[$i]['date']));
                            $uploadedDescription = $uploadedBankStmt[$i]['description'];

                            if(($transaction_id == $uploadedTransID) && ($amount == $uploadedAmount) && ($transaction_date == $uploadedTransDate)) {
                                array_push($matchingTransactionsArray, compact('transaction_id', 'amount', 'transaction_date', 'description'));
                            }
                        }
                    }
                }
                ?>
                <div class="row">
                    <div class="col-12 ml-auto mr-auto">
                        <div class="card card-pricing">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Matching Transactions</h4>
                                <!-- <p class="category">Category subtitle</p> -->
                                
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
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
                                                <?php
                                                foreach($matchingTransactionsArray as $matchingTransaction) {
                                                    extract($matchingTransaction);
                                                ?>
                                                <tr>
                                                    <td><b>Transaction ID [ <?php echo $transaction_id; ?> ]</b></td>
                                                    <td><?php echo '₦'. $amount; ?></td>
                                                    <td><?php echo $transaction_date; ?></td>
                                                    <td><?php echo $description; ?></td>
                                                    <td><?php echo '₦'. $amount; ?></td>
                                                    <td><?php echo $transaction_date; ?></td>
                                                    <td><?php echo $description; ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $inSekaniNotInUploadedArray = array();

                if(!empty($_POST['gl_code'])) {
                    $gl_code = $_POST['gl_code'];
                    $sekaniBankStmt = mysqli_query($connection, "SELECT * FROM `gl_account_transaction` WHERE int_id = {$sessint_id} AND gl_code = {$gl_code}");
                }
        
                $numOfRecordsInSekaniBankStmt = mysqli_num_rows($sekaniBankStmt);

                if($numOfRecordsInSekaniBankStmt > 0) {
                    while($row = mysqli_fetch_array($sekaniBankStmt)) {
                        extract($row);

                        $amount = number_format($amount, 2);
                        $transaction_date = date('d-m-Y', strtotime($transaction_date));

                        $h = 0;
                        $foundInUploaded[$h] = 0;

                        for ($i = 1; $i < $numOfRecordsInUploadedBankStmt; $i++) {
                            $uploadedTransID = $uploadedBankStmt[$i]['transaction_id'];
                            $uploadedAmount = number_format($uploadedBankStmt[$i]['amount'], 2);
                            $uploadedTransDate = date('d-m-Y', strtotime($uploadedBankStmt[$i]['date']));
                            $uploadedDescription = $uploadedBankStmt[$i]['description'];

                            if(($transaction_id == $uploadedTransID) && ($amount == $uploadedAmount) && ($transaction_date == $uploadedTransDate)) {
                                $foundInUploaded[$h]++;
                            }
                        }

                        if($foundInUploaded[$h] == 0) {
                            array_push($inSekaniNotInUploadedArray, compact('transaction_id', 'amount', 'transaction_date', 'description'));
                        }

                        $h++;
                    }
                }
                ?>
                <div class="row">
                    <div class="col-md-6 ml-auto mr-auto">
                        <div class="card card-pricing">
                            <div class="card-header card-header-info">
                                <h4 class="card-title">Sekani (Not Uploaded)</h4>
                                <!-- <p class="category">Category subtitle</p> -->
                                <div style="float: right;">
                                    <form>
                                        <input type="hidden" id="inSekaniNotInUploaded" value="<?php echo htmlentities(serialize($inSekaniNotInUploadedArray)); ?>" />
                                        <input type="hidden" id="gl_code" value="<?php echo $gl_code; ?>" />
                                        <span id="btnDelete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete these records from your database?');">Discard</span>
                                    </form>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#btnDelete').on("click", function() {
                                            var inSekaniNotInUploaded = $('#inSekaniNotInUploaded').val();
                                            var gl_code = $('#gl_code').val();

                                            $.ajax({
                                                url: "../functions/bank_reconciliation/deleterecords.php",
                                                method: "POST",
                                                data: {
                                                    inSekaniNotInUploaded: inSekaniNotInUploaded,
                                                    gl_code: gl_code
                                                },
                                                success: function(data) {
                                                    location.reload();
                                                }
                                            })
                                        });
                                    });
                                </script>
                            </div>    
                            <div class="card-body">
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
                                        <?php
                                        foreach($inSekaniNotInUploadedArray as $inSekaniNotInUploaded) {
                                            extract($inSekaniNotInUploaded);
                                        ?>
                                        <tr>
                                            <td><b>Transaction ID [ <?php echo $transaction_id; ?> ]</b></td>
                                            <td><?php echo '₦'. $amount; ?></td>
                                            <td><?php echo $transaction_date; ?></td>
                                            <td><?php echo $description; ?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php
                    $inUploadedNotInSekaniArray = array();

                    if($numOfRecordsInUploadedBankStmt > 0) {
                        for ($i = 1; $i < $numOfRecordsInUploadedBankStmt; $i++) {

                            $uploadedTransID = $uploadedBankStmt[$i]['transaction_id'];
                            $uploadedAmount = number_format($uploadedBankStmt[$i]['amount'], 2);
                            $uploadedTransDate = date('d-m-Y', strtotime($uploadedBankStmt[$i]['date']));
                            $uploadedDescription = $uploadedBankStmt[$i]['description'];
                            $uploadedType = $uploadedBankStmt[$i]['type'];

                            $foundInSekani[$i] = 0;

                            if(!empty($_POST['gl_code'])) {
                                $gl_code = $_POST['gl_code'];
                                $sekaniBankStmt = mysqli_query($connection, "SELECT * FROM `gl_account_transaction` WHERE int_id = {$sessint_id} AND gl_code = {$gl_code}");
                            }

                            while($row = mysqli_fetch_array($sekaniBankStmt)) {
                                extract($row);

                                $amount = number_format($amount, 2);
                                $transaction_date = date('d-m-Y', strtotime($transaction_date));

                                if(($transaction_id == $uploadedTransID) && ($amount == $uploadedAmount) && ($transaction_date == $uploadedTransDate)) {
                                    $foundInSekani[$i]++;
                                }
                            }
                            
                            if($foundInSekani[$i] == 0) {
                                array_push($inUploadedNotInSekaniArray, compact('uploadedTransID', 'uploadedAmount', 'uploadedTransDate', 'uploadedDescription', 'uploadedType'));
                            }
                        }
                    }
                    ?>
                    <div class="col-md-6 ml-auto mr-auto">
                        <div class="card card-pricing">
                            <div class="card-header card-header-warning">
                                <h4 class="card-title">Uploaded Excel (Not Found)</h4>
                                <!-- <p class="category">Category subtitle</p> -->
                                <div style="float: right;">
                                    <form>
                                        <input type="hidden" id="inUploadedNotInSekani" value="<?php echo htmlentities(serialize($inUploadedNotInSekaniArray)); ?>" />
                                        <input type="hidden" id="gl_code" value="<?php echo $gl_code; ?>" />
                                        <span id="btnUpload" class="btn btn-success" onclick="return confirm('Are you sure you want to upload these records to your database?');">Upload</span>
                                    </form>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#btnUpload').on("click", function() {
                                            var inUploadedNotInSekani = $('#inUploadedNotInSekani').val();
                                            var gl_code = $('#gl_code').val();

                                            $.ajax({
                                                url: "../functions/bank_reconciliation/uploadrecords.php",
                                                method: "POST",
                                                data: {
                                                    inUploadedNotInSekani: inUploadedNotInSekani,
                                                    gl_code: gl_code
                                                },
                                                success: function(data) {
                                                    location.reload();
                                                }
                                            })
                                        });
                                    });
                                </script>
                            </div>
                            <div class="card-body">
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
                                        <?php
                                        foreach($inUploadedNotInSekaniArray as $inUploadedNotInSekani) {
                                            extract($inUploadedNotInSekani);
                                        ?>
                                        <tr>
                                            <td><b>Transaction ID [ <?php echo $uploadedTransID; ?> ]</b></td>
                                            <td><?php echo '₦'. $uploadedAmount; ?></td>
                                            <td><?php echo $uploadedTransDate; ?></td>
                                            <td><?php echo $uploadedDescription; ?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>

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