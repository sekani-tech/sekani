<?php
include('../../../functions/connect.php');
session_start();

$sessint_id = $_SESSION['int_id'];
$int_name = $_SESSION['int_name'];
$user_id = $_SESSION["user_id"];
$quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' AND user_id = '$user_id'";
$rult = mysqli_query($connection, $quy);

  $rccw = mysqli_fetch_array($rult);
        $roleid = $rccw['org_role'];
        $quyd = "SELECT * FROM permission WHERE  int_id = '$sessint_id' AND role_id = '$roleid'";
        $rlot = mysqli_query($connection, $quyd);
        $tolm = mysqli_fetch_array($rlot);
        $report = $tolm['staff_cabal'];
if($report == 1 || $report == '1'){
if (isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["branch"]))
{
    $int_id = $_SESSION["int_id"];
    $branch = $_POST["branch"];
    $branch_id = $_POST["branch"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $std = $_POST["start"];
    $endx = $_POST["end"];
      //  Always Check the vault
      $don = mysqli_query($connection, "SELECT * FROM branch WHERE id = '$branch_id'");
      $r = mysqli_fetch_array($don);
      $branch = $r['name'];
      function fill_stafff($connection, $int_id, $start, $end, $branch_id)
        {
          // import
                    // $q = mysqli_fetch_array($querytoget);
          $out = '';
          $sessint_id = $_SESSION['int_id'];
          $querytoget = mysqli_query($connection, "SELECT * FROM staff WHERE ((branch_id = '$branch_id') AND (int_id ='$int_id' AND employee_status = 'Employed'))");
          $q = mysqli_fetch_array($querytoget);
          while ($q = mysqli_fetch_array($querytoget))
          {
            $staff = $q["id"];
          $name = $q["display_name"];

          $query1 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query1exec = mysqli_query($connection, $query1);
          $current = mysqli_num_rows($query1exec);

          $query4 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query4exec = mysqli_query($connection, $query4);
          $c = mysqli_fetch_array($query4exec);
          $currentamount = $c['account_balance_derived'];

          $query2 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query2exec = mysqli_query($connection, $query2);
          $savings = mysqli_num_rows($query2exec);

          $query5 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query5exec = mysqli_query($connection, $query5);
          $s = mysqli_fetch_array($query5exec);
          $savingsamount = $s['account_balance_derived'];

          $query3 = "SELECT * FROM loan WHERE loan_officer = '$staff' AND submittedon_date BETWEEN '$start' AND '$end'";
          $query3exec = mysqli_query($connection, $query3);
          $loans = mysqli_num_rows($query3exec);

          $query6 = "SELECT SUM(principal_amount)  AS principal_amount FROM loan WHERE loan_officer = '$staff'AND submittedon_date BETWEEN '$start' AND '$end'";
          $query6exec = mysqli_query($connection, $query6);
          $l = mysqli_fetch_array($query6exec);
          $loansamount = $l['principal_amount'];
            $out .= '
            <tr>
            <th>'.$staff.'</th>
            <th>'.$name.'</th>
            <th>'.$current.'</th>
            <th>'.$currentamount.'</th>
            <th>'.$savings.'</th>
            <th>'.$savingsamount.'</th>
            <th>'.$loans.'</th>
            <th>'.$loansamount.'</th>
            </tr>
          ';
        }
          return $out;
        }
        $querycurttl = mysqli_query($connection, "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.product_id = '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'");
        $totalcurrent = mysqli_num_rows($querycurttl);

        $querysavttl = mysqli_query($connection, "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.product_id != '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'");
        $totalsavings = mysqli_num_rows($querysavttl);

        $querycurttl = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND submittedon_date BETWEEN '$start' AND '$end'");
        $totalloan = mysqli_num_rows($querycurttl);
        $output = '<div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">'.$int_name." ".$branch.'</h4>
            <p class="card-category">Teller Call Over Report</p>
          </div>
          <div class="card-body">
            <!-- sup -->
            <!-- hello -->
            <form action="../composer/staff_cabal.php" method="POST">
              <div class="row">
                  <div class="col-md-4 form-group">
                      <label for="">Branch</label>
                      <input type="text" name="start" value="'.$start.'" id="start1" class="form-control" hidden>
                      <input type="text" name="end" value="'.$end.'" id="end1" class="form-control" hidden>
                      <input type="text" name="branch" value="'.$branch_id.'" id="branch1" class="form-control" hidden>
                      <input type="text" name="int_id" value="'.$int_id.'" id="int_id1" class="form-control" hidden>
                      <input type="text" name="" value="'.$branch.'" id="" class="form-control" readonly>
                  </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">As at:</label>
                    <input type="date" value="'.$endx.'" name="" class="form-control" id="" readonly>
                  </div>
                </div>
                </div>
              <div class="clearfix"></div>
            
            <div class="table-responsive">
              <table id="tabledat4" class="table table-bordered" style="width: 100%;">
              <thead class=" text-primary">
              <tr>
                <th>Staff ID</th>
                  <th>Accounts Officer</th>
                  <th colspan="2">Current Accounts</th>
                  <th colspan="2">Savings Accounts</th>
                  <th colspan="2">Loans Disbursement
                  </th>
                  </tr>
                  <tr>
                  <th></th>
                  <th></th>
                  <th>No of Client</th>
                  <th>Value of Accounts </th>
                  <th>No of Client</th>
                  <th>Value of Accounts</th>
                  <th>No of Client</th>
                  <th>Value of Accounts</th>
                  </tr>
                </thead>
                <tbody>
                '.fill_stafff($connection, $int_id, $std, $endx, $branch_id).'
                <tr>
              <th>Total</th>
              <th></th>
              <th>'.$totalcurrent.'</th>
               <th></th>
               <th>'.$totalsavings.'</th>
               <th></th>
               <th>'.$totalloan.'</th>
               <th></th>
              </tr>
                </tbody>
              </table>
            </div>
            
            <hr>
            <p><b>Checked By: '.$_SESSION["username"].'</b>                             <b>Date/Sign: '.$std." - ".$endx.' </b></p>

            <p>
            <button id="pddf" type="sumbit" class="btn btn-primary pull-right">PDF print</button>
            <div id=""></div>
            </p>
            </form>
          </div>
        </div>
      </div>
      ';
      echo $output;
}
}
else{
  
}
?>

<script>
        $(document).ready(function () {
        $('#pddf').on("click", function () {
         
           var start = $('#start1').val();
           var end = $('#end1').val(); 
           var branch = $('#branch1').val();
          var int_id1 = $('#int_id1').val();
          swal({
              type: "success",
              title: "Staff Cabal REPORT",
              text: "From " + start1 + " to " + end1 + "Loading...",
              showConfirmButton: false,
              timer: 5000
                    
            })
         });
       });
     </script>