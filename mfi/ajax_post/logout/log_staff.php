<?php
include("../../../functions/connect.php");
$user = $_POST["user"];
$int_id = $_POST["int_id"];

if ($user != "" && $int_id != "") {
$query = "SELECT * FROM users WHERE int_id = '$int_id' && status = 'Active'";
$result = mysqli_query($connection, $query);
if ($result) {
    $inr = mysqli_num_rows($result);
    echo $inr;
}
}
?>