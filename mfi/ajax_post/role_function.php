<?php
// include("../../functions/connect.php");
// $output2 = '';

// if (isset($_POST["id"]) && isset($_POST["int_id"]))
// {
//     $int_id = $_POST["int_id"];
//     if($_POST["id"] != '' && $_POST["int_id"] != '')
//     {
//         $acct_use = $_POST["id"];
//         function fill_group($connection, $acct_use, $int_id)
//         {
//             $org = "SELECT * FROM `staff` WHERE int_id = '$int_id' &&  org_role = '$acct_use' ORDER BY org_role ASC";
//             $res = mysqli_query($connection, $org);
//             $row = mysqli_fetch_array($res);
//             $st_id = $row["id"];
//             // Parttwo
//             $orgx = mysqli_query($connection, "SELECT * FROM permission WHERE staff_id = '$st_id' && int_id = '$int_id'");
//             $resx1 = mysqli_num_rows($orgx);
//             if ($resx1 == 0 || $resx1 == NULL || $resx1 == '') {
//               $out1 = '';
//               while ($row = mysqli_fetch_array($res))
//               {
//                 $out1 .= '<option value="'.$row["id"].'">'.strtoupper($row["first_name"]." ".$row["last_name"]).'</option>';
//               }
//             } else {
//             // new stuff
//             $getstaff = "SELECT * FROM `staff` WHERE int_id = '$int_id' &&  org_role = '$acct_use' && id != '$st_id' ORDER BY org_role ASC";
//             $res1 = mysqli_query($connection, $getstaff);
//             // OK lets Go
//             $out1 = '';
//               while ($row1 = mysqli_fetch_array($res1))
//               {
//                 $out1 .= '<option value="'.$row1["id"].'">'.strtoupper($row1["first_name"]." ".$row1["last_name"]).'</option>';
//               }
//             }
//             return $out1;
//         }
//         $output2 = '
//         <label class="bmd-label-floating">Staff</label>
//           <select class="form-control" name="parent_id" id="pid">
//             "'.fill_group($connection, $acct_use, $int_id).'"
//           </select>';
//     echo $output2;
//     }
// }
?>