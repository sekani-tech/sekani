<?php
session_start();
include('../../functions/connect.php');

$sessint_id = $_SESSION['int_id'];

if(!empty($_POST["start"]) && !empty($_POST["end"])) {
    $start = $_POST["start"];
    $end = $_POST["end"];
    $branch_id = $_POST["branch_id"];
?>

<div class="col-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Disbursed Loan Accounts Report</h4>
        </div>
        <div class="card-body">
            <div class="card card-profile ml-auto mr-auto" style="max-width: 370px; max-height: 360px">
                <div class="card-body ">
                    <?php
                        $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
                        while ($result = mysqli_fetch_array($getParentID)) {
                            $parent_id = $result['parent_id'];
                        }

                        if ($parent_id == 0) {
                            // Select loan data from all branches
                            $accountquery = "SELECT l.principal_amount FROM loan l JOIN client c ON l.client_id = c.id WHERE l.int_id = $sessint_id AND (l.disbursement_date  BETWEEN '$start' AND '$end')";
                            $result = mysqli_query($connection, $accountquery);
                        } else {
                            $accountquery = "SELECT l.principal_amount FROM loan l JOIN client c ON l.client_id = c.id JOIN branch b ON c.branch_id = b.id WHERE l.int_id = $sessint_id AND (l.disbursement_date  BETWEEN '$start' AND '$end') AND b.id = $branch_id";
                            $result = mysqli_query($connection, $accountquery);
                        }
                        
                        $totalDisbursedLoans = 0;
                        while ($loan = mysqli_fetch_array($result)) {
                            $totalDisbursedLoans += $loan['principal_amount'];
                        }
                    ?>
                    <h4 class="card-title">Total Disbursed Loans: <b>&#8358;<?php echo number_format(round($totalDisbursedLoans), 2); ?></b></h4>
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
            <div class="row">
                <div class="col-12">
                    <div class="table-resposive">
                        <table id="disbursedloan" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th><small>Client Name</small></th>
                                    <th><small>Principal Amount</small></th>
                                    <th><small>Loan Term</small></th>
                                    <th><small>Disbursement Date</small></th>
                                    <th><small>Maturity Date</small></th>
                                    <th><small>Interest Rate</small></th>
                                    <th><small>Cumulative Interest Amount</small></th>
                                    <th><small>Total Outstanding Balance</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
                                    while ($result = mysqli_fetch_array($getParentID)) {
                                        $parent_id = $result['parent_id'];
                                    }

                                    if ($parent_id == 0) {
                                        // Select loan data from all branches
                                        $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id FROM loan l JOIN client c ON l.client_id = c.id WHERE l.int_id = $sessint_id AND (l.disbursement_date  BETWEEN '$start' AND '$end')";
                                        $result = mysqli_query($connection, $accountquery);
                                    } else {
                                        $accountquery = "SELECT l.client_id, l.principal_amount, l.loan_term, l.disbursement_date, l.repayment_date, l.interest_rate, l.total_outstanding_derived, c.display_name, c.branch_id, b.parent_id FROM loan l JOIN client c ON l.client_id = c.id JOIN branch b ON c.branch_id = b.id WHERE l.int_id = $sessint_id AND (l.disbursement_date  BETWEEN '$start' AND '$end') AND b.id = $branch_id";
                                        $result = mysqli_query($connection, $accountquery);
                                    }

                                    while ($loan = mysqli_fetch_array($result)) {
                                ?>
                                        <tr>
                                            <th><?php echo $loan['display_name']; ?></th>
                                            <th><?php echo number_format(round($loan['principal_amount']), 2); ?></th>
                                            <th><?php echo $loan['loan_term']; ?></th>
                                            <th><?php echo $loan['disbursement_date']; ?></th>
                                            <th><?php echo $loan['repayment_date']; ?></th>
                                            <th><?php echo $loan['interest_rate']; ?>%</th>
                                            <?php
                                                $intr = $loan['interest_rate'] / 100;
                                                $total_interest = $loan['loan_term'] * $intr * $loan['principal_amount'];
                                                // the code below is as a result of the total_outstanding_derived column in the loan table not been updated at the moment
                                                $total_outstanding_bal = $loan['total_outstanding_derived'] + $total_interest;
                                            ?>
                                            <th><?php echo number_format(round($total_interest), 2); ?></th>
                                            <th><?php echo number_format(round($total_outstanding_bal), 2); ?></th>
                                        </tr>
                                <?php
                                    }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group mt-4">
                        <form method="POST" action="../composer/disbursedloan.php">
                            <input hidden type="text" name="branch_id" value="<?php echo $branch_id; ?>" />
                            <input hidden type="text" name="start" value="<?php echo $start; ?>" />
                            <input hidden type="text" name="end" value="<?php echo $end; ?>" />
                            <button type="submit" name="downloadPDF" class="btn btn-primary">Download PDF</button>
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
        $('#disbursedloan').DataTable({
            "ordering": false
        });
    });
</script>

<?php
}
?>