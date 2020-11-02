<?php
include("../../functions/connect.php");
$int_id = '13';

$query_client_ln = mysqli_query($connection, "SELECT * FROM `outstanding_loans` WHERE int_id = '$int_id'");

if (mysqli_num_rows($query_client_ln) > 0)  {
    while ($rx = mysqli_fetch_array($query_client_ln)) {
        $l_id = $rx["id"];
        $new_client_id = $rx["client_id"];
        // next
        $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE client_id = '$new_client_id' AND int_id = '$int_id'");
        if (mysqli_num_rows($query_loan) > 0) {
            while ($uq = mysqli_fetch_array($query_loan)) {
                $loan_id = $uq["id"];
                $total = $uq["principal_amount"];
                // put
                    $update_disbursment_cache = mysqli_query($connection, "UPDATE `loan_disbursement_cache` SET principal_amount_proposed = '$total', principal_amount = '$total', approved_principal = '$total' WHERE client_id = '$new_client_id' AND int_id = '$int_id'");
                    if ($update_disbursment_cache) {
                        echo "CAHCE";
                    } else {
                        echo "///g";
                    }
            }
        } else {
            echo "NOT RUNNING LOAN";
        }
    }
} else {
    echo "NOT RUNNING";
}