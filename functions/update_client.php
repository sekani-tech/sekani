<?php
include("connect.php");
?>
<?php
if (isset($_POST['bank']) && isset($_POST['email'])) {
    $id = $_POST['id'];
    $bank = $_POST['bank'];
    $acct_no = $_POST['acct_no'];
    $display_name = $_POST['display_name'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $phone2 = $_POST['phone2'];
    $address = $_POST['addres'];
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

$query = "UPDATE clients SET bank = '$bank', acct_no = '$acct_no', display_name = '$display_name',
email = '$email', first_name = '$first_name', last_name = '$last_name', phone = '$phone',
phone2 = '$phone2', addres = '$address', gender = '$gender', is_staff = '$is_staff',
date_of_birth = '$date_of_birth', img = '$img', gau_first_name = '$gau_first_name', gau_last_name = '$gau_last_name',
gau_phone = '$gau_phone', gau_phone2 = '$gau_phone2', gau_home_address = '$gau_home_address',
gau_office_address = '$gau_office_address', gau_position_held = '$gau_position_held', gau_email = '$gau_email' WHERE id = '$id'";

$result = mysqli_query($connection, $query);
if($result) {
    echo header("location: ../institutions/client.php");
} else {
    echo "there is an error here";
}
}
?>