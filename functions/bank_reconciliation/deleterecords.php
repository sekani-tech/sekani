<?php
include("../connect.php");
session_start();
$sessint_id = $_SESSION['int_id'];
$sessbranch_id = $_SESSION['branch_id'];
$sessuser_id = $_SESSION['user_id'];

if(!empty($_POST['inSekaniNotInUploaded'])) {

    $inSekaniNotInUploadedArray = unserialize($_POST['inSekaniNotInUploaded']);
    $GLCode = $_POST['gl_code'];

    $numOfRecords = sizeof($inSekaniNotInUploadedArray);

    $i = 1;

    foreach($inSekaniNotInUploadedArray as $inSekaniNotInUploaded) {
        extract($inSekaniNotInUploaded);

        // $deleteGLAccountTrans = delete('gl_account_transaction', 'transaction_id', $transaction_id);
        $deleteGLAccountTrans = mysqli_query($connection, "DELETE FROM gl_account_transaction WHERE int_id = {$sessint_id} AND gl_code = {$GLCode} AND transaction_id = {$transaction_id}");

        if($deleteGLAccountTrans) {
            if($i == $numOfRecords) {
                $_SESSION["delete_successful"] = 1;
                return $_SESSION["delete_successful"];
            }
        } else {
            $_SESSION["delete_failed"] = 1;
            return $_SESSION["delete_failed"];
        }

        $i++;
    }
}