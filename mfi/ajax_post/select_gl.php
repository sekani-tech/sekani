<?php
include("../../functions/connect.php");
session_start();
$fof = $_SESSION['int_id'];

if(isset($_POST['id'])){
    $state = $_POST['id'];

            $stateg = "SELECT * FROM acc_gl_account WHERE int_id = '$fof ' AND classification_enum = '$state'";
            $state1 = mysqli_query($connection, $stateg);
            $out = '';
            while ($row = mysqli_fetch_array($state1))
            {
            $out .= '
            <option value="'.$row["gl_code"].'">'.$row["name"].'</option>';
            }
            echo $out;
    }
    else {
        echo 'ID not posted';
    }
?>