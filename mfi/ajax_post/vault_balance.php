<?php
include("../../functions/connect.php");

if(isset($_POST['id'])){
    $state = $_POST['id'];
    $int = $_POST['int'];
            $stateg = "SELECT * FROM int_vault WHERE branch_id = '$state' AND int_id = '$int'";
            $state1 = mysqli_query($connection, $stateg);
            $bal = mysqli_fetch_array($state1);
            $balance = $bal['balance'];
            $out = '';
            $out .= '
            <div class="form-group">
            <label class="bmd-label-floating">Current Balance</label>
            <!-- populate available balance -->
            <input type="text" value="'.$balance.'" name="balance" id="" class="form-control" readonly>
            </div>';
            echo $out;
    }
    else {
        echo 'ID not posted';
    }
?>