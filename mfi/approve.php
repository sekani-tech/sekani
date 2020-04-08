<?php

$page_title = "Approve";
$destination = "transact_approval.php";
    include("header.php");

?>
<?php
if (isset($_GET['approve']) && $_GET['approve'] !== '') {
  $appod = $_GET['approve'];
  $checkm = mysqli_query($connection, "SELECT * FROM transact_cache WHERE id = '$appod' && int_id = '$sessint_id'");
  if (count([$checkm]) == 1) {
      $x = mysqli_fetch_array($checkm);
      $ssint_id = $_SESSION["int_id"];
      $appuser_id = $_SESSION["user_id"];
      $cn = $x['client_name'];
      $acct_no = $x['account_no'];
      $staff_id = $x['staff_id'];
      $ao = $x['account_off_name'];
      $amount = $x['amount'];
      $pay_type = $x['pay_type'];
      $transact_type = $x['transact_type'];
      $product_type = $x['product_type'];
      $stat = $x['status'];
  }
}
?>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $approve = $_POST['submit'];
   $decline = $_POST['submit'];
   if ($approve == 'approve') {
    if (isset($_GET['approve']) && $_GET['approve'] !== '') {
      $appod = $_GET['approve'];
      $checkm = mysqli_query($connection, "SELECT * FROM transact_cache WHERE id = '$appod' && int_id = '$sessint_id'");
      if (count([$checkm]) == 1) {
          $x = mysqli_fetch_array($checkm);
          $ssint_id = $_SESSION["int_id"];
          $appuser_id = $_SESSION["user_id"];
          $acct_no = $x['account_no'];
          $staff_id = $x['staff_id'];
          $amount = $x['amount'];
          $pay_type = $x['pay_type'];
          $transact_type = $x['transact_type'];
          $product_type = $x['product_type'];
          $stat = $x['status'];
          $gen_date = date("Y-m-d");
          $digits = 10;
          $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
          $transid = $sessint_id."-".$randms;
  
          if ($stat == "Not Verified") {
              $getacct = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' && int_id = '$sessint_id'");
              if (count([$getacct]) == 1) {
                 $y = mysqli_fetch_array($getacct);
                 $branch_id = $y['branch_id'];
                 $acct_no = $y['account_no'];
                 $client_id = $y['client_id'];
                 $int_acct_bal = $y['account_balance_derived'];
                 $comp = $amount + $int_acct_bal;
                 $comp2 = $int_acct_bal - $amount;
                 $trans_type = "credit";
                 $trans_type2 = "debit";
                 $irvs = 0;
  
              //    account deposite computation
                if($transact_type == "Deposit") {
                  $new_abd = $comp;
                  $iupq = "UPDATE account SET account_balance_derived = '$new_abd',
                  total_deposits_derived = '$amount' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
                  $iupqres = mysqli_query($connection, $iupq);
                  if ($iupqres) {
                      $iat = "INSERT INTO account_transaction (int_id, branch_id,
                      account_no, product_id,
                      client_id, transaction_id, transaction_type, is_reversed,
                      transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                      created_date, appuser_id) VALUES ('{$ssint_id}', '{$branch_id}',
                      '{$acct_no}', '{$product_type}', '{$client_id}', '{$trans_id}', '{$trans_type}', '{$irvs}',
                      '{$gen_date}', '{$amount}', '{$new_abd}', '{$amount}',
                      '{$gen_date}', '{$appuser_id}')";
                      $res3 = mysqli_query($connection, $iat);
                      if ($res3) {
                          $v = "Verified";
                          $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                          $res4 = mysqli_query($connection, $iupqx);
                          if ($res4) {
                            echo '<script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    type: "success",
                                    title: "Success",
                                    text: "Transaction Successfully Approved",
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            });
                            </script>
                            ';
                          } else {
                            echo '<script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    type: "error",
                                    title: "Error",
                                    text: "Error updating Cache",
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            });
                            </script>
                            ';
                          }
                          
                      } else {
                        echo '<script type="text/javascript">
                        $(document).ready(function(){
                            swal({
                                type: "error",
                                title: "Error",
                                text: "Error in Transaction",
                                showConfirmButton: false,
                                timer: 2000
                            })
                        });
                        </script>
                        ';
                      }
                  } else {
                    echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "error",
                            title: "Error",
                            text: "Error in Account",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
                  }
                } else if ($transact_type == "Withdrawal") {
                  $new_abd2 = $comp2;
                  $iupq = "UPDATE account SET account_balance_derived = '$new_abd2',
                  total_withdrawals_derived  = '$amount' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
                  $iupqres = mysqli_query($connection, $iupq);
                  if ($iupqres) {
                      $iat = "INSERT INTO account_transaction (int_id, branch_id,
                      account_no, product_id,
                      client_id, transaction_id, transaction_type, is_reversed,
                      transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                      created_date, appuser_id) VALUES ('{$ssint_id}', '{$branch_id}',
                      '{$acct_no}', '{$product_type}', '{$client_id}', '{$trans_id}', '{$trans_type2}', '{$irvs}',
                      '{$gen_date}', '{$amount}', '{$new_abd}', '{$amount}',
                      '{$gen_date}', '{$appuser_id}')";
                      $res3 = mysqli_query($connection, $iat);
                      if ($res3) {
                          $v = "Verified";
                          $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                          $res4 = mysqli_query($connection, $iupqx);
                          if ($res4) {
                            echo '<script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    type: "success",
                                    title: "Success",
                                    text: "Transaction Successfully Approved",
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            });
                            </script>
                            ';
                          } else {
                            echo '<script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    type: "error",
                                    title: "Error",
                                    text: "Error updating Cache",
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            });
                            </script>
                            ';
                          }
                      } else {
                        echo '<script type="text/javascript">
                        $(document).ready(function(){
                            swal({
                                type: "error",
                                title: "Error",
                                text: "Error in Transaction",
                                showConfirmButton: false,
                                timer: 2000
                            })
                        });
                        </script>
                        ';
                      }
                  } else {
                    echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "error",
                            title: "Error",
                            text: "Error in Account",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
                  }
                } else {
                  echo '<script type="text/javascript">
                  $(document).ready(function(){
                      swal({
                          type: "error",
                          title: "Error",
                          text: "No Deposit or Withdrawal",
                          showConfirmButton: false,
                          timer: 2000
                      })
                  });
                  </script>
                  ';
                 }
  
              }
          } else {
              // a message
              echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "error",
                            title: "Error",
                            text: "Transaction Has Been Approved Already",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
          }
      }
  }
   } else {
    $digits = 10;
    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
     if (isset($_GET['approve']) && $_GET['approve'] !== '') {
       $appe = $_GET['approve'];
       $dc = "declined";
       $take = "UPDATE transact_cache SET `status` = '$dc' WHERE id = '$appe' && int_id = '$sessint_id'";
       $deny = mysqli_query($connection, $take);
       if ($deny) {
        echo '<script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    type: "success",
                                    title: "Success",
                                    text: "Transaction Declined",
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            });
                            </script>
        ';
       } else {
        echo '<script type="text/javascript">
                            $(document).ready(function(){
                                swal({
                                    type: "error",
                                    title: "Error",
                                    text: "Error Not Declined",
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            });
                            </script>
      ';
       }
     }
   }
 }
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Approve Transaction</h4>
                  <p class="card-category">Make sure everything is in order</p>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Transaction Type:</label>
                          <input type="text" class="form-control" name="name" value="<?php echo $transact_type; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Account Officer</label>
                          <input type="text" class="form-control" name="email" value="<?php echo $ao; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Client</label>
                          <input type="text" class="form-control" name="phone" value="<?php echo $cn; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="text" class="form-control" name="location" value="<?php echo $amount; ?>">
                        </div>
                      </div>
                      </div>
                      <a href="client.php" class="btn btn-secondary">Back</a>
                      <button type="submit" name="submit" value="decline" class="btn btn-danger pull-right">Decline</button>
                    <button type="submit" name="submit" value="approve" class="btn btn-primary pull-right">Approve</button>
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