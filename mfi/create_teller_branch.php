<?php
include("../functions/connect.php");
// $query = "SELECT * FROM branch";
// $result = mysqli_query($connection, $query);
// if (count([$result]) == 1) {
//     $a = mysqli_fetch_array($result);
//     $name = $a['name'];
//    }
   function fill_branch($connection)
        {
        $staff_id = $_POST['tell_name'];
        $que = "SELECT * FROM staff WHERE id = '$staff_id'";
        $ans = mysqli_query($connection, $que);
        if (count([$ans]) == 1) {
        $a = mysqli_fetch_array($ans);
        $branch_id = $a['branch_id'];
       }
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