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

if ($result) {
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
$mail->Body = "<!DOCTYPE html>
<html lang='en' xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
<head>
    <meta charset='utf-8'> <!-- utf-8 works for most cases -->
    <meta name='viewport' content='width=device-width'> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv='X-UA-Compatible' content='IE=edge'> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name='x-apple-disable-message-reformatting'>  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->


    <link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i' rel='stylesheet'>

    <!-- CSS Reset : BEGIN -->
<style>

html,
body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #f1f1f1;
}

/* What it does: Stops email clients resizing small text. */
* {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}

/* What it does: Centers email on Android 4.4 */
div[style*='margin: 16px 0'] {
    margin: 0 !important;
}

/* What it does: Stops Outlook from adding extra spacing to tables. */
table,
td {
    mso-table-lspace: 0pt !important;
    mso-table-rspace: 0pt !important;
}

/* What it does: Fixes webkit padding issue. */
table {
    border-spacing: 0 !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    margin: 0 auto !important;
}

/* What it does: Uses a better rendering method when resizing images in IE. */
img {
    -ms-interpolation-mode:bicubic;
}

/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
a {
    text-decoration: none;
}

/* What it does: A work-around for email clients meddling in triggered links. */
*[x-apple-data-detectors],  /* iOS */
.unstyle-auto-detected-links *,
.aBn {
    border-bottom: 0 !important;
    cursor: default !important;
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
.a6S {
    display: none !important;
    opacity: 0.01 !important;
}

/* What it does: Prevents Gmail from changing the text color in conversation threads. */
.im {
    color: inherit !important;
}

/* If the above doesn't work, add a .g-img class to any image in question. */
img.g-img + div {
    display: none !important;
}

/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
/* Create one of these media queries for each additional viewport size you'd like to fix */

/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
    u ~ div .email-container {
        min-width: 320px !important;
    }
}
/* iPhone 6, 6S, 7, 8, and X */
@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
    u ~ div .email-container {
        min-width: 375px !important;
    }
}
/* iPhone 6+, 7+, and 8+ */
@media only screen and (min-device-width: 414px) {
    u ~ div .email-container {
        min-width: 414px !important;
    }
}

</style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
<style>

.primary{
	background: #f3a333;
}

.bg_white{
	background: #ffffff;
}
.bg_light{
	background: #fafafa;
}
.bg_black{
	background: #000000;
}
.bg_dark{
	background: rgba(0,0,0,.8);
}
.email-section{
	padding:2.5em;
}

/*BUTTON*/
.btn{
	padding: 10px 15px;
}
.btn.btn-primary{
	border-radius: 30px;
	background: #f3a333;
	color: #ffffff;
}



h1,h2,h3,h4,h5,h6{
	font-family: 'Playfair Display', serif;
	color: #000000;
	margin-top: 0;
}

body{
	font-family: 'Montserrat', sans-serif;
	font-weight: 400;
	font-size: 15px;
	line-height: 1.8;
	color: rgba(0,0,0,.4);
}

a{
	color: #f3a333;
}

table{
}
/*LOGO*/

.logo h1{
	margin: 0;
}
.logo h1 a{
	color: #000;
	font-size: 20px;
	font-weight: 700;
	text-transform: uppercase;
	font-family: 'Montserrat', sans-serif;
}

/*HERO*/
.hero{
	position: relative;
}
.hero img{

}
.hero .text{
	color: rgba(255,255,255,.8);
}
.hero .text h2{
	color: #ffffff;
	font-size: 30px;
	margin-bottom: 0;
}


/*HEADING SECTION*/
.heading-section{
}
.heading-section h2{
	color: #000000;
	font-size: 28px;
	margin-top: 0;
	line-height: 1.4;
}
.heading-section .subheading{
	margin-bottom: 20px !important;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(0,0,0,.4);
	position: relative;
}
.heading-section .subheading::after{
	position: absolute;
	left: 0;
	right: 0;
	bottom: -10px;
	content: '';
	width: 100%;
	height: 2px;
	background: #f3a333;
	margin: 0 auto;
}

.heading-section-white{
	color: rgba(255,255,255,.8);
}
.heading-section-white h2{
	font-size: 28px;
	font-family: 
	line-height: 1;
	padding-bottom: 0;
}
.heading-section-white h2{
	color: #ffffff;
}
.heading-section-white .subheading{
	margin-bottom: 0;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(255,255,255,.4);
}


.icon{
	text-align: center;
}
.icon img{
}


/*SERVICES*/
.text-services{
	padding: 10px 10px 0; 
	text-align: center;
}
.text-services h3{
	font-size: 20px;
}

/*BLOG*/
.text-services .meta{
	text-transform: uppercase;
	font-size: 14px;
}

