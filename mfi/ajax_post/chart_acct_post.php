<?php
include("../../functions/connect.php");
$int_id = $_SESSION["int_id"];
session_start();

$output2 = '';

if (isset($_POST["gl"]) && isset($_POST["ch"]) && $_POST["gl"] == "1")
{
    if($_POST["gl"] != '' && $_POST["ch"] != '')
    {
        $acct_use = $_POST["ch"];
        function fill_group($connection, $acct_use)
        {
            $int_id = $_SESSION["int_id"];
            $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$int_id' && classification_enum = '$acct_use' && parent_id IS NULL";
            $res = mysqli_query($connection, $org);
            $out = '';
            while ($row = mysqli_fetch_array($res))
              {
                echo $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
              }
            return $out;
        }
        $output2 = '<label >GL Group</label>
          <select class="form-control" name="parent_id" id="pid">
            <option value="0">choose group</option>
            "'.fill_group($connection, $acct_use).'"
          </select>';
    echo $output2;
    } else {
        echo "empty"." + ".$int_id ;
    }
} else {
    echo "check the gl account";
}
?>