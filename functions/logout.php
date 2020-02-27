<?php
  // get connections for all pages
  include("connect.php");
?>
<?php
// Initialize the session
session_start();
$activecode = "Not Active";
$acuser = $_SESSION["username"];
$activeq = "UPDATE users SET users.status ='$activecode' WHERE users.username ='$acuser'";
$rezz = mysqli_query($connection, $activeq);
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: ../login.php");

exit;
?>