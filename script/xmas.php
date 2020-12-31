<?php
// run connect file
include("../functions/connect.php");
require_once "../bat/phpmailer/PHPMailerAutoload.php";


// now import email phpmailer
$get_all_client_email = mysqli_query($connection, "SELECT * FROM `client` WHERE status = 'Approved'");

if (mysqli_num_rows($get_all_client_email) > 0) {
    // now dispaly
    while ($row = mysqli_fetch_array($get_all_client_email)) {
        $int_id = $row["int_id"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $middlename = $row["middlename"];
        // arrange the client name
        $fullname = $firstname." ".$middlename." ".$lastname;
        // get the nec from the details
        $email = $row["email_address"];

        // get the instituiton information
        $query_int = mysqli_query($connection, "SELECT * FROM `institutions` WHERE int_id = '$int_id'");
        if (mysqli_num_rows($query_int) > 0) {
            $icn = mysqli_fetch_array($query_int);
            $int_name = $icn["int_name"];
            $int_full = $icn["int_full"];
            $office_address = $icn["office_address"];
            $int_email = $icn["email"];
            $int_logo = $icn["img"];
            $pc_phone = $icn["pc_phone"];
            $pc_designation = $icn["pc_designation"];

            // form a full
            $pc_title = $icn["pc_title"];
            $pc_surname = $icn["pc_surname"];
            $pc_other_name = $icn["pc_other_name"];

            // full mixer
            $primary_contact = $pc_title." ".$pc_surname." ".$pc_other_name;

            // Next is the email
            $current_date = date('Y-m-d');
            $x_mas = "2020-12-25";

            if ($current_date == $x_mas) {
                // Trigger Email with Entity
                $mail = new PHPMailer;
                // from email addreess and name
                $mail->From = "techsupport@sekanisystems.com.ng";
                $mail->FromName = "$int_name";
                // to adress and name
                $mail->addAddress($email, "$fullname");
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
               $mail->Subject = "$int_name Says Merry Christmas";
               $mail->Body = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>

               <html xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:v='urn:schemas-microsoft-com:vml'>
               <head>
               <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
               <meta content='text/html; charset=utf-8' http-equiv='Content-Type'/>
               <meta content='width=device-width' name='viewport'/>
               <!--[if !mso]><!-->
               <meta content='IE=edge' http-equiv='X-UA-Compatible'/>
               <!--<![endif]-->
               <title></title>
               <!--[if !mso]><!-->
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
               <style id='media-query' type='text/css'>
                       @media (max-width: 520px) {
               
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
               
                           .col_cont {
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
               
                           .no-stack .col.num2 {
                               width: 16.6% !important;
                           }
               
                           .no-stack .col.num3 {
                               width: 25% !important;
                           }
               
                           .no-stack .col.num4 {
                               width: 33% !important;
                           }
               
                           .no-stack .col.num5 {
                               width: 41.6% !important;
                           }
               
                           .no-stack .col.num6 {
                               width: 50% !important;
                           }
               
                           .no-stack .col.num7 {
                               width: 58.3% !important;
                           }
               
                           .no-stack .col.num8 {
                               width: 66.6% !important;
                           }
               
                           .no-stack .col.num9 {
                               width: 75% !important;
                           }
               
                           .no-stack .col.num10 {
                               width: 83.3% !important;
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
               <body class='clean-body' style='margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #FFFFFF;'>
               <!--[if IE]><div class='ie-browser'><![endif]-->
               <table bgcolor='#FFFFFF' cellpadding='0' cellspacing='0' class='nl-container' role='presentation' style='table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF; width: 100%;' valign='top' width='100%'>
               <tbody>
               <tr style='vertical-align: top;' valign='top'>
               <td style='word-break: break-word; vertical-align: top;' valign='top'>
               <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td align='center' style='background-color:#FFFFFF'><![endif]-->
               <div style='background-color:transparent;'>
               <div class='block-grid' style='min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;'>
               <div style='border-collapse: collapse;display: table;width: 100%;background-color:transparent;'>
               <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0' style='background-color:transparent;'><tr><td align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:500px'><tr class='layout-full-width' style='background-color:transparent'><![endif]-->
               <!--[if (mso)|(IE)]><td align='center' width='500' style='background-color:transparent;width:500px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;' valign='top'><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;'><![endif]-->
               <div class='col num12' style='min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;'>
               <div class='col_cont' style='width:100% !important;'>
               <!--[if (!mso)&(!IE)]><!-->
               <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;'>
               <!--<![endif]-->
               <div align='center' class='img-container center fixedwidth' style='padding-right: 0px;padding-left: 0px;'>
               <!--[if mso]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr style='line-height:0px'><td style='padding-right: 0px;padding-left: 0px;' align='center'><![endif]--><img align='center' alt='Alternate text' border='0' class='center fixedwidth' src='https://sekanisystems.com.ng/wp-content/uploads/2020/12/SEKANI_LOGO_1_christmas.png' style='text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 150px; display: block;' title='Alternate text' width='150'/>
               <!--[if mso]></td></tr></table><![endif]-->
               </div>
               <!--[if (!mso)&(!IE)]><!-->
               </div>
               <!--<![endif]-->
               </div>
               </div>
               <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
               <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
               </div>
               </div>
               </div>
               <div style='background-color:transparent;'>
               <div class='block-grid' style='min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;'>
               <div style='border-collapse: collapse;display: table;width: 100%;background-color:transparent;background-image:;background-position:top left;background-repeat:no-repeat'>
               <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0' style='background-color:transparent;'><tr><td align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:500px'><tr class='layout-full-width' style='background-color:transparent'><![endif]-->
               <!--[if (mso)|(IE)]><td align='center' width='500' style='background-color:transparent;width:500px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;' valign='top'><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;'><![endif]-->
               <div class='col num12' style='min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;'>
               <div class='col_cont' style='width:100% !important;'>
               <!--[if (!mso)&(!IE)]><!-->
               <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;'>
               <!--<![endif]-->
               <div align='center' class='img-container center autowidth' style='padding-right: 0px;padding-left: 0px;'>
               <!--[if mso]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr style='line-height:0px'><td style='padding-right: 0px;padding-left: 0px;' align='center'><![endif]--><img align='center' alt='Alternate text' border='0' class='center autowidth' src='$int_logo' style='text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 500px; display: block;' title='Alternate text' width='500'/>
               <!--[if mso]></td></tr></table><![endif]-->
               </div>
               <!--[if (!mso)&(!IE)]><!-->
               </div>
               <!--<![endif]-->
               </div>
               </div>
               <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
               <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
               </div>
               </div>
               </div>
               <div style='background-color:transparent;'>
               <div class='block-grid' style='min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;'>
               <div style='border-collapse: collapse;display: table;width: 100%;background-color:transparent;'>
               <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0' style='background-color:transparent;'><tr><td align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:500px'><tr class='layout-full-width' style='background-color:transparent'><![endif]-->
               <!--[if (mso)|(IE)]><td align='center' width='500' style='background-color:transparent;width:500px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;' valign='top'><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;'><![endif]-->
               <div class='col num12' style='min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;'>
               <div class='col_cont' style='width:100% !important;'>
               <!--[if (!mso)&(!IE)]><!-->
               <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;'>
               <!--<![endif]-->
               <!--[if mso]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif'><![endif]-->
               <div style='color:#393d47;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.8;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;'>
               <div style='line-height: 1.8; font-size: 12px; color: #393d47; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 22px;'>
               <p style='font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;'>Dear $fullname Our Esteemed Customer,</p>
               </div>
               </div>
               <!--[if mso]></td></tr></table><![endif]-->
               <!--[if mso]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif'><![endif]-->
               <div style='color:#393d47;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;'>
               <div style='line-height: 1.5; font-size: 12px; color: #393d47; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;'>
               <p style='line-height: 1.5; word-break: break-word; font-size: 14px; mso-line-height-alt: 21px; margin: 0;'><span style='font-size: 14px;'>Season's greetings to you our esteemed customer, may the glorious message of peace and love fill you with joy during this beautiful season.</span></p>
               <p style='line-height: 1.5; word-break: break-word; mso-line-height-alt: 18px; margin: 0;'> </p>
               <p style='line-height: 1.5; word-break: break-word; font-size: 14px; mso-line-height-alt: 21px; margin: 0;'><span style='font-size: 14px;'>Thank you for trusting us in 2020, we hope to serve you better in 2021.</span></p>
               </div>
               </div>
               <!--[if mso]></td></tr></table><![endif]-->
               <!--[if (!mso)&(!IE)]><!-->
               </div>
               <!--<![endif]-->
               </div>
               </div>
               <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
               <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
               </div>
               </div>
               </div>
               <div style='background-color:transparent;'>
               <div class='block-grid' style='min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;'>
               <div style='border-collapse: collapse;display: table;width: 100%;background-color:transparent;'>
               <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0' style='background-color:transparent;'><tr><td align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:500px'><tr class='layout-full-width' style='background-color:transparent'><![endif]-->
               <!--[if (mso)|(IE)]><td align='center' width='500' style='background-color:transparent;width:500px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;' valign='top'><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;'><![endif]-->
               <div class='col num12' style='min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;'>
               <div class='col_cont' style='width:100% !important;'>
               <!--[if (!mso)&(!IE)]><!-->
               <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;'>
               <!--<![endif]-->
               <!--[if mso]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif'><![endif]-->
               <div style='color:#393d47;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;'>
               <div style='line-height: 1.5; font-size: 12px; color: #393d47; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;'>
               <p style='line-height: 1.5; word-break: break-word; mso-line-height-alt: 18px; margin: 0;'><strong><span style='font-size: 20px;'><em><span style=''>$int_full</span></em></span></strong></p>
               </div>
               </div>
               <!--[if mso]></td></tr></table><![endif]-->
               <!--[if (!mso)&(!IE)]><!-->
               </div>
               <!--<![endif]-->
               </div>
               </div>
               <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
               <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
               </div>
               </div>
               </div>
               <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
               </td>
               </tr>
               </tbody>
               </table>
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
                echo "<h1>EMAIL SENT</h1>";
               }
            } else {
                // End email trigger
                echo "Today is not Christmas";
            }
            // End the email
        } else {
            echo "Cant find institution";
        }


    }
} else {
    echo "No email";
}
?>