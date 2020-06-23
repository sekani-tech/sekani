<?php
include("../../functions/connect.php");
$output2 = '';
session_start();
if (isset($_POST["gl"]) && isset($_POST["ch"]))
{
    $int_id = $_POST["id"];
    if($_POST["gl"] != '' && $_POST["ch"] != '')
    {
        $acct_use = $_POST["ch"];

        function fill_gl($connection) {
          $sint_id = $_SESSION["int_id"];
          $org = "SELECT * FROM acc_gl_account WHERE (int_id = '$sint_id' AND (parent_id = '' OR parent_id = '0'))";
          $res = mysqli_query($connection, $org);
          $out = '';
          while ($row = mysqli_fetch_array($res))
          {
            $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
          }
          return $out;
        }
        $output2 = '<label >GL Group</label>
          <select class="form-control" name="parent_id" id="pid">
            <option value="0">choose group</option>
            "'.fill_gl($connection, $acct_use, $int_id).'"
          </select>';
    echo $output2;
    }
}
?>