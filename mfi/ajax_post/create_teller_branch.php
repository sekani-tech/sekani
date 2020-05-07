<?php
include("../../functions/connect.php");
$output = '';
   function fill_branch($connection)
        {
        $branch_id = $_POST['id'];
        $int_id = $_POST['int_id'];

        $org = "SELECT * FROM tellers WHERE int_id = '$int_id' && branch_id = '$branch_id' ";
        $res = mysqli_query($connection, $org);
        $out = '';
        while ($row = mysqli_fetch_array($res))
        {
        $out .= '<option name ="teller_id" value="'.$row["name"].'">'.$row["description"]. '</option>';
        }
        return $out;
        }
        $output = '
        <label class="bmd-label-floating">Teller</label>
          <select class="form-control" name="teller1" id="till">
            <option value="">choose teller</option>
            "'.fill_branch($connection).'"
          </select>';
    echo $output;
?>