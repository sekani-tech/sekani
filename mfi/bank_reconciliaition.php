<?php

$page_title = "Bank Reconciliation";
$destination = "";
include("header.php");

if(isset($_SESSION["reconciled"])) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Bank Reconciliation Completed!",
            showConfirmButton: false,
            timer: 3000
        })
    });
    </script>
    ';
    unset($_SESSION["reconciled"]);
}

if(isset($_SESSION["deletedReconcData"])) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Reconciliation Data Deleted Successfully!",
            showConfirmButton: false,
            timer: 3000
        })
    });
    </script>
    ';
    unset($_SESSION["deletedReconcData"]);
}
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
                                    <th>Bank Balance (Reconciled)</th>
                                    <th>Excel Amount (Not Reconciled)</th>
                                    <!-- <th class="text-center">Delete</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $getBankReconcData = mysqli_query($connection, "SELECT * FROM `bank_reconciliation` WHERE int_id = {$sessint_id}");
                                while($bankReconc = mysqli_fetch_array($getBankReconcData)) {
                                    extract($bankReconc);
                                ?>
                                <tr>
                                    <td><?php echo $bank; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $staff; ?></td>
                                    <td><?php echo $system_amount; ?></td>
                                    <td><?php echo $bank_amount; ?></td>
                                    <!-- <td class="text-center">
                                        <button id="delete<?php echo $id; ?>" class="btn btn-danger btn-fab btn-fab-mini btn-round">
                                            <i class="material-icons">clear</i>
                                        </button>
                                    </td> -->
                                </tr>
                                <!-- <script>
                                    $('#delete<?php echo $id; ?>').on("click", function() {
                                        var id = <?php echo $id; ?>;

                                        $.ajax({
                                            url: "../functions/bank_reconciliation/delete_reconc_record.php",
                                            method: "POST",
                                            data: {
                                                id: id
                                            },
                                            success: function(data) {
                                                location.reload();
                                            }
                                        })
                                    });
                                </script> -->
                                <?php
                                }
                                ?>
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