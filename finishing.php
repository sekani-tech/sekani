<?php
include("material.php");
include("functions/connect.php");
require_once "bat/phpmailer/PHPMailerAutoload.php";

session_start();

$intname = $_SESSION["int_name"];
$intemail = $_SESSION["int_email"];
$email = $_SESSION["email"];
$fullname = $_SESSION["username"];
$codey = $_SESSION["codex"];
$name = $_SESSION["name"];
$int_id = $_SESSION["int_id"];
// finial finishing
if (isset($_POST['pass'])) {
    $conpass = $_POST["pass"];
    $_SESSION["pass"] = $conpass;
}
$extt = $_SESSION["pass"];
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $tent = password_hash($extt, PASSWORD_DEFAULT);
    // $passk = $_SESSION["password"];
    // check
    $code = $_POST['code'];
    if ($code == $codey) {
        $updatec = "UPDATE users SET users.password = '$tent' WHERE username = '$name' && int_id = '$int_id'";
        $res = mysqli_query($connection, $updatec);
        if ($res) {
            echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Created Password Successfully",
                text: "DONE!",
                showConfirmButton: false,
                timer: 4000
            })
        });
        </script>';
        $mail = new PHPMailer;
// from email addreess and name
$mail->From = $intemail;
$mail->FromName = $intname;
// to adress and name
$mail->addAddress($email, $name);
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
$mail->Subject = "Changed Password";
$mail->Body = "<!doctype html>
<html lang='en' xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
  <head>
    <title>
    </title>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style type='text/css'>
      #outlook a{padding: 0;}
      			.ReadMsgBody{width: 100%;}
      			.ExternalClass{width: 100%;}
      			.ExternalClass *{line-height: 100%;}
      			body{margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;}
      			table, td{border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;}
      			img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
      			p{display: block; margin: 13px 0;}
    </style>
    <!--[if !mso]><!-->
    <style type='text/css'>
      @media only screen and (max-width:480px) {
      			  		@-ms-viewport {width: 320px;}
      			  		@viewport {	width: 320px; }
      				}
              #dam {
              color: #FFFFFF;
              font-family: Droid Sans, 'Helvetica Neue', Arial, sans-serif;
              font-size: 36px;
              line-height:1;text-align:center;
              }
    </style>
		<xml> 
			<o:OfficeDocumentSettings> 
				<o:AllowPNG/> 
				<o:PixelsPerInch>96</o:PixelsPerInch> 
			</o:OfficeDocumentSettings> 
		</xml>
		<style type='text/css'> 
			.outlook-group-fix{width:100% !important;}
		</style>
		<![endif]-->
    <style type='text/css'>
      @media only screen and (max-width:480px) {
      
      			  table.full-width-mobile { width: 100% !important; }
      				td.full-width-mobile { width: auto !important; }
      
      }
      @media only screen and (min-width:480px) {
      .dys-column-per-100 {
      	width: 100.000000% !important;
      	max-width: 100.000000%;
      }
      }
      @media only screen and (max-width:480px) {
      
      			  table.full-width-mobile { width: 100% !important; }
      				td.full-width-mobile { width: auto !important; }
      
      }
      @media only screen and (min-width:480px) {
      .dys-column-per-100 {
      	width: 100.000000% !important;
      	max-width: 100.000000%;
      }
      }
      @media only screen and (min-width:480px) {
      .dys-column-per-100 {
      	width: 100.000000% !important;
      	max-width: 100.000000%;
      }
      }
    </style>
  </head>
  <body>
    <div>
      <!--[if mso | IE]>
<table align='center' border='0' cellpadding='0' cellspacing='0' style='width:600px;' width='600'><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'>
<![endif]-->
      <div style='background:#4DBFBF;background-color:#4DBFBF;margin:0px auto;max-width:600px;'>
        <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#4DBFBF;background-color:#4DBFBF;width:100%;'>
          <tbody>
            <tr>
              <td style='direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;'>
                <!--[if mso | IE]>
<table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td style='vertical-align:top;width:600px;'>
<![endif]-->
                <div class='dys-column-per-100 outlook-group-fix' style='direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;'>
                  <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:collapse;border-spacing:0px;'>
                          <tbody>
                            <tr>
                              <td style='width:216px;'>
                                <img alt='Descriptive Alt Text' height='189' src='https://assets.opensourceemails.com/imgs/neopolitan/robot-happy.png' style='border:none;display:block;font-size:13px;height:189px;outline:none;text-decoration:none;width:100%;' width='216' />
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                        <div id='dam'>
                          Changed Password!
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                        <div style='color:#187272;font-family:Droid Sans, Helvetica Neue, Arial, sans-serif;font-size:16px;line-height:20px;text-align:center;'>
                          $name Your password has been changed successfully!
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;' vertical-align='middle'>
                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:separate;line-height:100%;width:200px;'>
                          <tr>
                            <td align='center' bgcolor='#178F8F' role='presentation' style='background-color:#178F8F;border:none;border-radius:4px;cursor:auto;padding:10px 25px;' valign='middle'>
                              <a href='https://app.sekanisystems.com.ng' style='background:#178F8F;color:#ffffff;font-family:Droid Sans, Helvetica Neue, Arial, sans-serif;font-size:16px;font-weight:bold;line-height:30px;margin:0;text-decoration:none;text-transform:none;' target='_blank'>
                                Login!
                              </a>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </div>
                <!--[if mso | IE]>
