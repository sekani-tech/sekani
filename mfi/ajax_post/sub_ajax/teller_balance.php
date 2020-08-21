<?php
include("../../../functions/connect.php");
$output = '';
session_start();

  // we are gonna post to get the name of the button
  if (isset($_POST['id'])) {
    $name = $_POST['id'];
    $int_id = $_SESSION['int_id'];
    $branchid = $_SESSION['branch_id'];
  
    $que = "SELECT * FROM institution_account WHERE teller_id = '$name' AND int_id = '$int_id' AND branch_id = '$branchid'";
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
  else if (isset($_POST['ib'])) {
    $name = $_POST['ib'];
    $int_id = $_SESSION['int_id'];
    $branchid = $_SESSION['branch_id'];
  
    $que = "SELECT * FROM acc_gl_account WHERE gl_code = '$name' AND int_id = '$int_id' AND branch_id = '$branchid'";
    $roc = mysqli_query($connection, $que);
    $yn = mysqli_fetch_array($roc);
    $balance = $yn['organization_running_balance_derived'];

    $output = '<div class="form-group">
    <label>Account Balance:</label>
    <input type="text" value="'.number_format($balance, 2).'" name="principal_amoun" class="form-control" readonly required id="principal_amount">
  </div>
  ';
    echo $output;
  }
    ?>