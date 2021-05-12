<?php

$page_title = "Shares Report";
$destination = "";
include("header.php");
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Deposit for Sharesholders</h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-body">
                     
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Shareholders Name</th>
                                    <th>Unit of Shares</th>
                                    <th>Value of Shares</th>
                                    <th>% of Shareholding</th>
                                    <th>Actons</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <button type="button" class="btn btn-success">Download Excel</button>
                            <button type="button" class="btn btn-success">Download PDF</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    })
</script>

<?php
include("footer.php");
?>