<?php
include("../../functions/connect.php");
$output = '';
session_start();
$int_name = $_SESSION['int_name'];
$sint_id = $_SESSION['int_id'];
?>
<?php
if (isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["branch"]))
{
    $branch_id = $_POST['branch'];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $sdifo = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '$sint_id' AND id ='$branch_id'");
    $oi = mysqli_fetch_array($sdifo);
    $branch = $oi['name'];

    $date = date("F d, Y", strtotime($end));
    function fill_gl($connection, $sint_id, $start, $end)
                  {
                    $stateg = "SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND parent_id !=0";
                    $state1 = mysqli_query($connection, $stateg);
                    $out = '';
                    while ($row = mysqli_fetch_array($state1))
                    {
                      $gl_code = $row['gl_code'];
                      $name = $row['name'];
                        $brid = $row['branch_id'];
                        $sdsdsd = "SELECT * FROM branch WHERE id = '$brid' AND int_id = '$sint_id'";
                        $wrer = mysqli_query($connection, $sdsdsd);
                        $dc = mysqli_fetch_array($wrer);
                        $bname = $dc['name'];

                      // Opening Balance
                      $result = mysqli_query($connection, "SELECT * FROM gl_account_transaction WHERE (gl_code = '$gl_code' && int_id = '$sint_id' && branch_id = '$brid') && (transaction_date < '$start') ORDER BY transaction_date DESC");
                      $rerc = mysqli_fetch_array($result);
                      if(isset($rerc)){
                        $open_bal = $rerc['gl_account_balance_derived'];
                      }
                      else{
                        $open_bal = 0.00;
                      }
                      // total debit
                      $totald = mysqli_query($connection,"SELECT SUM(debit)  AS debit FROM gl_account_transaction WHERE  (gl_code = '$gl_code' && int_id = '$sint_id' && branch_id = '$brid') && (transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC");
                      $deb = mysqli_fetch_array($totald);
                      $tdp = $deb['debit'];
                      $totaldb = number_format($tdp, 2);

                      // total credit
                      $totalc = mysqli_query($connection, "SELECT SUM(credit)  AS credit FROM gl_account_transaction WHERE (gl_code = '$gl_code' && int_id = '$sint_id' && branch_id = '$brid') && (transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC");
                      $cred = mysqli_fetch_array($totalc);
                      $tcp = $cred['credit'];
                      $totalcd = number_format($tcp, 2);
                      // Closing Balance
                      $sdop = mysqli_query($connection, "SELECT * FROM gl_account_transaction WHERE (gl_code = '$gl_code' && int_id = '$sint_id' && branch_id = '$brid') && (transaction_date <= '$end') ORDER BY transaction_date DESC");
                      $epow = mysqli_fetch_array($sdop);
                      if(isset($epow)){
                        $closing_bal = $epow['gl_account_balance_derived'];
                      }
                      else{
                        $closing_bal = 0.00;
                      }
                    $out .= '
                    <tr>
                    <th>'.$gl_code.'</th>
                    <td>'.$name.'</td>
                    <td>'.$bname.'</td>
                    <th>'.number_format($open_bal, 2).'</th>
                    <th>'.$totaldb.'</th>
                    <th>'.$totalcd.'</th>
                    <th>'.number_format($closing_bal, 2).'</th>
                    </tr>
                  ';
                    }
                  return $out;
                  }
                  // total debit
                  $totald = mysqli_query($connection,"SELECT SUM(debit)  AS debit FROM gl_account_transaction WHERE  (int_id = '$sint_id') && (transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC");
                  $deb = mysqli_fetch_array($totald);
                  $tdp = $deb['debit'];
                  $totaldb = number_format($tdp, 2);

                  // total credit
                  $totalc = mysqli_query($connection, "SELECT SUM(credit)  AS credit FROM gl_account_transaction WHERE (int_id = '$sint_id') && (transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC");
                  $cred = mysqli_fetch_array($totalc);
                  $tcp = $cred['credit'];
                  $totalcd = number_format($tcp, 2);
                  

        $output = '<div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">'.$int_name." ".$branch.'</h4>
            <p class="card-category">Trial Balance Statement Report</p>
          </div>
          <div class="card-body">
            <!-- sup -->
            <!-- hello -->
            <form action="../composer/gl_report.php" method="POST">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="bmd-label-floating">As at:</label>
                    <input type="text" value="'.$date.'" name="" class="form-control" id="" readonly>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="bmd-label-floating">Total Debit:</label>
                    <input type="text" value="'.$totaldb.'" name="" class="form-control" id="" readonly>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="bmd-label-floating">Total Credit:</label>
                    <input type="text" value="'.$totalcd.'" name="" class="form-control" id="" readonly>
                  </div>
                </div>
                <div class="col-md-3 form-group">
                      <label for=""></label>
                      <input type="text" name="start" value="'.$start.'" id="start1" class="form-control" hidden>
                      <input type="text" name="end" value="'.$end.'" id="end1" class="form-control" hidden>
                      <input type="text" name="branch" value="'.$branch_id.'" id="branch1" class="form-control" hidden>
                  </div>
                </div>
              <div class="clearfix"></div>
            
            <div class="table-responsive">
              <table id="tabledat4" class="table" style="width: 100%;">
                <thead class="text-primary">
                <th>GL Code</th>
                  <th>Name</th>
                  <th>Office</th>
                  <th>Opening Balance</th>
                  <th>Debit</th>
                  <th>Credit</th>
                  <th>Closing Balance</th>
                </thead>
                <tbody>
                '.fill_gl($connection, $sint_id, $start, $end).'
                <tr>
              <th>Total</th>
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