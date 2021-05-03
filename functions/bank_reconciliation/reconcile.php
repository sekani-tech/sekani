<?php
include("../connect.php");
session_start();
$sessint_id = $_SESSION['int_id'];
$sessbranch_id = $_SESSION['branch_id'];
$sessuser_id = $_SESSION['user_id'];

if(isset($_POST['btnBankReconciliation'])) {
    $gl_code = $_POST['gl_code'];
    $getBank = mysqli_query($connection, "SELECT name FROM `acc_gl_account` WHERE int_id = {$sessint_id} AND gl_code = {$gl_code}");
    $bank = mysqli_fetch_array($getBank)['name'];

    $getSystemAmount = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM `gl_account_transaction` WHERE int_id = {$sessint_id} and gl_code = {$gl_code}");
    $getSystemAmount = mysqli_fetch_array($getSystemAmount);
    $total_credit = $getSystemAmount['credit'];
    $total_debit = $getSystemAmount['debit'];
    $system_amount = $total_credit - $total_debit;

    $bank_amount = $_POST['bank_amount'];

    $getStaff = mysqli_query($connection, "SELECT display_name FROM `staff` WHERE int_id = {$sessint_id} AND user_id = {$sessuser_id}");
    $staff = mysqli_fetch_array($getStaff)['display_name'];
    
    $bankReconciliationData = [
        'int_id' => $sessint_id, 
        'branch_id' => $sessbranch_id, 
        'bank' => $bank,
        'system_amount' => $system_amount,
        'bank_amount' => $bank_amount, 
        'staff' => $staff,
        'date' => date('Y-m-d')
    ];

    // inserting bank reconciliation data into db
    $reconcile = insert('bank_reconciliation', $bankReconciliationData);

    if($reconcile) {
        $_SESSION['reconciled'] = 1;
        echo header('Location: ../../mfi/bank_reconciliaition.php');
    }

}