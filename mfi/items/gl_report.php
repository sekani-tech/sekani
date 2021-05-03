<?php
include("../../functions/connect.php");
$output = '';
session_start();
?>
<?php
if (isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["branch"]))
{
    $int_id = $_SESSION["int_id"];
    if($_POST["start"] != '' )
    {
        $glcode = $_POST["glcode"];
      $std = $_POST["start"];
      $datex= strtotime('-1 day', $std); 
      $sdate = date("Y-m-d", $datex);
       $start = $sdate;
      //  echo $start;
       $endx = $_POST["end"];
       $datey= strtotime($endx); 
       $eyd= date("Y-m-d", strtotime('+1 day', $datey));
       $end = $eyd;
      //  echo $end;
       $branch = $_POST["branch"];
       $int_name = $_SESSION["int_name"];
   
    $branch_id = $_POST["branch"];
    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
    }

      //  Always Check the vault
      if (count([$branchquery]) == 1) {
        // here we will some data
        $genb1 = mysqli_query($connection, "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE gl_code = '$glcode' AND int_id ='$int_id' AND transaction_date BETWEEN '$std' AND '$endx'  ORDER BY transaction_date ASC");
        // then we will be fixing
        $genb = mysqli_query($connection, "SELECT SUM(debit) AS debit FROM gl_account_transaction WHERE gl_code = '$glcode' AND int_id ='$int_id' AND transaction_date BETWEEN '$std' AND '$endx' ORDER BY transaction_date ASC");
        $m1 = mysqli_fetch_array($genb1);
        $m = mysqli_fetch_array($genb);
        // qwerty
        $tcp = $m1["credit"];
        $tdp = $m["debit"];

        $quetoget = mysqli_query($connection, "SELECT * FROM gl_account_transaction WHERE gl_code = '$glcode' AND int_id ='$int_id' AND transaction_date BETWEEN '$std' AND '$endx' ORDER BY transaction_date DESC");
          $r = mysqli_fetch_array($quetoget);
          $fom = $r['gl_account_balance_derived'];

          $fdfgfg = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$glcode' AND int_id ='$int_id'");
          $ff = mysqli_fetch_array($fdfgfg);
          $gl_account = $ff['organization_running_balance_derived'];
        // summing
        function fill_report($connection, $int_id, $std, $glcode, $endx, $branch_id)
        {
            $out = '';
          // import
        //   $glcode = $_POST['glcode'];
          $querytoget = mysqli_query($connection, "SELECT * FROM gl_account_transaction WHERE gl_code = '$glcode' AND int_id ='$int_id' AND transaction_date BETWEEN '$std' AND '$endx' ORDER BY transaction_date, id ASC");
          while ($q = mysqli_fetch_array($querytoget, MYSQLI_ASSOC))
          {

          $transaction_date = $q["transaction_date"];
          $camt = $q["credit"];
          $damt = $q["debit"];
          $balance = $q["gl_account_balance_derived"];
          $description = $q['description'];
          $amt = $camt;
          $amt2 = $damt;
            
            $amt = number_format($amt, 2);
            
            $amt2 = number_format($amt2, 2);
          

            $out .= '
            <tr>
            <th>'.$transaction_date.'</th>
            <th>'.$description.'</th>
            <th>'.$amt.'</th>
            <th>'.$amt2.'</th>
            <td>'.number_format($balance, 2).'</td>
            </tr>
          ';
          }
        // }
          return $out;
        }
        // NOTHIG

        $output = '<div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">'.$int_name." ".$branch.'</h4>
            <p class="card-category">General Ledger Statement Report</p>
          </div>
          <div class="card-body">
            <!-- sup -->
            <!-- hello -->
            <form action="../composer/gl_report.php" method="POST">
              <div class="row">
                  <div class="col-md-4 form-group">
                      <label for="">GL Code:</label>
                      <input type="text" name="" value="'.$glcode.'" id="start1" readonly class="form-control">
                  </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">As at:</label>
                    <input type="text" value="'.$endx.'" name="" class="form-control" id="" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Current Balance:</label>
                    <input type="text" value="'.number_format($balance).'" name="" class="form-control" id="" readonly>
                  </div>
                </div>
                <div class="col-md-4 form-group">
                      <label for=""></label>
                      <input type="text" name="start" value="'.$start.'" id="start1" class="form-control" hidden>
                      <input type="text" name="end" value="'.$end.'" id="end1" class="form-control" hidden>
                      <input type="text" name="branch" value="'.$branch_id.'" id="branch1" class="form-control" hidden>
                      <input type="text" name="int_id1" value="'.$int_id.'" id="int_id1" class="form-control" hidden>
                      <input type="text" name="gl_acc" value="'.$glcode.'" id="" class="form-control" hidden readonly>
                  </div>
                </div>
              <div class="clearfix"></div>
            
            <div class="table-responsive">
              <table id="tabledat4" class="table" style="width: 100%;">
                <thead class="text-primary">
                <th>Date/Time</th>
                  <th>Description</th>
                  <th>Deposit</th>
                  <th>
                    Withdrawal
                  </th>
                  <th>Balance</th>
                </thead>
                <tbody>
                '.fill_report($connection, $int_id, $std, $glcode, $endx, $branch_id).'
                <tr>
              <th>Total</th>
              <th></th>
              <th>'.number_format($tcp, 2).'</th>
               <th>'.number_format($tdp, 2).'</th>
               <th>'.number_format($tcp - $tdp, 2).'</th>
            <th></th>
              </tr>
                </tbody>
              </table>
            </div>
            <p><b>Checked By: '.$_SESSION["username"].'</b>                             <b>Date/Sign: '.$std." - ".$endx.' </b></p>

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
      } else {
        echo 'Not Seeing Data';
      }
    }
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