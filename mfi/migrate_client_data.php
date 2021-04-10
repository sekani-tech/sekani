<?php

$page_title = "Client data";
$destination = "migrations";
include("header.php");
include("ajaxcall.php");

// Account type
$condition = ['int_id' => $_SESSION['int_id']];
$accountType = selectAll("savings_product", $condition);

// staff
$staffCondition = ['int_id' => $_SESSION['int_id']];
$staff = selectAll("staff", $condition);

// branch
$branchCondition = ['int_id' => $_SESSION['int_id']];
$branch = selectAll("branch", $condition);

// feedback
$exp_error = "";
if (isset($_GET["account1"])) {
    $key = $_GET["account1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Accounts created Successful",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["account2"])) {
    $key = $_GET["account2"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error",
            text: "No file Uploaded",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
?>


<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="row">

            <div class="col-md-12">


                <!-- Clients Data Card Begins -->
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Clients Data</h4>
                        <p class="category"></p>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title text-center">Select Branch</h4>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class=" text-primary">
                                                    <th>S/N</th>
                                                    <th>Branch Name</th>
                                                    <th>Branch ID</th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($branch as $key => $type) { ?>
                                                        <tr>
                                                            <td><?php echo $key + 1 ?></td>
                                                            <td><?php echo $type['name'] ?></td>
                                                            <td><?php echo $type['id'] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title text-center">Select Account Type</h4>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class=" text-primary">
                                                    <th>S/N</th>
                                                    <th>Account Type</th>
                                                    <th>Product ID</th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($accountType as $key => $type) { ?>
                                                        <tr>
                                                            <td><?php echo $key + 1 ?></td>
                                                            <td><?php echo $type['name'] ?></td>
                                                            <td><?php echo $type['id'] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title text-center">Select Client Officer</h4>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class=" text-primary">
                                                    <th>S/N</th>
                                                    <th>Staff Name</th>
                                                    <th>ID</th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($staff as $key => $type) { ?>
                                                        <tr>
                                                            <td><?php echo $key + 1 ?></td>
                                                            <td><?php echo $type['display_name'] ?></td>
                                                            <td><?php echo $type['id'] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title"><i class="material-icons">info</i> Procedure </h4>

                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Files must be in <b>.csv</b></li>
                                            <li>CSV files should contain all the columns as stated on the Data
                                                Sample
                                            </li>
                                            <li>The order of the columns should be the same as stated on the Data
                                                Sample with the first rows as header
                                            </li>
                                            <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                rows, please split them into multiple files.
                                            </li>
                                            <li>
                                                <STRONG style="color: red">
                                                    IMPORTANT: Before upLoading your excel file please always
                                                    remember
                                                    to remove
                                                    the default table header (i.e row 1) completely.
                                                </STRONG>
                                            </li>
                                        </ul>
                                        <div class="card-body text-center">
                                            <a href='bulkWork/getFile.php?name=clientData&loc=2' class="btn btn-primary btn-lg">Download Data Sample</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- UPLOAD SECTION BEGINS -->
                                <form action="../functions/migrate/clients_accounts_create.php" method="post" enctype="multipart/form-data">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Upload Excel File</h4>
                                            <p class="category"></p>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="file" name="clientData" class="form-control inputFileVisible" placeholder="Single File" required>
                                                    <span class="input-group-btn">
                                                        <button type="submit" name="submitClient" class="btn btn-fab btn-round btn-primary">
                                                            <i class="material-icons">send</i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- UPLOAD SECTION ENDS -->

                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Clients Card Data Ends -->

                <!-- Accounts Card Data Begins -->
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Accounts Data</h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Files must be in <b>.csv</b></li>
                                            <li>CSV files should contain all the columns as stated on the Data
                                                Sample
                                            </li>
                                            <li>The order of the columns should be the same as stated on the Data
                                                Sample with the first rows as header
                                            </li>
                                            <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                rows, please split them into multiple files.
                                            </li>
                                            <li>
                                                <STRONG style="color: red">
                                                    IMPORTANT: Before upLoading your excel file please always
                                                    remember
                                                    to remove
                                                    the default table header (i.e row 1) completely.
                                                </STRONG>
                                            </li>
                                        </ul>
                                        <div class="card-body text-center">
                                            <button class="btn btn-primary btn-lg ">
                                                Download Data Sample
                                            </button>
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
                                                    <i class="material-icons">send</i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Accounts Card Data Ends -->

                <!-- Accounts Transactions Card Data Begins -->
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Accounts Transactions</h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Files must be in <b>.csv</b></li>
                                            <li>CSV files should contain all the columns as stated on the Data
                                                Sample
                                            </li>
                                            <li>The order of the columns should be the same as stated on the Data
                                                Sample with the first rows as header
                                            </li>
                                            <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                rows, please split them into multiple files.
                                            </li>
                                            <li>
                                                <STRONG style="color: red">
                                                    IMPORTANT: Before upLoading your excel file please always
                                                    remember
                                                    to remove
                                                    the default table header (i.e row 1) completely.
                                                </STRONG>
                                            </li>
                                        </ul>
                                        <div class="card-body text-center">
                                            <button class="btn btn-primary btn-lg ">
                                                Download Data Sample
                                            </button>
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
                                                    <i class="material-icons">send</i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- Accounts Transactions Card Data Ends -->

            </div>

        </div>
    </div>


</div>


<?php

include("footer.php");

?>