<?php
include("../functions/connect.php");
session_start();
$output = '';
?>
<?php

$dif = "SELECT * FROM `client` WHERE int_id = '8'";
$sdf = mysqli_query($connection, $dif);
$int_id = '8';
while($d = mysqli_fetch_array($sdf)){
    $id = $d['id'];
    $accno = $d['account_no'];
    $newacc = "00".$accno;
    $os = "UPDATE client SET account_no = '$newacc' WHERE int_id = '$int_id' AND id = '$id'";
    $fdf = mysqli_query($connection, $os);
    if($fdf){
        $ioe = "UPDATE account SET account_no = '$newacc' WHERE int_id = '$int_id' AND client_id = '$id'";
        $iom = mysqli_query($connection, $ioe);
    }
    if($iom){
        echo "DONE!!".$id."</br>";
    }
}
?>