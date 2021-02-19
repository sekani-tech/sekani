<?php
session_start();
include('../../functions/connect.php');

$sessint_id = $_SESSION['int_id'];
    
$branch_id = $_POST["branch_id"];

$getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
while ($result = mysqli_fetch_array($getParentID)) {
    $parent_id = $result['parent_id'];
}

if ($parent_id == 0) {
    // Select loan data from all branches
    $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
    $result = mysqli_query($connection, $query);
} else {
    $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id)";
    $result = mysqli_query($connection, $query);
}
?>
<div class="col-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title ">Matured Loan Report</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="mlr" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Principal Amount</th>
                            <th>Loan Term</th>
                            <th>Disbursement Date</th>
                            <th>Maturity Date</th>
                            <th>Outstanding Loan Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                            <tr>
                                <?php $std = date("Y-m-d");
                                if ($std >= $row["maturedon_date"]) {
                                ?>
                                    <?php $row["id"]; ?>
                                    <?php
                                    $name = $row['client_id'];
                                    $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                                    $f = mysqli_fetch_array($anam);
                                    $nae = strtoupper($f["firstname"] . " " . $f["lastname"]);
                                    ?>
                                    <td><?php echo $nae; ?></td>
                                    <td><?php echo number_format($row["principal_amount"]); ?></td>
                                    <td><?php echo $row["loan_term"]; ?></td>
                                    <td><?php echo $row["disbursement_date"]; ?></td>
                                    <td><?php echo $row["maturedon_date"]; ?></td>
                                    <td><?php echo number_format($row["total_outstanding_derived"], 2); ?></td>
                                <?php 
                                }
                                ?>
                            </tr>
                        <?php   
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Client Name</th>
                            <th>Principal Amount</th>
                            <th>Loan Term</th>
                            <th>Disbursement Date</th>
                            <th>Maturity Date</th>
                            <th>Outstanding Loan Balance</th>
                        </tr>
                    </tfoot>
                </table>
            </div>   
            <div class="row">
                <div class="col-12">
                    <div class="form-group mt-4">
                        <form action="../composer/loan_maturity.php" method="POST">
                            <input type="hidden" name="branch_id" value="<?php echo $branch_id ?>"/>
                            <button type="submit" name="downloadPDF" class="btn btn-primary pull-left">Download PDF</button>
                            <button type="submit" name="downloadExcel" class="btn btn-primary">Download Excel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#mlr').DataTable();
    });
</script>