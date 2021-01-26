<?php
// ALgorithm
// Select all loan where outstanding loan balance is greater than zero
// sum all balances in repayment schedule with loan id where installment is 1
//  sum all balances in loan arrears with loan id where installment is 1.
// add balances together and update loan table

include('../functions/connect.php');
// col name total_outstanding_derived
// Select all loan where outstanding loan balance is greater than zero
$query_loan_table = mysqli_query($connection, "SELECT * FROM `loan`");
if (mysqli_num_rows($query_loan_table) > 0) {
    while ($row = mysqli_fetch_array($query_loan_table)) {
        $loan_id = $row["id"];
// sum all balances in repayment schedule with loan id where installment is 1
        $query_sum_loan_repayment_sch = mysqli_query($connection, "SELECT SUM(principal_amount + interest_amount) AS total_loan_sch FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND installment = '1'");
        $rowx = mysqli_fetch_array($query_sum_loan_repayment_sch);
        $outstanding_loan_repayment_sch = $rowx["total_loan_sch"];
//  sum all balances in loan arrears with loan id where installment is 1.
        $query_sum_loan_arrears = mysqli_query($connection, "SELECT SUM(principal_amount + interest_amount) AS total_loan_arr FROM `loan_arrear` WHERE loan_id = '$loan_id' AND installment = '1'");
        $rowy = mysqli_fetch_array($query_sum_loan_arrears);
        $outstanding_loan_arrears = $rowy["total_loan_arr"];
// add balances together and update loan table
        $total_outstanding_derived = $outstanding_loan_repayment_sch + $outstanding_loan_arrears;

        $query_update_loan_table = mysqli_query($connection, "UPDATE `loan` SET total_outstanding_derived = '$total_outstanding_derived' WHERE id = '$loan_id'");

        if ($query_update_loan_table) {
            echo "Successfully Updated Balance";
        } else {
            echo "Error Updating Balance";
        }
    }
} else {
    echo "No Loan Outstanding Found";
}
?>