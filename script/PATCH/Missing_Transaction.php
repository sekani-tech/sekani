<?php
include("../../functions/connect.php");
$int_id = '10';
$query_transact_cache = mysqli_query($connection, "SELECT * FROM `transact_cache` WHERE int_id = '$int_id' AND status = 'Verified' AND fixed = '0' AND transact_type = 'Deposit' OR transact_type = 'Withdrawal' ORDER BY id ASC");

if (mysqli_num_rows($query_transact_cache) > 0) {
    // now while loop all the data
    while ($qtc = mysqli_fetch_array($query_transact_cache)) {
        $uid = $qtc["id"];
        $branch_id = $qtc["branch_id"];
        $transact_id = $qtc["transact_id"];
        $description = $qtc["description"];
        $account_no = $qtc["account_no"];
        $client_id = $qtc["client_id"];
        $staff_id = $qtc["staff_id"];
        $amount = $qtc["amount"];
        $transaction_date = $qtc["date"];
        $transact_type = $qtc["transact_type"];
        if ($transact_type == "Withdrawal") {
            $transaction_type = "debit";
            $credit = "0.00";
            $debit = $amount;
        } else if ($transact_type == "Deposit") {
            $transaction_type = "credit";
            $credit = $amount;
            $debit = "";
        }
        // MAKING A POST
        $query_account_trans = mysqli_query($connection, "SELECT * FROM `account_transaction` WHERE (transaction_id != '' AND int_id = '$int_id') AND transaction_id = '$transact_id' AND client_id = '$client_id'");
        $gex = mysqli_fetch_array($query_account_trans);
        $check_trans_id = $gex["transaction_id"];
        $check_account = $gex["account_no"];
        $query_account = mysqli_query($connection, "SELECT * FROM `account` WHERE account_no = '$account_no' AND client_id = '$client_id' AND int_id = '$int_id'");
            // account table
                $qe = mysqli_fetch_array($query_account);
                    $acc_id = $qe["id"];
                    $product_id = $qe["product_id"];
                    $account_balance = $qe["account_balance_derived"];
            // qery
            if ($transact_id == $check_trans_id && $account_no == $check_account) {
                echo "...";
            } else {
                $query_account_transact = mysqli_query($connection, "INSERT INTO `account_transaction` (`id`, `int_id`, `branch_id`, `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`, `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`, `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) VALUES (NULL, '{$int_id}', '{$branch_id}', '{$product_id}', '{$acc_id}', '{$account_no}', '{$client_id}', '{$staff_id}', '{$transact_id}', '{$description}', '{$transaction_type}', '0', '{$transaction_date}', '{$amount}', '{$amount}', '{$transaction_date}', NULL, '{$account_balance}', '{$account_balance}', '{$transaction_date}', '{$staff_id}', '0', '{$debit}', '{$credit}')");
                if ($query_account_transact) {
                    $update_transaction_cache = mysqli_query($connection, "UPDATE `transact_cache` SET  fixed = '1' WHERE id = '$uid'");
                    if ($update_transaction_cache) {
                        echo "I-U";
                    } else {
                        echo "Update Problem";
                    }
                } else {
                    echo "Error Inserting";
                }
            }
            
    }
} else {
    echo "No Transaction Cache Found";
}