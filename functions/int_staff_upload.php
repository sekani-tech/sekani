<?php
include("connect.php");
session_start();
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
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
$digits = 10;
$temp = explode(".", $_FILES['imagefile']['name']);
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$imagex = $randms. '.' .end($temp);

if (move_uploaded_file($_FILES['imagefile']['tmp_name'], "staff/" . $imagex)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$queryuser = "INSERT INTO users (int_id, username, fullname, password, usertype, status, time_created, pics)
VALUES ('{$sessint_id}', '{$username}', '{$display_name}', '{$hash}', '{$user_t}', '{$std}', '{$date_joined}', '{$imagex}')";

$result = mysqli_query($connection, $queryuser);

if ($result) {
$qrys = "SELECT id FROM users WHERE username = '$username'";
$res = mysqli_query($connection, $qrys);
$row = mysqli_fetch_array($res);
$ui = $row["id"];
 if ($res) {
    $qrys = "INSERT INTO staff (int_id, user_id, int_name, username, display_name, email, first_name, last_name,
description, address, date_joined, org_role, phone, img) VALUES ('{$sessint_id}', '{$ui}', '{$int_n}', '{$username}', '{$display_name}', '{$email}',
'{$first_name}', '{$last_name}', '{$description}', '{$address}', '{$date_joined}', '{$org_role}', '{$phone}', '{$imagex}')";

$result = mysqli_query($connection, $qrys);

if ($result) {
   // If 'result' is successful, it will send the required message to client.php
   $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
   echo header ("Location: ../mfi/users.php?message1=$randms");
 } else {
    $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
   echo header ("Location: ../mfi/users.php?message2=$randms");
     // echo header("location: ../mfi/client.php");
 }
 } else {
     echo "<p>ERROR</p>";
 }
} else {
  $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
   echo header ("Location: ../mfi/users.php?message2=$randms");
}
// if ($connection->error) {
//     try {   
//         throw new Exception("MySQL error $connection->error <br> Query:<br> $qrys", $msqli->errno);   
//     } catch(Exception $e ) {
//         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//         echo nl2br($e->getTraceAsString());
//     }
// }
?>