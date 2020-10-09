<?php
include("../../functions/connect.php");

$query_remodel = mysqli_query($connection, "SELECT * FROM `client_remodel` WHERE remodel_status = '1' ORDER BY `new_client_id` ASC");
if (mysqli_num_rows($query_remodel) > 0) {
    while ($row = mysqli_fetch_array($query_remodel)) {
        $id = $row["id"];
        $branch_id = $row["branch_id"];
        $staff_id = $row["loan_officer_id"];
        $new_client_id = $row["new_client_id"];
        $old_client_id = $row["id"];
        // end update
        $query_account_done = mysqli_query($connection, "SELECT * FROM `account_remodel` WHERE client_id = '$old_client_id'");
        
       
        if (mysqli_num_rows($query_account_done) > 0) {
            while($mx = mysqli_fetch_array($query_account_done)) {
                $account_id = $mx["id"];
                $account_number = $mx["account_no"];
                $product_id = $mx["product_id"];
                $accoount_balance = $mx["account_balance_derived"];
                // move
                $query_account_transact = mysqli_query($connection, "SELECT * FROM `account_transaction_remodel` WHERE account_no = '$account_number'");
                if (mysqli_num_rows($query_account_transact) > 0) {
                    $query_update_account = mysqli_query($connection, "UPDATE `account_transaction_remodel` SET branch_id = '$branch_id', product_id = '$product_id', account_id = '$account_id', new_client_id = '$new_client_id', teller_id = '$staff_id', appuser_id = '$staff_id', running_balance_derived = '$accoount_balance' WHERE client_id = '$old_client_id' AND account_no = '$account_number'");
                    if ($query_update_account) {
                        $query_client_insertupdate = mysqli_query($connection, "UPDATE `client_remodel` SET remodel_status = '2' WHERE id = '$old_client_id'");
                     if ($query_client_insertupdate) {
                        echo "DONE".$old_client_id." ";
                     } else {
                        echo "ERROR";
                     }
                    } else {
                      echo "BAD UPDATE";
                    }
                } else {
                    echo "..";
                }
            }
        } else {
            echo "NO ACCOUNT DATA";
        }
        
        // query_update
        
    }
} else {
    echo "NO DATA";
    $query_account = mysqli_query($connection, "SELECT * FROM  `account_transaction` WHERE int_id = '13'");
      if (mysqli_num_rows($query_account) > 0) {
          while ($io = mysqli_fetch_array($query_account)) {
              $account_number = $io["account_no"];
              $account_id = $io["id"];
              $client_id = $io["client_id"];
            //   make a query
            $query_transaction = mysqli_query($connection, "SELECT * FROM `account_transaction` WHERE (int_id = '13' AND account_no = '$account_number') AND client_id = '$client_id'"); 
                if (mysqli_num_rows($query_transaction) > 0) {
                    $update_transaction_id = mysqli_query($connection, "UPDATE `account_transaction` SET account_id = '$account_id' WHERE account_no = '$account_number' AND int_id = '13' AND client_id = '$client_id'");
                    if ($update_transaction_id) {
                        echo "DONE";
                    } else {
                        echo "---";
                    }
                } else {
                    "...";
                }
          }
    } else {
        echo "NO";
    }
   }
?>