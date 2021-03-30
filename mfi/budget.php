<?php

$page_title = "Budget";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">


                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Budget</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">
                        <table id="budget" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>GL Code</th>
                                    <th>GL</th>
                                    <th>Budget Amount</th>
                                    <th>Actual Amount</th>
                                    <th>Budget Varance</th>
                                    <th>Budget Performance %</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>10100</td>
                                    <td>CASH BALANCES</td>
                                    <td>₦60,000</td>
                                    <td>₦50,000</td>
                                    <td>₦10,000</td>
                                    <td>20%</td>
                                    <td><button type="button" class="btn btn-warning">Review Budget</button></td>
                                </tr>
                                <tr>
                                    <td>10100</td>
                                    <td>CASH BALANCES</td>
                                    <td>₦60,000</td>
                                    <td>₦50,000</td>
                                    <td>₦10,000</td>
                                    <td>20%</td>
                                    <td><button type="button" class="btn btn-warning">Review Budget</button></td>
                                </tr>
                                <tr>
                                    <td>10100</td>
                                    <td>CASH BALANCES</td>
                                    <td>₦60,000</td>
                                    <td>₦50,000</td>
                                    <td>₦10,000</td>
                                    <td>20%</td>
                                    <td><button type="button" class="btn btn-warning">Review Budget</button></td>
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
            $('#budget').DataTable();
        });
    </script>


    <?php
    include("footer.php");
    ?>