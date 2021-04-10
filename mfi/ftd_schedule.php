<?php

$page_title = "FTD Schedule";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">

                                        <a class="nav-link active" href="#home" data-toggle="tab"><i class="material-icons">analytics</i>SUMMARY</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#updates" data-toggle="tab"><i class="material-icons">table_view</i>REPAYMENT SCHEDULE</a>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="tab-content text-center">
                            <div class="tab-pane active" id="home">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card text-left" style="width: 20rem;">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><b>Client Name: </b> </li>
                                                <li class="list-group-item"><b>FTD No:</b> </li>
                                                <li class="list-group-item"><b>Linked Account:</b> </li>
                                                <li class="list-group-item"><b>Interest Repayment:</b> </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-left" style="width: 20rem;">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><b>Booking Date:</b> </li>
                                                <li class="list-group-item"><b>Maturity Date: </b> </li>
                                                <li class="list-group-item"><b>Tenure:</b> </li>
                                                <li class="list-group-item"><b>Status:</b> </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <button type="button" class="btn btn-danger" style="margin-top: 100px;">Terminate FTD</button>

                                    </div>
                                </div>

                                <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Contract</th>
                                                <th>Paid</th>
                                                <th>Outstanding</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Principal</th>
                                                <th>₦0.00</th>
                                                <th>₦0.00</th>
                                                <th>₦0.00</th>

                                            </tr>
                                            <tr>
                                                <th>Interest</th>
                                                <th>₦0.00</th>
                                                <th>₦0.00</th>
                                                <th>₦0.00</th>

                                            </tr>
                                            <tr>
                                                <th>Fees</th>
                                                <th>₦0.00</th>
                                                <th>₦0.00</th>
                                                <th>₦0.00</th>

                                            </tr>
                                            <tr>
                                                <th>Penalties</th>
                                                <th>₦0.00</th>
                                                <th>₦0.00</th>
                                                <th>₦0.00</th>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane" id="updates">
                                <div class="card">
                                    <!-- end -->
                                    <div class="card card-profile ml-auto mr-auto" style="max-width: 360px; max-height: 360px">
                                        <div class="card-body ">
                                            <h4 class="card-title">BLESSING UMOGBAI</h4>
                                            <h6 class="card-category text-gray">FTD Number: 0190006393</h6>
                                        </div>
                                        <div class="card-footer justify-content-center">
                                        </div>
                                    </div>
                                    <!-- end new card profile -->
                                    <div class="card-body">
                                        
                                            <table class="table table-bordered" style="width:100%">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>Term</th>
                                                        <th>Principal</th>
                                                        <th>Interest</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>0</td>
                                                        <td>₦100,000</td>
                                                        <td>₦3,333.33</td>
                                                        <td>₦200.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>₦100,000</td>
                                                        <td>₦3,333.33</td>
                                                        <td>₦200,000.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-body">

                    </div> -->
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>


<?php
include("footer.php");
?>