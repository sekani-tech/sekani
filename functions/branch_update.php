<?php include("connect.php")?>
<?php
if (isset($_POST['id'])) {
$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$state = $_POST['state'];
$lga = $_POST['lga'];
$parent_bid = $_POST['parent_bid'];
$location = $_POST['location'];

  $query = "UPDATE branch SET name = '$name', email = '$email', phone = '$phone',
  location = '$location', state = '$state', lga = '$lga', parent_id = '$parent_bid' WHERE id = '$id'";
  $result = mysqli_query($connection, $query);
  if(($result)) {
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