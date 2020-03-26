<?php
include("../functions/connect.php");

$output = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT * FROM collateral WHERE id = '".$_POST["id"]."'";
    }
    else
    {
        $sql = "SELECT * FROM collateral";
    }
    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_array($result))
    {
        $output = '<div class="form-group">
        <label>Value:</label>
        <input type="text" value="'.$row["value"].'" name="col_name" class="form-control" />
      </div>
      <div class="form-group">
        <label for="">Description:</label>
        <input type="text" value="'.$row["description"].'" name="col_description" class="form-control" id="">
      </div>';
    }
    echo $output;
}
?>