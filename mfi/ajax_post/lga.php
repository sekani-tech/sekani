<?php
include("../../functions/connect.php");

if(isset($_POST['id'])){
    $state = $_POST['id'];

            $stateg = "SELECT * FROM locals WHERE state_id = '$state' ORDER BY locals.local_name ASC";
            $state1 = mysqli_query($connection, $stateg);
            $out = '';
            while ($row = mysqli_fetch_array($state1))
            {
            $out .= '
            <option value="'.$row["local_name"].'">'.$row["local_name"].'</option>';
            }
            echo $out;
    }
    else {
        echo 'ID not posted';
    }
?>