/*TESTIMONY*/
.text-testimony .name{
	margin: 0;
}
.text-testimony .position{
	color: rgba(0,0,0,.3);

}


/*VIDEO*/
.img{
	width: 100%;
	height: auto;
	position: relative;
}
.img .icon{
	position: absolute;
	top: 50%;
	left: 0;
	right: 0;
	bottom: 0;
	margin-top: -25px;
}
.img .icon a{
	display: block;
	width: 60px;
	position: absolute;
	top: 0;
	left: 50%;
	margin-left: -25px;
}



/*COUNTER*/
.counter-text{
	text-align: center;
}
.counter-text .num{
	display: block;
	color: #ffffff;
	font-size: 34px;
	font-weight: 700;
}
.counter-text .name{
	display: block;
	color: rgba(255,255,255,.9);
	font-size: 13px;
}


/*FOOTER*/

.footer{
	color: rgba(255,255,255,.5);

}
.footer .heading{
	color: #ffffff;
	font-size: 20px;
}
.footer ul{
	margin: 0;
	padding: 0;
}
.footer ul li{
	list-style: none;
	margin-bottom: 10px;
}
.footer ul li a{
	color: rgba(255,255,255,1);
}


@media screen and (max-width: 500px) {

	.icon{
		text-align: left;
	}

	.text-services{
		padding-left: 0;
		padding-right: 20px;
		text-align: left;
	}

}

</style>


</head>

