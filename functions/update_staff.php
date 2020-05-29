<?php 
include("connect.php")
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
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
    $usertype = $_POST['usertype'];

if($_FILES['imagefile']['name']) {
  $temp = explode(".", $_FILES['imagefile']['name']);
  $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
  $img = $randmst. '.' .end($temp);
  if (move_uploaded_file($_FILES['imagefile']['tmp_name'], "staff/" . $img)) {
      $msg = "Image uploaded successfully";
  } else {
      $msg = "Image Failed";
  }  
} else {
  $img = $_POST['imagefileL'];
}

    $query = "UPDATE users SET username = '$username', usertype = '$usertype' WHERE id = '$user_id'";
    $result = mysqli_query($connection, $query);
    if($result) {
        $sec = "UPDATE staff SET int_name = '$int_name', username = '$username', display_name = '$display_name', email = '$email',
        first_name = '$first_name', last_name = '$last_name', phone = '$phone', employee_status = '$status', address = '$address', date_joined = '$date_joined',
        org_role = '$org_role', img = '$img' WHERE id = '$staff_id'";
        $res = mysqli_query($connection, $sec);
        if ($res) {
          $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
          echo header ("Location: ../mfi/staff_mgmt.php?message3=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/staff_mgmt.php?message4=$randms");
            // echo header("location: ../mfi/client.php");
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
    echo header("location: ../mfi/staff_mgmt.php");
  } else {
    echo "there is an error here on sanusi end";
  }
?>