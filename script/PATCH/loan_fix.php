<?php
include("../../functions/connect.php");
$int_id = '13';

$query_loan_migrate = mysqli_query($connection, "SELECT * FROM `outstanding_report_migrate` WHERE migration_status = '3'");
if (mysqli_num_rows($query_loan_migrate)) {
    while($qlm = mysqli_fetch_array($query_loan_migrate)) {
        // no principal loan
        $mid = $qlm["id"];
        $old_client_id = $qlm["client_id"];
        $interest = $qlm["interest"];
        // $installments = $qlm["installments"];
        // NEXT MOVE
        $query_client = mysqli_query($connection, "SELECT * FROM `client` WHERE account_no = '$old_client_id' AND int_id = '$int_id'");
        if ($query_client) {
            $qc = mysqli_fetch_array($query_client);
            $client_id = $qc["id"];
            // calculate the installment
            $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE client_id = '$client_id' AND int_id = '$int_id'");
            if (mysqli_num_rows($query_loan) > 0) {
                while ($ql = mysqli_fetch_array($query_loan)) {
                $loan_id = $ql["id"];
                $approved_principal = $ql["approved_principal"];
                // calculate the loan int and prin
                // update
                $query_get_Repayment = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND int_id = '$int_id'");
                $get_com_inst = mysqli_num_rows($query_get_Repayment);
                $new_principal = ($approved_principal / $get_com_inst);
                $new_interest = $interest / $get_com_inst;
                $update_loan_repayment = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET installment = '1', principal_amount = '$new_principal', interest_amount = '$new_interest' WHERE loan_id = '$loan_id' AND int_id = '$int_id'");
                if ($update_loan_repayment) {
                    $update_migrate = mysqli_query($connection, "UPDATE `outstanding_report_migrate` SET  migration_status = '2' WHERE id = '$mid'");
                    if ($update_migrate) {
                        echo "...";
                $query_get_PM = mysqli_query($connection, "SELECT SUM(principal_amount) AS p_m FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND int_id = '$int_id' AND installment = '1'");
                $query_get_IM = mysqli_query($connection, "SELECT SUM(interest_amount) AS a_m FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND int_id = '$int_id' AND installment = '1'");
                $poi = mysqli_fetch_array($query_get_PM);
                $poi2 = mysqli_fetch_array($query_get_IM);
                $out_p = $poi["p_m"];
                $out_i = $poi2["i_m"];
                $out_loan_bal = $out_p + $out_i;
                        $update_loan_balance = mysqli_query($connection, "UPDATE `loan` SET total_outstanding_derived = '$out_loan_bal' WHERE id = '$loan_id' AND int_id = '$int_id'");
                        if ($update_loan_balance) {
                            echo 'bal'.$out_loan_bal;
                        } else {
                            echo "90";
                        }
                    } else {
                        echo "BAD UPDATE";
                    }
                } else {
                    echo "Wrong Repayment query";
                }
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