<?php
include("../../functions/connect.php");
$output2 = '';
session_start();
if (isset($_POST["ch"]))
{
    $int_id = $_POST["id"];
        function fill_gl($connection) {
          $acct_use = $_POST["ch"];
          $sint_id = $_SESSION["int_id"];
          $org = "SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND parent_id = '$acct_use'";
          $res = mysqli_query($connection, $org);
          $out = '';
          while ($row = mysqli_fetch_array($res))
          {
            $out .= '<option value="'.$row["gl_code"].'">'.$row["name"].'</option>';
          }
          return $out;
        }
        $output2 = '
            "'.fill_gl($connection).'"
            ';
    echo $output2;
}
?>