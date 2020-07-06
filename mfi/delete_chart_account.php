<?php
include("../functions/connect.php");
session_start();
$sessint_id = $_SESSION['int_id'];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

if(isset($_GET['edit'])){
    $id = $_GET['edit'];
   $que = "DELETE FROM acc_gl_account WHERE int_id = '$sessint_id' AND id = '$id'";
    $fdof = mysqli_query($connection, $que);
    if ($fdof) {
        $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
              echo header ("Location: chart_account.php?message1=$randms");
            } else {
               $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
               echo "error";
              echo header ("Location: chart_account.php?message2=$randms");
                // echo header("location: ../mfi/client.php");
            }
}
?>