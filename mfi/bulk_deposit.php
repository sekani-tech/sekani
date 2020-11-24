<?php

$page_title = "Charge data";
$destination = "bulk_update";
include("header.php");
//session_start();
// select branch for display
$branchs = selectAll('branch', ['int_id' => $_SESSION['int_id']]);
//dd($branchs);
?>


<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <!-- Begining of Charge Row !-->

        <div class="row">

            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Bulk Deposit</h4>
                        <p class="category">Make Bulk Deposit in different Branches </p>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <form action="./bulkWork/deposit.php" method="post" enctype="multipart/form-data">

                                    <!--                                    script to populate tellers-->
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#branchID').on("change keyup paste", function () {
                                                let id = $(this).val();
                                                $.ajax({
                                                    url: "bulkWork/tellerTable.php",
                                                    method: "POST",
                                                    data: {
                                                        id: id,
                                                    },
                                                    success: function (data) {
                                                        $('#tellerInfo').html(data);
                                                    }
                                                })
                                            });
                                        });
                                    </script>
                                    <!-- SELECT BRANCH CARD BEGINS -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Select Branch</label>
                                                <select class="form-control selectpicker" required name="branch"
                                                        data-style="btn btn-link"
                                                        id="branchId">
                                                    <option>Select A Branch</option>
                                                    <?php foreach ($branchs as $branch) { ?>
                                                        <option value="<?php echo $branch['id'] ?>"
                                                        ><?php echo $branch['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SELECT BRANCH CARD ENDS -->

                                    <!-- UPLOAD SECTION BEGINS -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Upload Excel File</h4>
                                            <p class="category"></p>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="file" name="excelFile"
                                                           class="form-control inputFileVisible"
                                                           placeholder="Single File" required>
                                                    <span class="input-group-btn">
                                                    <button type="submit" name="submit"
                                                            class="btn btn-fab btn-round btn-primary">
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

                            <!-- REQUIREMENTS SAMPLE COLUMN BEGINS -->

                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Files must be in <b>Excel Format</b></li>
                                            <li>Excel files should contain all the columns as stated on the Data
                                                Sample
                                            </li>
                                            <li>The order of the columns should be the same as stated on the Data Sample
                                                with the first rows as header
                                            </li>
                                            <li>You can upload a maximum of 120 rows in 1 file. If you have more rows,
                                                please split them into multiple files.
                                            </li>
                                        </ul>
                                        <form action="./bulkWork/getFile.php" method="post">
                                            <div class="card-body text-center">
                                                <input type="hidden" name="file_content" id="file_content"/>
                                                <button class="btn btn-primary btn-lg" type="submit" name="getFile">
                                                    Download Data Sample
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- REQUIREMENTS SAMPLE COLUMN BEGINS -->
                        </div>

                        <!-- SELECT TELLER TABLE BEGINS -->
                        <div class="row">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h4 class="card-title text-center">Select Teller </h4>

                                </div>


                                <div class="card-body" id="tellerInfo">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                            <th>ID</th>
                                            <th>Teller Number</th>
                                            <th>Teller ID</th>
                                            </thead>
                                            <tbody >
                                            <tr>
                                                <td>1</td>
                                                <td>Dakota Rice</td>
                                                <td>Niger</td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- SELECT TELLER TABLE ENDS -->
                    </div>


                </div>


            </div>
        </div>

    </div>
</div>