<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
$sessint_id = 5;
$int_email = 'dgmfb@gmail.com';
$int_name = 'DGMFB';
$username = "Test";
$nm = 'Tech Support';
$int_logo = 'https://firebasestorage.googleapis.com/v0/b/recipeapp-6e1ce.appspot.com/o/DGMFB.png?alt=media&token=c4d6cb90-3bc3-47be-82d3-71b1a26d9b27';
$quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' AND employee_status = 'Employed'";
$rult = mysqli_query($connection, $quy);
if (mysqli_num_rows($rult) > 0) {
  while ($row = mysqli_fetch_array($rult))
      {
        $remail = $row['email'];
        $roleid = $row['org_role'];
        $quyd = "SELECT * FROM permission WHERE role_id = '$roleid'";
        $rlot = mysqli_query($connection, $quyd);
        $tolm = mysqli_fetch_array($rlot);
        $vaul = $tolm['vault_email'];
        
        if ($vaul == 1 || $vaul == "1") {
          echo $remail.'<br/>';
         // mailin
                            // begining of mail
                            $mail = new PHPMailer;
                            // from email addreess and name
                            $mail->From = $int_email;
                            $mail->FromName = $int_name;
                            // to adress and name
                            $mail->addAddress($remail, $username);
                            // reply address
                            //Address to which recipient will reply
                            // progressive html images
                            $mail->addReplyTo($int_email, "Reply");
                            // CC and BCC
                            //CC and BCC
                            // $mail->addCC("cc@example.com");
                            // $mail->addBCC("bcc@example.com");
                            // Send HTML or Plain Text Email
                            $mail->isHTML(true);
                            $mail->Subject = "LOGGED IN?";
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
                            
                            <body class='clean-body' style='margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #FFFFFF;'>
                                <!--[if IE]><div class='ie-browser'><![endif]-->
                                <table class='nl-container' style='table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF; width: 100%;' cellpadding='0' cellspacing='0' role='presentation' width='100%' bgcolor='#FFFFFF' valign='top'>
                                    <tbody>
                                        <tr style='vertical-align: top;' valign='top'>
                                            <td style='word-break: break-word; vertical-align: top;' valign='top'>
                                                <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td align='center' style='background-color:#FFFFFF'><![endif]-->
                                                <div style='background-color:transparent;'>
                                                    <div class='block-grid ' style='Margin: 0 auto; min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;'>
                                                        <div style='border-collapse: collapse;display: table;width: 100%;background-color:transparent;'>
                                                            <!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0' style='background-color:transparent;'><tr><td align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:500px'><tr class='layout-full-width' style='background-color:transparent'><![endif]-->
                                                            <!--[if (mso)|(IE)]><td align='center' width='500' style='background-color:transparent;width:500px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;' valign='top'><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;'><![endif]-->
                                                            <div class='col num12' style='min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;'>
                                                                <div style='width:100% !important;'>
                                                                    <!--[if (!mso)&(!IE)]><!-->
                                                                    <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;'>
                                                                        <!--<![endif]-->
                                                                        <!--[if mso]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif'><![endif]-->
                                                                        <div style='color:#e7953f;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;'>
                                                                            <div style='line-height: 2; font-size: 12px; color: #e7953f; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 24px;'>
                                                                                <p style='font-size: 14px; line-height: 2; word-break: break-word; mso-line-height-alt: 28px; margin: 0;'><strong>Did You Just Logged In?</strong></p>
                                                                            </div>
                                                                        </div>
                                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                                        <table class='divider' border='0' cellpadding='0' cellspacing='0' width='100%' style='table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;' role='presentation' valign='top'>
                                                                            <tbody>
                                                                                <tr style='vertical-align: top;' valign='top'>
                                                                                    <td class='divider_inner' style='word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;' valign='top'>
                                                                                        <table class='divider_content' border='0' cellpadding='0' cellspacing='0' width='100%' style='table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px solid #C39F3C; height: 1px; width: 100%;' align='center' role='presentation' height='1' valign='top'>
                                                                                            <tbody>
                                                                                                <tr style='vertical-align: top;' valign='top'>
                                                                                                    <td style='word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;' height='1' valign='top'><span></span></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <div class='img-container center fixedwidth' align='center' style='padding-right: 0px;padding-left: 0px;'>
                                                                            <!--[if mso]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr style='line-height:0px'><td style='padding-right: 0px;padding-left: 0px;' align='center'><![endif]--><img class='center fixedwidth' align='center' border='0' src='https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/BeeProAgency/536737_517710/57e3d3404a53ad14f1dc8460962a3f7f153fdde74e50744172297fdc9448c6_640.png' alt='Alternate text' title='Alternate text' style='text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 150px; display: block;' width='150'>
                                                                            <!--[if mso]></td></tr></table><![endif]-->
                                                                        </div>
                                                                        <div class='button-container' align='center' style='padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;'>
                                                                            <!--[if mso]><table width='100%' cellpadding='0' cellspacing='0' border='0' style='border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;'><tr><td style='padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px' align='center'><v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' xmlns:w='urn:schemas-microsoft-com:office:word' href='https://app.sekanisystems.com.ng/change_password.php?edit=$username' style='height:31.5pt; width:150.75pt; v-text-anchor:middle;' arcsize='10%' stroke='false' fillcolor='#c39f3c'><w:anchorlock/><v:textbox inset='0,0,0,0'><center style='color:#ffffff; font-family:Arial, sans-serif; font-size:16px'><![endif]-->
                                                                                <a href='https://app.sekanisystems.com.ng/change_password.php?edit=$username' target='_blank' style='-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #ffffff; background-color: #c39f3c; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; width: auto; width: auto; border-top: 1px solid #c39f3c; border-right: 1px solid #c39f3c; border-bottom: 1px solid #c39f3c; border-left: 1px solid #c39f3c; padding-top: 5px; padding-bottom: 5px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;'><span style='padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;'><span style='font-size: 16px; line-height: 2; word-break: break-word; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 32px;'>update password</span></span></a>
                                                                            <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                            
                            </html>
                            ";
                            $mail->AltBody = "This is the plain text version of the email content";
                            // mail system
                            if(!$mail->send()) 
                            {
                                echo "Mailer Error: " . $mail->ErrorInfo;
                            } else
                            {
                                echo "Message has been sent successfully";
                            }
                          }
                        }
  } 
?>