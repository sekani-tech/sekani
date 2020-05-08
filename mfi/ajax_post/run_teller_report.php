<?php
include("../../functions/connect.php");
$output = '';
?>
<?php
if (isset($_POST["start"]) && isset($_POST["branch"]) && isset($_POST["teller"]) && isset($_POST["int_id"]))
{
    $int_id = $_POST["int_id"];
    if($_POST["start"] != '' && $_POST["teller"] != '')
    {
        $start = $_POST["start"];
       $end = $_POST["end"];
       $branch = $_POST["branch"];
       $teller = $_POST["teller"];
       $int_name = $_SESSION["int_name"];
   $query = mysqli_query($connection, "SELECT * FROM tellers WHERE name ='$teller' && int_id='$int_id' && branch_id = '$branch'");
  if (count([$query]) == 1) {
    $ans = mysqli_fetch_array($query);
    $id = $ans['id'];
    $int_id = $ans['int_id'];
    $tell_name = $ans['description'];
    $postlimit = $ans['post_limit'];
    $tellerno = $ans['till_no'];
    $tillno = $ans['till'];
    $startdate = $ans['valid_from'];
    $endate = $ans['valid_to'];
    $branch_id = $ans['branch_id'];
    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
    }
  }

       $querytoget = mysqli_query($connection, "SELECT * FROM institution_account_transaction WHERE teller_id = '$teller' || appuser_id = '$teller' && int_id = '$int_id' && branch_id = '$branch_id' && transaction_date >= '$start' AND transaction_date <= '$end' ORDER BY id ASC");
       $q = mysqli_fetch_array($querytoget);
       $client_id = $q["client_id"];
       $transact_id = $q["transaction_id"];
       $transaction_type = $q["transaction_type"];
       $transaction_date = $q["transaction_date"];
       $amount = $q["amount"];
       $balance = $q["running_balance_derived"];
      //  test
       $teller_id = $q["teller_id"];
       $teller_run_bal = $q["running_balance_derived"];
       $client_query = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id' && int_id = '$int_id'");
       $nx = mysqli_fetch_array($client_query);
       $client_name = $nx["firstname"]." ".$nx["middlename"]." ".$nx["lastname"];
      //  Always Check the vault
      if (count([$query]) == 1 && count([$branchquery]) == 1) {
        // here we will some data
        if ($transaction_type == "vault_in") {
          $client_name = "Valut In";
          $amt = number_format($amount, 2);
        }
        if ($transaction_type == "valut_out") {
          $client_name = "Valut Out";
          $amt = number_format($amount, 2);
        }
        if ($transaction_type == "credit" || "Credit") {
          // credit
          $tcdp = round($amount);
          $amt = number_format($amount, 2);
        }
        if ($transaction_type == "debit" || "Debit") {
          // debit
          $tddp = round($amount);
          $amt2 = number_format($amount, 2);
        }
        $balran = round($teller_run_bal);
        // DONE HERE
        if ($teller_id != $teller) {
          $runglq = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE gl_code = '$teller_id'");
          $w = mysqli_fetch_array($runglq);
          $client_name = $w["name"];
        }
        // then we will be fixing
        echo '<div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">'.$int_name." ".$branch.'</h4>
            <p class="card-category">Teller Call Over Report</p>
          </div>
          <div class="card-body">
            <!-- sup -->
            <!-- hello -->
            <form action="" method="post">
              <div class="row">
                  <div class="col-md-4 form-group">
                      <label for="">Name of Teller</label>
                      <input type="text" name="" value="'.$tell_name.'" id="" class="form-control" readonly>
                  </div>
                  <div class="col-md-4 form-group">
                      <label for="">Branch</label>
                      <input type="text" name="" value="'.$branch.'" id="" class="form-control" readonly>
                  </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">As at:</label>
                    <input type="text" value="'.$end.'" name="" class="form-control" id="" readonly>
                  </div>
                </div>
                </div>
              <div class="clearfix"></div>
            </form>
            <div class="table-responsive">
              <table id="tabledat4" class="table" style="width: 100%;">
                <thead class=" text-primary">
                  <!-- <th>
                    ID
                  </th> -->
                  <th>Account Name</th>
                  <th>Deposit</th>
                  <th>
                    Withdrawal
                  </th>
                  <th>Balance</th>
                </thead>
                <tbody>
                '; if (mysqli_num_rows($querytoget) > 0) { 
                  while($row = mysqli_fetch_array($querytoget, MYSQLI_ASSOC)) {
                  echo '
                  <tr>
                    <th>'.$client_name.'</th>
                    <th>'.$amt.'</th>
                    <th>'.$amt2.'</th>
                    <td>'.number_format($teller_run_bal, 2).'</td>
                  </tr>
                  '; }}
                  else {
                    echo "0 Doc";
                  }
                  echo '<tr>
                      <th>Total</th>
                      <th></th>
                      <th>Total Deposit</th>
                      <th>Total Withdrawal</th>
                      <th>Total Balance</th>
                  </tr>
                </tbody>
              </table>
            </div>
            <p><b>Opening Balance:</b> '.$vin.' </p>
            <p><b>Total Deposit:</b> '.$tcdp.' </p>
            <p><b>Total Withdrawal:</b> '.$tddp.' </p>
            <p><b>Closing Balance:</b> 129 </p>
            <hr>
            <p><b>Teller Sign:</b> 129                        <b>Date:</b></p>
            <p><b>Checked By:</b>                             <b>Date/Sign:</b></p>
          </div>
        </div>
      </div>';
      echo $output;
      } else {
        echo 'Not Seeing Data';
      }
    }
}
?>