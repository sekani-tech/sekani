<?php
include("connect.php");
session_start();
?>
<?php
$sessint_id = $_SESSION["int_id"];
$int_n = $_POST['int_name'];
$username = $_POST['username'];
$user_t = $_POST['user_t'];
$display_name = $_POST['display_name'];
$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);
$description = $_POST['description'];
$address = $_POST['address'];
$date_joined = $_POST['date_joined'];
$org_role = $_POST['org_role'];
$std = "Not Active";
$phone = $_POST['phone'];


$image1 = $_FILES['picture']['name'];
$target1 = "staff/".basename($image1);

if (move_uploaded_file($_FILES['picture']['tmp_name'], $target1)) {
    $msg = "Image uploaded successfully";
} else{
    $msg = "Failed to upload image";
    echo "<script> console.log($msg); </script>";
}

$queryuser = "INSERT INTO users (int_id, username, fullname, password, usertype, status, time_created, pics)
VALUES ('{$sessint_id}', '{$username}', '{$display_name}', '{$hash}', '{$user_t}', '{$std}', '{$date_joined}', '{$image1}')";

$result = mysqli_query($connection, $queryuser);

if ($result) {
$qrys = "SELECT id FROM users WHERE username = '$username'";
$res = mysqli_query($connection, $qrys);
$row = mysqli_fetch_array($res);
$ui = $row["id"];
 if ($res) {
    $qrys = "INSERT INTO staff (int_id, user_id, int_name, username, display_name, email, first_name, last_name,
description, address, date_joined, org_role, phone, img) VALUES ('{$sessint_id}', '{$ui}', '{$int_n}', '{$username}', '{$display_name}', '{$email}',
'{$first_name}', '{$last_name}', '{$description}', '{$address}', '{$date_joined}', '{$org_role}', '{$phone}', '{$image1}')";

$result = mysqli_query($connection, $qrys);

if ($result) {
    echo header("location: ../mfi/users.php");
    exit;
} else {
   echo "<p>Error</p>";
}
 } else {
     echo "<p>ERROR</p>";
 }
} else {
   echo "<p>Error</p>";
}
if ($connection->error) {
    try {   
        throw new Exception("MySQL error $connection->error <br> Query:<br> $qrys", $msqli->errno);   
    } catch(Exception $e ) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
}
?>