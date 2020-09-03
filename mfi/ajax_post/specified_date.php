<?php
include("../../functions/connect.php");
$output = '';

if (isset($_POST["id"]))
{
    $id = $_POST["id"];
    if($id == "2"){
        $outo = '
        <div class="form-group">
        <label class="bmd-label-floating">Amount</label>
        <input type="number" class="form-control" name="amount">
      </div>
      ';
      echo $outo;
    }
}
?>