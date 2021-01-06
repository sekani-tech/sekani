<?php
include("../../functions/connect.php");
$output = '';
session_start();
$int_name = $_SESSION['int_name'];
$sint_id = $_SESSION['int_id'];
// Fecth Institution Location
$find = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id = '$sint_id'");
$instituiton = mysqli_fetch_array($find);
$location = $instituiton['office_address'];
?>
<?php
if (isset($_POST["start"])  && isset($_POST["end"])  && isset($_POST["branch"])) {
  $branch_id = $_POST['branch'];
  $start = $_POST["start"];
  $end = $_POST["end"];
  $sdifo = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '$sint_id' AND id ='$branch_id'");
  $oi = mysqli_fetch_array($sdifo);
  $branch = $oi['name'];

  $date = date("F d, Y", strtotime($end));



?>

  <div class="row">
    <div class="col-md-12">
      <div class="card card-profile ml-auto mr-auto" style="max-width: 560px; max-height: 360px">
        <div class="card-body ">
          <h4 class="card-title"></h4>
          <h3 class="card-category text-black"><?php echo $int_name ?> </b> </h3>
        </div>
        <div class="card-footer justify-content-center">
          <?php echo $branch ?>
        </div>
        <div class="card-footer justify-content-center">
          <b> <?php echo $location ?> </b>
        </div>
        <div class="card-footer justify-content-center">
          From: <?php echo $start ?> || To: <?php echo $end ?>
        </div>
      </div>
    </div>
  </div>
  <form action="../composer/gl_report.php" method="post">
    <div class="row">
      <div class="col-md-12">
        <table class="display" style="width:100%">
          <thead>
            <tr>
              <th style="width:50px;">
                <small>Account Number</small>
              </th>
              <th>
                <small>Account Title</small>
              </th>
              <th>
                <small>Section</small>
              </th>
              <th>
                <small>Opening Balance(₦)</small>
              </th>
              <th>
                <small>Credit Movement(₦)</small>
              </th>
              <th>
                <small>Debit Movement(₦)</small>
              </th>
              <th>
                <small>Current Balance(₦)</small>
              </th>
            </tr>
          </thead>
          <?php
          $total;
          $query = "SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND parent_id = 0";
          $result = mysqli_query($connection, $query);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
              $gl_account = $row['id'];

              $query2 = "SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND parent_id = '$gl_account'";
              // var_dump($result);
              // dd($query2);

              $result2 = mysqli_query($connection, $query2);

              if (mysqli_num_rows($result2) > 0) {
                while ($rows = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                  $gl_code = $rows['gl_code'];


          ?>
                  <tbody>
                    <?php

                    $query3 = "SELECT acc_gl_account.name, gl_account_transaction.gl_code, SUM(gl_account_transaction.gl_account_balance_derived), SUM(gl_account_transaction.credit), SUM(gl_account_transaction.debit) FROM gl_account_transaction JOIN acc_gl_account ON gl_account_transaction.int_id = '$sint_id' AND gl_account_transaction.gl_code = '$gl_code' AND (gl_account_transaction.transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC";
                    $result3 = mysqli_query($connection, $query3);
                    // var_dump($query3);
                    if (mysqli_num_rows($result3) > 0) {
                      while ($rowt = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
                        // Opening Balance
                        $result = mysqli_query($connection, "SELECT * FROM gl_account_transaction WHERE (gl_code = '$gl_code'  AND int_id = '$sint_id') AND (transaction_date < '$start') ORDER BY transaction_date DESC");
                        $rerc = mysqli_fetch_array($result);
                        if (isset($rerc)) {
                          $open_bal = $rerc['gl_account_balance_derived'];
                        } else {
                          $open_bal = 0.00;
                        }
                        // total debit
                        $totald = mysqli_query($connection, "SELECT SUM(debit)  AS debit FROM gl_account_transaction WHERE  (gl_code = '$gl_code'  AND int_id = '$sint_id'  )  AND (transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC");
                        $deb = mysqli_fetch_array($totald);
                        $tdp = $deb['debit'];
                        $totaldb = number_format($tdp, 2);

                        // total credit
                        $totalc = mysqli_query($connection, "SELECT SUM(credit)  AS credit FROM gl_account_transaction WHERE (gl_code = '$gl_code'  AND int_id = '$sint_id'  )  AND (transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC");
                        $cred = mysqli_fetch_array($totalc);
                        $tcp = $cred['credit'];
                        $totalcd = number_format($tcp, 2);
                        // Closing Balance
                        $sdop = mysqli_query($connection, "SELECT * FROM gl_account_transaction WHERE (gl_code = '$gl_code'  AND int_id = '$sint_id'  )  AND (transaction_date <= '$end') ORDER BY transaction_date DESC");
                        $epow = mysqli_fetch_array($sdop);
                        if (isset($epow)) {
                          $closing_bal = $epow['gl_account_balance_derived'];
                        } else {
                          $closing_bal = 0.00;
                        }

                    ?>
                        <tr>
                          <td><?php echo $rowt['gl_code'] ?></td>
                          <td><?php echo $rows['name'] ?></td>
                          <td><?php echo $row['name'] ?></td>
                          <td><?php echo $rowt['gl_account_transaction.gl_account_balance_derived'] ?></td>
                          <td><?php echo $rowt['gl_account_transaction.credit'] ?></td>
                          <td><?php echo $rowt['gl_account_transaction.debit'] ?></td>
                          <td><?php echo $rowt['gl_account_transaction.gl_account_balance_derived'] ?></td>
                        </tr>
                        
                    <?php
                      }
                    }
                    ?>
                    <tr>
                          <td></td>
                          <td></td>
                          <td><b><?php echo $row['name'] ?></b></td>
                          <td></td>
                          <td></td>
                          <td><b>Group Total</b></td>
                          <td><?php
                              // $rowgl = $rowt['gl_code'];
                              // $sumquery = "SELECT gl_account_balance_derived FROM gl_account_transaction WHERE int_id = '$sint_id' AND gl_code = '$gl_code'";
                              // $sumresult = mysqli_query($connection, $sumquery);
                              // var_dump($sumresult);
                              // // $current;
                              // if (mysqli_num_rows($sumresult) > 0) {
                              //     while ($sums = mysqli_fetch_array($sumresult, MYSQLI_ASSOC)) {
                              //         $current[] = $sums['gl_account_balance_derived'];
                              //         var_dump($current);
                              //         $total = array_sum($current);
                              //         echo number_format($total, 2);
                              //     }
                              // }
                              // $total = array_sum($current);
                              // echo number_format($current, 2);
                              ?></td>
                        </tr>


                  </tbody>
          <?php
                }
              }
            }
          }
          ?>
          <tfoot>
            <tr>
              <th style="width:50px;">
                <small>Account Number</small>
              </th>
              <th>
                <small>Account Title</small>
              </th>
              <th>
                <small>Section</small>
              </th>
              <th>
                <small>Opening Balance(₦)</small>
              </th>
              <th>
                <small>Credit Movement(₦)</small>
              </th>
              <th>
                <small>Debit Movement(₦)</small>
              </th>
              <th>
                <small>Current Balance(₦)</small>
              </th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label class="bmd-label-floating">As at:</label>
          <input type="text" value="<?php echo $date ?>" name="" class="form-control" id="" readonly>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label class="bmd-label-floating">Total Debit:</label>
          <input type="text" value="<?php echo $totaldb ?>" name="" class="form-control" id="" readonly>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="bmd-label-floating">Total Credit:</label>
          <input type="text" value="<?php echo $totalcd ?>" name="" class="form-control" id="" readonly>
        </div>
      </div>
    </div>
    <p><b>Checked By: <?php echo $_SESSION["username"] ?> '</b> <b>Date/Sign: <?php echo $start . " - " . $end ?> </b></p>

    <p>

      <button id="pddf" type="sumbit" class="btn btn-primary pull-right">Download PDF</button>
      <div id=""></div>
    </p>
  </form>


<?php

}
?>

<script>
  $(document).ready(function() {
    $('#pddf').on("click", function() {

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