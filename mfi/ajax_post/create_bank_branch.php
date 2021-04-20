<?php
include("../../functions/connect.php");
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
        $findParent = mysqli_query($connection,"SELECT id FROM acc_gl_account WHERE gl_code = '10200' AND int_id ='$int_id' AND branch_id = '$branch_id' ");
        $fid = mysqli_fetch_array($findParent);
        $id = $fid['id'];
        $org = "SELECT name, gl_code FROM acc_gl_account WHERE int_id = '$int_id' AND parent_id = '$id' AND branch_id = '$branch_id'";
        $res = mysqli_query($connection, $org);
        $out = '';
        while ($row = mysqli_fetch_array($res))
        {
                $out .= '<option name ="gl_code" value="'.$row["gl_code"].'">'.$row["name"]. '</option>';
        }
        return $out;
        }
// while ($row = mysqli_fetch_array($result))
//     {
        echo ''.fill_branch($connection).'';
// }

?>