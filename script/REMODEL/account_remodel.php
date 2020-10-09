<?php
include("../../functions/connect.php");

$query_remodel = mysqli_query($connection, "SELECT * FROM `client_remodel` WHERE remodel_status = '0' ORDER BY `new_client_id` ASC");
if (mysqli_num_rows($query_remodel) > 0) {
    while ($row = mysqli_fetch_array($query_remodel)) {
        $id = $row["id"];
        $branch_id = $row["branch_id"];
        $staff_id = $row["loan_officer_id"];
        $new_client_id = $row["new_client_id"];
        $old_client_id = $row["id"];
        // query
        $query_update_account = mysqli_query($connection, "UPDATE `account_remodel` SET branch_id = '$branch_id', field_officer_id = '$staff_id', new_client_id = '$new_client_id' WHERE client_id = '$old_client_id'");
        if ($query_update_account) {
            $query_client_insertupdate = mysqli_query($connection, "UPDATE `client_remodel` SET remodel_status = '1' WHERE id = '$old_client_id'");
            if ($query_client_insertupdate) {
                echo "DONE WITH CLIENT".$old_client_id;
            } else {
                echo "ERROR";
            }
        } else {
            echo "BAD UPDATE";
        }
    }
} else {
    echo "NO DATA";
}
?>