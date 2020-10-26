<?php
include("../../functions/connect.php");
// START -- REALAID
$query_the_realaid = mysqli_query($connection, "SELECT * FROM `realaid_loan_interest_remodel` WHERE `status` = '5'");

if (mysqli_num_rows($query_the_realaid) > 0) {
    while($q = mysqli_fetch_array($query_the_realaid)) {
        $qid = $q["id"];
        $client_id = $q["client_id"];
        // $account_no = $q["account_no"];
        // $interest_rate = $q["interest_rate"];
        // $repayment_date = $q["repayment_date"];
        // realaid_loan_interest_remodel SHOUT
        //     // realaid
                $query_delete_loanremodel = mysqli_query($connection, "DELETE FROM `loan_remodeling_reform` WHERE client_id = '$client_id'");
                if ($query_delete_loanremodel) {
                    echo "...";
                    $query_update_realaid = mysqli_query($connection, "UPDATE `realaid_loan_interest_remodel` SET `status` = '9' WHERE id = '$qid'");
                } else {
                    echo "ERROR ON DELETE";
                }
        // end
        // $query_the_repaymenttable = mysqli_query($connection, "UPDATE `loan_remodeling_reform` SET interest_rate = '$interest_rate', repayment_date = '$repayment_date', status = '1' WHERE int_id = '13' AND client_id = '$client_id'");
        //                 if ($query_the_repaymenttable) {
        //                   echo "Good";
        //                   $query_update_realaid = mysqli_query($connection, "UPDATE `realaid_loan_interest_remodel` SET `status` = '1' WHERE id = '$qid'");
        //                 } else {
        //                   echo "Bad";
        //                 }
    }
} else {
    echo "Nothing";
}
// END -- REALAID
?>