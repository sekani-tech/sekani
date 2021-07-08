<?php
include("../../functions/connect.php");

if ($_POST["int_id"] != "" && $_POST["branch_id"] != "") {
// zoom
$int_id = $_POST["int_id"];
$branch_id = $_POST["branch_id"];
$bro = date("Y-m-d");
// alright
$sql_insert = mysqli_query($connection, "INSERT INTO `sekani_wallet` (`branch_id`, `int_id`, `total_deposit`, `total_withdrawal`, `running_balance`, `created_date`) 
VALUES ('{$branch_id}', '{$int_id}', '0.00', '0.00', '0.00', '{$bro}')");

if ($sql_insert) {
    echo "<span style='color:green;'>WALLET CREATED SUCCESSFULLY<span>";
} else {
    echo "<span style='color:red;'>Failed During Creation<span>";
}
} else {
    echo "CANT CREATE WALLET, NO DATA";
}
?>