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
        $ro = 1;
if($ro == 1 || $ro == '1'){
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
          $querytoget = mysqli_query($connection, "SELECT * FROM inventory WHERE branch_id = '$branch_id' AND int_id ='$int_id' AND date BETWEEN '$start' AND '$end'");
          while ($q = mysqli_fetch_array($querytoget))
          {
            $date = $q["date"];
            $sn = $q["serial_no"];
            $item = $q['item'];
            $quantity = $q['quantity'];
            $unit_price = $q['unit_price'];
            $total = $q['total_price'];

            $out .= '
            <tr>
            <th>'.$date.'</th>
            <th>'.$sn.'</th>
            <th>'.$item.'</th>
            <th>'.$quantity.'</th>
            <th>'.$unit_price.'</th>
            <th>'.$total.'</th>
            </tr>
          ';
        }
          return $out;
        }
        $output = '<div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">'.$int_name." ".$branch.'</h4>
            <p class="card-category">Inventory Schedule Report</p>
          </div>
          <div class="card-body">
            <!-- sup -->
            <!-- hello -->
            <form action="../composer/inventory_schedule.php" method="POST">
              <div class="row">
                  <div class="col-md-4 form-group">
                      <label for="">Branch</label>
                      <input type="text" name="start" value="'.$start.'" id="start1" class="form-control" hidden>
                      <input type="text" name="end" value="'.$end.'" id="end1" class="form-control" hidden>
                      <input type="text" name="branch" value="'.$branch_id.'" id="branch1" class="form-control" hidden>
                      <input type="text" name="int_id" value="'.$int_id.'" id="int_id1" class="form-control" hidden>
                      <input type="text" name="" value="'.$branch.'" id="" class="form-control" readonly>
                      <button id="pddf" type="sumbit" class="btn btn-primary pull-left">Download PDF</button>
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
                  <th>Date</th>
                  <th>Serial no</th>
                  <th>Item</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                '.fill_stafff($connection, $int_id, $std, $endx, $branch_id).'
                </tbody>
              </table>
            </div>
            <hr>
            <p>
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
              title: "INVENTORY SCHEDULE REPORT",
              text: "From " + start1 + " to " + end1 + "Loading...",
              showConfirmButton: false,
              timer: 3000
                    
            })
         });
       });
     </script>