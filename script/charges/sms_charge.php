<?php
// IMPORT * FILES 
include('../../functions/connect.php');

// SELECT STATEMENT FROM SMS_CHARGE TABLE - WHERE paid equals to zero
// Query to select one of each from the multiple table and sum the payment for the charges

// RUn Code Every Last day if the Month 
$current_day = date('Y-m-d');
$last_month_day = date("Y-m-t");

if ($current_day == $last_month_day) {

$sms_charge_query = mysqli_query($connection, "SELECT client_id, trans_id, account_no, int_id, branch_id, min(id) AS id FROM sms_charge WHERE paid = '0' group by client_id");	

if (mysqli_num_rows($sms_charge_query) > 0) {
    while ($row = mysqli_fetch_array($sms_charge_query)) {
        // Get Details of the SMS charge
        $client_id = $row["client_id"];
        $account_no = $row["account_no"];
        $trans_id = $row["trans_id"];
        $int_id = $row["int_id"];
        $branch_id = $row["branch_id"];
        $gen_date = date('Y-m-d H:i:s');
        
        // sum all the data for each clients
        $query_sum_paid = mysqli_query($connection, "SELECT SUM(amount) AS total_charge_amount FROM sms_charge WHERE client_id = '$client_id' AND paid = '0' AND int_id = '$int_id'");
        // get the total amount
        $tota = mysqli_fetch_array($query_sum_paid);
        $total_charge_amount = $tota["total_charge_amount"];

        // Query the client Account Table to get information
        $query_client_account = mysqli_query($connection, "SELECT * FROM `account` WHERE account_no = '$account_no' AND client_id = '$client_id' AND int_id = '$int_id'");
        // get client account details
        if (mysqli_num_rows($query_client_account) == 1) {
            // Making Next move
        $gcad = mysqli_fetch_array($query_client_account);
        $account_id = $gcad["id"];
        $last_withdrawal = $gcad["last_withdrawal"] + $total_charge_amount;
        $account_balance_derived = $gcad["account_balance_derived"];
        $new_account_balance = $account_balance_derived - $total_charge_amount;

        // Update the Client Account
        $update_client_account = mysqli_query($connection, "UPDATE account SET last_withdrawal = '$last_withdrawal', account_balance_derived = '$new_account_balance' WHERE id = '$account_id'");
        
        // Update Account transaction
        if ($update_client_account) {

            // Insert into the Transaction
            $query_insert_account_transaction = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
            `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
            `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
            `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
            `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
            VALUES ('{$int_id}', '{$branch_id}', '0', '{$account_id}', '{$account_no}', '{$client_id}', '0', '{$trans_id}',
            'SMS CHARGE', 'SMS CHARGE', '0', '{$gen_date}', '{$total_charge_amount}', '{$total_charge_amount}',
            '{$gen_date}', '0', '{$new_account_balance}',
            '{$new_account_balance}', '{$gen_date}', '0', '0', '{$total_charge_amount}', '0.00')");
            // if successful
            if ($query_insert_account_transaction) {
                // Update SMS CHARGE TABLE, SET PAID TO 1  
                $query_update_sms_charge = mysqli_query($connection, "UPDATE sms_charge SET paid = '1' WHERE client_id = '$client_id' AND int_id = '$int_id'");

                // Output Success
                if ($query_update_sms_charge) {
                    echo "Successfully Charged for SMS";
                } else {
                    echo "A problem Occured during Update for SMS charge and client has been debited".$client_id;
                }
            } else {
                echo "A problem Occured during Insertion of Date to Account Transaction = ".$client_id;
            }
        } else {
            echo "A problem Occured during an Account Update at = ".$client_id;
        }
        } else {
            echo "No Account Found for Id ".$client_id;
        }
        

    }
} else {
    echo "NO SMS CHARGE";
}

} else {
    echo "END OF MONTH IS ON ".$last_month_day;
}
?>