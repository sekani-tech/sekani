<?php
include("connect.php");
session_start();

$sessint_id = $_SESSION["int_id"];
if(isset($_GET["edit"])) {
    $id = $_GET["edit"];
}
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$date = date('Y-m-d h:m:s');


    $appclient = "UPDATE client SET status = 'Approved', activation_date = '$date'  WHERE id = '$id'";

    $clsures = mysqli_query($connection, $appclient);
    if ($clsures) {
        $_SESSION["Lack_of_intfund_$randms"] = "Client Approved";
        header ("Location: ../mfi/client_approval.php?message=$randms");
    } else {
        // echo an error:
    }
?>