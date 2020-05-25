<?php
include("connect.php");
session_start();
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$ctype = $_POST['ctype'];
if($ctype == 'INDIVIDUAL')
{
    if (isset($_POST['id']) && isset($_POST['ctype'])) {
        $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id'");
      if (count([$person]) == 1) {
        $n = mysqli_fetch_array($person);
        $signa = $n['signature'];
        $pas = $n['passport'];
        $idimg = $n['id_img_url'];
      }
        $id = $_POST['id'];
        $account_no = $_POST['account_no'];
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
        $acct_off = $_POST['acct_off'];
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
            if (move_uploaded_file($_FILES['signature']['tmp_name'], "clients/sign/" . $img1)) {
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
            if (move_uploaded_file($_FILES['id_img_url']['tmp_name'], "clients/id/" . $img2)) {
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
            if (move_uploaded_file($_FILES['passport']['tmp_name'], "clients/passport/" . $img3)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }
        }
        else {
            $img3 = $_POST['passportbk'];
        }
    $updated_by = $_SESSION["user_id"];
    $updated_on = date("Y-m-d");
    $queryx = "UPDATE client SET loan_officer_id = '$acct_off', client_type = '$ctype', account_type = '$acct_type', display_name = '$display_name',
    firstname = '$first_name', lastname= '$last_name', middlename = '$middle_name',
    mobile_no = '$phone', mobile_no_2 = '$phone2', ADDRESS = '$address', gender = '$gender',
    date_of_birth = '$date_of_birth',email_address = '$email', branch_id = '$branch', COUNTRY = '$country', STATE_OF_ORIGIN = '$state',
    LGA = '$lga', BVN = '$bvn', SMS_ACTIVE = '$sms_active',
    EMAIL_ACTIVE = '$email_active', id_card = '$id_card', updated_by = '$updated_by', updated_on = '$updated_on',
    id_img_url = '$img2', passport = '$img3', signature = '$img1', status = 'Not Approved' WHERE id = '$id'";
    
    $result = mysqli_query($connection, $queryx);
    if($result) {
        // select * the client and then update the product
        $acctquery = mysqli_query($connection, "SELECT * FROM client WHERE id = '$id'");
        // next step
        if (count([$acctquery]) == 1) {
            $x = mysqli_fetch_array($acctquery);
            $account_type = $x['account_type'];
            $queryd = mysqli_query($connection, "SELECT * FROM savings_product WHERE id='$account_type'");
            $res = mysqli_fetch_array($queryd);
            $accttname = $res['name'];
            $updateacctp = mysqli_query($connection, "UPDATE account SET account_type = '$accttname', product_id = '$account_type' WHERE account_no = '$account_no'");
        }
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
        echo "bad stuff";
    }
}
else if($ctype == 'CORPORATE'){
    if (isset($_POST['id']) && isset($_POST['ctype'])) {

        $vd = $_POST['id'];
        $acct_type = $_POST['account_type'];
        $account_no = $_POST['acc_no'];
        $regdate = $_POST['date_of_birtha'];
        $first_name = $_POST['firstname'];
        $rcno = $_POST['rc_number'];
        $regname = $_POST['display_namea'];
        $regemail = $_POST['emaila'];
        $regaddress = $_POST['addressa'];
        $bran = $_POST['brancha'];
        $acc_of = $_POST['acct_ofa'];
        $account_officer = $_POST['loan_officer_id'];
        $checkl = "SELECT * FROM staff WHERE user_id = '$account_officer'";
        $resxx = mysqli_query($connection, $checkl);
        $xf = mysqli_fetch_array($resxx);
        $acctn = strtoupper($xf['first_name'] ." ". $xf['last_name']);
        $signame1 = $_POST['sig_one'];
        $signame2 = $_POST['sig_two'];
        $signame3 = $_POST['sig_three'];
        $address1 = $_POST['sig_address_one'];
        $address2 = $_POST['sig_address_two'];
        $address3 = $_POST['sig_address_three'];
        $phone1 = $_POST['sig_phone_one'];
        $phone2 = $_POST['sig_phone_two'];
        $phone3 = $_POST['sig_phone_three'];
        $gender1 = $_POST['sig_gender_one'];
        $gender2 = $_POST['sig_gender_two'];
        $gender3 = $_POST['sig_gender_three'];
        $state1 = $_POST['sig_state_one'];
        $state2 = $_POST['sig_state_two'];
        $state3 = $_POST['sig_state_three'];
        $lga1 = $_POST['sig_lga_one'];
        $lga2 = $_POST['sig_lga_two'];
        $lga3 = $_POST['sig_lga_three'];
        $bvn1 = $_POST['sig_bvn_one'];
        $bvn2 = $_POST['sig_bvn_two'];
        $bvn3 = $_POST['sig_bvn_three'];

        $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id'");
      if (count([$person]) == 1) {
        $n = mysqli_fetch_array($person);
        $pas1 = $n['sig_passport_one'];
        $pas2 = $n['sig_passport_two'];
        $pas3 = $n['sig_passport_three'];
        $sig1 = $n['sig_signature_one'];
        $sig2 = $n['sig_signature_two'];
        $sig3 = $n['sig_signature_three'];
        $id1 = $n['sig_id_img_one'];
        $id2 = $n['sig_id_img_two'];
        $id3 = $n['sig_id_img_three'];
    }
        $sigid1 = $_POST['sigid1'];
        $sigid2 = $_POST['sigid2'];
        $sigid3 = $_POST['sigid3'];

        if ( isset($_POST['sms_active_one']) ) {
            $smsactive1 = 1;
        } else {
            $smsactive1 = 0;
        }
        
        if ( isset($_POST['email_active_one']) ) {
            $emailactive1 = 1;
        } else { 
            $emailactive1 = 0;
        }
        if ( isset($_POST['sms_active_two']) ) {
            $smsactive2 = 1;
        } else {
            $smsactive2 = 0;
        }
        
        if ( isset($_POST['email_active_two']) ) {
            $emailactive2 = 1;
        } else { 
            $emailactive2 = 0;
        }
        if ( isset($_POST['sms_active_three']) ) {
            $smsactive3 = 1;
        } else {
            $smsactive3 = 0;
        }
        
        if ( isset($_POST['email_active_three']) ) {
            $emailactive3 = 1;
        } else { 
            $emailactive3 = 0;
        }  
        
        if($_FILES['sig_passport_one']['name']) {
            $temp = explode(".", $_FILES['sig_passport_one']['name']);
            $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
            $p1 = $randmst. '.' .end($temp);
            if (move_uploaded_file($_FILES['sig_passport_one']['tmp_name'], "clients/passport/" . $img1)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }  
        } else {
            $p1 = $_POST['pas1'];
        }
        if($_FILES['sig_passport_two']['name']) {
            $temp = explode(".", $_FILES['sig_passport_two']['name']);
            $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
            $p2 = $randmst. '.' .end($temp);
            if (move_uploaded_file($_FILES['sig_passport_two']['tmp_name'], "clients/passport/" . $img1)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }  
        } else {
            $p2 = $_POST['pas2'];
        }
        if($_FILES['sig_passport_three']['name']) {
            $temp = explode(".", $_FILES['sig_passport_three']['name']);
            $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
            $p3 = $randmst. '.' .end($temp);
            if (move_uploaded_file($_FILES['sig_passport_three']['tmp_name'], "clients/passport/" . $img1)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }  
        } else {
            $p3 = $_POST['pas3'];
        }
        if($_FILES['sig_signature_one']['name']) {
            $temp = explode(".", $_FILES['sig_signature_one']['name']);
            $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
            $s1 = $randmst. '.' .end($temp);
            if (move_uploaded_file($_FILES['sig_signature_one']['tmp_name'], "clients/sign/" . $img1)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }  
        } else {
            $s1 = $_POST['sig1'];
        }
        if($_FILES['sig_signature_two']['name']) {
            $temp = explode(".", $_FILES['sig_signature_two']['name']);
            $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
            $s2 = $randmst. '.' .end($temp);
            if (move_uploaded_file($_FILES['sig_signature_two']['tmp_name'], "clients/sign/" . $img1)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }  
        } else {
            $s2 = $_POST['sig2'];
        }
        if($_FILES['sig_signature_three']['name']) {
            $temp = explode(".", $_FILES['sig_signature_three']['name']);
            $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
            $s3 = $randmst. '.' .end($temp);
            if (move_uploaded_file($_FILES['sig_signature_three']['tmp_name'], "clients/sign/" . $img1)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }  
        } else {
            $s3 = $_POST['sig3'];
        }
        if($_FILES['sig_id_img_one']['name']) {
            $temp = explode(".", $_FILES['sig_id_img_one']['name']);
            $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
            $i1 = $randmst. '.' .end($temp);
            if (move_uploaded_file($_FILES['sig_id_img_one']['tmp_name'], "clients/id/" . $img1)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }  
        } else {
            $i1 = $_POST['id1'];
        }
        if($_FILES['sig_id_img_two']['name']) {
            $temp = explode(".", $_FILES['sig_id_img_two']['name']);
            $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
            $i2 = $randmst. '.' .end($temp);
            if (move_uploaded_file($_FILES['sig_id_img_two']['tmp_name'], "clients/id/" . $img1)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }  
        } else {
            $i2 = $_POST['id2'];
        }
        if($_FILES['sig_id_img_three']['name']) {
            $temp = explode(".", $_FILES['sig_id_img_three']['name']);
            $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
            $i3 = $randmst. '.' .end($temp);
            if (move_uploaded_file($_FILES['sig_id_img_three']['tmp_name'], "clients/id/" . $img1)) {
                $msg = "Image uploaded successfully";
            } else {
                $msg = "Image Failed";
            }  
        } else {
            $i3 = $_POST['id3'];
        }
        $updated_by = $_SESSION["user_id"];
        $updated_on = date("Y-m-d");

        $queryx = "UPDATE client SET loan_officer_id = '$account_officer', branch_id = '$bran', account_no = '$account_no', account_type = '$acct_type',
        firstname = '$regname', display_name = '$regname', date_of_birth = '$regdate', updated_on = '$updated_on', updated_by = '$updated_by', email_address = '$regemail', ADDRESS = '$regaddress', COUNTRY = '$',
          rc_number = '$rcno', sig_one = '$signame1', sig_two = '$signame2', sig_three = '$signame3', sig_address_one = '$address1', sig_address_two = '$address2', sig_address_three = '$address3', sig_phone_one = '$phone1', sig_phone_two = '$phone2', sig_phone_three = '$phone3',
           sig_gender_one = '$gender1', sig_gender_two = '$gender2', sig_gender_three = '$gender3', sig_state_one = '$state1', sig_state_two = '$state2', sig_state_three = '$state3', sig_lga_one = '$lga1', sig_lga_two = '$lga2', sig_lga_three = '$lga3',
            sig_bvn_one = '$bvn1', sig_bvn_two = '$bvn2', sig_bvn_three = '$bvn3', sms_active_one = '$smsactive1', sms_active_two = '$smsactive2', sms_active_three = '$smsactive3', email_active_one = '$emailactive1', email_active_two = '$emailactive2',
             email_active_three = '$emailactive3', sig_passport_one = '$p1', sig_passport_two = '$p2', sig_passport_three = '$p3', sig_signature_one = '$s1', sig_signature_two = '$s2', sig_signature_three = '$s3',
              sig_id_img_one = '$i1', sig_id_img_two = '$i2', sig_id_img_three = '$i3', sig_id_card_one = '$sigid1', sig_id_card_two = '$sigid2', sig_id_card_three = '$sigid3', status = 'Not Approved'
              WHERE id = '$vd'";

        $result = mysqli_query($connection, $queryx);
        if($result) {
            // select * the client and then update the product
            $acctquery = mysqli_query($connection, "SELECT * FROM client WHERE id = '$vd'");
            // next step
            if (count([$acctquery]) == 1) {
                $x = mysqli_fetch_array($acctquery);
                $account_type = $x['account_type'];
                $queryd = mysqli_query($connection, "SELECT * FROM savings_product WHERE id='$account_type'");
                $res = mysqli_fetch_array($queryd);
                $accttname = $res['name'];
                $updateacctp = mysqli_query($connection, "UPDATE account SET account_type = '$accttname', product_id = '$account_type' WHERE account_no = '$account_no'");
            }
            // If 'result' is successful, it will send the required message to client.php
            $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
                  echo header ("Location: ../mfi/client.php?message3=$randms");
                } else {
                   $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                   echo "error";
                  echo header ("Location: ../mfi/client.php?message4=$randms");
                    // echo header("location: ../mfi/client.php");
                }

    }else {
        echo "bad not";
    }
}
?>