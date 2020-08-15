<?php
include("../functions/connect.php");
// Block Codes, Thread with care

// Draw all fixed deposits for test
$fd_accounts = mysqli_query($connection, "SELECT * FROM account WHERE type_id = '3'");
while($a = mysqli_fetch_array($fd_accounts)){
// Declaring account parameters
    $term = $a['term'];
    $mature_date = $a['maturedon_date'];
    $int_rate = $a['int_rate'];
    $auto_renew = $a['auto_renew_on_closure'];
    $linked_acc = $a['linked_savings_account'];
    $int_repay = $a['interest_repayment'];
}
?>