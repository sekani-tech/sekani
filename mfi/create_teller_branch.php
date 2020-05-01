<?php
include("../functions/connect.php");
// $query = "SELECT * FROM branch";
// $result = mysqli_query($connection, $query);
// if (count([$result]) == 1) {
//     $a = mysqli_fetch_array($result);
//     $name = $a['name'];
//    }
$output = '';
   function fill_branch($connection)
        {
        $branch_id = $_POST['id'];
        $int_id = $_POST['int_id'];

        $org = "SELECT * FROM staff WHERE int_id = '$int_id' && branch_id = '$branch_id' ";
        $res = mysqli_query($connection, $org);
        $out = '';
        while ($row = mysqli_fetch_array($res))
        {
        $out .= '<option name ="staff" value="'.$row["id"].'">'.$row["display_name"]. '</option>';
        }
        return $out;
        }
// while ($row = mysqli_fetch_array($result))
//     {
        echo ''.fill_branch($connection).'';
// }

?>