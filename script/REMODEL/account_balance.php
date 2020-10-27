<?php
include('../../functions/connect.php');

$query_client = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '13'");
if (mysqli_num_rows($query_client) > 0) {
    while ($qc = mysqli_fetch_array($query_client)) {
        $client_id = $qc["id"];
        $client_name = $qc["display_name"];
        $query_account = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$client_id'");
        if (mysqli_num_rows($query_account) > 0) {
            while ($acv = mysqli_fetch_array($query_account)) {
                $account_number = $acv["account_no"];
                // end it here
                $select_account_migrate = mysqli_query($connection, "SELECT * FROM `saving_balances_migration` WHERE Account_No = '$account_number' AND Client_Name = '$client_name' AND migration_status = '0' ");
                if (mysqli_num_rows($select_account_migrate) > 0) {
                    while ($sam = mysqli_fetch_array($select_account_migrate)) {
                        $migrate_id = $sam["id"];
                        $account_balance = $sam["Account_Balance_Derived"];
                        $total_withdrawal = $sam["Total_Withdrawals_Derived"];
                        $total_deposited = $sam["Total_Deposits_Derived"];
                        $check_account_no = $sam["Account_No"];

                        // update the account
                        $query_account_update = mysqli_query($connection, "UPDATE `account` SET account_balance_derived = '$account_balance', last_withdrawal = '$total_withdrawal', last_deposit = '$total_deposited' WHERE int_id = '13' AND account_no = '$check_account_no'");
                        if ($query_account_update) {
                            $update_account_mig = mysqli_query($connection, "UPDATE `saving_balances_migration` SET migration_status = '1' WHERE Account_No = '$account_number' AND Client_Name = '$client_name'");
                            if ($update_account_mig) {
                                echo "successfully updated balances";
                            } else {
                                echo "Error Updating Balances";
                            }
                        }
                    }
                } else {
                    echo "No Migration";
                }
            }
        } else {
            echo "No Account Found";
        }
    }
} else {
    echo "No Client";
}
