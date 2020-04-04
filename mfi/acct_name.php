<?php
include("../functions/connect.php");
$output = '';

if(isset($_POST["id"]) && isset($_POST["int_id"]))
{
    if($_POST["id"] !='') {
        $balancesql = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '".$_POST["id"]."' && int_id = '".$_POST["int_id"]."'");
        if (count([$balancesql]) == 1) {
            $x = mysqli_fetch_array($balancesql);
            $balance = $x['account_balance_derived'];
            $accnsql =  mysqli_query($connection, "SELECT * FROM client WHERE account_no = '".$_POST["id"]."' && int_id = '".$_POST["int_id"]."'");
            if (count([$accnsql]) == 1) {
                $z = mysqli_fetch_array($accnsql);
                $fn = $z['firstname'];
                $ln = $z['lastname'];
                $mb = $z['mobile_no'];

                // output
                while ($row = mysqli_fetch_array($accnsql))
                {
                    $output = '
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Account Balance:</label>
                        <input type="text" value="'.$balance.'" name="Acctbb" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Account Balance:</label>
                        <input type="text" value="'.$fn.'" name="Abb" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Account Balance:</label>
                        <input type="text" value="'.$ln.'" name="Abbb" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Account Balance:</label>
                        <input type="text" value="'.$mb.'" name="Abbnb" class="form-control">
                        </div>
                    </div>';
                }
                echo $output;
            }
        }

    } else {
        echo "nothing";
    }
} else {
    echo "test false";
}