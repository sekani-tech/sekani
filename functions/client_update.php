<?php
include("connect.php");
session_start();
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
if (isset($_POST['id']) && isset($_POST['ctype'])) {
    $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id'");
  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $signa = $n['signature'];
    $pas = $n['passport'];
    $idimg = $n['id_img_url'];
  }
    $id = $_POST['id'];
    $ctype = $_POST['ctype'];
    $acct_type = $_POST['account_type'];
    $display_name = $_POST['display_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $phone2 = $_POST['phone2'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $branch = $_POST['branch'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $lga = $_POST['lga'];
    $bvn = $_POST['bvn'];
    // $image1 = $_POST['sign'];
    // $image2 = $_POST['passportbk'];
    // $image3 = $_POST['idimg'];
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
    $id_card = $_POST['id_card'];
    // a new stuff for data upload
    $digits = 10;

    if($_FILES['signature']['name']) {
        $temp = explode(".", $_FILES['signature']['name']);
        $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
        $img1 = $randmst. '.' .end($temp);
        if (move_uploaded_file($_FILES['signature']['tmp_name'], "clients/" . $img1)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Image Failed";
        }  
    } else {
        $img1 = $_POST['sign'];
    }
    
    // }
    // else {
    //     $image1 = $_POST['sign'];
    // }
// $image2 = $_FILES['idimg']['name'];
// $target2 = "clients/".basename($image2);

// if ID image has value, code should run and save normally
    if($_FILES['id_img_url']['name']) {
        $temp2 = explode(".", $_FILES['id_img_url']['name']);
        $randms2 = str_pad(rand(0, pow(10, 9)-1), 10, '0', STR_PAD_LEFT);
        $img2 = $randms2. '.' .end($temp2);
        if (move_uploaded_file($_FILES['id_img_url']['tmp_name'], "clients/" . $img2)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Image Failed";
        }
    }
    else {
        $img2 = $_POST['idimg'];
    }

// if passport has value, code should run and save normally
    if($_FILES['passport']['name']) {
        $temp3 = explode(".", $_FILES['passport']['name']);
        $randms3 = str_pad(rand(0, pow(10, 8)-1), 10, '0', STR_PAD_LEFT);
        $img3 = $randms3. '.' .end($temp3);
        if (move_uploaded_file($_FILES['passport']['tmp_name'], "clients/" . $img3)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Image Failed";
        }
    }
    else {
        $img3 = $_POST['passportbk'];
    }


// This query will not work because the random string you are using will always send a value at the end. So nothing is null.

    // if ($image1 == NULL && $image2 == NULL && $image3 == NULL) {
    //     $img1 = $imgx;
    //     $img2 = $imgxx;
    //     $img3 = $imgxxx;
    //   } else if ($image2 == NULL && $image3 == NULL) {
    //     $img1 = $image1;
    //     $img2 = $imgxx;
    //     $img3 = $imgxxx;
    //   } else if ($image3 == NULL) {
    //       $img1 = $image1;
    //       $img2 = $image2;
    //       $img3 = $imgxxx;
    //   } else if ($image1 == NULL) {
    //       $img1 = $imgx;
    //     $img2 = $image2;
    //     $img3 = $image3;
    //   } else if ($image2 == NULL) {
    //     $img1 = $image1;
    //     $img2 = $imgxx;
    //     $img3 = $image3;
    //   } else if ($image1 == NULL && $image3 == NULL) {
    //       $img1 = $imgx;
    //       $img2 = $image2;
    //       $img3 = $imgxxx;
    //   } else if ($image1 == NULL && $image2 == NULL) {
    //       $img1 = $imgx;
    //       $img2 = $imgxx;
    //       $img3 = $image3;
    //   } else {
    //       $img1 = $image1;
    //       $img2 = $image2;
    //       $img3 = $image3;
    //   }
// This query will not work because the random string you are using will always send a value at the end. So nothing is null.

$updated_by = $_SESSION["user_id"];
$updated_on = date("Y-m-d");
$queryx = "UPDATE client SET client_type = '$ctype', account_type = '$acct_type', display_name = '$display_name',
firstname = '$first_name', lastname= '$last_name', middlename = '$middle_name',
mobile_no = '$phone', mobile_no_2 = '$phone2', ADDRESS = '$address', gender = '$gender',
date_of_birth = '$date_of_birth', branch_id = '$branch', COUNTRY = '$country', STATE_OF_ORIGIN = '$state',
LGA = '$lga', BVN = '$bvn', SMS_ACTIVE = '$sms_active',
EMAIL_ACTIVE = '$email_active', id_card = '$id_card', updated_by = '$updated_by', updated_on = '$updated_on',
id_img_url = '$img2', passport = '$img3', signature = '$img1' WHERE id = '$id'";

$result = mysqli_query($connection, $queryx);
if($result) {
    // If 'result' is successful, it will send the required message to client.php
    $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
          echo header ("Location: ../mfi/client.php?message3=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/client.php?message4=$randms");
            // echo header("location: ../mfi/client.php");
        }
if ($connection->error) {
    try {   
        throw new Exception("MySQL error $connection->error <br> Query:<br> $queryx", $mysqli->error);   
    } catch(Exception $e ) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
}
} else {
    echo "bad";
}
?>