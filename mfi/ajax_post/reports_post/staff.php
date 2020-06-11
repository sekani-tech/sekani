<?php
include("../../../functions/connect.php");

if(isset($_POST['id'])){
    $state = $_POST['id'];

            $stateg = "SELECT * FROM staff WHERE branch_id = '$state'";
            $state1 = mysqli_query($connection, $stateg);
            $out = '';
            while ($row = mysqli_fetch_array($state1))
            {
            $out .= '
            <option value="'.$row["id"].'">'.$row["display_name"].'</option>';
            }
            echo $out;
    }
    else {
        echo 'ID not posted';
    }
?>