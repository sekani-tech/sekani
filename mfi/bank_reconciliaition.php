<?php

$page_title = "Bank Reconciliation";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Bank Reconciliation</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">

                    <div class="mb-4">
                    <a class="btn btn-primary" href="bank_reconciliaition_form.php"> Add </a>
                    </div>

                        <table id="bankr" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Bank</th>
                                    <th>Date</th>
                                    <th>Staff</th>
                                    <th>System Amount</th>
                                    <th>Bank Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Zenith Bank</td>
                                    <td>10-12-2021</td>
                                    <td>John Doe</td>
                                    <td>₦500,000</td>
                                    <td>₦500,000</td>
                                    <td><button class="btn btn-warning btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">create</i>
                                        </button>
                                        <button class="btn btn-success btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">done</i>
                                        </button>
                                        <button class="btn btn-danger btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">clear</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Zenith Bank</td>
                                    <td>10-12-2021</td>
                                    <td>John Doe</td>
                                    <td>₦500,000</td>
                                    <td>₦500,000</td>
                                    <td><button class="btn btn-warning btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">create</i>
                                        </button>
                                        <button class="btn btn-success btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">done</i>
                                        </button>
                                        <button class="btn btn-danger btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">clear</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Zenith Bank</td>
                                    <td>10-12-2021</td>
                                    <td>John Doe</td>
                                    <td>₦500,000</td>
                                    <td>₦500,000</td>
                                    <td><button class="btn btn-warning btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">create</i>
                                        </button>
                                        <button class="btn btn-success btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">done</i>
                                        </button>
                                        <button class="btn btn-danger btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">clear</i>
                                        </button>
                                    </td>
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
        $('#bankr').DataTable({
            "ordering": false
        });
    });
</script>
<?php
include("footer.php");
?>