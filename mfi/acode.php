<?php
include("../functions/connect.php");
session_start();
$output = '';
?>
<?php

$dif = "SELECT * FROM `current` ORDER BY name ASC";
$sdf = mysqli_query($connection, $dif);
while($a = mysqli_fetch_array($sdf)){
    $name = $a['name'];

    $dsio = "SELECT * FROM previous WHERE name LIKE '%$name%'";
    $fdf = mysqli_query($connection, $dsio);
    $d = mysqli_fetch_array($fdf);
    $id = $d['id'];
    $id_two = $d['id_two'];
    $name2 = $d['name'];
    $accno = $d['account_no'];

    echo $name." has ".$id_two."</br>";


    $os = "UPDATE current SET account_no = '$accno', id_two = '$id_two' WHERE name LIKE '%$name%'";
    $fdf = mysqli_query($connection, $os);

    if($fdf){
        // echo $name2." is set bruhh!!</br>";
    }
}
?>