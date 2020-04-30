<?php
include("../../functions/connect.php");
$int_id = $_SESSION["int_id"];
$output2 = '';

if (isset($_POST["gl"]))
{
    if($_POST["gl"] != '')
    {
        function fill_group($connection)
        {
            $int_id = $_SESSION["int_id"];
            $org = "SELECT * FROM `acc_gl_account` WHERE parent_id IS NULL  && int_id = '$int_id'";
            $res = mysqli_query($connection, $org);
            $out = '';
            while ($row = mysqli_fetch_array($res))
              {
                $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
              }
            return $out;
        }
        $output2 = '<div class="col-md-6">
        <div class="form-group">
          <label >GL Group</label>
          <select class="form-control" name="parent_id" id="pid" required>
            <option value="0">choose group</option>
            "'.fill_group($connection).'"
          </select>                    
        </div>
      </div>';
    echo $output2;
    } else {
        echo "BLANK";
    }
} else {
    echo "NOT CALLING";
}
?>