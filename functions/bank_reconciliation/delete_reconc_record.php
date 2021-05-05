<?php
include("../connect.php");
session_start();
$sessint_id = $_SESSION['int_id'];
$sessbranch_id = $_SESSION['branch_id'];
$sessuser_id = $_SESSION['user_id'];

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $deleteReconcData = mysqli_query($connection, "DELETE FROM bank_reconciliation WHERE int_id = {$sessint_id} AND id = {$id}");
    if($deleteReconcData) {
        $_SESSION["deletedReconcData"] = 1;
        return $_SESSION["deletedReconcData"];
    }
}