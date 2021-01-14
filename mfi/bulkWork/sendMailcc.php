<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../vendor/autoload.php";
// Recipient
$tos = [
    'james' => 'jambone.james82@gmail.com',
    'omoteeaiyenigba' => '',
    'easylife' => '',
    'hbf' => '',
    'bis' => '',
    'greenback' => '',
    'emeraidcm' => '',
    'mutualtrust' => '',
    'danelsglobal' => '',
    'lifeenhancement' => ''
];

//PHPMailer Object
$mail = new PHPMailer(true); //Argument true in constructor enables exceptions

//From email address and name
$mail->From = " it-support@sekanisystems.com.ng";
$mail->FromName = "Sekani-Tech";

//To address and name
$mail->addAddress("jambone.james82@gmail.com");
$mail->addAddress("omoteeaiyenigba@gmail.com");
$mail->addAddress("easylifecoop@yahoo.com");
$mail->addAddress("hbflenders@yahoo.com");
$mail->addAddress("bistoy2012@gmail.com");
$mail->addAddress("greenbacksmpcs@yahoo.com");
$mail->addAddress("emeraidcmc@gmail.com");
$mail->addAddress("mutualtrustcoop@gmail.com");
$mail->addAddress("info@danelsglobal.com.ng");
$mail->addAddress("lifeenhancementhop@gmail.com");
//$mail->addAddress("recepient1@example.com");

// Attachment file
$file = "sekani-technewyear-min.jpg";

// Email body content

//CC and BCC
$mail->addCC("fumogbai1@gmail.com");
$mail->addCC("olochesamuel2@gmail.com");


// Preparing attachment
if ($file) {
    if (is_file($file)) {
//Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject = "Happy New Year";
        $mail->Body = '<img src="cid:newYear">';
        try {
            $mail->AddEmbeddedImage( '/sekani-technewyear-min.jpg', 'newYear');
        } catch (Exception $e) {
        }

// Send email
        try {
            $mail->send();
            echo "Message has been sent successfully";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}