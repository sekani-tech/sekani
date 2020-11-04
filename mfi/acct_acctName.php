<?php
include("../functions/connect.php");
session_start();
$output = '';
$output2 = '';

if(isset($_POST["name"]))
{

  function branch_option($connection)
  {  
      $br_id = $_SESSION["branch_id"];
      $sint_id = $_POST["ist"];
      $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
      $dof = mysqli_query($connection, $dff);
      $out = '';
      while ($row = mysqli_fetch_array($dof))
      {
        $do = $row['id'];
      $out .= " OR client.branch_id ='$do'";
      }
      return $out;
  }
  function branch_opt($connection)
  {  
      $br_id = $_SESSION["branch_id"];
      $sint_id = $_POST["ist"];
      $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
      $dof = mysqli_query($connection, $dff);
      $out = '';
      while ($row = mysqli_fetch_array($dof))
      {
        $do = $row['id'];
      $out .= " OR branch_id ='$do'";
      }
      return $out;
  }
  $branche = branch_opt($connection);
  $branches = branch_option($connection);
  $br_id = $_SESSION['branch_id'];
    if($_POST["name"] !='')
    {
        $sql = "SELECT client.id, account.account_no FROM client JOIN account ON account.client_id = client.id WHERE (client.branch_id ='$br_id' $branches) && client.int_id = '".$_POST["ist"]."' && client.display_name = '".$_POST["name"]."' AND client.status = 'Approved'";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($result))
    {
        $output = '<div class="form-group">
        <label>Account Number:</label>
        <input type="text" value=" '.strtoupper($row["account_no"]).'" name="principal_amoun" class="form-control" readonly required id="principal_amount">
      </div>
      ';
    }
  }
    if($_POST["name"] !='')
    {
        $ans = "SELECT * FROM account WHERE account_no = '".$_POST["name"]."' && (branch_id ='$br_id' $branche) && int_id = '".$_POST["ist"]."'";
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