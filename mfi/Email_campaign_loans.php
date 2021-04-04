<?php
include("../functions/connect.php");
require_once "../bat/phpmailer/PHPMailerAutoload.php";
session_start();
$institutionId = $_SESSION['int_id'];
// querying institution data for logo and other informations
$query_institution = mysqli_query($connection, "SELECT * FROM `institutions` WHERE int_id = '$institutionId'");
    $x = mysqli_fetch_array($query_institution);
    $int_name = $x["int_name"];
    $full_int_name = $x["int_full"];
    $int_address = $x["office_address"];
    $title = $x["pc_title"];
    $name = $x["pc_surname"];
    $position = $x["pc_designation"];
    $img = $x["img"];



if(isset($_POST['send-mail'])){ 

  // intializing post values
$subject = $_POST['subject'];
$message = $_POST['message'];
$gender = $_POST['gender'];
$religion =$_POST['religion'];
$age = $_POST['age'];
if($gender == "All" && $religion == "All" && $age = "All"){
  // query if all -  basacally no specifications
  $getall = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '$institutionId'");
}else if ($gender != "All" || $religion != "All" || $age != "All"){ //if any of the specifiactions are not equals to All
  // find specification
  if($gender != "All" && $religion == "All" && $age == "All"){
    // check for where gender is not all but the rest are all
    $getall = mysqli_query($connection, "SELECT * FROM `client` WHERE gender = '$gender'");
  }else if($gender == "All" && $religion != "All" && $age == "All"){
    // check where all genders are inclusive but religion is not
    $getall = mysqli_query($connection, "SELECT * FROM `client` WHERE religion = '$religion'");
  }else if ($gender != "All" && $religion != "All" && $age == "All"){
    // check for specific gender and religion
    $getall = mysqli_query($connection, "SELECT * FROM `client` WHERE gender = '$gender' AND religion = '$religion'"); 
  }else if ($gender != "All" && $religion != "All" && $age != "All"){
    // check for specific gender, religion and age
    $getall = mysqli_query($connection, "SELECT * FROM `client` WHERE gender = '$gender' AND religion = '$religion' AND age = '$age'"); 
  
}




while ($res = mysqli_fetch_assoc($getall)) {
    $gender =  $res["gender"]; 
    $religion = $res["religion"];
    $date_of_birth = $res["date_of_birth"];
    // MAKE ME MOVE
    
    $mail = new PHPMailer;
    // from email addreess and name
    $mail->From = "techsupport@sekanisystems.com.ng";
    $mail->FromName = "$int_name";
    // to adress and name
    $mail->addAddress($usermail, "HAPPY INDEPENDENCE DAY");
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
   $mail->Subject = $subject;
   $mail->Body = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
   <html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
   
   <head>
     <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
     <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
     <meta name='viewport' content='width=device-width'>
     <!--[if !mso]><!-->
     <meta http-equiv='X-UA-Compatible' content='IE=edge'>
     <!--<![endif]-->
     <title></title>
     <!--[if !mso]><!-->
     <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
     <link href='https://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet' type='text/css'>
     <link href='https://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
     <!--<![endif]-->
     <style type='text/css'>
       body {
         margin: 0;
         padding: 0;
       }
   
       table,
       td,
       tr {
         vertical-align: top;
         border-collapse: collapse;
       }
   
       * {
         line-height: inherit;
       }
   
       a[x-apple-data-detectors=true] {
         color: inherit !important;
         text-decoration: none !important;
       }
     </style>
     <style type='text/css' id='media-query'>
       @media (max-width: 690px) {
   
         .block-grid,
         .col {
           min-width: 320px !important;
           max-width: 100% !important;
           display: block !important;
         }
   
         .block-grid {
           width: 100% !important;
         }
   
         .col {
           width: 100% !important;
         }
   
         .col>div {
           margin: 0 auto;
         }
   
         img.fullwidth,
         img.fullwidthOnMobile {
           max-width: 100% !important;
         }
   
         .no-stack .col {
           min-width: 0 !important;
           display: table-cell !important;
         }
   
         .no-stack.two-up .col {
           width: 50% !important;
         }
   
         .no-stack .col.num4 {
           width: 33% !important;
         }
   
         .no-stack .col.num8 {
           width: 66% !important;
         }
   
         .no-stack .col.num4 {
           width: 33% !important;
         }
   
         .no-stack .col.num3 {
           width: 25% !important;
         }
   
         .no-stack .col.num6 {
           width: 50% !important;
         }
   
         .no-stack .col.num9 {
           width: 75% !important;
         }
   
         .video-block {
           max-width: none !important;
         }
   
         .mobile_hide {
           min-height: 0px;
           max-height: 0px;
           max-width: 0px;
           display: none;
           overflow: hidden;
           font-size: 0px;
         }
   
         .desktop_hide {
           display: block !important;
           max-height: none !important;
         }
       }
     </style>
   </head>
   
   <body class='clean-body' style='margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: transparent;'>
     <!--[if IE]><div class='ie-browser'><![endif]-->
     $message
     <!--[if (IE)]></div><![endif]-->
   </body>
   
   </html>";
   $mail->AltBody = "This is the plain text version of the email content";
   // mail system
   if(!$mail->send()) 
   {
     echo "Mailer Error: " . $mail->ErrorInfo;
   } else
   {
    echo $xm = "<h1>EMAIL SENT</h1>";
   }
} 

?>