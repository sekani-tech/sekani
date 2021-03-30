<?php
session_start();
include("../../functions/connect.php");

$sessint_id = $_SESSION['int_id'];

if (!empty($_POST["start"]) && !empty($_POST["end"]) && !empty($_POST["branch_id"]))
{
    $start = $_POST['start'];
    $end = $_POST['end'];
    $branch_id = $_POST['branch_id'];

    $parent_gl_accounts = mysqli_query($connection, "SELECT id, name FROM `acc_gl_account` where int_id = '$sessint_id' AND parent_id = '0'");
?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Trial Balance</h4>
                    <!-- <p class="category">Category subtitle</p> -->
                </div>
                <div class="card-body">
                    <table id="trialbalance-tbl" class="table table-striped table-bordered" style="width:100%">
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

                            <?php
                            $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = '$sessint_id' AND id = '$branch_id'");
                            while ($row = mysqli_fetch_array($getParentID)) {
                                $parent_id = $row['parent_id'];
                            }

                            while($row = mysqli_fetch_array($parent_gl_accounts)) {
                                $group_total = 0;

                                $parent_gl_acc_id = $row['id'];
                                $parent_gl_acc_name = $row['name'];

                                $child_gl_accounts = mysqli_query($connection, "SELECT name, gl_code FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id = '$parent_gl_acc_id'");
                                while($row = mysqli_fetch_array($child_gl_accounts)) {
                                    $child_gl_acc_name = $row['name'];
                                    $child_gl_acc_code = $row['gl_code'];

                                    $get_opening_balance = mysqli_query($connection, "SELECT cumulative_balance_derived FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = '$child_gl_acc_code' AND (transaction_date BETWEEN '$start' AND '$end') ORDER BY `transaction_date` ASC LIMIT 1");
                                    $row = mysqli_fetch_array($get_opening_balance);
                                    $opening_balance = $row['cumulative_balance_derived'];

                                    $get_current_balance = mysqli_query($connection, "SELECT cumulative_balance_derived FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = '$child_gl_acc_code' AND (transaction_date BETWEEN '$start' AND '$end') ORDER BY `transaction_date` DESC LIMIT 1");
                                    $row = mysqli_fetch_array($get_current_balance);
                                    $current_balance = $row['cumulative_balance_derived'];

                                    if($parent_id == 0) {
                                        $get_credit_debit_movement = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM `gl_account_transaction` where int_id = '$sessint_id' and gl_code = '$child_gl_acc_code'");
                                        $row = mysqli_fetch_array($get_credit_debit_movement);
                                        $credit_movement = $row['credit'];
                                        $debit_movement = $row['debit'];

                                    } else {
                                        $get_credit_debit_movement = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM `gl_account_transaction` where int_id = '$sessint_id' AND branch_id = '$branch_id' and gl_code = '$child_gl_acc_code'");
                                        $row = mysqli_fetch_array($get_credit_debit_movement);
                                        $credit_movement = $row['credit'];
                                        $debit_movement = $row['debit'];
                                    }
                                    
                                    $group_total += $current_balance;

                            ?>
                                    <tr>
                                        <td><?php echo $child_gl_acc_code; ?></td>
                                        <td><?php echo ucfirst(strtolower($child_gl_acc_name)); ?></td>
                                        <td><?php echo strtoupper($parent_gl_acc_name); ?></td>
                                        <td><?php echo number_format($opening_balance, 2); ?></td>
                                        <td><?php echo number_format($credit_movement, 2); ?></td>
                                        <td><?php echo number_format($debit_movement, 2); ?></td>
                                        <td><b><?php echo number_format($current_balance, 2); ?></b></td>
                                    </tr>
                            <?php
                                }
                            ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo strtoupper($parent_gl_acc_name); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td>Group total</td>
                                    <td><b><?php echo number_format($group_total, 2); ?></b></td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>

                    <div class="form-group mt-4">
                        <form method="POST" action="../composer/trial_balance.php">
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

<?php
}  
?>

<script>
    $(document).ready(function() {
        var groupColumn = 2;
        var table = $('#trialbalance-tbl').DataTable({
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
        $('#trialbalance-tbl tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
                table.order([groupColumn, 'desc']).draw();
            } else {
                table.order([groupColumn, 'asc']).draw();
            }
        });
    });
</script>

