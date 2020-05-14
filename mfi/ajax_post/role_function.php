<?php
include("../../functions/connect.php");
$output2 = '';

if (isset($_POST["id"]) && isset($_POST["int_id"]))
{
    $int_id = $_POST["int_id"];
    if($_POST["id"] != '' && $_POST["int_id"] != '')
    {
        $acct_use = $_POST["id"];
        function fill_group($connection, $acct_use, $int_id)
        {
            $org = "SELECT * FROM `staff` WHERE int_id = '$int_id' &&  org_role = '$acct_use' ORDER BY org_role ASC";
            $res = mysqli_query($connection, $org);
            $out = '';
            while ($row = mysqli_fetch_array($res))
              {
                $out .= '<option value="'.$row["id"].'">'.strtoupper($row["first_name"]." ".$row["last_name"]).'</option>';
              }
            return $out;
        }
        $output2 = '
        <label class="bmd-label-floating">Staff</label>
          <select class="form-control" name="parent_id" id="pid">
            "'.fill_group($connection, $acct_use, $int_id).'"
          </select>';
    echo $output2;
    }
}
?>