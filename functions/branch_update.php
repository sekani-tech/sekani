<?php include("connect.php")?>
<?php
if (isset($_POST['id'])) {
$id = $_POST['id'];
$int_id = $_POST['int_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$location = $_POST['location'];
  $query = "UPDATE branch SET id = '$id', name = '$name', email = '$email', phone = '$phone',
  location = '$location' WHERE id = '$id'";
  $result = mysqli_prepare($connection, $query);
  if(mysqli_stmt_execute($result)) {
     echo header("location: ../mfi/branch.php");
    echo "<p>done</p>";
  } else {
      echo "nop";
  }
}
mysqli_close($connection);
?>