<?php
include("../../../functions/connect.php");
//active user
$user = $_POST["user"];
$int_id = $_POST["int_id"];

if ($user != "" && $int_id != "") {
    $activecode = "Active";
// working on the time stamp right now
$ts = date('Y-m-d H:i:s');
$acuser = $user;
// $_SESSION['last_login_timestamp'] = time();
// $timmer_check = $_SESSION['last_login_timestamp'];
// AUTO LOGIN
$activeq = "UPDATE users SET users.status ='$activecode', users.last_logged = '$ts' WHERE users.username ='$acuser' AND int_id = '$int_id'";
$rezz = mysqli_query($connection, $activeq);
}
// Don't Wake me Up
?>