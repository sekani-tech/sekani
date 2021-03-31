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
                        <table id="bankr" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Activities</th>
                                    <th>Amount</th>
                                    <th>Reconciliation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Transfer to Zenith Bank</td>
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
                                    <td>Transfer to Access Bank</td>
                                    <td>₦200,000</td>
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
                                    <td>Transfer from Sterling Bank</td>
                                    <td>₦300,000</td>
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
                                    <td>Transfer to Access Bank</td>
                                    <td>₦450,000</td>
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
                                    <td>Transfer to Access Bank</td>
                                    <td>₦200,000</td>
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