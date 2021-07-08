<?php

$page_title = "Credit Bureau Report";
$destination = "";
include("header.php")
?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Credit Bureau Report</h4>
                        <p class="category">Customer Details</p>
                    </div>
                    <div class="card-body">
                        <table id="crb" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th><small>Customer ID</small></th>
                                    <th><small>Account Number</small></th>
                                    <th><small>Account Status</small></th>
                                    <th><small>Account Status Date</small></th>
                                    <th><small>Date of loan (facility) disbursement/Loan effective date</small> </th>
                                    <th><small>Credit limit/Facility amount/Global limit</small> </th>
                                    <th><small>Loan (Facility) Amount/Availed Limit</small></th>
                                    <th><small>Outstanding Balance</small></th>
                                    <th><small>Instalment Amount</small></th>
                                    <th><small>Currency</small> </th>
                                    <th><small>Days in Arrears</small> </th>
                                    <th><small>Overdue Amount</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Credit Bureau Report</h4>
                        <p class="category">Credit Details</p>
                    </div>
                    <div class="card-body">
                        <table id="crb1" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>                                  
                                    <th><small>Loan Facility Type</small> </th>
                                    <th><small>Loan (Facility) Tenor</small></th>
                                    <th> <small>Repayment frequency</small> </th>
                                    <th><small>Last payment date</small> </th>
                                    <th><small>Last payment amount</small> </th>
                                    <th><small>Maturity date</small> </th>
                                    <th><small>Loan Classification</small> </th>
                                    <th><small>Legal Challenge Status</small> </th>
                                    <th><small>Litigation Date</small></th>
                                    <th><small>Consent Status</small> </th>
                                    <th><small>Loan Security Status</small></th>
                                    <th><small>Collateral Type</small> </th>
                                    <th><small>Collateral Details</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
</div>



<script>
    $(document).ready(function() {
        $('#crb1').DataTable();
    });
    $(document).ready(function() {
        $('#crb').DataTable();
    });
</script>


<?php
include("footer.php");
?>