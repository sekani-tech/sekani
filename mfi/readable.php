<?php
include("../functions/connect.php");
$int_id = $_SESSION["int_id"];
$output = '';
$output2 = '';
if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT client.id, client.firstname, client.middlename, client.lastname FROM client JOIN account ON account.client_id = client.id && client.int_id = '".$_POST["ist"]."' && account.account_no = '".$_POST["id"]."'";
    }
    $output = '<div>"'.$rd = "".'"</div>';
    echo $output;
} else if (isset($_POST["gl"]) && $_POST["gl"] == 2)
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
    }
    while ($row = mysqli_fetch_array($res))
    {
        $output2 = '<div class="col-md-6">
        <div class="form-group">
          <label >GL Group</label>
          <select class="form-control" name="parent_id" id="pid" required>
            <option value="0">choose group</option>
            "'.fill_group($connection).'"
          </select>                    
        </div>
      </div>';
    }
    echo $output2;
}
?>