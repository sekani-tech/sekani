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
            $acc_no = $n['account_no'];
        }

    }
}
else{
    $br_id = $_SESSION["branchid"];
    $accid = $_SESSION["acc_id"];
}
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$date = date('Y-m-d h:m:s');
    // $client = mysqli_query($connection, "SELECT account_no FROM client WHERE id = '$id'");
    // if (count([$person]) == 1) {
    //     $n = mysqli_fetch_array($person);
    //     $app = $n['status'];
    // }
if($accid && $br_id){
    $appclient = "DELETE FROM client  WHERE id = '$id'";
}
else{
    $appclient = "DELETE FROM client  WHERE id = '$id'";
}
    $clsures = mysqli_query($connection, $appclient);
    if ($clsures) {
        $ds = "DELETE FROM account WHERE client_id = '$id'";
        $fpd = mysqli_query($connection, $ds);
        $_SESSION["Lack_of_intfund_$randms"] = "Insufficent Fund From Institution Account! OR This Client Has Been Given Loan Before";
        header ("Location: ../mfi/client_approval.php?message3=$randms");
    } else {
        
    }
?>