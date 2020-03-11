<?php
include("connect.php");
session_start();
?>
<?php
if (isset($_POST['id']) && isset($_POST['ctype'])) {
    $id = $_POST['id'];
    $ctype = $_POST['ctype'];
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
    // $passport =$_POST['passport'];
    // $signature = $_POST['signature'];
    // $id_img_url = $_POST['id_img_url'];
// smalls
$updated_by = $_SESSION["user_id"];
$updated_on = date("Y-m-d");
$queryx = "UPDATE client SET client_type = '$ctype', display_name = '$display_name',
firstname = '$first_name', lastname= '$last_name', middlename = '$middle_name',
mobile_no = '$phone', mobile_no_2 = '$phone2', ADDRESS = '$address', gender = '$gender',
date_of_birth = '$date_of_birth', branch_id = '$branch', COUNTRY = '$country', STATE_OF_ORIGIN = '$state',
LGA = '$lga', BVN = '$bvn', SMS_ACTIVE = '$sms_active',
EMAIL_ACTIVE = '$email_active', id_card = '$id_card', updated_by = '$updated_by', updated_on = '$updated_on' WHERE id = '$id'";

$result = mysqli_query($connection, $queryx);
if($result) {
    echo header("location: ../institutions/client.php");
} else {
    echo "there is an error here";
}
// if ($connection->error) {
//     try {   
//         throw new Exception("MySQL error $connection->error <br> Query:<br> $queryx", $mysqli->error);   
//     } catch(Exception $e ) {
//         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//         echo nl2br($e->getTraceAsString());
//     }
// }
} else {
    echo "bad";
}
?>