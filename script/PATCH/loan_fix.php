<?php
include("../../functions/connect.php");
$int_id = '13';

$query_loan_migrate = mysqli_query($connection, "SELECT * FROM `outstanding_report_migrate` WHERE migration_status = '1'");
if (mysqli_num_rows($query_loan_migrate)) {
    while($qlm = mysqli_fetch_array($query_loan_migrate)) {
        // no principal loan
        $mid = $qlm["id"];
        $old_client_id = $qlm["client_id"];
        $interest = $qlm["interest"];
        $installments = $qlm["installments"];
        $outstanding_principal = $qlm["outstanding_principal"];
        // NEXT MOVE
        $query_client = mysqli_query($connection, "SELECT * FROM `client` WHERE account_no = '$old_client_id' AND int_id = '$int_id'");
        if ($query_client) {
            $qc = mysqli_fetch_array($query_client);
            $client_id = $qc["id"];
            // calculate the installment
            $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE client_id = '$client_id' AND int_id = '$int_id'");
            if ($query_loan) {
                $ql = mysqli_fetch_array($query_loan);
                $loan_id = $ql["id"];
                // calculate the loan int and prin
                $new_principal = $outstanding_principal / $installments;
                $new_interest = $interest / $installments;
                // update
                $update_loan_repayment = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET installment = '1', principal_amount = '$new_principal', interest_amount = '$new_interest' WHERE loan_id = '$loan_id' AND int_id = '$int_id'");
                if ($update_loan_repayment) {
                    $update_migrate = mysqli_query($connection, "UPDATE `outstanding_report_migrate` SET  migration_status = '2' WHERE id = '$mid'");
                    if ($update_migrate) {
                        echo "...";
                    } else {
                        echo "BAD UPDATE";
                    }
                } else {
                    echo "Wrong Repayment query";
                }
            } else {
                echo "BAD LOAN QUERY";
            }
        } else {
            echo "BAD CLIENT QUERY";
        }
       
        
    }
} else {
    echo "NO MIGRATION";
}