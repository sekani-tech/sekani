<?php 
include("connect.php")
?>
<?php
if (isset($_POST['int_name']) && isset($_POST['usertype'])) {
    $user_id = $_POST['user_id'];
    $staff_id = $_POST['staff_id'];
    $int_name = $_POST['int_name'];
    $username = $_POST['username'];
    $display_name = $_POST['display_name'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $status = $_POST['employee_status'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $date_joined = $_POST['date_joined'];
    $org_role = $_POST['org_role'];
    $img = $_POST['img'];
    $usertype = $_POST['usertype'];

    $query = "UPDATE users SET username = '$username', usertype = '$usertype' WHERE id = '$user_id'";
    $result = mysqli_query($connection, $query);
    if($result) {
        $sec = "UPDATE staff SET int_name = '$int_name', username = '$username', display_name = '$display_name', email = '$email',
        first_name = '$first_name', last_name = '$last_name', phone = '$phone', employee_status = '$status', address = '$address', date_joined = '$date_joined',
        org_role = '$org_role', img = '$img' WHERE id = '$staff_id'";
        $res = mysqli_query($connection, $sec);
        // if ($connection->error) {
        //     try {   
        //                     throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $msqli->errno);   
        //                 } catch(Exception $e ) {
        //                     echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        //                     echo nl2br($e->getTraceAsString());
        //                 }
        // }
        if ($res) {
            echo header("location: ../mfi/users.php");
        } else {
            echo "there is an error here";
        }
    } else {
        echo "nop";
    }
}
?>
<?php
if (isset($_POST['employee_status']) && ($_POST['employee_status'] == "Employed")) {
  $employee = "Decomisioned";
 } else {
  $employee = "Employed";
 }
 
  $query = "UPDATE staff SET employee_status = $employee WHERE id = '$user_id'";
  
  $form = mysqli_query($connection, $query);
  if ($form) {
    echo header("location: ../mfi/users.php");
  } else {
    echo "there is an error here";
  }
?>