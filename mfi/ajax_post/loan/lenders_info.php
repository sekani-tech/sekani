<?php
include("../../../functions/connect.php");
session_start();
$output = '';
$output2 = '';
$id = 1;
if (isset($_POST["id"])) {

  function branch_option($connection)
  {
    $br_id = $_SESSION["branch_id"];
    $sint_id = $_POST["ist"];
    $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
    $dof = mysqli_query($connection, $dff);
    $out = '';
    while ($row = mysqli_fetch_array($dof)) {
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
    while ($row = mysqli_fetch_array($dof)) {
      $do = $row['id'];
      $out .= " OR branch_id ='$do'";
    }
    return $out;
  }
  $branche = branch_opt($connection);
  $branches = branch_option($connection);
  $br_id = $_SESSION['branch_id'];
  if ($_POST["id"] != '') {
    $int_id = $_POST["ist"];
    $accountNo = $_POST["id"];
    $sql = "SELECT client.id, client.firstname, client.middlename, client.lastname FROM client JOIN account ON account.client_id = client.id WHERE client.int_id = '" . $_POST["ist"] . "' && account.account_no = '" . $_POST["id"] . "' AND client.status = 'Approved'";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
      $findGroup = mysqli_query($connection, "SELECT id, g_name FROM groups JOIN group_balance ON group_balance.group_id = groups.id AND groups.int_id = '" . $_POST["ist"] . "' AND group_balance.account_no = '190002572'");
      // dd($findGroup);
      if(!$findGroup) {
            printf('Error: %s\n', mysqli_error($connection));//checking for errors
            exit();
          }else{
            //output
            while ($row = mysqli_fetch_array($findGroup)) {
              $output = '<div class="form-group">
                <label>Account Name:</label>
                <input type="text" value="' . strtoupper($row["g_name"]) . '" name="principal_amoun" class="form-control" readonly required id="principal_amount">
                <input type="text" id="client_id" name="client_id" value="' . $row["id"] . '" hidden>
              </div>
              ';
            }
           
          }
    } else {
      while ($row = mysqli_fetch_array($result)) {
        $output = '<div class="form-group">
          <label>Account Name:</label>
          <input type="text" value="' . strtoupper($row["firstname"]) . ' ' . strtoupper($row["middlename"]) . ' ' . strtoupper($row["lastname"]) . '" name="principal_amoun" class="form-control" readonly required id="principal_amount">
          <input type="text" id="client_id" name="client_id" value="' . $row["id"] . '" hidden>
        </div>
        ';
      }
    }
  }
  if ($_POST["id"] != '') {
    $ans = "SELECT loan.*, product.name FROM loan JOIN product ON loan.account_no = '" . $_POST["id"] . "' AND loan.int_id = '" . $_POST["ist"] . "' AND product.id = loan.product_id AND loan.total_outstanding_derived > 0";
    $result = mysqli_query($connection, $ans);

    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_array($result)) {
            $output2 = '<div class="form-group">
              <label>Loan Details:</label>
              <input type="text" value="Existing Loan - ' . $row["total_outstanding_derived"] . ' - ' . $row["name"] . '" name="principal_amoun" class="form-control" readonly required id="principal_amount">
            </div>
            ';
          }
        
    } else {
        $output2 = '<div class="form-group">
        <label>Account Balance:</label>
        <input type="text" value="No Loan" name="principal_amoun" class="form-control" readonly required id="principal_amount">
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
