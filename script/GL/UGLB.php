<?php
include("../../functions/connect.php");
// upload GL balance from Transaction Uploaded (ORDER BY ID DESC LIMIT 1)
$query_gl_balance = mysqli_query($connection, "SELECT * FROM `gl_account_transaction` ORDER BY id, transaction_date DESC LIMIT 1");

if (mysqli_num_rows($query_gl_balance)  >  0) {
    // open a loop
    while ($row = mysqli_fetch_array($query_gl_balance)) {
        // get the balance, branch id and gl code and update
        $branch_id = $row["branch_id"];
        $gl_code  = $row["gl_code"];
        $gl_balance = $row["gl_account_balance_derived"];
        // update the balance
        $update_gl_table = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = '$gl_balance' WHERE branch_id = '$branch_id' AND gl_code = '$gl_code'");
        if ($update_gl_table) { 
            echo "Table Updated";
        } else {
            echo "Error Updating GL balance";
        }
    }
}

// make a push
?>