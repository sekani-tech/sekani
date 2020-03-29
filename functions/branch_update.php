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
    // If 'result' is successful, it will send the required message to client.php
    $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
          echo header ("Location: ../mfi/branch.php?message3=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/branch.php?message4=$randms");
            // echo header("location: ../mfi/client.php");
        }
  if ($connection->error) {
    try {   
        throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
    } catch(Exception $e ) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
}
}
mysqli_close($connection);
?>