</td></tr></table>
<![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--[if mso | IE]>
</td></tr></table>
<![endif]-->
      <!--[if mso | IE]>
<table align='center' border='0' cellpadding='0' cellspacing='0' style='width:600px;' width='600'><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'>
<![endif]-->
      <div style='background:#F5774E;background-color:#F5774E;margin:0px auto;max-width:600px;'>
        <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#F5774E;background-color:#F5774E;width:100%;'>
          <tbody>
            <tr>
              <td style='direction:ltr;font-size:0px;padding:10px 0;text-align:center;vertical-align:top;'>
                <!--[if mso | IE]>
<table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td style='vertical-align:top;width:600px;'>
<![endif]-->
                <div class='dys-column-per-100 outlook-group-fix' style='direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;'>
                  <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
                    <tr>
                      <td align='center' style='font-size:0px;padding:0;word-break:break-word;'>
                        <div style='color:#FFFFFF;font-family:Droid Sans, Helvetica Neue, Arial, sans-serif;font-size:36px;line-height:1;text-align:center;'>
                          STAY SAFE!
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;padding-top:10px;word-break:break-word;'>
                        <div style='color:#933f24;font-family:Droid Sans, Helvetica Neue, Arial, sans-serif;font-size:18px;line-height:1;text-align:center;'>
                          Eid el Kabir
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align='center' style='font-size:0px;padding:5px;word-break:break-word;'>
                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:collapse;border-spacing:0px;'>
                          <tbody>
                            <tr>
                              <td style='width:147px;'>
                                <img alt='Descriptive Alt Text' height='121' src='https://assets.opensourceemails.com/imgs/neopolitan/present.png' style='border:none;display:block;font-size:13px;height:121px;outline:none;text-decoration:none;width:100%;' width='147' />
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                        <div style='color:#933f24;font-family:Droid Sans, Helvetica Neue, Arial, sans-serif;font-size:13px;line-height:1;text-align:center;'>
                          Thank You
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
                <!--[if mso | IE]>
</td></tr></table>
<![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--[if mso | IE]>
</td></tr></table>
<![endif]-->
      <!--[if mso | IE]>
<table align='center' border='0' cellpadding='0' cellspacing='0' style='width:600px;' width='600'><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'>
<![endif]-->
      <div style='background:#414141;background-color:#414141;margin:0px auto;max-width:600px;'>
        <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#414141;background-color:#414141;width:100%;'>
          <tbody>
            <tr>
              <td style='direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;text-align:center;vertical-align:top;'>
                <!--[if mso | IE]>
<table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td style='vertical-align:top;width:600px;'>
<![endif]-->
                <div class='dys-column-per-100 outlook-group-fix' style='direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;'>
                  <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                        <table border='0' cellpadding='0' cellspacing='0' style='cellpadding:0;cellspacing:0;color:#000000;font-family:Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:40%;' width='40%'>
                          <tbody>
                            <tr align='center'>
                              <td align='center'>
                                <a href='https://linkedin.com'>
                                  <img alt='linkedin' height='50px' src='https://swu-cs-assets.s3.amazonaws.com/OSET/neopolitan/linkedin.png' width='50px'>
                                </a>
                              </td>
                              <td align='center'>
                                <a href='https://facebook.com'>
                                  <img alt='facebook' height='50px' src='https://swu-cs-assets.s3.amazonaws.com/OSET/neopolitan/facebook.png' width='50px'>
                                </a>
                              </td>
                              <td align='center'>
                                <a href='https://twitter.com'>
                                  <img alt='twitter' height='50px' src='https://swu-cs-assets.s3.amazonaws.com/OSET/neopolitan/twitter.png' width='50px'>
                                </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </table>
                </div>
                <!--[if mso | IE]>
</td></tr></table>
<![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--[if mso | IE]>
</td></tr></table>
<![endif]-->
      <!--[if mso | IE]>
<table align='center' border='0' cellpadding='0' cellspacing='0' style='width:600px;' width='600'><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'>
<![endif]-->
      <div style='background:#414141;background-color:#414141;margin:0px auto;max-width:600px;'>
        <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#414141;background-color:#414141;width:100%;'>
          <tbody>
            <tr>
              <td style='direction:ltr;font-size:0px;padding:20px 0;padding-top:0px;text-align:center;vertical-align:top;'>
                <!--[if mso | IE]>
<table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td style='vertical-align:top;width:600px;'>
<![endif]-->
                <div class='dys-column-per-100 outlook-group-fix' style='direction:ltr;display:inline-block;font-size:13px;text-align:left;vertical-align:top;width:100%;'>
                  <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:top;' width='100%'>
                    <tr>
                      <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
                        <div style='color:#BBBBBB;font-family:Droid Sans, Helvetica Neue, Arial, sans-serif;font-size:12px;line-height:1;text-align:center;'>
                          Unsubscribe | Contact © 2020 All Rights Reserved
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
                <!--[if mso | IE]>
</td></tr></table>
<![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--[if mso | IE]>
</td></tr></table>
<![endif]-->
    </div>
  </body>
</html>";
$mail->AltBody = "This is the plain text version of the email content";
// mail system
if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} else
{
    echo $xm = "Changing Password?";
    // Unset all of the session variables
    $_SESSION = array();
    // Destroy the session.
   session_destroy();
   $URL="login.php";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
        }
    } else if ($code == ""){
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Email Confirmation",
                text: "Check Email For Confirmation",
                showConfirmButton: false,
                timer: 4000
            })
        });
        </script>';
    } else {

        function getIPAddress() {
            //whether ip is from the share internet  
             if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                    $ip = $_SERVER['HTTP_CLIENT_IP'];  
                }  
            //whether ip is from the proxy  
            else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
             }  
        //whether ip is from the remote address  
            else{  
                    $ip = $_SERVER['REMOTE_ADDR'];  
             }  
             return $ip;  
        } 
        $ip = getIPAddress();
        $getip = mysqli_query($connection, "SELECT * FROM ip_blacklist WHERE ip_add = '$ip'");

        if (mysqli_num_rows($getip) == 1) {
            $gtp = mysqli_query($connection, "SELECT * FROM ip_blacklist WHERE ip_add = '$ip'");
            if (count([$gtp]) == 1) {
            $x = mysqli_fetch_array($gtp);
            $vm = $x['trial'];
            }
            // new script
            $try = 0;
            $takme = $vm + 1;
            $timestamp = date('Y-m-d H:i:s');
            $takemeup = "UPDATE ip_blacklist SET trial = '$takme', time = '$timestamp' WHERE ip_add = '$ip'";
            $res5 = mysqli_query($connection, $takemeup);
            if ($res5) {
                echo '<script type="text/javascript">
            $(document).ready(function(){
            swal({
                type: "error",
                title: "Wrong Confrimation Code",
                text: "Error You Will Be Blocked After Trying Three Times",
                showConfirmButton: false,
                timer: 5000
            })
        });
        </script>';
            }
            if ($vm >= 3) {
                $_SESSION = array();
               // Destroy the session.
               session_destroy();
               echo '<script type="text/javascript">
            $(document).ready(function(){
            swal({
                type: "error",
                title: "BLOCKED IP",
                text: "Contact Us For Confirmation and Unblocking",
                showConfirmButton: false,
                timer: 5000
            })
        });
        </script>';
               $URL="ip/block_ip.php";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            } else {
                $newcode = $vm + 1;
                $mmm = mysqli_query($connection, "UPDATE ip_blacklist SET trial = '$newcode' WHERE ip_add='$ip'");
            }
        } else {
            $try = 0;
            $timestamp = date('Y-m-d H:i:s');
            $takemeup = "INSERT INTO `ip_blacklist` (`id`, `user`, `ip_add`, `time`, `trial`) VALUES ('{$int_id}', '{$name}', '{$ip}', '{$timestamp}', '{$try}')";
            $res5 = mysqli_query($connection, $takemeup);
            if ($res5) {
                echo '<script type="text/javascript">
            $(document).ready(function(){
            swal({
                type: "error",
                title: "Wrong Confrimation Code",
                text: "Error You Will Be Blocked After Trying Three Times",
                showConfirmButton: false,
                timer: 5000
            })
        });
        </script>';
            }
        }
    }
}
?>

<div class="card text-center">
  <div class="card-header">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
        <a class="nav-link active" href="#0">Active</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <h4 class="card-title"><?php echo $fullname; ?></h4>
    <p class="card-text">
    <!-- <a href="getkey.php?getme=<?php echo $codex ?>" target="_blank" value="button2" class="btn btn-primary btn-link btn-wd btn-sm">getcode</a> -->
    <form class="form" method="POST">
        <p class="description text-center" style="color: green;"><?php echo $mx; ?></p>
            <div class="card-body">
                <div class="form-group bmd-form-group">
                    <br>
                     <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">code</i></div>
                        </div>
                        <input type="text" name="code" placeholder="Code" class="form-control" required>
                    </div>
                </div>
                <div class="justify-content-center">
                    <button type="submit" name="button2" value="button2" class="btn btn-primary btn-link btn-wd btn-lg">SUBMIT</button>
                </div>
            </div>
    </form>
    </p>
  </div>
</div>
