<?php

$page_title = "Deposit/ Withdrwal";
$destination = "index.php";
include("header.php");
?>
<?php
$exp_error = "";
if (isset($_GET["message"])) {
    $key = $_GET["message"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Transaction Successful",
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
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error",
            text: "Transaction Error",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
} else if (isset($_GET["messagep"])) {
  $key = $_GET["messagep"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Deposit",
          text: "Transaction Successful, Awaiting Approval",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["messagex2"])) {
  $key = $_GET["messagex2"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "NOT AUTHURIZED",
          text: "This is a Tellers Job",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["message3"])) {
    $key = $_GET["message3"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Withdrawal",
            text: "Transaction Successful, Awaiting Approval",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
} else if (isset($_GET["message4"])) {
    $key = $_GET["message4"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Withdrawal Error",
            text: "Transaction Error",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
 }
} else if (isset($_GET["message5"])) {
    $key = $_GET["message5"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Fund Error",
            text: "Insufficient Fund in the Till",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
 }
} else if (isset($_GET["message7"])) {
    $key = $_GET["message7"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Account Number Error",
            text: "Account Not Found",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["messagex5"])) {
  $key = $_GET["messagex5"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Insufficient Fund",
          text: "Client Has Insufficient Fund",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["message8"])) {
  $key = $_GET["message8"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Pick",
          text: "Select Transaction Type",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["loan1"])) {
  $key = $_GET["loan1"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "EXPENSE POSTING",
          text: "Expense Posting Successful",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["loan2"])) {
  $key = $_GET["loan2"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "EXPENSE POSTING",
          text: "Expense Posting Successful, Awaiting Approval",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["loan2c"])) {
  $key = $_GET["loan2c"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Expense Not Found",
          text: "(^_^) Dont Post Like That, Else i will Notify Someone.",
          showConfirmButton: false,
          timer: 5000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["loan3"])) {
  $key = $_GET["loan3"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Loan",
          text: "Amount Less Than Expected Amount",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["loan4"])) {
  $key = $_GET["loan4"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Your Have an Error",
          showConfirmButton: false,
          timer: 3000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["legal"])) {
  $key = $_GET["legal"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "System Error",
          text: "Call Us",
          showConfirmButton: false,
          timer: 3000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["legalq"])) {
  $key = $_GET["legalq"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Transaction Has Been Posted",
          text: "You Have Made This Transaction Before",
          showConfirmButton: false,
          timer: 3000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["message0"])) {
  $key = $_GET["message0"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Transaction Successful, Email not sent",
          showConfirmButton: false,
          timer: 3000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else {
    echo "";
}
?>
<?php

if ($trans_post == 1 || $trans_post == "1") {
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$randms1= str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$transid = $randms;
$transid1 = $randms1;
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title">Deposit/Withdrawal</h4>
                        <!-- <p class="card-category">Fill in all important data</p> -->
                      </div>
                      <div class="card-body">
                      <form action="../functions/withdep.php" method="post">
    <div class="row">
        <div class="col-md-4">
            <script>
                $(document).ready(function() {
                  $('#act').on("change keyup paste click", function(){
                    var id = $(this).val();
                    var ist = $('#int_id').val();
                    $.ajax({
                      url:"acct_name.php",
                      method:"POST",
                      data:{id:id, ist: ist},
                      success:function(data){
                        $('#accname').html(data);
                      }
                    })
                  });
                });
              </script>
            <div class="form-group">
                <label for="">Type</label>
                <select class="form-control" name="test">
                    <option> </option>
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                 </select>
            </div>
            <div id="acct_name"></div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
               <label class="bmd-label-floating">Account Number</label>
               <input type="text" class="form-control" name="account_no" id="act">
               <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id;?>" id="int_id">
            </div>
            <div id="accname"></div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
               <label class="bmd-label-floating">Amount</label>
               <input type="number" class="form-control" name="amount" value="">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
            <script>
                $(document).ready(function() {
                  $('#opo').change(function(){
                    var id = $(this).val();
                    if (id == "Cheque") {
                      document.getElementById('ti').readOnly = false;
                      $("#ti").val("");
                    } else {
                      document.getElementById('ti').readOnly = true;
                      $("#ti").val(Math.floor(100000 + Math.random() * 900000));
                    }
                  });
                });
              </script>
              <label>Transaction Method</label>
               <select class="form-control" name="pay_type" id="opo">
                  <option value="Cash">Cash</option>
                  <option value="Bank">Bank</option>
                  <option value="Cheque">Cheque</option>
               </select>
            </div>
        </div>
        <div id="rd"></div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Transaction ID(Cheque no, Transfer Id, Deposit Id):</label>
                <input type="text" value="<?php echo $transid1; ?>" name="transid" class="form-control" id="ti">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="">Description</label>
                <input type="text" value="" name="description" class="form-control" id="ti">
            </div>
          </div>
    </div>
    <button type="reset" class="btn btn-danger">Reset</button>
    <button type="submit" class="btn btn-primary pull-right">Submit</button>
    <div class="clearfix"></div>
</form>
                      </div>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title">Expense Posting</h4>
                        <!-- <p class="card-category">Fill in all important data</p> -->
                      </div>
                      <div class="card-body">
                      <form action="../functions/expense.php" method="post">
    <div class="row">
        <div class="col-md-4">
        <script>
              $(document).ready(function() {
                  $('#acct').on("change keyup paste click", function(){
                    var id = $(this).val();
                    var ist = $('#int_id').val();
                    $.ajax({
                      url:"acct_rep.php",
                      method:"POST",
                      data:{id:id, ist: ist},
                      success:function(data){
                        $('#accrep').html(data);
                      }
                    })
                  });
              });
        </script>
            <div class="form-group">
                <label for="">GL Number</label>
                <input type="text" class="form-control" name="acct_gl" id="acct">
                <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id;?>" id="int_id">
            </div>
        </div>
        <div class="col-md-4">
        <div class="form-group">
          <label for="">Amount Recieved:</label>
          <input type="number" name="amount" id="" value="" class="form-control">
          <span class="help-block" style="color: red;"><?php echo $exp_error;?></span>
        </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          <label for="">Payment Method:</label>
          <script>
                $(document).ready(function() {
                  $('#poo').change(function(){
                    var id = $(this).val();
                    if (id == "Cheque") {
                      document.getElementById('tit').readOnly = false;
                      $("#tit").val("");
                    } else {
                      document.getElementById('tit').readOnly = true;
                      $("#tit").val(Math.floor(100000 + Math.random() * 900000));
                    }
                  });
                });
              </script>
          <select name="payment_method" id="poo" class="form-control">
            <option value="Cash">Cash</option>
            <!-- <option value="Cheque">Cheque</option> -->
            <!-- <option value="Transfer">Transfer</option> -->
          </select>
      </div>
    </div>
    <div class="col-md-4">
    <div id="accrep"></div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          <label for="">Transaction ID:</label>
          <input type="text" readonly value="<?php echo $transid; ?>" name="transid" class="form-control" id="tit">
      </div>
    </div>
    </div>    
          <button type="submit" class="btn btn-primary pull-right">Submit</button>
  </form>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
<?php
include("footer.php");
?>
<?php
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Vault Authorization",
    text: "You Dont Have permission to Make Transactions",
   showConfirmButton: false,
    timer: 2000
    }).then(
    function (result) {
      history.go(-1);
    }
    )
    });
   </script>
  ';
  // $URL="transact.php";
  // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

?>