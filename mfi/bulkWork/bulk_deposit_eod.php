<?php
include('../../functions/connect.php');

$today = date("Y-m-d");
$eod_validate = eod($today);

if ($eod_validate == 2){
    header("Location: ../bulk_deposit.php?response=manual_vault");
} else if ($eod_validate == 0){
    header("Location: deposit.php");
}else if ($eod_validate == 1){
    header("Location: ../bulk_deposit.php?response=err");
}?>