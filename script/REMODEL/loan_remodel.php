<?php
include("../../functions/connect.php");
// start
$query_migrate = mysqli_query($connection, "SELECT * FROM `clients_branch_migrate` WHERE (int_id = '13' AND outstanding_principal > 0) AND migration_status = 0");
if (mysqli_num_rows($query_migrate) > 0) {
    while($qm = mysqli_fetch_array($query_migrate)) {
        // DISPLAY DATA IN ARRAY
        $id = $qm["id"];
        $int_id = $qm["int_id"];
        $old_client_id = $qm["client_id"];
        $old_product = $qm["product"];
        // we query product by short name
        $query_loan_product = mysqli_query($connection, "SELECT * FROM `product` WHERE int_id = '13' AND short_name = '$old_product' ORDER BY id ASC LIMIT 1");
        if (mysqli_num_rows($query_loan_product) > 0) {
            $xc = mysqli_fetch_array($query_loan_product);
            $loan_product_id = $xc["id"];
        } else {
            $loan_product_id = "60";
        }
        // new product query
        $outstanding_principal = $qm["outstanding_principal"];
        $outstanding_interest = $qm["outstanding_interest"];
        $repaid = $qm["repaid"];
        $outstanding_loan_balance = $qm["outstanding_loan_balance"];
        // END DISPLAY
        $query_loan_balance_migrate = mysqli_query($connection, "SELECT * FROM `outstanding_report_migrate` WHERE client_id = '$old_client_id' AND migration_status = 0");
        if (mysqli_num_rows($query_loan_balance_migrate) > 0) {
            while ($qlbm = mysqli_fetch_array($query_loan_balance_migrate)) {
                $lid = $qlbm["id"];
                $loan_principal = $qlbm["loan_principal"];
                $loan_interest = $qlbm["interest_at_disbursement"];
                $interest_percentage = (($loan_interest/$loan_principal) * 100);
                $disbursed_date = $qlbm["disbursed"];
                $loan_term = $qlbm["installments"];
                $repay_every = $qlbm["periods"];
                // if its weekly divide loan by 4
                if ($repay_every == 'week' || $repay_every == 'weekly') {
                    $total_outstanding = (($loan_interest / 4) + ($loan_principal / $loan_term)) * $loan_term;
                    $loan_repaid = $total_outstanding - $outstanding_loan_balance;
                } else if ($repay_every == 'month' || $repay_every == 'monthly')
                {
                    $total_outstanding = (($loan_interest / 1) + ($loan_principal / $loan_term)) * $loan_term;
                    $loan_repaid = $total_outstanding - $outstanding_loan_balance;
                } else if ($repay_every == 'day' || $repay_every == 'daily') {
                    $total_outstanding = (($loan_interest / 28) + ($loan_principal / $loan_term)) * $loan_term;
                    $loan_repaid = $total_outstanding - $outstanding_loan_balance;
                }
                $maturity_date = $qlbm["maturity_date"];
                $arrear_amount = $qlbm["arrear_amount"];
                // next
                $loan_purpose = $qlbm["loan_purpose"];
                // query the account number, loan officer and product.
                $query_client = mysqli_query($connection, "SELECT * FROM `client` WHERE account_no = '$old_client_id' AND int_id = '13' ORDER BY id ASC LIMIT 1");
                $qa = mysqli_fetch_array($query_client);
                $new_client_id = $qa["id"];
                $loan_officer = $qa["loan_officer_id"];
                // NEXT IS GET ACCOUNT AND UPLOAD THE BATCH
                $query_account_number_one = mysqli_query($connection, "SELECT * FROM `account` WHERE client_id = '$new_client_id' AND int_id = '13' ORDER BY id ASC LIMIT 1");
                $mcxs = mysqli_fetch_array($query_account_number_one);
                $account_number = $mcxs["account_no"];


                // new insert into test account;
                $query_reform_table = mysqli_query($connection, "INSERT INTO `loan_remodeling_reform` (`id`, `int_id`, `client_id`, `account_no`, `loan_id`, `product_id`, `loan_officer`, `loan_puporse`, `principal_amount`, `loan_term`, `interest_rate`, `repay_every`, `repayment_date`, `maturedon_date`, `disbursement_date`, `no_of_repayments`, `amount_paid`, `arrear_amount`, `loan_status`, `status`) VALUES (NULL, '13', '{$new_client_id}', '{$account_number}', '0', '{$loan_product_id}', '{$loan_officer}', '{$loan_purpose}', '{$loan_principal}', '{$loan_term}', '{$interest_percentage}', '{$repay_every}', '{$disbursed_date}', '{$maturity_date}', '{$disbursed_date}', '1', '{$loan_repaid}', '{$arrear_amount}', 'x', '0')");

                if ($query_reform_table) {
                    $query_clients_branch_migrate = mysqli_query($connection, "UPDATE clients_branch_migrate SET migration_status = '1' WHERE int_id = '13' AND id = '$id'");
                    if ($query_clients_branch_migrate) {
                        $query_outstanding_report_migrate = mysqli_query($connection, "UPDATE `outstanding_report_migrate` SET migration_status = '1' WHERE int_id = '13' AND id = '$lid'");
                        if ($query_outstanding_report_migrate) {
                            echo "SUCCESS";
                        } else {
                            echo "EROR AT Outreport migrate";
                        }
                    } else {
                        echo "ERROR updating branch migrate";
                    }
                } else {
                    echo "Error";
                }
            }
            // Move to the next
        } else {
            echo "NO DATA LOAN BALANACE MIGRATE";
        }
        // THINGS TO GET
        // 1. Account Number, 2. Loan Product id, 3. Loan officer -- check, 4. new client id -- check
    }
} else {
    echo "NO Data";
}
// end 
?>