<?php

$page_title = "Audit Trail";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Audit Trail</h4>
                    </div>

                    <div class="card-body">
                        <table id="audit" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Activity</th>
                                    <th>Performed By</th>
                                    <th>Approved By</th>
                                    <th>Date Approved</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>22/03/2021</td>
                                    <td>Create Client</td>
                                    <td>John Doe</td>
                                    <td>Anet Eze</td>
                                    <td>22/03/2021</td>
                                </tr>
                                <tr>
                                    <td>22/03/2021</td>
                                    <td>Create Client</td>
                                    <td>John Doe</td>
                                    <td>Anet Eze</td>
                                    <td>22/03/2021</td>
                                </tr>
                                <tr>
                                    <td>22/03/2021</td>
                                    <td>Create Client</td>
                                    <td>John Doe</td>
                                    <td>Anet Eze</td>
                                    <td>22/03/2021</td>
                                </tr>
                                <tr>
                                    <td>22/03/2021</td>
                                    <td>Disburse Loan</td>
                                    <td>John Doe</td>
                                    <td>Anet Eze</td>
                                    <td>22/03/2021</td>
                                </tr>
                                <tr>
                                    <td>22/03/2021</td>
                                    <td>Loan Repayment</td>
                                    <td>John Doe</td>
                                    <td>Anet Eze</td>
                                    <td>22/03/2021</td>
                                </tr>
                                <tr>
                                    <td>22/03/2021</td>
                                    <td>Create Client</td>
                                    <td>John Doe</td>
                                    <td>Anet Eze</td>
                                    <td>22/03/2021</td>
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
        $('#audit').DataTable();
    });
</script>

<?php
include("footer.php");
?>