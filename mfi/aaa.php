<?php
include("../functions/connect.php");
session_start();
$int_id = $_SESSION['int_id'];
$output = '';
?>
<?php

$dif = "SELECT client.id, client.int_id, firstname, lastname, client.loan_status, loan.principal_amount FROM `client` JOIN loan 
ON client.id = loan.client_id WHERE client.int_id = '$int_id' AND client.status = 'Approved'";
$sdf = mysqli_query($connection, $dif);

while($d = mysqli_fetch_array($sdf)){
    $id = $d['id'];

    $os = "UPDATE client SET loan_status = '' WHERE int_id = '$int_id' AND id = '$id'";
    $fdf = mysqli_query($connection, $os);


}
?>