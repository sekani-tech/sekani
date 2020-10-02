<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";

$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$ekaniN = $_SESSION["sek_name"];
$ekaniE = $_SESSION["sek_email"];
// alright i am done
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
$branch_id = $_POST['branch'];
$phone = $_POST['phone'];
$digits = 10;
$temp2 = explode(".", $_FILES['idimg']['name']);
$randms2 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$imagex = $randms2. '.' .end($temp2);

if (move_uploaded_file($_FILES['idimg']['tmp_name'], "clients/" . $image2)) {
$msg = "Image uploaded successfully";
} else {
$msg = "Image Failed";
}

$queryuser = "INSERT INTO users (int_id, branch_id, username, fullname, password, usertype, status, time_created, pics)
VALUES ('{$sessint_id}', '{$branch_id}', '{$username}', '{$display_name}', '{$hash}', '{$user_t}', '{$std}', '{$date_joined}', '{$imagex}')";

$result = mysqli_query($connection, $queryuser);

if ($result) {
$qrys = "SELECT id FROM users WHERE username = '$username'";
$res = mysqli_query($connection, $qrys);
$row = mysqli_fetch_array($res);
$ui = $row["id"];
 if ($res) {
    $qrys = "INSERT INTO staff (int_id, branch_id, user_id, int_name, username, display_name, email, first_name, last_name,
description, address, date_joined, org_role, phone, img) VALUES ('{$sessint_id}', '{$branch_id}', '{$ui}', '{$int_n}', '{$username}', '{$display_name}', '{$email}',
'{$first_name}', '{$last_name}', '{$description}', '{$address}', '{$date_joined}', '{$org_role}', '{$phone}', '{$imagex}')";

$result = mysqli_query($connection, $qrys);
// OPEN THE DAYTS
if ($result) {
  if (isset($_POST["mon"])) {
    $mon = "1";
  } else {
    $mon = "0";
  }
  if (isset($_POST["tue"])) {
    $tue = "1";
  } else {
    $tue = "0";
  }
  if (isset($_POST["wed"])) {
    $wed = "1";
  } else {
    $wed = "0";
  }
  if (isset($_POST["thur"])) {
    $thur = "1";
  } else {
    $thur = "0";
  }
  if (isset($_POST["fri"])) {
    $fri = "1";
  } else {
    $fri = "0";
  }
  if (isset($_POST["sat"])) {
    $sat = "1";
  } else {
    $sat = "0";
  }
  if (isset($_POST["sun"])) {
    $sun = "1";
  } else {
    $sun = "0";
  }

  $start_time = $_POST["start_time"];
  $end_time = $_POST["end_time"];

  // query
  $query_restric = mysqli_query($connection, "INSERT INTO `staff_restriction` (`int_id`, `staff_id`, `start_time`, `end_time`, `mon`, `tue`, `wed`, `thurs`, `fri`, `sat`) VALUES ('{$sessint_id}', '{$ui}', '{$start_time}', '{$end_time}', '{$mon}', '{$tue}', '{$wed}', '{$thur}', '{$fri}', '{$sat}')");
  // END DATE
   // If 'result' is successful, it will send the required message to client.php
  // Start mail
$mail = new PHPMailer;
// from email addreess and name
$mail->From = $ekaniE;
$mail->FromName = $int_name;
// to adress and name
$mail->addAddress($email, $username);
// reply address
//Address to which recipient will reply
// progressive html images
$mail->addReplyTo($intemail, "Reply");
// CC and BCC
//CC and BCC
// $mail->addCC("cc@example.com");
// $mail->addBCC("bcc@example.com");
// Send HTML or Plain Text Email
$mail->isHTML(true);
$mail->Subject = "CONGRATULATIONS THANK YOU FOR JOINING $int_name";
$mail->Body = '';
$mail->AltBody = "This is the plain text version of the email content";
// mail system
if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
    $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was created successfully!";
  echo header ("Location: ../mfi/staff_mgmt.php?message1=$randms");
} else
{
  $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was created successfully!";
  echo header ("Location: ../mfi/staff_mgmt.php?message1=$randms");
}
  // end Mail system
 } else {
    $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
   echo header ("Location: ../mfi/staff_mgmt.php?message2=$randms");
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