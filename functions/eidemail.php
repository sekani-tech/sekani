<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
$sessint_id = $_SESSION["int_id"];
  $quy = "SELECT * FROM client WHERE int_id = '$sessint_id'";
  $rult = mysqli_query($connection, $quy);
  if (mysqli_num_rows($rult) > 0) {
    while ($row = mysqli_fetch_array($rult))
        {
          $remail = $row['email'];
$mail = new PHPMailer;
$mail->From = $int_email;
$mail->FromName = $int_name;
$int_email = $_SESSION["int_email"];
$mail->addAddress($remail);
$mail->addReplyTo($int_email, "No-Reply");
$mail->isHTML(true);
$mail->Subject = "Transaction Alert from $int_name";
$mail->Body = "<!doctype html>
<html lang='en'>
<head>
<!-- Required meta tags -->
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
<!-- Bootstrap CSS -->
<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>

<title>Transaction Alert</title>
</head>
<body>
<div class='container'>
<div class='row justify-content-md-center'>
  <div class='col col-lg-6'>
    <div class='shadow p-3 mb-5 bg-white rounded'>
        <span> <b>$int_name</b> </span>
    </div>
  </div>
</div>
<div class='row'>
  <div class='col col-lg-12'>
    <div class='shadow-sm p-3 mb-5 bg-white rounded'>
      <img src='instimg/msg2.jpg'></img>
      <img src='instimg/msg1.jpg'></img>
    </div>
  </div>
</div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
</body>
</html>";
          }
        }
$mail->AltBody = "This is the plain text version of the email content";
// mail system
if(!$mail->send()) 
{
$_SESSION["Lack_of_intfund_$randms"] = "";
echo "error";
echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
} else
{
$_SESSION["Lack_of_intfund_$randms"] = "";
echo "error";
echo header ("Location: ../mfi/teller_journal.php?message1=$randms");
}
?>