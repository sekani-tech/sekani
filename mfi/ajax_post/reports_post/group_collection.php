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
    $officer_name = $ti['display_name'];
    
    function fill_collect($connection){
        $sessint_id = $_SESSION['int_id'];
        $out = '';
        $query = "SELECT * FROM groups WHERE int_id ='$sessint_id'";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result)){
            $g_id = $row['id'];
            $g_name = $row['g_name'];
                $fido = '';
            $odp = "SELECT * FROM group_clients WHERE int_id = '$sessint_id' AND group_id = '$g_id'";
            $dps = mysqli_query($connection, $odp);
            while($if = mysqli_fetch_array($dps)){
                $gnmae = $if['client_name'];
                $fido .= '
                <tr>
                    <td>
                        hello '.$gnmae.'
                    </td>
                </tr>
                ';
            }
            $out .= '
            <tr>
            <th colspan="11">'.$g_name.'</th>
            </tr>
            <tr>
            <th>Client Name</th>
            <th>Client ID</th>
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
            <tr><th></th></tr>
          ';
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
                '.fill_collect($connection).'
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