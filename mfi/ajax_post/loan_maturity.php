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
    $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND (total_outstanding_derived <> 0)";
    $result = mysqli_query($connection, $query);
} else {
    $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (total_outstanding_derived <> 0)";
    $result = mysqli_query($connection, $query);
}
?>
<div class="col-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Matured Loan Report</h4>
        </div>
        
        <div class="card-body">
            <div class="card card-profile ml-auto mr-auto" style="max-width: 370px; max-height: 360px">
                <div class="card-body ">
                    <?php
                        $maturedLoans = 0;
                        if (mysqli_num_rows($result) > 0) {
                            while ($loan = mysqli_fetch_array($result)) {
                                $today = date("Y-m-d");
                                if ($today >= $loan["maturedon_date"]) {
                                    $maturedLoans++;
                                }
                            }
                        }
                    ?>
                    <h4 class="card-title">Matured Loans: <b><?php echo $maturedLoans; ?></b></h4>
                    <h6 class="card-category text-gray">
                        <?php
                            $getBranchName = mysqli_query($connection, "SELECT name FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
                            while ($branch = mysqli_fetch_array($getBranchName)) {
                                $branchName = $branch['name'];
                            }
                            echo $branchName;
                        ?>
                    </h6>
                </div>
            </div>

            <div class="table-responsive">
                <table id="mlr" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Principal Amount</th>
                            <th>Loan Term</th>
                            <th>Disbursement Date</th>
                            <th>Maturity Date</th>
                            <th>Outstanding Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($parent_id == 0) {
                                // Select loan data from all branches
                                $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND (total_outstanding_derived <> 0)";
                                $result = mysqli_query($connection, $query);
                            } else {
                                $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (total_outstanding_derived <> 0)";
                                $result = mysqli_query($connection, $query);
                            }

                            while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <?php
                                if ($today >= $row["maturedon_date"]) {
                                    $client_id = $row['client_id'];
                                    $name = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$client_id'");
                                    $f = mysqli_fetch_array($name);
                                    $name = strtoupper($f["firstname"] . " " . $f["lastname"]);
                                ?>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo number_format($row["principal_amount"], 2); ?></td>
                                    <td><?php echo $row["loan_term"]; ?></td>
                                    <td><?php echo $row["disbursement_date"]; ?></td>
                                    <td><?php echo $row["maturedon_date"]; ?></td>
                                    <td><?php echo number_format(round($row["total_outstanding_derived"]), 2); ?></td>
                                <?php 
                                }
                                ?>
                            </tr>
                        <?php   
                            }
                        ?>
                    </tbody>
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