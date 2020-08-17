<?php
include("../../functions/connect.php");
$output = '';
session_start();
?>
<?php
if (isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["branch"]))
{
    $int_id = $_SESSION["int_id"];
    $branch_id = $_POST["branch"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $ass_type = $_POST["asstype"];

    $dd = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id = '$int_id'");
    $fid = mysqli_fetch_array($dd);
    $int_name = $fid['int_name'];

    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
    }

        // summing
        function fill_report($connection, $int_id, $start, $end, $ass_type)
        {
            $out = '';
          // import
          $as = $ass_type;
          if($as == '0'){
            $querytoget = mysqli_query($connection, "SELECT * FROM assets WHERE int_id ='$int_id' AND date BETWEEN '$start' AND '$end' ORDER BY date, id ASC");
          }
          else{
            $querytoget = mysqli_query($connection, "SELECT * FROM assets WHERE int_id ='$int_id' AND asset_type_id = '$ass_type' AND date BETWEEN '$start' AND '$end' ORDER BY date, id ASC");
          }
          while ($q = mysqli_fetch_array($querytoget, MYSQLI_ASSOC))
          {
            $name = $q['asset_name'];
            $type = $q['type'];
            $qty = $q['qty'];
            $unit = $q['unit_price'];
            $amount = $q['amount'];
            $asset = $q['asset_no'];
            $location = $q['location'];
            $branch_id = $q['branch_id'];
            $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
            if (count([$branchquery]) == 1) {
              $ans = mysqli_fetch_array($branchquery);
              $branch = $ans['name'];
            }
            $out .= '
            <tr>
            <td>'.$name.'</td>
            <td>'.$type.'</td>
            <td>'.$qty.'</td>
            <td>'.$unit.'</td>
            <td>'.$amount.'</td>
            <td>'.$asset.'</td>
            <td>'.$location.'</td>
            <td>'.$branch.'</td>
            <td>0.00</td>
            <td>0.00</td>
            <td>0.00</td>
            <td>0.00</td>
            </tr>
          ';
          }
        // }
          return $out;
        }
        // for total qty
        if($ass_type == '0'){
            $ss = mysqli_query($connection, "SELECT SUM(qty) AS qty FROM assets WHERE int_id = '$int_id' AND date BETWEEN '$start' AND '$end'");
        }else{
            $ss = mysqli_query($connection, "SELECT SUM(qty) AS qty FROM assets WHERE int_id = '$int_id' AND type = '$ass_type' AND date BETWEEN '$start' AND '$end'");
        }
        $o = mysqli_fetch_array($ss);
        $ttlqty = $o['qty'];

        // for total unit_price
        if($ass_type == '0'){
            $sds = mysqli_query($connection, "SELECT SUM(unit_price) AS unit_price FROM assets WHERE int_id = '$int_id' AND date BETWEEN '$start' AND '$end'");
        }else{
            $sds = mysqli_query($connection, "SELECT SUM(unit_price) AS unit_price FROM assets WHERE int_id = '$int_id' AND type = '$ass_type'  AND date BETWEEN '$start' AND '$end'");
        }
        $w = mysqli_fetch_array($sds);
        $ttlunit = $w['unit_price'];

        // for total amount
        if($ass_type == '0'){
            $xco = mysqli_query($connection, "SELECT SUM(amount) AS amount FROM assets WHERE int_id = '$int_id' AND date BETWEEN '$start' AND '$end'");
        }else{
            $xco = mysqli_query($connection, "SELECT SUM(amount) AS amount FROM assets WHERE int_id = '$int_id' AND type = '$ass_type' AND date BETWEEN '$start' AND '$end'");
        }
        $d = mysqli_fetch_array($xco);
        $ttlamount = $d['amount'];

        $output = '<div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">'.$int_name." ".$branch.'</h4>
            <p class="card-category">Assets Report</p>
          </div>
          <div class="card-body">
            <!-- sup -->
            <!-- hello -->
            <form action="../composer/assets.php" method="POST">
              <div class="row">
                <div class="col-md-4 form-group">
                      <label for=""></label>
                      <input type="text" name="start" value="'.$start.'" id="start1" class="form-control" hidden>
                      <input type="text" name="end" value="'.$end.'" id="end1" class="form-control" hidden>
                      <input type="text" name="branch" value="'.$branch_id.'" id="branch1" class="form-control" hidden>
                      <input type="text" name="int_id1" value="'.$int_id.'" id="int_id1" class="form-control" hidden>
                      <input type="text" name="gl_acc" value="'.$ass_type.'" id="" class="form-control" hidden readonly>
                  </div>
                </div>
              <div class="clearfix"></div>
            
            <div class="table-responsive">
              <table id="tabledat4" class="table" style="width: 100%;">
                <thead class="text-primary">
                <tr>
                  <th colspan="8">General Asset Details</th>
                  <th colspan="4">Current Year Depreciation</th>
                  </tr>
                <tr>
                  <th>Asset Name</th>
                  <th>Asset Type</th>
                  <th>Qty</th>
                  <th>Unit Price</th>
                  <th>Amount</th>
                  <th>Asset No</th>
                  <th>Location</th>
                  <th>Branch</th>
                  <th>Purchase Date</th>
                  <th>Current Year(2020)</th>
                  <th>Previous Year(2019)</th>
                  <th>Net Present Value</th>
                </tr>
                </thead>
                <tbody>
                '.fill_report($connection, $int_id, $start, $end, $ass_type).'
                <tr>
              <th>Total</th>
              <th></th>
               <th>'.$ttlqty.'</th>
               <th>'.number_format($ttlunit, 2).'</th>
               <th>'.number_format($ttlamount, 2).'</th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
              </tr>
                </tbody>
              </table>
            </div>
            <p><b>Checked By: '.$_SESSION["username"].'</b>                             <b>Date/Sign: '.$start." - ".$end.' </b></p>

            <p>
            <button id="pddf" type="sumbit" class="btn btn-primary pull-right">Download PDF</button>
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

<script>
        $(document).ready(function () {
        $('#pddf').on("click", function () {
         
           var start1 = $('#start1').val();
           var end1 = $('#end1').val();
           var branch1 = $('#branch1').val();
           var teller1 = $('#teller1').val();
          var int_id1 = $('#int_id1').val();
          swal({
              type: "success",
              title: "TELLER REPORT",
              text: "From " + start1 + " to " + end1 + "Loading...",
              showConfirmButton: false,
              timer: 5000
                    
            })
         });
       });
     </script>