<?php
include("connect.php");
$output = '';
session_start();

if(isset($_GET["edit"]))
{
    $sessint_id = $_SESSION["int_id"];
    $branch_id = $_SESSION["branch_id"];
    $gid = $_GET["edit"];

    $eor = "SELECT * FROM group_clients WHERE id = '{$gid}'";
    $jendjen = mysqli_query($connection, $eor);
    $mfi = mysqli_fetch_array($jendjen);
    $randms = $mfi['group_id'];

    $query = "DELETE FROM group_clients WHERE id = '{$gid}'";
     $queryexec = mysqli_query($connection, $query);
     if ($queryexec) {
      $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
            echo header ("Location: ../mfi/update_group.php?edit=$randms");
          } else {
             $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
             echo "error";
            echo header ("Location: ../mfi/update_group.php?edit=$randms");
              // echo header("location: ../mfi/client.php");
          }
}
?>