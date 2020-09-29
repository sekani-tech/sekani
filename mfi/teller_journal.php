<?php

$page_title = "Vault Transaction";
$destination = "transaction.php";
    include("header.php");
?>
<?php
//  Sweet alert Function

// If it is successfull, It will show this message
  if (isset($_GET["message"])) {
    $key = $_GET["message"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Transaction Denied",
            text: "Movable Amount Exceeded",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
else if (isset($_GET["message1"])) {
  $key = $_GET["message1"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Transaction Successful",
          text: "Amount has been withdrawn from teller, Email has been sent.",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
// If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Not enough Loan in the teller Account",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
if (isset($_GET["message3"])) {
  $key = $_GET["message3"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Amount has been deposited to teller, Email has been sent.",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
else if (isset($_GET["message4"])) {
$key = $_GET["message4"];
// $out = $_SESSION["lack_of_intfund_$key"];
$tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error",
        text: "Not enough Amount in the vault",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
$_SESSION["lack_of_intfund_$key"] = 0;
    }
}
else if (isset($_GET["message5"])) {
  $key = $_GET["message5"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "No transaction type selected",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
  }
  else if (isset($_GET["message6"])) {
    $key = $_GET["message6"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
      if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Success",
                text: "Amount has been deposited to teller, email not sent",
                showConfirmButton: false,
                timer: 2000
            })
        });
        </script>
        ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
    }
    else if (isset($_GET["message10"])) {
      $key = $_GET["message10"];
      // $out = $_SESSION["lack_of_intfund_$key"];
      $tt = 0;
        if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
      echo '<script type="text/javascript">
      $(document).ready(function(){
          swal({
              type: "error",
              title: "Depositor/Recipient not selected",
              text: "Please select a Depositor/Recipient",
              showConfirmButton: false,
              timer: 2000
          })
      });
      </script>
      ';
      $_SESSION["lack_of_intfund_$key"] = 0;
    }
    }
    else if (isset($_GET["message11"])) {
      $key = $_GET["message11"];
      // $out = $_SESSION["lack_of_intfund_$key"];
      $tt = 0;
        if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
      echo '<script type="text/javascript">
      $(document).ready(function(){
          swal({
              type: "error",
              title: "Insufficient Funds",
              text: "Not enough amount in the bank transaction",
              showConfirmButton: false,
              timer: 2000
          })
      });
      </script>
      ';
      $_SESSION["lack_of_intfund_$key"] = 0;
    }
    }
?>
<!-- Content added here -->
<?php
// right now we will program
// first step - check if this person is authorized
if ($valut == 1 || $valut == "1") {
?> 
<?php
$bch_id = $_SESSION['branch_id'];
$sint_id = $_SESSION['int_id'];
// output the branch name
  $bch_name =  mysqli_query($connection, "SELECT * FROM branch WHERE id = '$bch_id' && int_id = '$sessint_id'");
  $grn = mysqli_fetch_array($bch_name);
  $get_b_r_n = $grn['id'];
  $bname = $grn['name'];
// Ending branch_name

// check the current balance
$int_balance = mysqli_query($connection, "SELECT * FROM int_vault WHERE branch_id = '$bch_id' && int_id = '$sessint_id'");
$itb = mysqli_fetch_array($int_balance);
$g_i_t_b = $itb['balance'];
$vault_limit = $itb['movable_amount'];
$vault_last_with = $itb['last_withdrawal'];
$vault_last_dep = $itb['last_deposit'];

// For the Transaction ID auto generated
$digits = 10;
$transaction_id = str_pad(rand(0, pow(10, 7)-1), 7, '0', STR_PAD_LEFT);
// check if every data is active
// then we will do the transaction - stored 
// then if will reflect inside of int_transaction for the teller that will be picked
// then you can display a message that the transaction is successful.
// remember to add code of making institution branch add a vualt and also Super Admin
?>
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Vault Transaction (In & Out)</h4>
                  <!-- <p class="card-category">Fill in all important data</p> -->
                </div>
                <div class="card-body">
                  <form action="../functions/vaulttrans.php" method="POST">
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating"> Transaction Type</label>
                          <select name="type" id="selctttype" class="form-control">
                            <option value="0">select a transaction type in/out</option>
                            <option value="vault_in">SELL INTO VAULT</option>
                            <option value="vault_out">BUY FROM VAULT</option>
                            <option value="from_bank">FROM BANK TO VAULT</option>
                            <option value="to_bank">FROM VAULT TO BANK</option>
                          </select>
                        </div>
                      </div>
                      <?php
                        function branch_option($connection)
                        {  
                            $br_id = $_SESSION["branch_id"];
                            $sint_id = $_SESSION["int_id"];
                            $out = '';

                            $sdf = "SELECT * FROM branch WHERE int_id = '$sint_id' AND id = '$br_id'";
                            $dsse = mysqli_query($connection, $sdf);
                            $fkdl = mysqli_fetch_array($connection, $dsse);
                            $pid = $fkdl['parent_id'];
                            if($pid == 0){
                              $fod = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                              $dof = mysqli_query($connection, $fod);
                              while ($row = mysqli_fetch_array($dof))
                              {
                              $out .= '<option value="'.$row["id"].'">' .$row["name"]. '</option>';
                              }
                            }
                            else{
                              $fod = "SELECT * FROM branch WHERE int_id = '$sint_id' AND id = '$br_id'";
                              $dof = mysqli_query($connection, $fod);
                              while ($row = mysqli_fetch_array($dof))
                              {
                              $out .= '<option value="'.$row["id"].'">' .$row["name"]. '</option>';
                              }
                            }
                            return $out;
                        }
                      ?>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label class="">Branch:</label>
                            <select class="form-control" id ="bid" name="branch_id">
                            <?php echo branch_option($connection);?>
                            </select>
                        </div>
                        </div>
                      <script>
                              $(document).ready(function() {
                                $('#selctttype').change(function(){
                                  var id = $(this).val();
                                  $.ajax({
                                    url:"ajax_post/vault_options.php",
                                    method:"POST",
                                    data:{id:id},
                                    success:function(data){
                                      $('#sw').html(data);
                                    }
                                  })
                                });
                              })

                              $(document).ready(function() {
                                $('#bid').change(function(){
                                  var id = $(this).val();
                                  var int = $('#intt').val();

                                  $.ajax({
                                    url:"ajax_post/vault_balance.php",
                                    method:"POST",
                                    data:{id:id, int:int},
                                    success:function(data){
                                      $('#show_branch_balance').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                      <div class="col-md-4" id ="sw">
                        
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="number" name="amount" id="" class="form-control">
                          <input type="text" hidden name="int" id="intt" value="<?php echo $sint_id; ?>" class="form-control">
                        </div>
                      </div>
                      <div id="show_branch_balance" class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Vault Balance</label>
                          <!-- populate available balance -->
                          <input type="text" value="<?php echo $g_i_t_b; ?>" name="balance" id="" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Transaction id</label>
                          <!-- populate available balance -->
                          <input type="text" value="<?php echo $transaction_id; ?>" name="transact_id" id="" class="form-control" readonly>
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
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Vault Authorization",
    text: "You Dont Have permission to Make Transaction From Vault",
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
