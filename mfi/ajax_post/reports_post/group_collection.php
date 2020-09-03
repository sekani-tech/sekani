<?php
include('../../../functions/connect.php');
session_start();

$sessint_id = $_SESSION['int_id'];
$int_name = $_SESSION['int_name'];
$user_id = $_SESSION["user_id"];
if (isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["branch"]))
{
    $start = $_POST["start"];
    $int_id = $_SESSION["int_id"];
    $end = $_POST["end"];
    $branch_id = $_POST["branch"];
    $officer = $_POST["officer"];
    $odsp = "SELECT * FROM branch WHERE int_id = '$int_id' AND id ='$branch_id'";
    $io = mysqli_query($connection, $odsp);
    $i = mysqli_fetch_array($io);
    $branch = $i['name'];

    $spdop = "SELECT * FROM staff WHERE int_id = '$int_id' AND id ='$officer' AND employee_status = 'Employed'";
    $dso = mysqli_query($connection, $spdop);
    $ti = mysqli_fetch_array($dso);
    if(isset($ti)){
      $officer_name = $ti['display_name'];
    }
    else{
      $officer_name = "All";
    }
    $query = "SELECT * FROM groups WHERE int_id ='$sessint_id'";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result)){
          $fi = "";
            $g_id = $row['id'];
            $g_name = $row['g_name'];
            $fi = '
            <tr>
            <td>'.$g_name.'</td>
            </tr>
            ';
          }

    function fill_collect($connection, $officer){
        $sessint_id = $_SESSION['int_id'];
        $out = '';
        if($officer == 'all'){
          $query = "SELECT * FROM groups WHERE int_id ='$sessint_id'";
        }
        else{
          $query = "SELECT * FROM groups WHERE int_id ='$sessint_id' AND loan_officer = '$officer'";
        }
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result)){
            $g_id = $row['id'];
            $g_name = $row['g_name'];
            $dod = "SELECT * FROM group_clients WHERE group_id = '$g_id'";
            $fdi = mysqli_query($connection, $dod);
            while($fo = mysqli_fetch_array($fdi)){
              $name = "";
              $c_name = $fo["client_name"];
              $c_id = $fo["client_id"];
              $mobile = $fo["mobile_no"];
              $prod = $fo["product_name"];
              $account = $fo["account_no"];

              $sdl = "SELECT * FROM account WHERE client_id = '$c_id'";
              $soiw = mysqli_query($connection, $sdl);
              $ow = mysqli_fetch_array($soiw);
              $balance = $ow['account_balance_derived'];

              $worp = "SELECT * FROM loan WHERE client_id = '$c_id'";
              $dfoi = mysqli_query($connection, $worp);
              $ds = mysqli_fetch_array($dfoi);
              $repayment = $ds['repayment_date'];
              $matured = $ds['maturedon_date'];

              $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND client_id = '$c_id' AND int_id = '$sessint_id'";
              $sdoi = mysqli_query($connection, $dd);
              $e = mysqli_fetch_array($sdoi);
              $interest = $e['interest_amount'];

              $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND client_id = '$c_id' AND int_id = '$sessint_id'";
              $sdswe = mysqli_query($connection, $dfdf);
              $u = mysqli_fetch_array($sdswe);
              $prin = $u['principal_amount'];

              $outstanding = $prin + $interest;

              // Arrears
              $ldfkl = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND client_id = '$c_id' AND int_id = '$sessint_id'";
              $fosdi = mysqli_query($connection, $ldfkl);
              $l = mysqli_fetch_array($fosdi);
              $interesttwo = $l['interest_amount'];

              $sdospd = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE installment >= '1' AND client_id = '$c_id' AND int_id = '$sessint_id'";
              $sodi = mysqli_query($connection, $sdospd);
              $s = mysqli_fetch_array($sodi);
              $printwo = $s['principal_amount'];

              $outstandingtwo = $printwo + $interesttwo;
              $ttout = $outstanding + $outstandingtwo;

              $out .='
              <tr>
                <td>'.$c_name.'</td>
                <td>'.$c_id.'</td>
                <td>'.$g_name.'</td>
                <td>'.$mobile.'</td>
                <td>'.$prod.'</td>
                <td>'.$account.'</td>
                <td>'.number_format($ttout, 2).'</td>
                <td>'.number_format($outstanding, 2).'</td>
                <td>'.$repayment.'</td>
                <td>'.$matured.'</td>
                <td>'.number_format($outstanding, 2).'</td>
                <td>'.number_format($balance, 2).'</td>
              </tr>
              ';
            
        }
      }
         
    return $out;
}
    $output = '<div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title">'.$int_name." ".$branch.'</h4>
        <p class="card-category">Group Collection</p>
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
                  <input type="text" name="officer" value="'.$officer.'" id="" class="form-control" readonly hidden>
              </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="bmd-label-floating">As at:</label>
                <input type="date" value="'.$end.'" name="" class="form-control" id="" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="bmd-label-floating">Account Officer:</label>
                <input type="text" name="usu" value="'.$officer_name.'" id="" class="form-control" readonly>
              </div>
            </div>
            </div>
          <div class="clearfix"></div>
        
        <div class="table-responsive">
          <table id="tabledat4" class="table table-bordered" style="width: 100%;">
            <tbody>
            <tr>
            <th>Client Name</th>
            <th>Client ID</th>
            <th>Group</th>
            <th>Phone Number</th>
            <th>Product</th>
            <th>Account Number</th>
            <th>Outstanding</th>
            <th>Total Due</th>
            <th>Expected Repayment</th>
            <th>Maturity Date</th>
            <th>Expected Repayment Amount</th>
            <th>Total Savings Balance</th>
            </tr>
                '.fill_collect($connection, $officer).'
            </tbody>
          </table>
        </div>
        
        <hr>
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
?>