<?php

$page_title = "Loan Report";
$destination = "report_loan.php";
include("header.php");

$sint_id = $_SESSION['int_id'];
// Function to populate branch options
function fill_branch($connection)
{
    $sint_id = $_SESSION["int_id"];
    $dks = $_SESSION["branch_id"];
    $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
    $res = mysqli_query($connection, $org);
    $out = '';
    while ($row = mysqli_fetch_array($res)) {
        $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
    }
    return $out;
}

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
                                    <input type="date" name="start" id="start" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">End Date</label>
                                    <input type="date" name="end" id="end" class="form-control">
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="">Branch</label>
                                    <select name="branch" id="branch" class="form-control">
                                        <?php echo fill_branch($connection); ?>
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
                            <span type="submit" id="runReport" class="btn btn-primary">Run report</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#runReport').on("click", function() {
                    var start = $('#start').val();
                    var end = $('#end').val();
                    var branch = $('#branch').val();
                    $.ajax({
                        url: "ajax_post/trial_balanceR.php",
                        method: "POST",
                        data: {
                            start: start,
                            end: end,
                            branch: branch
                        },
                        success: function(data) {
                            $('#display').html(data);
                        }
                    })
                });
            });
        </script>

        <script type="text/javascript">
            function PrintDiv() {
                var divToPrint = document.getElementById('divToPrint');
                var popupWin = window.open('', '_blank', 'width=300,height=300');
                popupWin.document.open();
                popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
                popupWin.document.close();
            }
        </script>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <input type="button" value="print" class="btn btn-primary pull-right" onclick="PrintDiv();" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="divToPrint">
                    <div class="card-header-primary">
                        <h4 class="card-title">Trial Balance Report</h4>
                    </div>
                    <div class="card-body">

                        <div id="display">

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