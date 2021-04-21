<?php
include("../connect.php");
session_start();
$sessuser_id = $_SESSION['user_id'];
$sessint_id = $_SESSION['int_id'];
$sessbranch_id = $_SESSION['branch_id'];

$getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $sessbranch_id");
$parent_id = mysqli_fetch_array($getParentID)['parent_id'];
                        
$terminationDate = date('Y-m-d');

if(isset($_POST['ftd_id'])) {
    $ftd_id = $_POST['ftd_id'];
    $getMaturityDate = mysqli_query($connection, "SELECT maturity_date FROM `ftd_interest_schedule` WHERE int_id = {$sessint_id} AND ftd_id = {$ftd_id} ORDER BY maturity_date DESC LIMIT 1");
    $maturityDate = mysqli_fetch_array($getMaturityDate)['maturity_date'];

    $getFTDInfo = mysqli_query($connection, "SELECT ftd_no, account_balance_derived, linked_savings_account, product_id FROM `ftd_booking_account` WHERE int_id = {$sessint_id} AND id = {$ftd_id}");
    $FTDInfo = mysqli_fetch_array($getFTDInfo);
    $ftdNo = $FTDInfo['ftd_no'];
    $principal = $FTDInfo['account_balance_derived'];
    $savingsAccount = $FTDInfo['linked_savings_account'];
    $savingsProductID = $FTDInfo['product_id'];

    $getAccountInfo = mysqli_query($connection, "SELECT id, client_id, account_balance_derived FROM `account` WHERE int_id = {$sessint_id} AND account_no = {$savingsAccount}");
    $accountInfo = mysqli_fetch_array($getAccountInfo);
    $accountID = $accountInfo['id'];
    $clientID = $accountInfo['client_id'];
    $currentAccountBalance = $accountInfo['account_balance_derived'];

    $newAccountBalance = $currentAccountBalance + $principal;
    $updateAccountBalance = mysqli_query($connection, "UPDATE `account` SET account_balance_derived = {$newAccountBalance}, last_deposit = {$principal} WHERE account_no = {$savingsAccount}");

    if($updateAccountBalance) {
        // insert client ftd_termination_principal record into `account_transaction` table
        $newAccountTransactionData = [
            'int_id' => $sessint_id,
            'branch_id' => $sessbranch_id,
            'product_id' => $savingsProductID,
            'account_id' => $accountID,
            'account_no' => $savingsAccount,
            'client_id' => $clientID,
            'teller_id' => '',
            'transaction_id' => $ftdNo,
            'description' => 'FTD_Termination_Principal',
            'transaction_type' => 'flat_charge',
            'is_reversed' => 0,
            'transaction_date' => date('Y-m-d'),
            'amount' => $principal,
            'overdraft_amount_derived' => '',
            'balance_end_date_derived' => '',
            'balance_number_of_days_derived' => '',
            'running_balance_derived' => $newAccountBalance,
            'cumulative_balance_derived' => $newAccountBalance,
            'created_date' => date('Y-m-d H:i:s'),
            'chooseDate' => '',
            'appuser_id' => $sessuser_id,
            'manually_adjusted_or_reversed' => 0,
            'credit' => $principal
        ];
        
        $insertAccountTransaction = insert('account_transaction', $newAccountTransactionData);

        if($insertAccountTransaction) {
            
            if($terminationDate < $maturityDate) {
                // check if there is a termination charge
                $getChargeID = mysqli_query($connection, "SELECT charge_id FROM `savings_product_charge` WHERE int_id = {$sessint_id} AND savings_id = {$savingsProductID}");
                $chargeID = mysqli_fetch_array($getChargeID)['charge_id'];
        
                if(!empty($chargeID)) {
                    $getChargeInfo = mysqli_query($connection, "SELECT amount, gl_code FROM `charge` WHERE int_id = {$sessint_id} AND id = {$chargeID}");
                    $chargeInfo = mysqli_fetch_array($getChargeInfo);
                    $chargeAmount = $chargeInfo['amount'];
                    $GLCode = $chargeInfo['gl_code'];
        
                    // deduct charge from customers account balance
                    $getAccountInfo = mysqli_query($connection, "SELECT account_balance_derived FROM `account` WHERE int_id = {$sessint_id} AND account_no = {$savingsAccount}");
                    $accountInfo = mysqli_fetch_array($getAccountInfo);
                    $currentAccountBalance = $accountInfo['account_balance_derived'];
        
                    $newAccountBalance = $currentAccountBalance - $chargeAmount;
                    $updateAccountBalance = mysqli_query($connection, "UPDATE `account` SET account_balance_derived = {$newAccountBalance}, last_withdrawal = {$chargeAmount} WHERE account_no = {$savingsAccount}");
        
                    if($updateAccountBalance) {
                        // insert client ftd_termination_charge record into `account_transaction` table
                        $newAccountTransactionData = [
                            'int_id' => $sessint_id,
                            'branch_id' => $sessbranch_id,
                            'product_id' => $savingsProductID,
                            'account_id' => $accountID,
                            'account_no' => $savingsAccount,
                            'client_id' => $clientID,
                            'teller_id' => '',
                            'transaction_id' => $ftdNo,
                            'description' => 'FTD_Termination_Charge',
                            'transaction_type' => 'flat_charge',
                            'is_reversed' => 0,
                            'transaction_date' => date('Y-m-d'),
                            'amount' => $chargeAmount,
                            'overdraft_amount_derived' => '',
                            'balance_end_date_derived' => '',
                            'balance_number_of_days_derived' => '',
                            'running_balance_derived' => $newAccountBalance,
                            'cumulative_balance_derived' => $newAccountBalance,
                            'created_date' => date('Y-m-d H:i:s'),
                            'chooseDate' => '',
                            'appuser_id' => $sessuser_id,
                            'manually_adjusted_or_reversed' => 0,
                            'debit' => $chargeAmount
                        ];
                        
                        $insertAccountTransaction = insert('account_transaction', $newAccountTransactionData);
        
                        if($insertAccountTransaction) {
        
                            if(!empty($GLCode)) {
                                // add charge to 'organization_running_balance_derived' for the selected 'gl_code' in the `acc_gl_account` table
                                $getOrganizationRunningBalance = mysqli_query($connection, "SELECT organization_running_balance_derived FROM `acc_gl_account` WHERE int_id = {$sessint_id} AND gl_code = {$GLCode}");
                                $currentOrganizationRunningBalance = mysqli_fetch_array($getOrganizationRunningBalance)['organization_running_balance_derived'];
                
                                $newOrganizationRunningBalance = $currentOrganizationRunningBalance + $chargeAmount;
                                $updateOrganizationRunningBalance = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = {$newOrganizationRunningBalance} WHERE int_id = {$sessint_id} AND gl_code = {$GLCode}");
                
                                if($updateOrganizationRunningBalance) {
                                    // insert GL transaction record into the `gl_account_transaction` table
                                    $newGLAccountTransactionData = [
                                        'int_id' => $sessint_id,
                                        'branch_id' => $sessbranch_id,
                                        'gl_code' => $GLCode,
                                        'parent_id' => $parent_id,
                                        'transaction_id' => '',
                                        'description' => 'FTD_Termination_Charge',
                                        'transaction_type' => 'flat_charge',
                                        'teller_id' => '',
                                        'is_reversed' => 0,
                                        'transaction_date' => date('Y-m-d'),
                                        'amount' => $chargeAmount,
                                        'gl_account_balance_derived' => $newOrganizationRunningBalance,
                                        'branch_balance_derived' => '',
                                        'overdraft_amount_derived' => '',
                                        'balance_end_date_derived' => date('Y-m-d'),
                                        'balance_number_of_days_derived' => '',
                                        'cumulative_balance_derived' => $newOrganizationRunningBalance,
                                        'created_date' => date('Y-m-d H:i:s'),
                                        'manually_adjusted_or_reversed' => 0,
                                        'credit' => $chargeAmount
                                    ];
                                    
                                    $insertGLAccountTransaction = insert('gl_account_transaction', $newGLAccountTransactionData);
                
                                    if($insertGLAccountTransaction) {
                                        // 'is_paid' value is updated to 2 in the `ftd_booking_account` table to indicate that the FTD is terminated
                                        $updateFTD = mysqli_query($connection, "UPDATE `ftd_booking_account` SET is_paid = '2' WHERE id = {$ftd_id}");
                
                                        if($updateFTD) {
                                            echo header("Location: ../../mfi/ftd_schedule.php?id=$ftd_id");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}