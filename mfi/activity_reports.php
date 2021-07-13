<?php

$page_title = "Teller Management";
$destination = "";
include("header.php");
?>

<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Activity Reports</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- TELLER CARD BEGINS -->
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Teller</h4>
                                <!-- <p class="category">Category subtitle</p> -->
                                <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#exampleModal">Info</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Teller Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card card-profile ml-auto mr-auto" style="max-width: 370px; max-height: 360px">
                                                <div class="card-body ">
                                                    <h4 class="card-title">Teller Balance: <b>₦60,000.00</b></h4>
                                                    <h4 class="card-title">Last Withdrawal: <b>₦60,000.00</b></h4>
                                                    <h4 class="card-title">Last Deposit: <b>₦60,000.00</b></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="POST" action="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Start Date</label>
                                                        <input type="date" value="" id="start" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">End Date</label>
                                                        <input type="date" value="" id="end" class="form-control">
                                                        <input type="text" id="int_id" hidden="" name="" value="9" class="form-control" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                            <button type="button" class="btn btn-success" id="">Run Report</button>
                                        </form>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <table id="teller" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>Credit/Debit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>13/07/2021</td>
                                                    <td>Client Withdrawal</td>
                                                    <td>₦5,000</td>
                                                    <td>credit</td>

                                                </tr>
                                                <tr>
                                                    <td>13/07/2021</td>
                                                    <td>Client Deposit</td>
                                                    <td>₦62,000</td>
                                                    <td>debit</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- TELLER CARD ENDS -->
                    </div>
                    <div class="col-md-6">
                    <!-- CLIENTS CARD BEGINS -->
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Clients</h4>
                                <!-- <p class="category">Category subtitle</p> -->
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="POST" action="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Start Date</label>
                                                        <input type="date" value="" id="start" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">End Date</label>
                                                        <input type="date" value="" id="end" class="form-control">
                                                        <input type="text" id="int_id" hidden="" name="" value="9" class="form-control" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                            <button type="button" class="btn btn-success" id="">Run Report</button>
                                        </form>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <table id="clients" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Client Name</th>
                                                    <th>Account Number</th>
                                                    <th>Date Created</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>0237547230</td>
                                                    <td>13/07/2021</td>
                                                    <td><button type="button" class="btn btn-info">View</button></td>
                                                </tr>
                                                <tr>
                                                    <td>Garrett Winters</td>
                                                    <td>0237547230</td>
                                                    <td>13/07/2021</td>
                                                    <td><button type="button" class="btn btn-info">View</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CLIENT CARD ENDS -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                    <!-- APPROVAL CARD BEGINS -->
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Approval Activity</h4>
                                <!-- <p class="category">Category subtitle</p> -->
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="POST" action="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Start Date</label>
                                                        <input type="date" value="" id="start" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">End Date</label>
                                                        <input type="date" value="" id="end" class="form-control">
                                                        <input type="text" id="int_id" hidden="" name="" value="9" class="form-control" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                            <button type="button" class="btn btn-success" id="">Run Report</button>
                                        </form>
                                    </div>
                                    <div class="col-md-12 mt-4">

                                        <table id="approval" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Transaction Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>13/07/2021</td>
                                                    <td>System Architect</td>
                                                </tr>
                                                <tr>
                                                    <td>13/07/2021</td>
                                                    <td>Accountant</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- APPROVAL CARD ENDS -->
                    </div>
                    <div class="col-md-6">
                    <!-- SYSTEM ACTIVITY CARD BEGINS -->
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">System Activity</h4>
                                <!-- <p class="category">Category subtitle</p> -->
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="POST" action="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Start Date</label>
                                                        <input type="date" value="" id="start" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">End Date</label>
                                                        <input type="date" value="" id="end" class="form-control">
                                                        <input type="text" id="int_id" hidden="" name="" value="9" class="form-control" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                            <button type="button" class="btn btn-success" id="">Run Report</button>
                                        </form>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <table id="system" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Transaction Type</th>
                                                    <th>Activity Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>13/07/2021</td>
                                                    <td>System Architect</td>
                                                    <td>Edinburgh</td>
                                                </tr>
                                                <tr>
                                                    <td>13/07/2021</td>
                                                    <td>Accountant</td>
                                                    <td>Tokyo</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SYSTEM ACTIVITY CARD ENDS -->
                    </div>
                </div>


            </div>



        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#teller').DataTable();
        });

        $(document).ready(function() {
            $('#clients').DataTable();
        });

        $(document).ready(function() {
            $('#approval').DataTable();
        });

        $(document).ready(function() {
            $('#system').DataTable();
        });
    </script>


    <?php

    include("footer.php");

    ?>