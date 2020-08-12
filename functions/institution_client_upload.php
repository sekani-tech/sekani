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
            echo "SAVINGS PRODUCT BVN GL NOT FOUND";
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
              var msg = "WELCOME TO "+int_name+" PLEASE FIND YOUR ACCOUNT DETAILS BELOW\n"+"ACCT NO:"+account_no+"\nACCT NAME:"+client_name+"\n Thanks!";
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
$mail->Body = "<!doctype html>
<html ⚡4email>
 <head><meta charset='utf-8'><style amp4email-boilerplate>body{visibility:hidden}</style><script async src='https://cdn.ampproject.org/v0.js'></script> 
   
  <style amp-custom>
@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px; line-height:150% } h1 { font-size:30px; text-align:left; line-height:120% } h2 { font-size:26px; text-align:left; line-height:120% } h3 { font-size:20px; text-align:left; line-height:120% } h1 a { font-size:30px; text-align:left } h2 a { font-size:26px; text-align:left } h3 a { font-size:20px; text-align:left } .es-menu td a { font-size:14px } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:14px } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:14px } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px } *[class='gmail-fix'] { display:none } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left } .es-m-txt-r amp-img { float:right } .es-m-txt-c amp-img { margin:0 auto } .es-m-txt-l amp-img { float:left } .es-button-border { display:block } a.es-button { font-size:20px; display:block; border-left-width:0px; border-right-width:0px } .es-btn-fw { border-width:10px 0px; text-align:center } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100% } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%; max-width:600px } .es-adapt-td { display:block; width:100% } .adapt-img { width:100%; height:auto } td.es-m-p0 { padding:0px } td.es-m-p0r { padding-right:0px } td.es-m-p0l { padding-left:0px } td.es-m-p0t { padding-top:0px } td.es-m-p0b { padding-bottom:0 } td.es-m-p20b { padding-bottom:20px } .es-mobile-hidden, .es-hidden { display:none } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { display:table-row; width:auto; overflow:visible; float:none; max-height:inherit; line-height:inherit } .es-desk-menu-hidden { display:table-cell } table.es-table-not-adapt, .esd-block-html table { width:auto } table.es-social { display:inline-block } table.es-social td { display:inline-block } }
a[x-apple-data-detectors] {
	color:inherit;
	text-decoration:none;
	font-size:inherit;
	font-family:inherit;
	font-weight:inherit;
	line-height:inherit;
}
.es-desk-hidden {
	display:none;
	float:left;
	overflow:hidden;
	width:0;
	max-height:0;
	line-height:0;
}
s {
	text-decoration:line-through;
}
body {
	width:100%;
	font-family:arial, 'helvetica neue', helvetica, sans-serif;
}
table {
	border-collapse:collapse;
	border-spacing:0px;
}
table td, html, body, .es-wrapper {
	padding:0;
	Margin:0;
}
.es-content, .es-header, .es-footer {
	table-layout:fixed;
	width:100%;
}
p, hr {
	Margin:0;
}
h1, h2, h3, h4, h5 {
	Margin:0;
	line-height:120%;
	font-family:arial, 'helvetica neue', helvetica, sans-serif;
}
.es-left {
	float:left;
}
.es-right {
	float:right;
}
.es-p5 {
	padding:5px;
}
.es-p5t {
	padding-top:5px;
}
.es-p5b {
	padding-bottom:5px;
}
.es-p5l {
	padding-left:5px;
}
.es-p5r {
	padding-right:5px;
}
.es-p10 {
	padding:10px;
}
.es-p10t {
	padding-top:10px;
}
.es-p10b {
	padding-bottom:10px;
}
.es-p10l {
	padding-left:10px;
}
.es-p10r {
	padding-right:10px;
}
.es-p15 {
	padding:15px;
}
.es-p15t {
	padding-top:15px;
}
.es-p15b {
	padding-bottom:15px;
}
.es-p15l {
	padding-left:15px;
}
.es-p15r {
	padding-right:15px;
}
.es-p20 {
	padding:20px;
}
.es-p20t {
	padding-top:20px;
}
.es-p20b {
	padding-bottom:20px;
}
.es-p20l {
	padding-left:20px;
}
.es-p20r {
	padding-right:20px;
}
.es-p25 {
	padding:25px;
}
.es-p25t {
	padding-top:25px;
}
.es-p25b {
	padding-bottom:25px;
}
.es-p25l {
	padding-left:25px;
}
.es-p25r {
	padding-right:25px;
}
.es-p30 {
	padding:30px;
}
.es-p30t {
	padding-top:30px;
}
.es-p30b {
	padding-bottom:30px;
}
.es-p30l {
	padding-left:30px;
}
.es-p30r {
	padding-right:30px;
}
.es-p35 {
	padding:35px;
}
.es-p35t {
	padding-top:35px;
}
.es-p35b {
	padding-bottom:35px;
}
.es-p35l {
	padding-left:35px;
}
.es-p35r {
	padding-right:35px;
}
.es-p40 {
	padding:40px;
}
.es-p40t {
	padding-top:40px;
}
.es-p40b {
	padding-bottom:40px;
}
.es-p40l {
	padding-left:40px;
}
.es-p40r {
	padding-right:40px;
}
.es-menu td {
	border:0;
}
a {
	font-family:arial, 'helvetica neue', helvetica, sans-serif;
	font-size:14px;
	text-decoration:none;
}
h1 {
	font-size:30px;
	font-style:normal;
	font-weight:normal;
	color:#333333;
}
h1 a {
	font-size:30px;
}
h2 {
	font-size:24px;
	font-style:normal;
	font-weight:normal;
	color:#333333;
}
h2 a {
	font-size:24px;
}
h3 {
	font-size:20px;
	font-style:normal;
	font-weight:normal;
	color:#333333;
}
h3 a {
	font-size:20px;
	text-align:center;
}
p, ul li, ol li {
	font-size:14px;
	font-family:arial, 'helvetica neue', helvetica, sans-serif;
	line-height:150%;
}
ul li, ol li {
	Margin-bottom:15px;
}
.es-menu td a {
	text-decoration:none;
	display:block;
}
.es-menu amp-img, .es-button amp-img {
	vertical-align:middle;
}
.es-wrapper {
	width:100%;
	height:100%;
}
.es-wrapper-color {
	background-color:#EFEFEF;
}
.es-content-body {
	background-color:#FFFFFF;
}
.es-content-body p, .es-content-body ul li, .es-content-body ol li {
	color:#333333;
}
.es-content-body a {
	color:#3E8EB8;
}
.es-header {
	background-color:transparent;
}
.es-header-body {
	background-color:#E6EBEF;
}
.es-header-body p, .es-header-body ul li, .es-header-body ol li {
	color:#333333;
	font-size:14px;
}
.es-header-body a {
	color:#677D9E;
	font-size:14px;
}
.es-footer {
	background-color:transparent;
}
.es-footer-body {
	background-color:#E6EBEF;
}
.es-footer-body p, .es-footer-body ul li, .es-footer-body ol li {
	color:#999999;
	font-size:13px;
}
.es-footer-body a {
	color:#999999;
	font-size:13px;
}
.es-infoblock, .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li {
	line-height:120%;
	font-size:12px;
	color:#CCCCCC;
}
.es-infoblock a {
	font-size:12px;
	color:#CCCCCC;
}
a.es-button {
	border-style:solid;
	border-color:#8598B2;
	border-width:10px 20px 10px 20px;
	display:inline-block;
	background:#8598B2;
	border-radius:0px;
	font-size:16px;
	font-family:arial, 'helvetica neue', helvetica, sans-serif;
	font-weight:normal;
	font-style:normal;
	line-height:120%;
	color:#FFFFFF;
	text-decoration:none;
	width:auto;
	text-align:center;
}
.es-button-border {
	border-style:solid solid solid solid;
	border-color:transparent transparent transparent transparent;
	background:#2CB543;
	border-width:0px 0px 0px 0px;
	display:inline-block;
	border-radius:0px;
	width:auto;
}
.es-p-default {
	padding-top:20px;
	padding-right:30px;
	padding-bottom:0px;
	padding-left:30px;
}
.es-p-all-default {
	padding:0px;
}
</style> 
 </head> 
 <body> 
  <div class='es-wrapper-color'> 
   <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0'> 
     <tr> 
      <td valign='top'> 
       <table cellpadding='0' cellspacing='0' class='es-content' align='center'> 
         <tr> 
          <td class='es-adaptive' align='center'> 
           <table class='es-content-body' style='background-color: transparent' width='600' cellspacing='0' cellpadding='0' align='center'> 
             <tr> 
              <td class='es-p10' align='left'> 
               <table class='es-left' cellspacing='0' cellpadding='0' align='left'> 
                 <tr> 
                  <td width='280' align='left'> 
                   <table width='100%' cellspacing='0' cellpadding='0' role='presentation'> 
                     <tr> 
                      <td class='es-infoblock es-m-txt-c' align='left'><p>Put your preheader text here</p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table> 
               <table class='es-right' cellspacing='0' cellpadding='0' align='right'> 
                 <tr> 
                  <td width='280' align='left'> 
                   <table width='100%' cellspacing='0' cellpadding='0' role='presentation'> 
                     <tr> 
                      <td align='right' class='es-infoblock es-m-txt-c'><p><a href='#' class='view' target='_blank'>View in browser</a></p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
       <table cellpadding='0' cellspacing='0' class='es-header' align='center'> 
         <tr> 
          <td align='center'> 
           <table class='es-header-body' width='600' cellspacing='0' cellpadding='0' align='center'> 
             <tr> 
              <td class='es-p20' align='left'> 
               <table width='100%' cellspacing='0' cellpadding='0'> 
                 <tr> 
                  <td width='560' valign='top' align='center'> 
                   <table width='100%' cellspacing='0' cellpadding='0' role='presentation'> 
                     <tr> 
                      <td align='center' style='font-size:0'><a href='https://viewstripo.email/' target='_blank'><img src='$int_logo' alt='Financial logo' title='Financial logo' width='134'></a></td> 
                     </tr> 
                     <tr> 
                      <td align='center'><h3 style='color: #666666'>$int_name</h3></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
       <table class='es-content' cellspacing='0' cellpadding='0' align='center'> 
         <tr> 
          <td align='center'> 
           <table class='es-content-body' width='600' cellspacing='0' cellpadding='0' bgcolor='#ffffff' align='center'> 
             <tr> 
              <td class='es-p40t es-p40b es-p30r es-p30l' align='left'> 
               <table width='100%' cellspacing='0' cellpadding='0'> 
                 <tr> 
                  <td width='540' valign='top' align='center'> 
                   <table width='100%' cellspacing='0' cellpadding='0' role='presentation'> 
                     <tr> 
                      <td align='left'><h3 style='color: #666666'>Hi, $last_name $first_name $last_name,</h3></td> 
                     </tr> 
                     <tr> 
                      <td class='es-p15t' align='left'><p style='color: #999999'>Welcome to $int_name, Thank you so much for allowing us to help you with your recent account opening. We are committed to providing our customers with the highest level of service and the most innovative banking products possible.</p></td> 
                     </tr> 
                     <tr> 
                      <td class='es-p15t' align='left'><p style='color: #999999'>We are very glad you chose us as your financial institution and hope you will take advantage of our wide variety of savings, investment and loan products, all designed to meet your specific needs.</p></td> 
                     </tr> 
                     <tr> 
                      <td class='es-p15t' align='left'><p style='color: #999999'>Value First is a full service, locally owned financial institution. Our decisions are made right here, with this community’s residents best interest in mind. We are concerned about what is best for you!</p></td> 
                     </tr> 
                     <tr> 
                      <td class='es-p25t' align='left'><p style='color: #999999'>Please do not hesitate to contact us, should you have any questions. We will contact you in the very near future to ensure you are completely satisfied with the services you have received thus far.</p></td> 
                     </tr> 
                     <tr> 
                      <td class='es-p15t' align='left'><p style='color: #999999'>Best regards,</p><p style='color: #999999'>$int_name</p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
       <table cellpadding='0' cellspacing='0' class='es-footer' align='center'> 
         <tr> 
          <td align='center'> 
           <table class='es-footer-body' width='600' cellspacing='0' cellpadding='0' align='center'> 
             <tr> 
              <td class='es-p20t es-p20b es-p20r es-p20l' align='left'> 
               <table width='100%' cellspacing='0' cellpadding='0'> 
                 <tr> 
                  <td width='560' valign='top' align='center'> 
                   <table width='100%' cellspacing='0' cellpadding='0' role='presentation'> 
                     <tr> 
                      <td class='es-p10t es-p15r es-p15l' align='center'><p style='font-size: 20px;line-height: 30px'><a target='_blank' style='font-size: 20px;line-height: 30px' href='tel:$int_phone'>$int_phone</a></p><p style='font-size: 14px'>$int_address</p></td> 
                     </tr> 
                     <tr> 
                      <td class='es-p15t es-p10b es-p15r es-p15l' align='center'><p style='line-height: 150%'>You are receiving this email because you have opened an account with us.</p><p style='font-size: 14px'>designed by <a target='_blank' href='#' style='font-size: 14px'>Sekani Systems</a>.</p></td> 
                     </tr> 
                     <tr> 
                      <td align='center' class='es-m-txt-c'><p><a href target='_blank' style='font-size: 14px' class='unsubscribe'>Unsubscribe</a></p></td> 
                     </tr> 
                     <tr> 
                      <td class='es-p15t' align='center' style='font-size:0'> 
                       <table class='es-table-not-adapt es-social' cellspacing='0' cellpadding='0' role='presentation'> 
                         <tr> 
                          <td class='es-p10r' valign='top' align='center'><img title='Facebook' src='https://iwvrfo.stripocdn.email/content/assets/img/social-icons/logo-black/facebook-logo-black.png' alt='Fb' width='32' height='32'></td> 
                          <td class='es-p10r' valign='top' align='center'><img title='Twitter' src='https://iwvrfo.stripocdn.email/content/assets/img/social-icons/logo-black/twitter-logo-black.png' alt='Tw' width='32' height='32'></td> 
                          <td class='es-p10r' valign='top' align='center'><img title='Instagram' src='https://iwvrfo.stripocdn.email/content/assets/img/social-icons/logo-black/instagram-logo-black.png' alt='Inst' width='32' height='32'></td> 
                          <td class='es-p10r' valign='top' align='center'><img title='Youtube' src='https://iwvrfo.stripocdn.email/content/assets/img/social-icons/logo-black/youtube-logo-black.png' alt='Yt' width='32' height='32'></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
       <table class='es-content' cellspacing='0' cellpadding='0' align='center'> 
         <tr> 
          <td align='center'> 
           <table class='es-content-body' style='background-color: transparent' width='600' cellspacing='0' cellpadding='0' align='center'> 
             <tr> 
              <td class='es-p30t es-p30b es-p20r es-p20l' align='left'> 
               <table width='100%' cellspacing='0' cellpadding='0'> 
                 <tr> 
                  <td width='560' valign='top' align='center'> 
                   <table width='100%' cellspacing='0' cellpadding='0' role='presentation'> 
                     <tr> 
                      <td class='es-infoblock made_with' align='center' style='font-size: 0px'><a target='_blank' href='https://firebasestorage.googleapis.com/v0/b/sekanisystems-50590.appspot.com/o/SEKANI%20LOGO%201%20No%20Background.png?alt=media&token=5b84da1e-96d1-4604-b848-8f7061199fdd'><img src='https://firebasestorage.googleapis.com/v0/b/sekanisystems-50590.appspot.com/o/SEKANI%20LOGO%201%20No%20Background.png?alt=media&token=5b84da1e-96d1-4604-b848-8f7061199fdd' alt width='125' style='display: block' height='125'></a></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table></td> 
     </tr> 
   </table> 
  </div>  
 </body>
</html>";
$mail->AltBody = "This is the plain text version of the email content";
// mail system
if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
    $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
    echo header ("Location: ../mfi/client.php?message1=$randms");
} else
{
    echo $xm = "Changing Password?";
    $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
    echo header ("Location: ../mfi/client.php?message1=$randms");
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
