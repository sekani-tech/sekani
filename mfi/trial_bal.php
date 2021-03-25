<?php

$page_title = "New Page";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">


    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Generate Trial Balance</h4>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="row">

                                <div class="form-group col-md-3">
                                    <label for="">Start Date</label>
                                    <input type="date" name="" id="start" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">End Date</label>
                                    <input type="date" name="" id="end" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Branch</label>
                                    <select name="" id="branch_id" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <span id="input" type="submit" class="btn btn-success">Run report</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Trial Balance</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th><small>Account Number</small></th>
                                    <th><small>Account Title</small></th>
                                    <th><small>Groups</small></th>
                                    <th><small>Opening Balance</small></th>
                                    <th><small>Credit Movement</small></th>
                                    <th><small>Debit Movement</small></th>
                                    <th><small>Current Balance</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>40010001</td>
                                    <td>CASH IN VAULT</td>
                                    <td>Cash and Cash Equivalent</td>
                                    <td>-188,126.23</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td><b>-188,126.23</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Cash and Cash Equivalent</td>
                                    <td></td>
                                    <td></td>
                                    <td>Group total</td>
                                    <td><b>-188,126.23</b></td>
                                </tr>
                                <tr>
                                    <td>51020306</td>
                                    <td>ACCESS BANK- WUSE-I/CLASS</td>
                                    <td>Balances with Banks</td>
                                    <td>-49,451.10</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td><b>-49,451.10</b></td>
                                </tr>
                                <tr>
                                    <td>51020306</td>
                                    <td>FIRST BANK- MAITAMA</td>
                                    <td>Balances with Banks</td>
                                    <td>-99,451.10</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td><b>-99,451.10</b></td>
                                </tr>
                                <tr>
                                    <td>51020306</td>
                                    <td>FIRST BANK- MAITAMA</td>
                                    <td>Balances with Banks</td>
                                    <td>-99,451.10</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td><b>-99,451.10</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Balances with Banks</td>
                                    <td></td>
                                    <td></td>
                                    <td>Group Total</td>
                                    <td><b>-4,451,957.10</b></td>
                                </tr>
                                <tr>
                                    <td>70030381</td>
                                    <td>INVESTMENT - FIDELITY</td>
                                    <td><b>Investment(Bills)</b></td>
                                    <td>-3,000.10</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td><b>-99,451.10</b></td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-primary">Download Excel</button>
                        <button type="button" class="btn btn-primary">Download PDF</button>

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