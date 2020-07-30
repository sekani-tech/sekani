<?php include("connect.php")?>
<?php
if (isset($_POST['int_name']) && isset($_POST['rcn'])  && isset($_POST['email'])) {
$int_id = $_POST['int_id'];
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
$sender_id = $_POST['sender_id'];

$digits = 10;
if($_FILES['int_logo']['name']) {
  $temp = explode(".", $_FILES['int_logo']['name']);
  $randmst = str_pad(rand(0, pow(10, 7)-1), 10, '0', STR_PAD_LEFT);
  $img = $int_name. '.' .end($temp);
  if (move_uploaded_file($_FILES['int_logo']['tmp_name'], "../instimg/" . $img)) {
      $msg = "Image uploaded successfully";
  } else {
      $msg = "Image Failed";
  }  
} else {
  $img = $_POST['int_img'];
}

  $query = "UPDATE institutions SET int_name = '$int_name', 
  rcn = '$rcn', lga = '$lga', int_state = '$int_state', email = '$email',
  office_address = '$office_address', website = '$website', office_phone = '$office_phone',
  pc_title = '$pc_title', pc_surname = '$pc_surname', pc_other_name = '$pc_other_name', pc_designation = '$pc_designation',
  pc_phone = '$pc_phone', pc_email = '$pc_email', img = '$img', sender_id = '$sender_id' WHERE int_id = '$int_id'";
  $result = mysqli_query($connection, $query);
  if($result) {
     echo header("location: ../institution.php");
    echo "<p>done</p>";
  } else {
      echo "nop";
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
?>