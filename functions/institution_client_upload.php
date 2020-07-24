<?php
// connection
include("connect.php");
include("../mfi/ajaxcall.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
// qwerty
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$ekaniN = $_SESSION["sek_name"];
$ekaniE = $_SESSION["sek_email"];
$sender_id = $_SESSION["sender_id"];
?>
<?php
$rigits = 7;
$sessint_id = $_SESSION["int_id"];
$ctype = strtoupper($_POST['ctype']);
$rand = str_pad(rand(0, pow(10, $rigits)-1), $rigits, '0', STR_PAD_LEFT);


if($ctype == 'INDIVIDUAL' || $ctype == 'GROUP')
{
  $loan_officer_id = $_POST["acct_of"];

$acct_type = strtoupper($_POST['acct_type']);
$branch = strtoupper($_POST['branch']);
$display_name = strtoupper($_POST['display_name']);
// an account number generation
 $inttest = str_pad($branch, 3, '0', STR_PAD_LEFT);
$digit = 4;
$randms = str_pad(rand(0, pow(10, $digit)-1), 7, '0', STR_PAD_LEFT);
$account_no = $inttest."".$randms;
// auto calculation for the account number generation
$first_name = strtoupper($_POST['firstname']);
$last_name = strtoupper($_POST['lastname']);
$middlename = strtoupper($_POST['middlename']);
$phone = $_POST['phone'];
$phone2 = $_POST['phone2'];
$email = $_POST['email'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$date_of_birth = $_POST['date_of_birth'];
$country = $_POST['country'];
$state = $_POST['stated'];
$lga = $_POST['lgka'];
$occupation = $_POST['occupation'];
$bvn = $_POST['bvn'];
$loan_status = "Not Active";
$activation_date = date("Y-m-d");
$submitted_on = date("Y-m-d");
// $sa = $_POST['sms_active'];
?>
<input type="text" id="s_int_id" value="<?php echo $sessint_id; ?>" hidden>
<input type="text" id="s_acct_nox" value="<?php echo $account_no; ?>" hidden>
<input type="text" id="s_branch_id" value="<?php echo $branch_id; ?>" hidden>
<input type="text" id="s_phone" value="<?php echo $phone; ?>" hidden>
<input type="text" id="s_sender_id" value="<?php echo $sender_id; ?>" hidden>
<input type="text" id="s_int_name" value="<?php echo $int_name; ?>" hidden>
<div id="make_display"></div>
<?php
$queryd = mysqli_query($connection, "SELECT * FROM savings_product WHERE id='$acct_type'");
$res = mysqli_fetch_array($queryd);
$accttname = $res['name'];
$type_id = $res['accounting_type'];
// $ea = $_POST['email_active'];
$id_card = $_POST['id_card'];
// an if statement to return uncheck value to 0
if ( isset($_POST['sms_active']) ) {
    $sms_active = 1;
} else {
    $sms_active = 0;
}

if ( isset($_POST['email_active']) ) {
    $email_active = 1;
} else { 
    $email_active = 0;
}

$digits = 9;

$temp = explode(".", $_FILES['signature']['name']);
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$image1 = $randms. '.' .end($temp);

if (move_uploaded_file($_FILES['signature']['tmp_name'], "clients/sign/" . $image1)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$temp2 = explode(".", $_FILES['id_img_url']['name']);
$randms2 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$image2 = $randms2. '.' .end($temp2);

if (move_uploaded_file($_FILES['id_img_url']['tmp_name'], "clients/id/" . $image2)) {
$msg = "Image uploaded successfully";
} else {
$msg = "Image Failed";
}

$temp3 = explode(".", $_FILES['passport']['name']);
$randms3 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$image3 = $randms3. '.' .end($temp3);

if (move_uploaded_file($_FILES['passport']['tmp_name'], "clients/passport/" . $image3)) {
$msg = "Image uploaded successfully";
} else {
$msg = "Image Failed";
}
// gaurantors part
$query = "INSERT INTO client (int_id, loan_officer_id, client_type, account_type,
display_name, account_no,
firstname, lastname, middlename, mobile_no, mobile_no_2, email_address, address, gender, date_of_birth,
branch_id, country, STATE_OF_ORIGIN, lga, occupation, bvn, sms_active, email_active, id_card,
passport, signature, id_img_url, loan_status, submittedon_date, activation_date) VALUES ('{$sessint_id}', '{$loan_officer_id}', '{$ctype}',
'{$acct_type}', '{$display_name}', '{$account_no}', '{$first_name}', '{$last_name}', '{$middlename}', '{$phone}', '{$phone2}',
'{$email}', '{$address}', '{$gender}', '{$date_of_birth}', '{$branch}',
'{$country}', '{$state}', '{$lga}', '{$occupation}', '{$bvn}', '{$sms_active}', '{$email_active}',
'{$id_card}', '{$image3}', '{$image1}', '{$image2}', '{$loan_status}',
'{$submitted_on}', '{$activation_date}')";

$res = mysqli_query($connection, $query);

 if ($res) {
    $acctquery = mysqli_query($connection, "SELECT * FROM client WHERE account_no = '$account_no'");
    if (count([$acctquery]) == 1) {
        $x = mysqli_fetch_array($acctquery);
        $int_id = $x['int_id'];
        $branch_id = $x['branch_id'];
        $account_no = $x['account_no'];
        $account_type = $x['account_type'];
        $client_id = $x['id'];
        $field_officer_id = $x['loan_officer_id'];
        $submittedon_date = $x['submittedon_date'];
        $submittedon_userid = $x['loan_officer_id'];
        $currency_code = "NGN";
        $activation_date = $x['activation_date'];
        $activation_userid = $x['loan_officer_id'];
        $account_balance_derived = 0;

        $accountins = "INSERT INTO account (int_id, branch_id, account_no, account_type,
        type_id, product_id, client_id, field_officer_id, submittedon_date, submittedon_userid,
        currency_code, activatedon_date, activatedon_userid,
        account_balance_derived) VALUES ('{$int_id}', '{$branch_id}', '{$account_no}',
        '{$accttname}', '{$type_id}', '{$account_type}', '{$client_id}', '{$field_officer_id}', '{$submittedon_date}',
        '{$submittedon_userid}', '{$currency_code}', '{$activation_date}', '{$activation_userid}',
        '{$account_balance_derived}')";

        $go = mysqli_query($connection, $accountins);
        if ($go) {
          // maing a post to the mennn SMS CHARGE
          // $sms_charge = mysqli_query($connection, "SELECT * FROM `sms_charge` WHERE int_id = '$int_id' AND account_no = '$account_no'");
          // $qp = mysqli_fetch_array($sms_charge);
          // if (mysqli_num_rows($qp) <= 0) {
          //   // create the SMS charge
          //   $insert_charge = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$int_id}', '{$client_id}', '{$account_no}', '4.00', '{$gen_date}')");
          //   // bursting overbverbverver
          // }
          // TAKE THE BVN CHARGE
          $select_account_charge = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$account_no' AND client_id = '$client_id' AND int_id = '$int_id'");
          $myx = mysqli_fetch_array($select_account_charge);
          $client_balance = $myx["account_balance_derived"];
          $client_tot_with = ($myx["last_withdrawal"] + 50);
          // ALRIGHT MEN
          $select_bvn_acct_rule =mysqli_query($connection, "SELECT * FROM savings_acct_rule WHERE int_id = '$int_id' AND savings_product_id = '$account_type'");
          $mxy = mysqli_fetch_array($select_bvn_acc_rule);
          $income_bvn = $mxy["bvn_income"];
          // $expense_bvn = $mxy["bvn_expense"];
          if ($income_bvn != "" && $expense_bvn != "") {
            // dman
            $calculated_client_bal = $client_balance - 50;
            $uca = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$calculated_client_bal', last_withdrawal = '$client_tot_with' WHERE account_no = '$account_no' AND client_id = '$client_id' AND int_id = '$int_id'");
            if ($uca) {
              $digits = 9;
            $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
            $transid = "SKWAL".$randms."LET".$int_id;
            $gen_date = date("Y-m-d");
              // now make a move for the transaction
              // branch
              $uath = mysqli_query($connection, "INSERT INTO account_transaction (int_id, branch_id,
              account_no, product_id, teller_id,
              client_id, transaction_id, description, transaction_type, is_reversed,
              transaction_date, amount, running_balance_derived, overdraft_amount_derived,
              created_date, appuser_id, debit) VALUES ('{$int_id}', '{$branch_id}',
              '{$account_no}', '{$account_type}', '{$field_officer_id}', '{$client_id}', '{$transid}', 'BVN SEARCH CHARGE', 'bvn', '0',
              '{$gen_date}', '5.00', '{$calculated_client_bal}', '50.00',
              '{$gen_date}', '{$field_officer_id}', '50.00')");
              if ($uath) {
                // echo take me the charge
                $select_bvn_gl = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$income_bvn' AND int_id = '$int_id'");
                $tty = mysqli_fetch_array($select_bvn_gl);
                $bvn_gl_bal = $tty["organization_running_balance_derived"] + 10;

                $make_bvn_update = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived =  '$bvn_gl_bal' WHERE int_id = '$int_id' AND gl_code = '$income_bvn'");
                // alright
                if ($make_bvn_update) {
                  // echo out
                  $insert_gl_trans = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`,
              `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `gl_account_balance_derived`,
              `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`,
              `manually_adjusted_or_reversed`, `credit`, `debit`) 
              VALUES ('{$int_id}', '{$branch_id}', '{$income_bvn}', '{$transid}',
              'BVN INCOME', 'bvn', '{$client_id}', '0', '{$gen_date}', '10.00', '{$bvn_gl_bal}',
              '{$bvn_gl_bal}', '{$gen_date}', '0', '{$new_gl_run_bal}', '{$gen_date}',
              '0', '10.00', '0.00')");
              if ($insert_gl_trans) {
                // channel
                // DMAN
          $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
          echo header ("Location: ../mfi/client.php?message1=$randms");
              } else {
                echo "AN ERROR OCCURED IN GL TRANSACTION";
              }
                } else {
                  // echo an error
                  echo "AN ERROR OCCURED IN GL UPDATE";
                }
              } else {
                // echo an error
                echo "ACCOUNT TRANSACTION IS BAD ";
              }
            } else 
            {
              // echo
              echo "ACCOUNT IS BAB";
            }
          } else {
            // export an output
            echo "DAMN BVN HAS PROBLEM CALL US NOW";
          }
          // $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
          // echo header ("Location: ../mfi/client.php?message1=$randms");
          // NOW CHECK THE BVN TABLE
          ?>
<input type="text" id="s_client_id" value="<?php echo $client_id; ?>" hidden>
<input type="text" id="s_client_name" value="<?php echo $first_name." ".$last_name; ?>" hidden>
<script>
          $(document).ready(function() {
              var int_id = $('#s_int_id').val();
              var branch_id = $('#s_branch_id').val();
              var sender_id = $('#s_sender_id').val();
              var phone = $('#s_phone').val();
              var client_id = $('#s_client_id').val();
              var account_no = $('#s_acct_nox').val();
              // function
              var int_name = $('#s_int_name').val();
              var client_name = $('#s_client_name').val();
              // now we work on the body.
              var msg = "WELCOME TO "+int_name+" PLEASE FIND YOUR ACCOUNT DETAILS BELOW\n"+"ACCT NO:"+account_no+"\nACCT NAME:"+client_name+"\n Thank you!";
              $.ajax({
                url:"../mfi/ajax_post/sms/sms.php",
                method:"POST",
                data:{int_id:int_id, branch_id:branch_id, sender_id:sender_id, phone:phone, msg:msg, client_id:client_id, account_no:account_no },
                success:function(data){
                  $('#make_display').html(data);
                }
              });
          });
        </script>
          <?php
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
	color: #fffffff;
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
            				<h2 style='color:#ffffff; text-shadow: #000000 1 0.5;'>Greetings &amp; Welcome to $int_name</h2>
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
						  
						  <p>Name: $last_name $first_name</p>
						  <p>Your new Account Number is : $account_no</p>
                          <p>You can now Login to $int_name With this Credentials, Please change your Password With the button above </p>
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
    echo $xm = "Changing Password?";
}
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/client.php?message2=$randms");
            // echo header("location: ../mfi/client.php");
        }
    }

 } else {
     echo "<p>Error</p>";
 }
