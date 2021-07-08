<?php
include("connect.php");
session_start();
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gtype = $_POST['gtype'];
    $mday = $_POST['meet_day'];
    $mtime = $_POST['meet_time'];
    $frq = $_POST['freq'];
    $loc = $_POST['location'];
    $date = date('Y-m-d h:i:sa');

    $sjsjjd = mysqli_query($connection, "SELECT * FROM groups WHERE id='$id'");
    $ods = mysqli_fetch_array($sjsjjd);
    $st = $ods['status'];
    if($st =='Pending'){
        $stat = 'Approved';
    }
    else{
        $stat = 'Pending';
    }

    $doe = mysqli_query($connection, "UPDATE groups SET g_name='$name', reg_type='$gtype',
     meeting_day='$mday', meeting_frequency='$frq', meeting_time='$mtime', meeting_location='$loc',
      approvedon_date='$date', status='$stat' WHERE id='$id'");

      if($doe) {
        // If 'result' is successful, it will send the required message to client.php
      $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
      echo header ("Location: ../mfi/groups.php?message3=$randms");
    } else {
       $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
       echo "error";
      echo header ("Location: ../mfi/groups.php?message4=$randms");
        // echo header("location: ../mfi/client.php");
    }
}
elseif(isset($_GET['close'])){
    $id = $_GET['close'];

    $doe = mysqli_query($connection, "UPDATE groups SET status='Closed' WHERE id='$id'");

      if($doe) {
        // If 'result' is successful, it will send the required message to client.php
      $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
      echo header ("Location: ../mfi/groups.php?message5=$randms");
    } else {
       $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
       echo "error";
      echo header ("Location: ../mfi/groups.php?message6=$randms");
        // echo header("location: ../mfi/client.php");
    }
}
elseif(isset($_GET['app'])){
  $id = $_GET['app'];

  $doe = mysqli_query($connection, "UPDATE groups SET status='Approved', approvedon_date = '$date' WHERE id='$id'");

    if($doe) {
      // If 'result' is successful, it will send the required message to client.php
    $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
    echo header ("Location: ../mfi/approve_group.php?message1=$randms");
  } else {
     $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
     echo "error";
    echo header ("Location: ../mfi/approve_group.php?message2=$randms");
      // echo header("location: ../mfi/client.php");
  }
}
?>