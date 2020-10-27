<?php
include("../../functions/connect.php");

$query_basic_m = mysqli_query($connection, "SELECT * FROM `savings_transactions_migrate` WHERE migration_status = '0'");
if (mysqli_num_rows($query_basic_m) > 0) {
    while ($m = mysqli_fetch_array($query_basic_m)) {
        $int_id = '13';
        $account_no = $m["Account_Number"];
        $transaction_type = $m["Transaction_Type"];
        if ($transaction_type == "deposit") {
            $transaction_type = "credit";
        } else {
            $transaction_type = "debit";
        }
        $deposit = $m["Deposit"];
        $withdrawal = $m["Withdrawal"];
        $ref = $m["Reference"];
        $transaction_date = $m["Effective_Date"];
        // make move
        $query_account_table = mysqli_query($connection, "SELECT * FROM `account` WHERE account_no = '$account_no' AND int_id = '13'");
        if (mysqli_num_rows($query_account_table) > 0) {
            $ac = mysqli_fetch_array($query_account_table);

            $branch_id = $ac["branch_id"];
            $product_id = $ac["product_id"];
            $account_id = $ac["id"];
            $client_id = $ac["client_id"];
            $field_officer_id = $ac["field_officer_id"];
            $description = $ref;
            $account_balance = $ac["account_balance_derived"];
    $amount = $deposit + $withdrawal;
    
    // query account
    $query_account_transact = mysqli_query($connection, "INSERT INTO `account_transaction` (`id`, `int_id`, `branch_id`, `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`, `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`, `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) VALUES (NULL, '13', '{$branch_id}', '{$product_id}', '{$account_id}', '{$account_no}', '{$client_id}', NULL, '{$ref}', '{$description}', '{$transaction_type}', '0', '{$transaction_date}', '{$amount}', '{$amount}', '{$transaction_date}', NULL, '{$account_balance}', '{$account_balance}', '{$transaction_date}', '{$field_officer_id}', '0', '{$withdrawal}', '{$deposit}')");
    if ($query_account_transact) {
        $update_account_migrate = mysqli_query($connection, "UPDATE `savings_transactions_migrate` SET migration_status = '1' WHERE int_id = '13' AND account_no = '$account_no'");
        if ($update_account_migrate) {
            echo "DONE";
        } else {
            echo "....";
        }
    } else {
        echo "Error Inserting";
    }
        }   else {
            echo "Cant Find Account";
        }    
    }
} else {
    echo "No Transaction";
}