// if (move_uploaded_file($_FILES['image1']['tmp_name'], $target)) {
//     echo "Image uploaded successfully";
// }else{
//     echo "Failed to upload image";
// }
if ($connection->error) {
        try {   
            throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
        } catch(Exception $e ) {
            echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
            echo nl2br($e->getTraceAsString());
        }
    }
}
elseif($ctype == 'CORPORATE')
{
  $rc_number = $_POST['rc_number'];
  $loan_officer_id = $_POST["acct_ofa"];
  $acct_type = strtoupper($_POST['acct_type']);
  $branch = strtoupper($_POST['brancha']);
  $display_name = strtoupper($_POST['display_namea']);
  $email = $_POST['emaila'];
  $address = $_POST['addressa'];
  $date_of_birth = $_POST['date_of_birtha'];
// an account number generation
 $inttest = str_pad($branch, 4, '0', STR_PAD_LEFT);
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$account_no = $inttest."".$randms;
$country = "NIGERIA";
$loan_status = "Not Active";
$activation_date = date("Y-m-d");
$submitted_on = date("Y-m-d");
$sig_one = $_POST['sig_one'];
$sig_two = $_POST['sig_two'];
$sig_three = $_POST['sig_three'];
$sig_address_one = $_POST['sig_address_one'];
$sig_address_two = $_POST['sig_address_two'];
$sig_address_three = $_POST['sig_address_three'];
$sig_phone_one = $_POST['sig_phone_one'];
$sig_phone_two = $_POST['sig_phone_two'];
$sig_phone_three = $_POST['sig_phone_three'];
$sig_gender_one = $_POST['sig_gender_one'];
$sig_gender_two = $_POST['sig_gender_two'];
$sig_gender_three = $_POST['sig_gender_three'];
$sig_state_one = $_POST['sig_state_one'];
$sig_state_two = $_POST['sig_state_two'];
$sig_state_three = $_POST['sig_state_three'];
$sig_lga_one = $_POST['sig_lga_one'];
$sig_lga_two = $_POST['sig_lga_two'];
$sig_lga_three = $_POST['sig_lga_three'];
$sig_occu_one = $_POST['sig_occu_one'];
$sig_occu_two = $_POST['sig_occu_two'];
$sig_occu_three = $_POST['sig_occu_three'];
$sig_bvn_one = $_POST['sig_bvn_one'];
$sig_bvn_two = $_POST['sig_bvn_two'];
$sig_bvn_three = $_POST['sig_bvn_three'];

$queryd = mysqli_query($connection, "SELECT * FROM savings_product WHERE id='$acct_type'");
$res = mysqli_fetch_array($queryd);
$accttname = $res['name'];
$type_id = $res['accounting_type'];

if( $_POST['sms_active_one']){
  $sms_active_one = 1;
}
else{
  $sms_active_one = 0;
}
if( $_POST['sms_active_two']){
  $sms_active_two = 1;
}
else{
  $sms_active_two = 0;
}
if( $_POST['sms_active_three']){
  $sms_active_three = 1;
}
else{
  $sms_active_three = 0;
}

if( $_POST['email_active_one']){
  $email_active_one = 1;
}
else{
  $email_active_one = 0;
}
if( $_POST['email_active_two']){
  $email_active_two = 1;
}
else{
  $email_active_two = 0;
}
if( $_POST['email_active_three']){
  $email_active_three = 1;
}
else{
  $email_active_three = 0;
}


$digits = 7;

$temp1 = explode(".", $_FILES['sig_passport_one']['name']);
$randms1 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sig_passport_one = $randms1. '.' .end($temp1);
if (move_uploaded_file($_FILES['sig_passport_one']['tmp_name'], "clients/passport/" . $sig_passport_one)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$temp2 = explode(".", $_FILES['sig_passport_two']['name']);
$randms2 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sig_passport_two = $randms2. '.' .end($temp2);

if (move_uploaded_file($_FILES['sig_passport_two']['tmp_name'], "clients/passport/" . $sig_passport_two)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$temp3 = explode(".", $_FILES['sig_passport_three']['name']);
$randms3 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sig_passport_three = $randms3. '.' .end($temp3);

if (move_uploaded_file($_FILES['sig_passport_three']['tmp_name'], "clients/passport/" . $sig_passport_three)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$temp4 = explode(".", $_FILES['sig_signature_one']['name']);
$randms4 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sig_signature_one = $randms4. '.' .end($temp4);
if (move_uploaded_file($_FILES['sig_signature_one']['tmp_name'], "clients/sign/" . $sig_signature_one)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$temp5 = explode(".", $_FILES['sig_signature_two']['name']);
$randms5 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sig_signature_two = $randms5. '.' .end($temp5);

if (move_uploaded_file($_FILES['sig_signature_two']['tmp_name'], "clients/sign/" . $sig_signature_two)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$temp6 = explode(".", $_FILES['sig_signature_three']['name']);
$randms6 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sig_signature_three = $randms6. '.' .end($temp6);

if (move_uploaded_file($_FILES['sig_signature_three']['tmp_name'], "clients/sign/" . $sig_signature_three)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$temp7 = explode(".", $_FILES['sig_id_img_one']['name']);
$randms7 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sig_id_img_one = $randms7. '.' .end($temp7);

if (move_uploaded_file($_FILES['sig_id_img_one']['tmp_name'], "clients/id/" . $sig_id_img_one)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$temp8= explode(".", $_FILES['sig_id_img_two']['name']);
$randms8 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sig_id_img_two = $randms8. '.' .end($temp8);

if (move_uploaded_file($_FILES['sig_id_img_two']['tmp_name'], "clients/id/" . $sig_id_img_two)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$temp9 = explode(".", $_FILES['sig_id_img_three']['name']);
$randms9 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sig_id_img_three = $randms9. '.' .end($temp9);

if (move_uploaded_file($_FILES['sig_id_img_three']['tmp_name'], "clients/id/" . $sig_id_img_three)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}

$sig_id_card_one = $_POST['sig_id_card_one'];
$sig_id_card_two = $_POST['sig_id_card_two'];
$sig_id_card_three = $_POST['sig_id_card_three'];


$query = "INSERT INTO client  (int_id, loan_officer_id, loan_status, branch_id, client_type, account_no, account_type, activation_date,
 firstname, display_name, date_of_birth, submittedon_date, email_address, ADDRESS, COUNTRY,
   rc_number, sig_one, sig_two, sig_three, sig_address_one, sig_address_two, sig_address_three, sig_phone_one, sig_phone_two, sig_phone_three,
    sig_gender_one, sig_gender_two, sig_gender_three, sig_state_one, sig_state_two, sig_state_three, sig_lga_one, sig_lga_two, sig_lga_three,
     sig_occu_one, sig_occu_two, sig_occu_three,sig_bvn_one, sig_bvn_two, sig_bvn_three, sms_active_one, sms_active_two, sms_active_three,
      email_active_one, email_active_two, email_active_three, sig_passport_one, sig_passport_two, sig_passport_three, sig_signature_one, 
      sig_signature_two, sig_signature_three, sig_id_img_one, sig_id_img_two, sig_id_img_three, sig_id_card_one, sig_id_card_two, sig_id_card_three, status) 
  VALUES ('{$sessint_id}', '{$loan_officer_id}', '{$loan_status}', '{$branch}', '{$ctype}', '{$account_no}','{$acct_type}', '{$activation_date}', '{$display_name}', '{$display_name}', '{$date_of_birth}',
  '{$submitted_on}', '{$email}', '{$address}','{$country}', '{$rc_number}','{$sig_one}','{$sig_two}','{$sig_three}','{$sig_address_one}','{$sig_address_two}','{$sig_address_three}',
  '{$sig_phone_one}','{$sig_phone_two}','{$sig_phone_three}','{$sig_gender_one}','{$sig_gender_two}','{$sig_gender_three}','{$sig_state_one}','{$sig_state_two}','{$sig_state_three}',
  '{$sig_lga_one}','{$sig_lga_two}','{$sig_lga_three}', '{$sig_occu_one}', '{$sig_occu_two}', '{$sig_occu_three}', '{$sig_bvn_one}','{$sig_bvn_two}','{$sig_bvn_three}','{$sms_active_one}','{$sms_active_two}','{$sms_active_three}',
  '{$email_active_one}','{$email_active_two}','{$email_active_three}','{$sig_passport_one}','{$sig_passport_two}','{$sig_passport_three}','{$sig_signature_one}','{$sig_signature_two}',
  '{$sig_signature_three}','{$sig_id_img_one}','{$sig_id_img_two}','{$sig_id_img_three}','{$sig_id_card_one}','{$sig_id_card_two}','{$sig_id_card_three}','Not Approved')";

$res = mysqli_query($connection, $query);

 if ($res) {
    $acctquery = mysqli_query($connection, "SELECT * FROM client WHERE account_no = '$account_no'");
    if (count([$acctquery]) == 1) {
        $x = mysqli_fetch_array($acctquery);
        $int_id = $x['int_id'];
        $branch_id = $x['branch_id'];
        $account_no = $x['account_no'];
        $account_type = $x['account_type'];
        $client_id = $x['id'];
        $field_officer_id = $x['loan_officer_id'];
        $submittedon_date = $x['submittedon_date'];
        $submittedon_userid = $x['loan_officer_id'];
        $currency_code = "NGN";
        $activation_date = $x['activation_date'];
        $activation_userid = $x['loan_officer_id'];
        $account_balance_derived = 0;

        $accountins = "INSERT INTO account (int_id, branch_id, account_no, account_type,
        type_id, product_id, client_id, field_officer_id, submittedon_date, submittedon_userid,
        currency_code, activatedon_date, activatedon_userid,
        account_balance_derived) VALUES ('{$int_id}', '{$branch_id}', '{$account_no}',
        '{$accttname}', {$type_id}', '{$account_type}', '{$client_id}', '{$field_officer_id}', '{$submittedon_date}',
        '{$submittedon_userid}', '{$currency_code}', '{$activation_date}', '{$activation_userid}',
        '{$account_balance_derived}')";

        $go = mysqli_query($connection, $accountins);
        if ($go) {
          $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
          echo header ("Location: ../mfi/client.php?message3=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/client.php?message4=$randms");
            // echo header("location: ../mfi/client.php");
        }
    }

 } else {
     echo "<p>Error</p>";
 }
if ($connection->error) {
        try {   
            throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
        } catch(Exception $e ) {
            echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
            echo nl2br($e->getTraceAsString());
        }
    }
}
else if
  ($connection->error) {
    try {   
        throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
    } catch(Exception $e ) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
}
?>
