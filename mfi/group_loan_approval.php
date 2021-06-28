<?php
$page_title = "Group Loan Approval";
include('header.php');
?>


<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Group Loan Approval</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Group Name</th>
                                    <th>Branch</th>
                                    <th>Principal</th>
                                    <th>Interest (%)</th>
                                    <th>Satus</th>
                                    <th>Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>Abuja</td>
                                    <td>₦250,000</td>
                                    <td>10%</td>
                                    <td>Pending</td>
                                    <td><a href="group_loan_view.php"><button type="button" class="btn btn-info">View</button></a></td>
                                </tr>

                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>Abuja</td>
                                    <td>₦250,000</td>
                                    <td>10%</td>
                                    <td>Pending</td>
                                    <td><a href="group_loan_view.php"><button type="button" class="btn btn-info">View</button></a></td>
                                </tr>

                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>Abuja</td>
                                    <td>₦250,000</td>
                                    <td>10%</td>
                                    <td>Pending</td>
                                    <td><a href="group_loan_view.php"><button type="button" class="btn btn-info">View</button></a></td>
                                </tr>

                                <tr>
                                    <td>Tion Group</td>
                                    <td>Asaba</td>
                                    <td>₦400,000</td>
                                    <td>30%</td>
                                    <td>Pending</td>
                                    <td><a href="group_loan_view.php"><button type="button" class="btn btn-info">View</button></a></td>
                                </tr>

                                <tr>
                                    <td>Robo Group</td>
                                    <td>Kano</td>
                                    <td>₦350,000</td>
                                    <td>12%</td>
                                    <td>Pending</td>
                                    <td><a href="group_loan_view.php"><button type="button" class="btn btn-info">View</button></a></td>
                                </tr>

                                <tr>
                                    <td>Nicon Group</td>
                                    <td>Lagos</td>
                                    <td>₦500,000</td>
                                    <td>20%</td>
                                    <td>Pending</td>
                                    <td><a href="group_loan_view.php"><button type="button" class="btn btn-info">View</button></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



        </div>
    </div>


    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                responsive: true
            });
        });
    </script>


    <?php
    include("footer.php");
    ?>