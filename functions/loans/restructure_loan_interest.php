<?php
include("../../functions/connect.php");
// START -- REALAID
$query_the_realaid = mysqli_query($connection, "SELECT * FROM `realaid_loan_interest_remodel`");

if (mysqli_num_rows($query_the_realaid) > 0) {
    while($q = mysqli_fetch_array($query_the_realaid)) {
        $client_id = $q["client_id"];
        $account_no = $q["account_no"];
        $interest_rate = $q["interest_rate"];
        $repayment_date = $q["repayment_date"];
        // realaid_loan_interest_remodel SHOUT
        $query_makeitup = mysqli_query($connection, "SELECT * FROM `realaid_loan_interest_remodel` WHERE interest_rate IS NULL");
        if (mysqli_num_rows($query_makeitup) > 0) {
            // realaid
            while ($yu = mysqli_fetch_array($query_makeitup)) {
                $d_c_id = $yu["client_id"];
                $query_delete_loanremodel = mysqli_query($connection, "DELETE FROM `loan_remodeling_reform` WHERE client_id = '$d_c_id'");
                if ($query_delete_loanremodel) {
                    $query_the_repaymenttable = mysqli_query($connection, "UPDATE `loan_remodeling_reform` SET interest_rate = '$interest_rate', repayment_date = '$repayment_date' WHERE int_id = '13' AND client_id = '$client_id'");
                        if ($query_the_repaymenttable) {
                          echo "Good";
                        } else {
                          echo "Bad";
                        }
                } else {
                    echo "ERROR ON DELETE";
                }
            }
        } else {
            echo "REAL AID LOAN";
        }
        // end
    }
} else {
    echo "Nothing";
}
// END -- REALAID
?>