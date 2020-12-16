<?php

$page_title = "Loan Report";
$destination = "report_loan.php";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Reports - Trial Balance</h4>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">Start Date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">End Date</label>
                                    <input type="date" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="">Branch</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">Head Office</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Break Down per Branch</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">No</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Hide Zero Balances</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">No</option>
                                    </select>
                                </div>
                            </div>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="submit" class="btn btn-primary">Run report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header-primary">
                        <h4 class="card-title">Trial Balance Report</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-profile ml-auto mr-auto" style="max-width: 560px; max-height: 360px">
                                    <div class="card-body ">
                                        <h4 class="card-title"></h4>
                                        <h3 class="card-category text-black">Daniel Global Microfinance Bank </b> </h3>
                                    </div>
                                    <div class="card-footer justify-content-center">
                                        Head Office
                                    </div>
                                    <div class="card-footer justify-content-center">
                                        <b> 9 Ndjamena crescent wuse II, Abuja </b>
                                    </div>
                                    <div class="card-footer justify-content-center">
                                    From: 24/05/2020 || To: 24/05/2020
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:50px;">
                                                <small>Account Number</small>
                                            </th>
                                            <th>
                                                <small>Account Title</small>
                                            </th>
                                            <th>
                                                <small>Section</small>
                                            </th>
                                            <th>
                                                <small>Opening Balance(₦)</small>
                                            </th>
                                            <th>
                                                <small>Credit Movement(₦)</small>
                                            </th>
                                            <th>
                                                <small>Debit Movement(₦)</small>
                                            </th>
                                            <th>
                                                <small>Current Balance(₦)</small>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>40010001</td>
                                            <td>CASH IN VAULT- NOTES</td>
                                            <td>Cash and Equivalent</td>
                                            <td>-188.126.23</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-188.126.23</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Cash and Equivalent</td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Group Total</b></td>
                                            <td><b>-188.126.23</b></td>
                                        </tr>
                                        <tr>
                                            <td>51020306</td>
                                            <td>ACCESS BANK - WUSE-1/CLASS</td>
                                            <td>Balances with Banks</td>
                                            <td>-49,451.10</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-49,451.10</td>
                                        </tr>
                                        <tr>
                                            <td>51020306</td>
                                            <td>ACCESS BANK - WUSE-CURRENT</td>
                                            <td>Balances with Banks</td>
                                            <td>-49,451.10</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-49,451.10</td>
                                        </tr>
                                        <tr>
                                            <td>51020306</td>
                                            <td>FIRST BANK PLC - MAITAMA</td>
                                            <td>Balances with Banks</td>
                                            <td>-49,451.10</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-49,451.10</td>
                                        </tr>
                                        <tr>
                                            <td>51020306</td>
                                            <td>FIRST CITY MONUMENT BANK (FCMB)</td>
                                            <td>Balances with Banks</td>
                                            <td>-49,451.10</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-49,451.10</td>
                                        </tr>
                                        <tr>
                                            <td>51020306</td>
                                            <td>AFRIBANK NIGERIA PLC</td>
                                            <td>Balances with Banks</td>
                                            <td>-49,451.10</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-49,451.10</td>
                                        </tr>
                                        <tr>
                                            <td>51020306</td>
                                            <td>ECOBANK FCDA BRANCH</td>
                                            <td>Balances with Banks</td>
                                            <td>-49,451.10</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-49,451.10</td>
                                        </tr>
                                        <tr>
                                            <td>51020306</td>
                                            <td>ECOBANK - AREA 1 BRANCH</td>
                                            <td>Balances with Banks</td>
                                            <td>-49,451.10</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-49,451.10</td>
                                        </tr>
                                        <tr>
                                            <td>51020306</td>
                                            <td>UBA</td>
                                            <td>Balances with Banks</td>
                                            <td>-49,451.10</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-49,451.10</td>
                                        </tr>
                                        <tr>
                                            <td>51020306</td>
                                            <td>FIDELITY BANK</td>
                                            <td>Balances with Banks</td>
                                            <td>-49,451.10</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-49,451.10</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Balances with Banks</td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Group Total</b></td>
                                            <td><b>-188.126.23</b></td>
                                        </tr>
                                        <tr>
                                            <td>70030381</td>
                                            <td>INVESTMENT - FIDELITY</td>
                                            <td>Investment(Bills)</td>
                                            <td>-4,000,000.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-4,000,000.00</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Investment(Bills)</td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Group Total</b></td>
                                            <td><b>-4,000,000.00</b></td>
                                        </tr>
                                        <tr>
                                            <td>02</td>
                                            <td>Current Accounts</td>
                                            <td>Loans/Advances</td>
                                            <td>-7,596,607.74</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-7,596,607.74</td>
                                        </tr>
                                        <tr>
                                            <td>03</td>
                                            <td>Loans</td>
                                            <td>Loans/Advances</td>
                                            <td>-7,596,607.74</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-7,596,607.74</td>
                                        </tr>
                                        <tr>
                                            <td>04</td>
                                            <td>Savings Accounts</td>
                                            <td>Loans/Advances</td>
                                            <td>-7,596,607.74</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-7,596,607.74</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Loans/Advances</td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Group Total</b></td>
                                            <td><b>-188.126.23</b></td>
                                        </tr>
                                        <tr>
                                            <td>62330381</td>
                                            <td>STATIONARY STOCKS</td>
                                            <td>Other Assets</td>
                                            <td>-245,600.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-245,600.00</td>
                                        </tr>
                                        <tr>
                                            <td>62330381</td>
                                            <td>STOCK OF CHEQUE BOOK </td>
                                            <td>Other Assets</td>
                                            <td>-245,600.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-245,600.00</td>
                                        </tr>
                                        <tr>
                                            <td>62330381</td>
                                            <td>INTEREST INC.RECBILE ON LOAN IND</td>
                                            <td>Other Assets</td>
                                            <td>-245,600.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>-245,600.00</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Other Assets</td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Group Total</b></td>
                                            <td><b>-188.126.23</b></td>
                                        </tr>


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="width:50px;">
                                                <small>Account Number</small>
                                            </th>
                                            <th>
                                                <small>Account Title</small>
                                            </th>
                                            <th>
                                                <small>Section</small>
                                            </th>
                                            <th>
                                                <small>Opening Balance(₦)</small>
                                            </th>
                                            <th>
                                                <small>Credit Movement(₦)</small>
                                            </th>
                                            <th>
                                                <small>Debit Movement(₦)</small>
                                            </th>
                                            <th>
                                                <small>Current Balance(₦)</small>
                                            </th>
                                        </tr>
                                    </tfoot>
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

            var groupColumn = 2;
            var table = $('#example').DataTable({

                "columnDefs": [{
                    "visible": false,
                    "targets": groupColumn
                }],
                "order": [
                    [groupColumn]
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
                                '<tr class="group"><td colspan="5"><b>' + group + '</b></td></tr>'
                            );

                            last = group;
                        }
                    });
                }

            });




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