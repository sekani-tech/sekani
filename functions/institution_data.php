<?php
// here i am going to add the connection
include("connect.php");?>
<!-- another for inputting the data -->
<?php
$int_name = $_POST['int_name'];
$rcn = $_POST['rcn'];
$lga = $_POST['lga'];
$int_state = $_POST['int_state'];
$email = $_POST['email'];
$office_address = $_POST['office_address'];
$website = $_POST['website'];
$office_phone = $_POST['office_phone'];
$pc_title = $_POST['pc_title'];
$pc_surname = $_POST['pc_surname'];
$pc_other_name = $_POST['pc_other_name'];
$pc_designation = $_POST['pc_designation'];
$pc_phone = $_POST['pc_phone'];
$pc_email = $_POST['pc_email'];
$query = "INSERT INTO institutions (int_name, rcn, lga, int_state, email,
office_address, website, pc_title, pc_surname, pc_other_name,
pc_designation, pc_phone, pc_email) VALUES ('{$int_name}','{$rcn}',
'{$lga}', '{$int_state}', '{$email}', '{$office_address}', '{$website}', '{$office_phone}',
'{$pc_title}', '{$pc_surname}', '{$pc_other_name}', '{$pc_designation}',
'{$pc_phone}', '{$pc_email}')";
// add
$result = mysqli_query($connection, $query);
if ($result) {
    // successfully inserted the data
    // header("Location: ../../manage_users.php");
    echo "<p>creation successful</p>";
    exit;
} else {
    // Display an error message
    echo "<p>User creation failed</p>";
}
?>