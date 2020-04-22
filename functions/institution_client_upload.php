<?php
// connection
include("connect.php");
session_start();
?>
<?php
$sessint_id = $_SESSION["int_id"];
$loan_officer_id = $_POST["acct_of"];
$ctype = strtoupper($_POST['ctype']);
$acct_type = strtoupper($_POST['acct_type']);
$branch = strtoupper($_POST['branch']);
$display_name = strtoupper($_POST['display_name']);
// an account number generation
 $inttest = str_pad($branch, 4, '0', STR_PAD_LEFT);
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
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
$state = $_POST['state'];
$lga = $_POST['lga'];
$bvn = $_POST['bvn'];
$loan_status = "Not Active";
$activation_date = date("Y-m-d");
$submitted_on = date("Y-m-d");
// $sa = $_POST['sms_active'];
$queryd = mysqli_query($connection, "SELECT * FROM savings_product WHERE id='$acct_type'");
$res = mysqli_fetch_array($queryd);
$accttname = $res['name'];
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

$digits = 10;

$temp = explode(".", $_FILES['signature']['name']);
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$image1 = $randms. '.' .end($temp);

if (move_uploaded_file($_FILES['signature']['tmp_name'], "clients/" . $image1)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}
// $image2 = $_FILES['idimg']['name'];
// $target2 = "clients/".basename($image2);

$temp2 = explode(".", $_FILES['idimg']['name']);
$randms2 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$image2 = $randms2. '.' .end($temp2);

if (move_uploaded_file($_FILES['idimg']['tmp_name'], "clients/" . $image2)) {
$msg = "Image uploaded successfully";
} else {
$msg = "Image Failed";
}

// $image3 = $_FILES['passport']['name'];
// $target3 = "clients/".basename($image3);

$temp3 = explode(".", $_FILES['passport']['name']);
$randms3 = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$image3 = $randms3. '.' .end($temp3);

if (move_uploaded_file($_FILES['passport']['tmp_name'], "clients/" . $image3)) {
$msg = "Image uploaded successfully";
} else {
$msg = "Image Failed";
}
// $image1 = $_FILES['signature']['name'];
// $target1 = "clients/".basename($image1);

// $image2 = $_FILES['idimg']['name'];
// $target2 = "clients/".basename($image2);

// $image3 = $_FILES['passport']['name'];
// $target3 = "clients/".basename($image3);

// if (move_uploaded_file($_FILES['signature']['tmp_name'], $target1)) {
//     $msg = "Image uploaded successfully";
// }else{
//     $msg = "Failed to upload image";
// }
// if (move_uploaded_file($_FILES['idimg']['tmp_name'], $target2)) {
//     $msg = "Image uploaded successfully";
// }else{
//     $msg = "Failed to upload image";
// }
// if (move_uploaded_file($_FILES['passport']['tmp_name'], $target3)) {
//     $msg = "Image uploaded successfully";
// }else{
//     $msg = "Failed to upload image";
// }
// gaurantors part
$query = "INSERT INTO client (int_id, loan_officer_id, client_type, account_type,
display_name, account_no,
firstname, lastname, middlename, mobile_no, mobile_no_2, email_address, address, gender, date_of_birth,
branch_id, country, state_of_origin, lga, bvn, sms_active, email_active, id_card,
passport, signature, id_img_url, loan_status, submittedon_date, activation_date) VALUES ('{$sessint_id}', '{$loan_officer_id}', '{$ctype}',
'{$acct_type}', '{$display_name}', '{$account_no}', '{$first_name}', '{$last_name}', '{$middlename}', '{$phone}', '{$phone2}',
'{$email}', '{$address}', '{$gender}', '{$date_of_birth}', '{$branch}',
'{$country}', '{$state}', '{$lga}', '{$bvn}', '{$sms_active}', '{$email_active}',
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
        product_id, client_id, field_officer_id, submittedon_date, submittedon_userid,
        currency_code, activatedon_date, activatedon_userid,
        account_balance_derived) VALUES ('{$int_id}', '{$branch_id}', '{$account_no}',
        '{$accttname}', '{$account_type}', '{$client_id}', '{$field_officer_id}', '{$submittedon_date}',
        '{$submittedon_userid}', '{$currency_code}', '{$activation_date}', '{$activation_userid}',
        '{$account_balance_derived}')";

        $go = mysqli_query($connection, $accountins);
        if ($go) {
          $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
          echo header ("Location: ../mfi/client.php?message1=$randms");
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
    // Email function section 
$to = $email;
$subject = "Login Successful";

echo "<!DOCTYPE html>
<head>
<link rel='./dfhk'></link>
</head>
</html>";
$message = "
<!DOCTYPE HTML>
<html>
    <head>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons\" />
  <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css\">
  <link href=\"assets/css/material-dashboard.css?v=2.1.1\" rel=\"stylesheet\" />
    </head>
	<body>
		<div class=\"card\">
                <div class=\"card-header card-header-primary\">
                  <h4 class=\"h4\">Thank you for registering</h4>
				   <h4 class=\"card-title\">You are now a member of <?php echo $display_name?></h4>
                </div>
                <div class=\"card-body\">
                  <form action=\"\">
                    <div class=\"form-group\">
                      <label for=\"\">Name:</label>
                      <input type=\"text\" name=\"\" id=\"\" class=\"form-control\" value=\"<?php echo $display_name; ?>\" readonly>
                    </div>
                    <div class=\"row\">
                      <div class=\"col-md-6\">
                        <div class=\"form-group\">
                          <label for=\"\">Account No:</label>
                          <input type=\"text\" name=\"\" id=\"\" class=\"form-control\" value=\"<?php echo $acc_no; ?>\" readonly>
                        </div>
                      </div>
					   <div class=\"col-md-6\">
                        <div class=\"form-group\">
                          <label for=\"\">Username</label>
                          <input type=\"text\" name=\"\" id=\"\" class=\"form-control\" value=\"<?php echo $display_name; ?>\" readonly>
                        </div>
                      </div>
					   <div class=\"col-md-6\">
                        <div class=\"form-group\">
                          <label for=\"\">Email</label>
                          <input type=\"text\" name=\"\" id=\"\" class=\"form-control\" value=\"<?php echo $email; ?>\" readonly>
                        </div>
                      </div>
					   <div class=\"col-md-6\">
                        <div class=\"form-group\">
                          <label for=\"\">Date of Birth</label>
                          <input type=\"text\" name=\"\" id=\"\" class=\"form-control\" value=\"<?php echo $date_of_birth; ?>\" readonly>
                        </div>
                      </div>
					   <div class=\"col-md-6\">
                        <div class=\"form-group\">
                          <label for=\"\">Phone No</label>
                          <input type=\"text\" name=\"\" id=\"\" class=\"form-control\" value=\"<?php echo $phone; ?>\" readonly>
                        </div>
                      </div>
					   <div class=\"col-md-6\">
                        <div class=\"form-group\">
                          <label for=\"\">Display Picture</label>
                          <input type=\"text\" name=\"\" id=\"\" class=\"form-control\" value=\"<?php echo $target3; ?>\" readonly>
                        </div>
                      </div>
					  <div class=\"col-md-6\">
                        <div class=\"form-group\">
                          <label for=\"\">Branch</label>
                          <input type=\"text\" name=\"\" id=\"\" class=\"form-control\" value=\"<?php echo $branch; ?>\" readonly>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
			  
	</body>
</html>

";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: hesanmal316@gmail.com' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";
// ini_set("SMTP","ssl://smtp.gmail.com");
// ini_set("smtp_port","465");
mail($to,$subject,$message,$headers);
?>
