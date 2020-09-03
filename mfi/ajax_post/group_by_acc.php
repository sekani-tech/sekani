<?php
include("../../functions/connect.php");
session_start();
if(isset($_POST['officer'])){
    $dfo = $_POST['officer'];
    $sint_id = $_SESSION["int_id"];
    function fill_officer($connection, $dfo, $sint_id)
    {
    $org = "SELECT * FROM groups WHERE int_id = '$sint_id' AND loan_officer = '$dfo'";
    $res = mysqli_query($connection, $org);
    $out = '';
    while ($row = mysqli_fetch_array($res))
    {
      $out .= '<option value="'.$row["id"].'">'.$row["g_name"].'</option>';
    }
    return $out;
    }  
}
$fdo ='
<label for="">Group</label>
<select name="" id="group" class="form-control">
<option value="all">All</option>
'.fill_officer($connection, $dfo, $sint_id).'
</select>
';
echo $fdo;
?>