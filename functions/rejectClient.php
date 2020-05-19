<?php
include("connect.php");
session_start();

$sessint_id = $_SESSION["int_id"];
if(isset($_GET["edit"])) {
    $id = $_GET["edit"];
}
if($_SESSION["branchid"]=="0" || $_SESSION["branchid"]==""){
    if($_SESSION["acc_id"]=="0" || $_SESSION["acc_id"]==""){

        $don = mysqli_query($connection, "SELECT * FROM client WHERE id = '$id'");
        if (count([$don]) == 1) {
            $n = mysqli_fetch_array($person);
            $br_id = $n['branch_id'];
            $accid = $n['loan_officer_id'];
        }

    }
}
else{
    $br_id = $_SESSION["branchid"];
    $accid = $_SESSION["acc_id"];
}
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

    // $client = mysqli_query($connection, "SELECT account_no FROM client WHERE id = '$id'");
    // if (count([$person]) == 1) {
    //     $n = mysqli_fetch_array($person);
    //     $app = $n['status'];
    // }
if($accid && $br_id){
    $appclient = "UPDATE client SET status = 'Pending', branch_id = '$br_id', loan_officer_id = '$accid' WHERE id = '$id'";
}
else{
    $appclient = "UPDATE client SET status = 'Pending' WHERE id = '$id'";
}
    $clsures = mysqli_query($connection, $appclient);
    if ($clsures) {
        $_SESSION["Lack_of_intfund_$randms"] = "Insufficent Fund From Institution Account! OR This Client Has Been Given Loan Before";
        header ("Location: ../mfi/client_approval.php?message2=$randms");
    } else {
        
    }
?>