<?php
include("../../functions/connect.php");

if (isset($_POST['type'])) {

//    getting vault balance and displaying
    if ($_POST['type'] === 'vault') {
        $state = $_POST['id'];
        $int = $_POST['int'];
        $stateg = selectOne('int_vault', ['int_id' => $int, 'branch_id' => $state]);
        $balance = $stateg['balance'];
        if ($balance) { ?>
            <div class="form-group">
                <label class="bmd-label-floating">Current Vault Balance</label>
                <!-- populate available balance -->
                <input type="text" value="<?php echo $balance ?>" name="balance" class="form-control" readonly>
            </div>
            <?php
        }
    }
//    getting bank balance and displaying
    else if ($_POST['type'] === 'bank') {
        $state = $_POST['id'];
        $int = $_POST['int'];
        $stateg = selectOne('int_vault', ['int_id' => $int, 'branch_id' => $state]);
        $balance = $stateg['balance'];
        if ($balance) { ?>
            <div class="form-group">
                <label class="bmd-label-floating">Current Vault Balance</label>
                <!-- populate available balance -->
                <input type="text" value="<?php echo $balance ?>" name="balance" class="form-control" readonly>
            </div>
            <?php
        }
    }

} else {
    echo 'ID not posted';
}
?>