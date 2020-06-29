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
      $std = $_POST["start"];
      $datex= strtotime($std); 
      $sdate = date("Y-m-d", $datex);
       $start = $sdate;
      //  echo $start;
       $endx = $_POST["end"];
       $datey= strtotime($endx); 
       $eyd= date("Y-m-d", $datey);
       $end = $eyd;
      //  echo $end;
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

      //  Always Check the vault
      if (count([$query]) == 1 && count([$branchquery]) == 1) {
        // here we will some data
        $genb1 = mysqli_query($connection, "SELECT SUM(credit) AS credit FROM institution_account_transaction WHERE (((teller_id = '$teller' OR appuser_id = '$teller') AND (int_id = '$int_id' AND branch_id = '$branch_id')) AND ( transaction_date BETWEEN '$start' AND '$end' )) ORDER BY transaction_date ASC");
        // then we will be fixing
        $genb = mysqli_query($connection, "SELECT SUM(debit) AS debit FROM institution_account_transaction WHERE (((teller_id = '$teller' OR appuser_id = '$teller') AND (int_id = '$int_id' AND branch_id = '$branch_id')) AND (transaction_date BETWEEN '$start' AND '$end' )) ORDER BY transaction_date ASC");
        $m1 = mysqli_fetch_array($genb1);
        $m = mysqli_fetch_array($genb);
        // qwerty
        $genb12 = mysqli_query($connection, "SELECT `running_balance_derived` FROM institution_account_transaction WHERE (((teller_id = '$teller' OR appuser_id = '$teller') AND (int_id = '$int_id' AND branch_id = '$branch_id')) AND (transaction_date BETWEEN '$start' AND '$end' )) ORDER BY id DESC LIMIT 1");
        $genb122 = mysqli_query($connection, "SELECT `running_balance_derived` FROM institution_account_transaction WHERE (((teller_id = '$teller' OR appuser_id = '$teller') AND (int_id = '$int_id' AND branch_id = '$branch_id')) AND (transaction_date BETWEEN '$start' AND '$end' )) ORDER BY id ASC LIMIT 1");
        $m12 = mysqli_fetch_array($genb12);
        $m122 = mysqli_fetch_array($genb122);
        $tcp = $m1["credit"];
        $tdp = $m["debit"];
        $famt =  $m12["running_balance_derived"];
        $famt2 =  $m122["running_balance_derived"];
        $finalbal = number_format(($famt), 2);
        $finalbal2 = number_format(($famt2), 2);
        $tcdp = number_format(round($tcp), 2);
        $tddp = number_format(round($tdp), 2);
        // total
        function fill_report($connection, $int_id, $start, $end, $branch_id, $teller)
        {
          // import
          $querytoget = mysqli_query($connection, "SELECT * FROM institution_account_transaction WHERE (((teller_id = '$teller' OR appuser_id = '$teller') AND (int_id = '$int_id' AND branch_id = '$branch_id')) AND (transaction_date BETWEEN '$start' AND '$end')) ORDER BY id ASC");
          // $q = mysqli_fetch_array($querytoget);
          $out = '';
          // $q = mysqli_fetch_array($querytoget);
          $client_name = "Expense";
          if (mysqli_num_rows($querytoget) > 0){
          while ($q = mysqli_fetch_array($querytoget, MYSQLI_ASSOC))
          {
            $client_id = $q["client_id"];
            if ($client_id == 0 && $q["is_vault"] == 0) {
              if ($q["transaction_type"] == "Debit" || $q["transaction_type"] == "debit" && $client_id = 0) {
              $xm = $q["teller_id"];
                $expq = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE gl_code = '$xm'");
              // }
              $cc = mysqli_fetch_array($expq);
              $client_name = $cc["name"];
              // while ($cc = mysqli_fetch_array($expq)) {
              //   
              //   }
              }
            } else if ($client_id == 0 && $q["is_vault"] == 1) {
              if ($q["transaction_type"] == "vault-in" || $q["transaction_type"] == "vault_in"  && $q["is_vault"] == 1) {
                $client_name = "VAULT IN";
              } else if ($q["transaction_type"] == "vault-out" || $q["transaction_type"] == "vault_out" && $q["is_vault"] == 1) {
                $client_name = "VAULT OUT";
              }
            } 
            else {
            $client_query = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id' && int_id = '$int_id'");
            $nx = mysqli_fetch_array($client_query);
            $client_name = $nx["firstname"]." ".$nx["middlename"]." ".$nx["lastname"];
              }
            // }
          // qwert
          $transact_id = $q["transaction_id"];
          // $transaction_type = $q["transaction_type"];
          $transaction_date = $q["transaction_date"];
          $camt = $q["credit"];
          $damt = $q["debit"];
          $balance = $q["running_balance_derived"];
         //  test
          $teller_id = $q["teller_id"];
          $teller_run_bal = $q["running_balance_derived"];
          // the next
          // if ($transaction_type == "vault_in") {
          //   $client_name = "Valut In";
          //   $amt = number_format($damt, 2);
          // }
          // if ($transaction_type == "valut_out") {
          //   $client_name = "Valut Out";
          //   $amt = number_format($camt, 2);
          // }
          $amt = $camt;
          $amt2 = $damt;
            
            $amt = number_format($amt, 2);
            
            $amt2 = number_format($amt2, 2);
          

            $out .= '
            <tr>
            <th>'.$transaction_date.'</th>
            <th>'.$client_name.'</th>
            <th>'.$amt.'</th>
            <th>'.$amt2.'</th>
            <td>'.number_format($balance, 2).'</td>
            </tr>
          ';
          }
        }
          return $out;
        }
        // NOTHIG

        $output = '<div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">'.$int_name." ".$branch.'</h4>
            <p class="card-category">Teller Call Over Report</p>
          </div>
          <div class="card-body">
            <!-- sup -->
            <!-- hello -->
            <form action="../composer/teller_call.php" method="post">
              <div class="row">
                  <div class="col-md-4 form-group">
                      <label for="">Name of Teller</label>
                      <input type="text" name="" value="'.$tell_name.'" id="" class="form-control" readonly>
                      <input type="text" name="start1" value="'.$start.'" id="start1" class="form-control" hidden>
                      <input type="text" name="end1" value="'.$end.'" id="end1" class="form-control" hidden>
                      <input type="text" name="branch1" value="'.$branch_id.'" id="branch1" class="form-control" hidden>
                      <input type="text" name="teller1" value="'.$teller.'" id="teller1" class="form-control" hidden>
                      <input type="text" name="int_id1" value="'.$int_id.'" id="int_id1" class="form-control" hidden>
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
            
            <div class="table-responsive">
              <table id="tabledat4" class="table" style="width: 100%;">
                <thead class=" text-primary">
                <th>Date/Time</th>
                  <th>Account Name</th>
                  <th>Deposit</th>
                  <th>
                    Withdrawal
                  </th>
                  <th>Balance</th>
                </thead>
                <tbody>
                "'.fill_report($connection, $int_id, $start, $end, $branch_id, $teller).'"
                <tr>
              <th>Total</th>
              <th></th>
               <th>'.$tcdp.'</th>
               <th>'.$tddp.'</th>
            <th>'.$finalbal.'</th>
              </tr>
                </tbody>
              </table>
            </div>
            <p><b>Opening Balance:</b> '.$finalbal2.' </p>
            <p><b>Total Deposit:</b> '.$tcdp.' </p>
            <p><b>Total Withdrawal:</b> '.$tddp.' </p>
            <p><b>Closing Balance:</b> '.$finalbal.' </p>
            <hr>
            <p><b>Teller Sign:</b> 129                        <b>Date:</b></p>
            <p><b>Checked By: '.$_SESSION["username"].'</b>                             <b>Date/Sign: '.$start." - ".$end.' </b></p>

            <p>
            <button id="pddf" type="sumbit" class="btn btn-primary pull-right">PDF print</button>
            <div id=""></div>
            </p>
            </form>
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