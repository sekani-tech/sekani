<?php
include("connect.php");
session_start();
?>
<?php
$ssint_id = $_SESSION["int_id"];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$location = $_POST['location'];

$query = "INSERT INTO branch (int_id, name, email, phone, location) VALUES ('{$ssint_id}',
'{$name}', '{$email}', '{$phone}', '{$location}')";

$result = mysqli_query($connection, $query);

if ($result) {
    // If 'result' is successful, it will send the required message to client.php
    $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
          echo header ("Location: ../mfi/branch.php?message1=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/branch.php?message2=$randms");
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
?>