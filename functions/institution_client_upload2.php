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
$tday = date('Y-m-d');

$rigits = 7;
$sessint_id = $_SESSION["int_id"];
$ctype = strtoupper($_POST['ctype']);
$rand = str_pad(rand(0, pow(10, $rigits) - 1), $rigits, '0', STR_PAD_LEFT);

// create an individual or group account
if($ctype == 'INDIVIDUAL' || $ctype == 'GROUP'){
  $loan_officer_id = $_POST["acct_of"];
  $acct_type = strtoupper($_POST['acct_type']);
  $branch = strtoupper($_POST['branch']);
  $display_name = strtoupper($_POST['display_name']);

  // an account number generation
  $inttest = str_pad($branch, 3, '0', STR_PAD_LEFT);
  $digit = 4;
  $randms = str_pad(rand(0, pow(10, $digit) - 1), 7, '0', STR_PAD_LEFT);
  $account_no = $inttest . "" . $randms;
  $length = strlen($account_no);

  if ($length == 10) {
    $account_no = $account_no;
  } else if ($length > 10) {
    $di = 6;
    $randms = str_pad(rand(0, pow(10, $di) - 1), $di, '0', STR_PAD_LEFT);
    $account_no = "0200" . $randms;
  } else {
    $di = 6;
    $randms = str_pad(rand(0, pow(10, $di) - 1), $di, '0', STR_PAD_LEFT);
    $account_no = "0200" . $randms;
  }

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
  $loan_status = "Not Active";
  $activation_date = date("Y-m-d");
  $submitted_on = date("Y-m-d");
  // $sa = $_POST['sms_active'];
}

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
$id_card = $_POST['id_card'];

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


// insert into client

$query = "INSERT INTO client (int_id, loan_officer_id, client_type, account_type,
display_name, account_no, firstname, lastname, middlename, mobile_no, mobile_no_2, email_address, address, gender, date_of_birth, 
branch_id, country, STATE_OF_ORIGIN, lga, occupation, id_card,
passport, signature, id_img_url, loan_status, submittedon_date, activation_date) VALUES ('{$sessint_id}', '{$loan_officer_id}', '{$ctype}',
'{$acct_type}', '{$display_name}', '{$account_no}', '{$first_name}', '{$last_name}', '{$middlename}', '{$phone}', '{$phone2}', '{$email}', '{$address}', 
'{$gender}', '{$date_of_birth}', '{$branch}', '{$country}', '{$state}', '{$lga}', '{$occupation}',
'{$id_card}', '{$image3}', '{$image1}', '{$image2}', '{$loan_status}', '{$submitted_on}', '{$activation_date}')";

$res = mysqli_query($connection, $query);
var_dump($res);

if($res){
  $acctquery = mysqli_query($connection, "SELECT * FROM client WHERE account_no = '$account_no'");
  if(count([$acctquery]) == 1){
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
        type_id, product_id, client_id, field_officer_id, submittedon_date, updatedon_date, submittedon_userid,
        currency_code, activatedon_date, activatedon_userid,
        account_balance_derived) VALUES ('{$int_id}', '{$branch_id}', '{$account_no}',
        '{$accttname}', '{$type_id}', '{$account_type}', '{$client_id}', '{$field_officer_id}', '{$submittedon_date}', '{$submittedon_date}',
        '{$submittedon_userid}', '{$currency_code}', '{$activation_date}', '{$activation_userid}',
        '{$account_balance_derived}')";
        // var_dump($accountins);

        $go = mysqli_query($connection, $accountins);
        if($go){
          $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
          echo header ("Location: ../mfi/configuration.php?message1=$randms");
        }else{
          echo "Account Creation Failed";
        }
  }
}else if($ctype == 'CORPORATE'){
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
  if($res){
    $acctquery = mysqli_query($connection, "SELECT * FROM client WHERE account_no = '$account_no'");
    if(count([$acctquery]) == 1){
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
          echo header ("Location: ../mfi/configuration.php?message3=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/configuration.php?message4=$randms");
            // echo header("location: ../mfi/client.php");
        }
    }
  }
}



?>