<?php

$page_title = "Settings";
$destination = "../index.php";
include("header.php");
require_once "../bat/phpmailer/PHPMailerAutoload.php";
// include("../../functions/connect.php");

?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old = $_POST["oldpasskey"];
    $new = password_hash($_POST["newpasskey"], PASSWORD_DEFAULT);
    $user_email = $_SESSION["email"];
    //  select the db
    $username = $_SESSION["username"];
    // check
    $intemail = $_SESSION["sek_email"];
    $intname = $_SESSION["sek_name"];
    $query_pass = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($query_pass) >= 1) {
        $x = mysqli_fetch_array($query_pass);
        $id_user = $x["id"];
        $user_pass = $x["password"];
        // making a change
        if (password_verify($old, $user_pass)) {
            // new password
            $update_query = mysqli_query($connection, "UPDATE `users` SET `password` = '$new' WHERE `users`.`id` = '$id_user'");
            if ($update_query) {
                echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "success",
                            title: "Password Changed Successfully",
                            text: "This will be affected upon your next login",
                            showConfirmButton: false,
                            timer: 5000
                        })
                    });
                    </script>
        ';
            } else {
                echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Entry Error",
                text: "Please Check Your Password Character",
                showConfirmButton: false,
                timer: 4000
            })
        });
        </script>
';
            }
        } else {
            echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "error",
                            title: "Old Password is Wrong",
                            text: "Please Check Your Mail to Reset if You cant remember old password",
                            showConfirmButton: false,
                            timer: 4000
                        })
                    });
                    </script>
        ';
            // check new
            $mail = new PHPMailer;
            // from email addreess and name
            $mail->From = $intemail;
            $mail->FromName = $intname;
            // to adress and name
            $mail->addAddress($user_email, $username);
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
            $mail->Subject = "CHANGING PASSWORD?";
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
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Message has been sent successfully";
            }
        }
    }
}
?>
<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Settings</h4>

                        <!-- Insert number users institutions -->
                    </div>
                    <div class="card-body">

                        <!-- change password -->
                        <div class="card">
                            <!-- <div class="card-header card-header-primary">
                            <h4 class="card-title ">Change Password</h4>
                    
                        </div> -->
                            <div class="card-body">
                                <div class="mt-3">
                                    <form method="post">
                                        <legend>Change Password:</legend>
                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label class="bmd-label-floating">Old Password</label>
                                                <input type="password" value="" name="oldpasskey" class="form-control" required>
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label class="bmd-label-floating">New Password</label>
                                                <input type="password" id="newpasskey" name="newpasskey" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control" required>

                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" onclick="show()">
                                                        Show Password
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <script>
                                                    function show() {
                                                        var x = document.getElementById("newpasskey");
                                                        if (x.type === "password") {
                                                            x.type = "text";
                                                        } else {
                                                            x.type = "password";
                                                        }
                                                    }
                                                </script>
                                            </div>
                                            
                                        </div>
                                        <input type="submit" value="Change" name="submit" id="submit" class="btn btn-primary" />
                                        <input type="reset" value="Reset" name="reset" id="reset" class="btn btn-danger" />
                                        <?php
                                        if ($per_bills == 1 || $per_bills == "1") {
                                        ?>
                                            <a href="bill_pin.php" class="btn btn-warning">change transaction password</a>
                                        <?php
                                        }
                                        ?>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <!-- <div class="card-header card-header-primary">
                        <h4 class="card-title ">Feedback</h4>
                  
                    </div> -->
                            <div class="card-body">
                                <div class="mt-3">
                                    <form method="post">
                                        <legend>Feedback:</legend>

                                        <div class="mt-3">
                                            <label class="bmd-label-floating">Complaint Type</label>
                                            <select name="religion" class="form-control" id="religion">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label class="bmd-label-floating">Complaint Message</label>
                                            <textarea value="" name="" class="form-control" required></textarea>
                                        </div>

                                        <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-primary mt-3" />

                                        <!-- <div class="clearfix"></div> -->
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- make a new settings -->
    </div>
</div>

<?php

include("footer.php");

?>