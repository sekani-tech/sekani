<?php
include("../functions/connect.php");

$output = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT * FROM client WHERE account_no = '".$_POST["id"]."' && int_id = '".$_POST["ist"]."'";
    }
    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_array($result))
    {
        $output = '<div class="form-group">
        <label>Account First Name:</label>
        <input type="text" value="'.$row["firstname"].'" name="principal_amoun" class="form-control" readonly required id="principal_amount">
      </div>
      <div class="form-group">
        <label>Account Middle Name:</label>
        <input type="text" value="'.$row["middlename"].'" name="principal_amoun" class="form-control" readonly required id="principal_amount">
      </div>
      <div class="form-group">
        <label>Account Last Name:</label>
        <input type="text" value="'.$row["lastname"].'" name="principal_amoun" class="form-control" readonly required id="principal_amount">
      </div>
      ';
    }
    if($_POST["id"] !='')
    {
        $ans = "SELECT * FROM account WHERE account_no = '".$_POST["id"]."' && int_id = '".$_POST["ist"]."'";
    }
    $result = mysqli_query($connection, $ans);

    while ($row = mysqli_fetch_array($result))
    {
        $output2 = '<div class="form-group">
        <label>Account Balance:</label>
        <input type="text" value="'.$row["account_balance_derived"].'" name="principal_amoun" class="form-control" readonly required id="principal_amount">
      </div>
      ';
    }
    echo $output;
    echo $output2;
}
// session_start();
//    $_SESSION['load_term'] = "batman";
//    $_SESSION['interest_rate'] = "batman";
//    $_SESSION['disbursment_date'] = "batman";
?>