<?php
include("../functions/connect.php");
session_start();
$output = '';
$output2 = '';

if(isset($_POST["id"]))
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
    if($_POST["id"] !='')
    {
        $sql = "SELECT client.id, client.firstname, client.middlename, client.lastname FROM client JOIN account ON account.client_id = client.id && (client.branch_id ='$br_id' $branches) && client.int_id = '".$_POST["ist"]."' && account.account_no = '".$_POST["id"]."' AND status='Approved'";
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
        $ans = "SELECT * FROM account WHERE account_no = '".$_POST["id"]."' && (branch_id ='$br_id' $branche) && int_id = '".$_POST["ist"]."'";
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