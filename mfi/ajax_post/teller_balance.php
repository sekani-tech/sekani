<?php
include("../../functions/connect.php");
$output = '';

  // we are gonna post to get the name of the button
  if (isset($_POST['id'])) {
    $name = $_POST['id'];
  
    $que = "SELECT * FROM institution_account WHERE teller_id = '$name'";
    $roc = mysqli_query($connection, $que);
    $yn = mysqli_fetch_array($roc);
    $balance = $yn['account_balance_derived'];

    $output = '<div class="form-group">
    <label>Account Balance:</label>
    <input type="text" value="'.$balance.'" name="principal_amoun" class="form-control" readonly required id="principal_amount">
  </div>
  ';
    echo $output;
  }
    ?>