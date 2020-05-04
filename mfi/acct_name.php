<?php
include("../functions/connect.php");

$output = '';
$output2 = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT client.id, client.firstname, client.middlename, client.lastname FROM client JOIN account ON account.client_id = client.id && client.int_id = '".$_POST["ist"]."' && account.account_no = '".$_POST["id"]."'";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($result))
    {
        $output = '<div class="form-group">
        <label>Account Name:</label>
        <input type="text" value="'.strtoupper($row["firstname"]).' '.strtoupper($row["middlename"]). ' '.strtoupper($row["lastname"]).'" name="principal_amoun" class="form-control" readonly required id="principal_amount">
      </div>
      ';
    }
    }


    if($_POST["id"] !='')
    {
        $ans = "SELECT * FROM account WHERE account_no = '".$_POST["id"]."' && int_id = '".$_POST["ist"]."'";
        $result = mysqli_query($connection, $ans);

    while ($row = mysqli_fetch_array($result))
    {
        $output2 = '<div class="form-group">
        <label>Account Balance:</label>
        <input type="text" value="'.$row["account_balance_derived"].'" name="principal_amoun" class="form-control" readonly required id="principal_amount">
      </div>
      ';
    }
    }
    echo $output;
    echo $output2;
}
// session_start();
//    $_SESSION['load_term'] = "batman";
//    $_SESSION['interest_rate'] = "batman";
//    $_SESSION['disbursment_date'] = "batman";
?>