<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  if($_SESSION["usertype"] == "super_admin"){
    header("location: index.php");
    exit;
  } 
  elseif($_SESSION["usertype"] == "admin"){
    header("location: ./modules/admin/dashboard.php");
    exit;
  }
//   elseif($_SESSION["usertype"] == "staff"){
//       if($_SESSION["employee_status"] == "Employed"){
//         header("location: mfi/index.php");
//       }
//       elseif($_SESSION["employee_status"] == "Decommisioned"){
//         $err = "Sorry, you are not allowed to login";
//         $password = "";
//       }
//     exit;
//   }
}
 
// Include config file
require_once "functions/config.php";
require_once "bat/phpmailer/PHPMailerAutoload.php";
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
$err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT users.id, staff.user_id, users.int_id, users.branch_id, staff.email, users.username, users.fullname, users.usertype,staff.employee_status, users.password, org_role, display_name FROM staff JOIN users ON users.id = staff.user_id WHERE users.username = ?";
        // $sqlj = "SELECT users.id, users.int_id, users.username, users.fullname, users.usertype, users.password, org_role, display_name FROM staff JOIN users ON users.id = staff.user_id WHERE users.username = "sam"";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $user_id, $int_id, $branch_id, $email, $username, $fullname, $usertype, $employee_status, $hashed_password, $org_role, $display_name);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            session_regenerate_id();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["int_id"] = $int_id;
                            $_SESSION["email"] = $email;
                            $_SESSION["username"] = $username;
                            $_SESSION["usertype"] = $usertype;
                            $_SESSION["fullname"] = $fullname;
                            $_SESSION["org_role"] = $org_role;
                            $_SESSION["employee_status"] = $employee_status;
                            $_SESSION["branch_id"] = $branch_id;
                            // $_SESSION["lastname"] = $lastname;
                            $compsec = mysqli_query($link, "SELECT * FROM `institutions` WHERE int_id ='$int_id'");
                            if (count([$compsec]) == 1) {
                            $res = mysqli_fetch_array($compsec);
                            $intname = $res["int_name"];
                            $intemail = $res["email"];

                            // mailin
                            // begining of mail
                            $mail = new PHPMailer;
                            // from email addreess and name
                            $mail->From = $intemail;
                            $mail->FromName = $intname;
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
                                                                            <!--[if mso]><table width='100%' cellpadding='0' cellspacing='0' border='0' style='border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;'><tr><td style='padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px' align='center'><v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' xmlns:w='urn:schemas-microsoft-com:office:word' href='https://app.sekanisystems.com.ng/change_password.php?edit=".$username."' style='height:31.5pt; width:150.75pt; v-text-anchor:middle;' arcsize='10%' stroke='false' fillcolor='#c39f3c'><w:anchorlock/><v:textbox inset='0,0,0,0'><center style='color:#ffffff; font-family:Arial, sans-serif; font-size:16px'><![endif]--><a href='https://app.sekanisystems.com.ng/change_password.php' target='_blank' style='-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #ffffff; background-color: #c39f3c; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; width: auto; width: auto; border-top: 1px solid #c39f3c; border-right: 1px solid #c39f3c; border-bottom: 1px solid #c39f3c; border-left: 1px solid #c39f3c; padding-top: 5px; padding-bottom: 5px; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;'><span style='padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;'><span style='font-size: 16px; line-height: 2; word-break: break-word; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 32px;'>update password</span></span></a>
                                                                            <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
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
                            // end of mail
                            }
                            session_write_close();                            
                            //run a quick code to show active user
                            // Redirect user to welcome page
                            if ($stmt->num_rows ==1 && $_SESSION["usertype"] =="super_admin") {
                              header("location: index.php");
                            }elseif ($stmt->num_rows ==1 && $_SESSION["usertype"]=="admin"){
                                header("location: mfi/index.php");
                            //   header("location: ./mfi/admin/dashboard.php");
                            }
                            elseif ($stmt->num_rows ==1 && $_SESSION["usertype"]=="staff") {
                                if($_SESSION["employee_status"] == "Employed"){
                                    header("location: mfi/index.php");
                                  }
                                  elseif($_SESSION["employee_status"] == "Decommisioned"){
                                    $err = "Sorry You cannot login";
                                    $password = "";
                                  }
                            }
                            elseif ($stmt->num_rows ==1 && $_SESSION["usertype"]=="super_staff") {
                                header("location: ./modules/staff/dashboard.php");
                              }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}

include('functions/config.php');

?>

<html lang="en">
<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- test -->
  <!-- Material Kit CSS -->
  <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
</head>
<body>
    <div class="wrapper">
        <div class="content justify-content-between">
            <div class="container">
                <!-- Login form -->
                <!-- <div class="row"> -->
                    <div class="col-md-7" style="margin-left:auto; margin-right:auto;">
                    <div class="card">
                        <div class="card-header card-header-primary">
                        <h4 class="card-title">Login</h4>
                        <h4 class="card-title"><?php echo $err;?></h4>
                        <p class="card-category">Sign in</p>
                        </div>
                        <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <label class="bmd-label-floating">Username</label>
                                    <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
                                    <span class="help-block"><?php echo $username_err; ?></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <label class="bmd-label-floating">Password</label>
                                    <input type="password" name="password" class="form-control" id="">
                                    <span class="help-block"><?php echo $password_err; ?></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Login</button>
                            <button type="reset" class="btn btn-danger ">Reset</button>
                            <div class="clearfix"></div>
                        </form>
                        </div>
                    </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
</body>
</html>