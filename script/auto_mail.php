<?php
include("../functions/connect.php");
require_once "../bat/phpmailer/PHPMailerAutoload.php";
?>
<?php 
$getall = "SELECT * FROM staff WHERE int_id = 3";
$getmail = mysqli_query($connection, $getall);

while ($res = mysqli_fetch_assoc($getmail)) {
    $usermail = $res["email"]; 
    $mail = new PHPMailer;
    // from email addreess and name
    $mail->From = "techsupport@sekanisystems.com.ng";
    $mail->FromName = "Tech Support - Auto Mail";
    // to adress and name
    $mail->addAddress($usermail, "Auto Mail Test");
    // reply address
    //Address to which recipient will reply
    // progressive html images
   $mail->addReplyTo("techsupport@sekanisystems.com.ng", "Reply");
   // CC and BCC
   //CC and BCC
   // $mail->addCC("cc@example.com");
   // $mail->addBCC("bcc@example.com");
   // Send HTML or Plain Text Email
   $mail->isHTML(true);
   $mail->Subject = "Comfirmation Code";
   $mail->Body = "Result of Testing Auto Mail System";
   $mail->AltBody = "This is the plain text version of the email content";
   // mail system
   if(!$mail->send()) 
   {
     echo "Mailer Error: " . $mail->ErrorInfo;
   } else
   {
    echo $xm = "<h1>404 ERROR PAGE NOT FOUND</h1>";
   }
} 
?>