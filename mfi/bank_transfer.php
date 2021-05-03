<?php

$page_title = "Cash Transaction";
$destination = "transaction.php";
include("header.php");
$message = $_SESSION['feedback'];
?>
<input type="text" value="<?php echo $message?>" id="feedback" hidden>
<?php
// If it is successfull, It will show this message
if (isset($_GET["message0"])) {
  $key = $_GET["message0"];
  $tt = 0;

  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
      let feedback =  document.getElementById("feedback").value;
        swal({
            type: "success",
            title: "Success",
            text: feedback,
            showConfirmButton: True,
            timer: 7000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
} else if (isset($_GET["message1"])) {
  $key = $_GET["message1"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error",
            text: "Not enough Money in this Account",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
} else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Transfer Successful, Awaiting Approval",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
// right now we will program
// first step - check if this person is authorized
// if ($valut == 1 || $valut == "1") {
?>
<?php
// output the branch name
$bch_name =  mysqli_query($connection, "SELECT * FROM branch WHERE id = '$bch_id' && int_id = '$sessint_id'");
$grn = mysqli_fetch_array($bch_name);
$get_b_r_n = $grn['id'];
$bname = $grn['name'];
// For the Transaction ID auto generated
$digits = 11;
$transaction_id = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

// Loop to pull all client
function fill_client($connection)
{
  $sint_id = $_SESSION["int_id"];
  $org = "SELECT * FROM client WHERE int_id = '$sint_id' AND status = 'Approved' ORDER BY firstname ASC";
  $res = mysqli_query($connection, $org);
  $out = '';
  while ($row = mysqli_fetch_array($res)) {
    $out .= '<option value="' . $row["id"] . '">' . strtoupper($row["firstname"]) . " " . strtoupper($row["middlename"]) . " " . strtoupper($row["lastname"]) . '</option>';
  }
  return $out;
}
?>
<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Funds Transfer</h4>
            <!-- <p class="card-category">Fill in all important data</p> -->
          </div>
          <div class="card-body">
            <form action="../functions/trans_cache.php" method="POST">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Branch Name</label>
                    <!-- populate available balance -->
                    <input type="text" value="<?php echo $bname; ?>" name="brfanch" id="branch_id" class="form-control" readonly>
                    <input type="text" value="<?php echo $get_b_r_n; ?>" name="branch" hidden id="branch_id" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <script>
                    $(document).ready(function() {
                      $('#act').on("change keyup paste", function() {
                        var id = $(this).val();
                        var ist = $('#int_id').val();
                        $.ajax({
                          url: "acct_name.php",
                          method: "POST",
                          data: {
                            id: id,
                            ist: ist
                          },
                          success: function(data) {
                            $('#accname').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <div class="form-group">
                    <label class="bmd-label-floating">Account Number(From)</label>
                    <input type="text" class="form-control" name="account_noFrom" id="act">
                    <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                  </div>
                  <div id="accname"></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Amount</label>
                    <input type="text" name="amount" id="amount" class="form-control">
                  </div>
                  <script>
                    $(document).ready(function() {
                      $('#amount').on("change blur", function() {
                        var amount = $(this).val();
                        $.ajax({
                          url: "ajax_post/function/converter.php",
                          method: "POST",
                          data: {
                            amount: amount
                          },
                          success: function(data) {
                            $('#amount').val(data);
                          }
                        })
                      });
                    });
                  </script>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Transaction id</label>
                    <!-- populate available balance -->
                    <input type="text" value="TRSF<?php echo $transaction_id; ?>" name="transact_id" id="" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <script>
                    $(document).ready(function() {
                      $('#act2').on("change keyup paste", function() {
                        var id = $(this).val();
                        var ist = $('#int_id').val();
                        $.ajax({
                          url: "acct_name.php",
                          method: "POST",
                          data: {
                            id: id,
                            ist: ist
                          },
                          success: function(data) {
                            $('#accnameto').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <div class="form-group">
                    <label class="bmd-label-floating">Account Number(To)</label>
                    <input type="text" class="form-control" name="account_noTo" id="act2">
                    <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                  </div>
                  <div id="accnameto"></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Transaction Date</label>
                    <input type="date" name="transDate" min="<?php echo $minDate; ?>" max="<?php echo $today; ?>" class="form-control" required />
                  </div>
                </div>
              </div>
              <button type="reset" class="btn btn-danger pull-left">Reset</button>
              <button type="submit" class="btn btn-primary pull-right">submit</button>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /content -->
  </div>
</div>
<?php
include("footer.php");
?>
<?php
// } else {
//   echo '<script type="text/javascript">
//   $(document).ready(function(){
//    swal({
//     type: "error",
//     title: "Vault Authorization",
//     text: "You Dont Have permission to Make Transaction From Vault",
//    showConfirmButton: false,
//     timer: 2000
//     }).then(
//     function (result) {
//       history.go(-1);
//     }
//     )
//     });
//    </script>
//   ';
//   // $URL="transact.php";
//   // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
// }

?>