<body width='100%' style='margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;'>
	<center style='width: 100%; background-color: #f1f1f1;'>
    <div style='display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;'>
      &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style='max-width: 600px; margin: 0 auto;' class='email-container'>
    	<!-- BEGIN BODY -->
      <table align='center' role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%' style='margin: auto;'>
      	<tr>
          <td class='bg_white logo' style='padding: 1em 2.5em; text-align: center'>
            <img src='$int_logo' alt='' style='width: 100%; max-width: 50px; height: auto; margin: auto; display: block;'>
            <h1><a href='app.sekanisystems.com.ng'>$int_name</a></h1>
          </td>
	      </tr><!-- end tr -->
				<tr>
          <td valign='middle' class='hero' style='background-image: url(https://images.unsplash.com/photo-1502214722586-9c0a74759710?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=752&q=80); background-size: cover; height: 400px;'>
            <table>
            	<tr>
            		<td>
            			<div class='text' style='padding: 0 3em; text-align: center;'>
            				<h2 style=' color: #ffffff;text-shadow: #000000 1 0.5;'>Greetings &amp; Welcome to $int_name</h2>
            				<!-- <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p> -->
            				<p><a href='app.sekanisystems.com.ng/change_password.php?edit=$username' class='btn btn-primary'>Change Password!</a></p>
            			</div>
            		</td>
            	</tr>
            </table>
          </td>
	      </tr><!-- end tr -->
	      <tr>
		      <td class='bg_white'>
		        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
		          <tr>
		            <td class='bg_dark email-section' style='text-align:center;'>
		            	<div class='heading-section heading-section-white'>
		            		<span class='subheading'>Login Credentials</span>
		              	<h2>Welcome To $int_name</h2>
                          <p>Username: $username  ||  Password: $password</p>
                          <p>You can now Login to $int_name With this Credentials, Please change your Password With the button above or link below</p>
            				<p><a href='app.sekanisystems.com.ng/change_password.php?edit=$username' class='btn btn-primary'>Change Password!</a></p>
		            	</div>
		            </td>
		          </tr><!-- end: tr -->
		          <tr>
		            <td class='bg_light email-section' style='text-align:center;'>
		            	<table>
		            		<tr>
		          </tr><!-- end: tr -->
		          <tr>
		            <td class='bg_white email-section'>
		            	<div class='heading-section' style='text-align: center; padding: 0 30px;'>
		            		<span class='subheading'>Greetings</span>
		              	<h2>Ramadan Kareem</h2>
		              	<!-- <p>$int_name wish you all a safe celebration.</p> -->
		            	</div>
		            	<table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
		            		<tr>
                      <!-- <td valign='top' width='50%' style='padding-top: 20px;'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td style='padding-right: 10px;'>
                              <img src='https://images.unsplash.com/photo-1459257831348-f0cdd359235f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60' alt='' style='width: 100%; max-width: 600px; height: auto; margin: auto; display: block;'>
                            </td>
                          </tr>
                          <tr>
                            <td class='text-services' style='text-align: left;'>
                            	<h3>SAVING</h3>
                             	<p>Far far away, behind the word mountains, far from the countries</p>
                             	<p><a href='#' class='btn btn-primary'>Read more</a></p>
                            </td>
                          </tr>
                        </table>
                      </td> -->
                      <!-- <td valign='top' width='50%' style='padding-top: 20px;'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td style='padding-left: 10px;'>
                              <img src='https://images.unsplash.com/photo-1539622287262-61e066a2c534?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60' alt='' style='width: 100%; max-width: 600px; height: auto; margin: auto; display: block;'>
                            </td>
                          </tr>
                          <tr>
                            <td class='text-services' style='text-align: left;'>
                            	<h3>CARD/ATM</h3>
                              <p>Far far away, behind the word mountains, far from the countries</p>
                              <p><a href='#' class='btn btn-primary'>Read more</a></p>
                            </td>
                          </tr>
                        </table>
                      </td> -->
                    </tr>
		            	</table>
		            </td>
                  </tr>
                  <!-- end: tr -->

		          <tr>
		            <td class='bg_light email-section' style='padding: 0; width: 100%;'>
		            	<table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
		            		<tr>
                      <!-- <td valign='middle' width='50%'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td class='text-services' style='text-align: left; padding: 20px 30px;'>
                            	<div class='heading-section'>
								            		<span class='subheading'>24/7 SUPPORT</span>
								              	<h2 style='font-size: 22px;'>Customer Care</h2>
								              	<p>We are always here for you at all times.</p>
								              	<p><a href='#' class='btn btn-primary'>Read more</a></p>
								            	</div>
                            </td>
                          </tr>
                        </table>
                      </td> -->
                      <td valign='middle' width='50%'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td>
                              <img src='https://images.unsplash.com/photo-1587617425953-9075d28b8c46?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80' alt='' style='width: 100%; max-width: 600px; height: auto; margin: auto; display: block;'>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
		            	</table>
		            </td>
		          </tr><!-- end: tr -->
		          <tr>
		            <td class='bg_light email-section' style='padding: 0; width: 100%;'>
		            	<table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
		            		<tr>
                      <!-- <td valign='middle' width='50%'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td>
                              <img src='https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80' alt='' style='width: 100%; max-width: 600px; height: auto; margin: auto; display: block;'>
                            </td>
                          </tr>
                        </table>
                      </td> -->
                      <td valign='middle' width='50%'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td class='text-services' style='text-align: left; padding: 20px 30px;'>
                            	<div class='heading-section'>
								            		<span class='subheading'>#STAY SAFE</span>
								              	<h2 style='font-size: 22px;'>Together We Can End Covid-19</h2>
								              	<p>
                                                      <ul>
                                                          <li> <b>STAY</b> home as much as you can</li>
                                                          <li> <b>KEEP</b> a safe distance</li>
                                                          <li> <b>WASH</b> hands often</li>
                                                          <li> <b>COVER</b> your cough</li>
                                                      </ul>
                                                  </p>
								            	</div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
		            	</table>
		            </td>
		          <!-- <tr>
			          <td valign='middle' class='counter' style='background-image: url(images/bg_1.jpg); background-size: cover; padding: 4em 0;'>
			            <table>
			            	<tr>
			            		<td valign='middle' width='25%'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td class='counter-text'>
                            	<span class='num'>9457</span>
                            	<span class='name'>Happy Customer</span>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign='middle' width='25%'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td class='counter-text'>
                            	<span class='num'>20</span>
                            	<span class='name'>Years of Experienced</span>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign='middle' width='25%'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td class='counter-text'>
                            	<span class='num'>80</span>
                            	<span class='name'>Branches</span>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign='middle' width='25%'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td class='counter-text'>
                            	<span class='num'>980</span>
                            	<span class='name'>Staff</span>
                            </td>
                          </tr>
                        </table>
                      </td>
			            	</tr>
			            </table>
			          </td>
				      </tr> -->
				      <tr>
		            <!-- <td class='bg_white email-section'>
		            	<div class='heading-section' style='text-align: center; padding: 0 30px;'>
		            		<span class='subheading'>Blog</span>
		              	<h2>Read Stories</h2>
		              	<p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
		            	</div>
		            	<table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
		            		<tr>
                      <td valign='top' width='50%' style='padding-top: 20px;'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td style='padding-right: 10px;'>
                              <img src='images/blog-1.jpg' alt='' style='width: 100%; max-width: 600px; height: auto; margin: auto; display: block;'>
                            </td>
                          </tr>
                          <tr>
                            <td class='text-services' style='text-align: left;'>
                            	<p class='meta'><span>Posted on Feb 18, 2019</span> <span>Food</span></p>
                            	<h3>Healthy Foods For Kids</h3>
                             	<p>Far far away, behind the word mountains, far from the countries</p>
                             	<p><a href='#' class='btn btn-primary'>Read more</a></p>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign='top' width='50%' style='padding-top: 20px;'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td style='padding-left: 10px;'>
                              <img src='images/blog-2.jpg' alt='' style='width: 100%; max-width: 600px; height: auto; margin: auto; display: block;'>
                            </td>
                          </tr>
                          <tr>
                            <td class='text-services' style='text-align: left;'>
                            	<p class='meta'><span>Posted on Feb 18, 2019</span> <span>Food</span></p>
                            	<h3>A Fresh Food Organic</h3>
                              <p>Far far away, behind the word mountains, far from the countries</p>
                              <p><a href='#' class='btn btn-primary'>Read more</a></p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
		            	</table>
		            </td> -->
		          </tr><!-- end: tr -->
		          <tr>
		            <!-- <td class='bg_light email-section'>
		            	<div class='heading-section' style='text-align: center; padding: 0 30px;'>
		            		<span class='subheading'>Says</span>
		              	<h2>Testimonial</h2>
		              	<p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
		            	</div>
		            	<table role='presentation' border='0' cellpadding='10' cellspacing='0' width='100%'>
		            		<tr>
                      <td valign='top' width='50%' style='padding-top: 20px;'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td>
                              <img src='images/person_1.jpg' alt='' style='width: 100px; max-width: 600px; height: auto; margin: auto; margin-bottom: 20px; display: block; border-radius: 50%;'>
                            </td>
                          </tr>
                          <tr>
                            <td class='text-testimony' style='text-align: center;'>
                            	<h3 class='name'>Ronald Tuff</h3>
                            	<span class='position'>Businessman</span>
                             	<p>Far far away, behind the word mountains, far from the countries</p>
                             	<p><a href='#' class='btn btn-primary'>Read more</a></p>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign='top' width='50%' style='padding-top: 20px;'>
                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                          <tr>
                            <td>
                              <img src='images/person_2.jpg' alt='' style='width: 100px; max-width: 600px; height: auto; margin: auto; margin-bottom: 20px; display: block; border-radius: 50%;'>
                            </td>
                          </tr>
                          <tr>
                            <td class='text-testimony' style='text-align: center;'>
                            	<h3 class='name'>Willam Clarson</h3>
                            	<span class='position'>Businessman</span>
                              <p>Far far away, behind the word mountains, far from the countries</p>
                              <p><a href='#' class='btn btn-primary'>Read more</a></p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
		            	</table>
		            </td> -->
		          </tr><!-- end: tr -->
		          
		        </table>

		      </td>
		    </tr><!-- end:tr -->
      <!-- 1 Column Text + Button : END -->
      </table>
      <table align='center' role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%' style='margin: auto;'>
      	<tr>
          <td valign='middle' class='bg_black footer email-section'>
            <table>
            	<tr>
                <td valign='top' width='33.333%' style='padding-top: 20px;'>
                  <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                    <tr>
                      <td style='text-align: left; padding-right: 10px;'>
                      	<h3 class='heading'>$int_name</h3>
                      	<!-- <p>Bank</p> -->
                      </td>
                    </tr>
                  </table>
                </td>
                <td valign='top' width='33.333%' style='padding-top: 20px;'>
                  <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                    <tr>
                      <td style='text-align: left; padding-left: 5px; padding-right: 5px;'>
                      	<h3 class='heading'>Contact Info</h3>
                      	<ul>
					                <li><span class='text'>$int_address</span></li>
					                <li><span class='text'>$int_phone</span></a></li>
					              </ul>
                      </td>
                    </tr>
                  </table>
                </td>
                <td valign='top' width='33.333%' style='padding-top: 20px;'>
                  <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                    <tr>
                      <td style='text-align: left; padding-left: 10px;'>
                      	<h3 class='heading'>Social Links</h3>
                      	<ul>
					                <li><a href='$int_email'>Email</a></li>
					                <li><a href='$int_web'>Website</a></li>
					                <li><a href='#'>Facebook</a></li>
					                <li><a href='#'>Twitter</a></li>
					              </ul>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!-- end: tr -->
        <tr>
        	<td valign='middle' class='bg_black footer email-section'>
        		<table>
            	<tr>
                <td valign='top' width='33.333%'>
                  <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                    <tr>
                      <td style='text-align: left; padding-right: 10px;'>
                      	<p>&copy; 2020 $int_name. All Rights Reserved</p>
                      </td>
                    </tr>
                  </table>
                </td>
                <td valign='top' width='33.333%'>
                  <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                    <tr>
                      <td style='text-align: right; padding-left: 5px; padding-right: 5px;'>
                      	<p><a href='#' style='color: rgba(255,255,255,.4);'>Unsubcribe</a></p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
        	</td>
        </tr>
      </table>

    </div>
  </center>
</body>
</html>";
$mail->AltBody = "This is the plain text version of the email content";
// mail system
if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
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