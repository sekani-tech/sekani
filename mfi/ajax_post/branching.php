<?php
include("../../functions/connect.php");

if(isset($_POST['id'])){
    $state = $_POST['id'];

            $stateg = "SELECT * FROM branch WHERE int_id = '$state' ORDER BY parent_id,id ASC";
            $state1 = mysqli_query($connection, $stateg);
            $out = '';
            while ($row = mysqli_fetch_array($state1))
            {
            $out .= '
            <option value="'.$row["id"].'">'.$row["name"].'</option>';
            }
            echo $out;
    }
    else {
        echo 'ID not posted';
    }
?>