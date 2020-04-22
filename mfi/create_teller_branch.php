<?php
include("../functions/connect.php");


$teller_name = $_POST['tell_name'];

// $query = "SELECT * FROM branch";
// $result = mysqli_query($connection, $query);
// if (count([$result]) == 1) {
//     $a = mysqli_fetch_array($result);
//     $name = $a['name'];
//    }
   function fill_branch($connection)
        {
        $org = "SELECT * FROM branch WHERE id = '$branch_id'";
        $res = mysqli_query($connection, $org);
        $out = '';
        while ($row = mysqli_fetch_array($res))
        {
        $out .= '<option value="'.$row["id"].'">'.$row["name"]. '</option>';
        }
        return $out;
        }
// while ($row = mysqli_fetch_array($result))
//     {
        echo ''.fill_branch($connection).'';    
// }

?>