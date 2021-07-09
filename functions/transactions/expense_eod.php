<?php
include('../connect.php');

$today = date("Y-m-d");
$eod_validate = eod($today);

if ($eod_validate == 2){
    header("Location: ../../mfi/transact.php?response=manual_vault");
} else if ($eod_validate == 0){
    header("Location: expense.php");
}else if ($eod_validate == 1){
    header("Location: ../../mfi/transact.php?response=err");
}
?>