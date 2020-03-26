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
    echo header("location: ../mfi/branch.php");
} else {
    echo "<p>Bad</p>";
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