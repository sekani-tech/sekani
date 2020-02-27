<?php
// connection
include("connect.php");
session_start();
?>
<?php
$sessint_id = $_SESSION["int_id"];
$loan_officer_id = $_SESSION["user_id"];
$fullname_name = $_SESSION["fullname"];
$loan_status = "No";
$bank = $_POST['bank'];
$acct_no = $_POST['acct_no'];
$display_name = $_POST['display_name'];
$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$phone2 = $_POST['phone2'];
$addres = $_POST['addres'];
$gender = $_POST['gender'];
$is_staff = $_POST['is_staff'];
$date_of_birth = $_POST['date_of_birth'];
$img = $_POST['img'];
// gaurantors part
$gau_first_name = $_POST['gau_first_name'];
$gau_last_name = $_POST['gau_last_name'];
$gau_phone = $_POST['gau_phone'];
$gau_phone2 = $_POST['gau_phone2'];
$gau_home_address = $_POST['gau_home_address'];
$gau_office_address = $_POST['gau_office_address'];
$gau_position_held = $_POST['gau_position_held'];
$gau_email = $_POST['gau_email'];
$query = "INSERT INTO clients (int_id, loan_officer_id, loan_officer, loan_status, bank, acct_no, display_name, email,
first_name, last_name, phone, phone2, addres, gender, is_staff, date_of_birth,
img, gau_first_name, gau_last_name, gau_phone, gau_phone2,
gau_home_address, gau_office_address, gau_position_held, gau_email) VALUES ('{$sessint_id}', '{$loan_officer_id}', '{$fullname_name}', '{$loan_status}', '{$bank}', '{$acct_no}', '{$display_name}', '{$email}', '{$first_name}',
'{$last_name}', '{$phone}', '{$phone2}', '{$addres}', '{$gender}', '{$is_staff}', '{$date_of_birth}', '{$img}',
'{$gau_first_name}', '{$gau_last_name}', '{$gau_phone}', '{$gau_phone2}', '{$gau_home_address}', '{$gau_office_address}', '{$gau_position_held}', '{$gau_email}')";

$res = mysqli_query($connection, $query);

 if ($res) {
    echo header("location: ../institutions/client.php");
 } else {
     echo "<p>Error</p>";
 }
// if ($connection->error) {
//         try {   
//             throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $msqli->errno);   
//         } catch(Exception $e ) {
//             echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//             echo nl2br($e->getTraceAsString());
//         }
//     }
?>