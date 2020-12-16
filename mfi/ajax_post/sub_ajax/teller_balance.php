<?php
include("../../../functions/connect.php");
$output = '';
session_start();

// we are gonna post to get the name of the button
if (isset($_POST['id'])) {
    $name = $_POST['id'];
    $int_id = $_SESSION['int_id'];
    $branchId = $_SESSION['branch_id'];
    $queCondition = [
        'int_id' => $int_id,
        'branch_id' => $branchId,
        'teller_id' => $name
    ];
    $que = selectOne('institution_account', $queCondition);
    $balance = $que['account_balance_derived'];

    if ($balance) { ?>
        <div class="form-group">
            <label>Account Balance:</label>
            <input type="text" value="<?php echo $balance ?>" name="principal_amoun" class="form-control" readonly
                   required
                   id="principal_amount">
        </div>
        <?php
    }
} else if (isset($_POST['ib'])) {
    $name = $_POST['ib'];
    $int_id = $_SESSION['int_id'];
    $branchId = $_SESSION['branch_id'];
    $queCondition = [
        'gl_code' => $name,
        'int_id' => $int_id,
        'branch_id' => $branchId];
    $que = selectOne('acc_gl_account', $queCondition);
    $balance = $que['organization_running_balance_derived'];

    if ($balance) { ?>
        <div class="form-group">
            <label>Account Balance:</label>
            <input type="text" value="<?php echo number_format($balance, 2) ?>" name="principal_amoun"
                   class="form-control"
                   readonly required id="principal_amount">
        </div>
        <?php
    }
}
?>