<?php 

$page_title = "Loan Collection";
$destination = "loans.php";
include("header.php");

?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
        <?php
                  if(isset($_GET["loancoll"])) {
                    $id = $_GET["loancoll"];
                    $update = true;
                    $person = mysqli_query($connection, "SELECT loan.interest_rate, client.id, client.account_no, loan.id, client.branch_id, loan.product_id, principal_amount, loan_term, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='$sessint_id' && client_id = '$id'");
                    if (count([$person]) == 1) {
                      $x = mysqli_fetch_array($person);
                      $pa = $x['principal_amount'];
                      $brh = $x['branch_id'];
                      $p_id = $x['product_id'];
                      $account_no = $x['account_no'];
                      $interest_R = $x['interest_rate'];
                      $lt = $x['loan_term'];
                      $ln_id = $x['id'];
                      $expa = $pa / $lt;
                      // transaction id generation
                      $sessint_id = $_SESSION["int_id"];
                      $inttest = str_pad($sessint_id, 3, '0', STR_PAD_LEFT);
                      $digits = 4;
                     $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
                     $transid = $inttest."-".$randms;
                    //  run a query to display clientm name
                    $cqu = mysqli_query($connection, "SELECT * FROM client WHERE id = '$id'");
                    if (count([$cqu]) == 1) {
                      $us = mysqli_fetch_array($cqu);
                      $display_n = $us['display_name'];
                    }
                    }
                  }
                  ?>
                  <!-- loan collection -->
                  <?php
// this page will calculate the loan and also post for collection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $exp_amount = $expa;
  $amt_recieved = $_POST['collect'];
  $pay_meth = $_POST['payment_method'];
  $transaction_id = $_POST['transid'];
  // make collection calculation
  $loan_principal = $pa;
  $loan_term = $lt;
  // test quickly - out put balance of the loan and calulation logic
  $minus = $amt_recieved - $exp_amount;
  if ($minus >= 0 ) {
    $exp_error = "";
    // now lets output the loan amount remaning into a variable
    $clamt = $loan_principal - $amt_recieved;
    $minlt = $loan_term - 1;
    if ($clamt >= 0) {
      // echo "Loan Balance remaining = ". $clamt ."and". $minlt ;
      // we update the loan
      $update_loan_b = "UPDATE loan SET principal_amount = '$clamt', loan_term = '$minlt' WHERE client_id = '$id'";
      $run_ulb = mysqli_query($connection, $update_loan_b);
      // we update loan transaction
      if ($run_ulb) {
        $inst_id = $sessint_id;
        $branch = $brh;
        $prod_id = $p_id;
        $loan_id = $ln_id;
        $trns_id = $transid;
        $cc_id = $id;
        $acct_no = $account_no;
        $trans_type = "credit";
        $trans_date = date("Y-m-d");
        $amt = $amt_recieved;
        $py_m = $pay_meth; 
        $p_d = $amt_recieved - ($amt_recieved * $interest_R);
        $i_d = $amt_recieved * $interest_R;
          // quick query on outstanding loan balance derived
        $olbd = mysqli_query($connection, "SELECT * FROM loan where client_id = '$id'");
        if (count([$olbd]) == 1) {
          $oo = mysqli_fetch_array($olbd);
          $out_loan_bal = $oo['principal_amount'];
        }
        $appuser_id = $_SESSION["user_id"];
        $olbdq = "INSERT INTO loan_transaction (int_id, branch_id,
        product_id, loan_id, transaction_id, client_id,
        account_no, transaction_type, transaction_date, amount,
        payment_method, principal_portion_derived, interest_portion_derived,
        outstanding_loan_balance_derived, submitted_on_date,
        created_date, appuser_id) VALUES ('{$inst_id}', '{$branch}',
        '{$prod_id}', '{$loan_id}', '{$transid}', '{$cc_id}',
        '{$acct_no}', '{$trans_type}', '{$trans_date}', '{$amt}', '{$pay_meth}',
        '{$p_d}', '{$i_d}', '{$out_loan_bal}', '{$trans_date}', '{$trans_date}',
        '{$appuser_id}')";
        $res2 = mysqli_query($connection, $olbdq);
      // we update institution account
      if ($res2) {
        $uiab = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id'");
        if (count([$uiab]) == 1) {
          $x = mysqli_fetch_array($uiab);
          $int_acct_bal = $x['account_balance_derived'];
          $new_abd = $amt_recieved + $int_acct_bal;
          $iupq = "UPDATE institution_account SET account_balance_derived = '$new_abd' WHERE int_id = '$sessint_id'";
          $iupqres = mysqli_query($connection, $iupq);
      // we insert credit institution account transaction
      if ($iupqres) {
        $trans_id = $transaction_id;
        $trans_type = "credit";
        $trans_date = date("Y-m-d");
        $trans_amt = $amt;
        $irvs = 0;
        $ova = 0;
        $running_b = $new_abd;
        $created_date = date("Y-m-d");
        $iat = "INSERT INTO institution_account_transaction (int_id, branch_id,
        client_id, transaction_id, transaction_type, is_reversed,
        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
        created_date, appuser_id) VALUES ('{$inst_id}', '{$branch}',
        '{$id}', '{$trans_id}', '{$trans_type}', '{$irvs}',
        '{$trans_date}', '{$trans_amt}', '{$running_b}', '{$trans_amt}',
        '{$created_date}', '{$appuser_id}')";
        $res3 = mysqli_query($connection, $iat);
      //   if ($connection->error) {
      //     try {
      //         throw new Exception("MYSQL error $connection->error <br> $iat ", $mysqli->error);
      //     } catch (Exception $e) {
      //         echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
      //         echo n12br($e->getTraceAsString());
      //     }
      // }
        // we insert to priciapl portfolio
        if ($res3) {
          // we insert to interest portfolio
          $last = "INSERT INTO loan_principal_port (int_id, officer_id, branch_id,
          client_id, principal_amount) VALUES ('{$inst_id}', '{$appuser_id}',
          '{$branch}', '{$id}', '{$p_d}')";
          $last2 = "INSERT INTO loan_interest_port (int_id, officer_id, branch_id,
          client_id, interest_amount) VALUE ('{$inst_id}', '{$appuser_id}',
          '{$branch}', '{$id}', '{$i_d}')";
          $res4 = mysqli_query($connection, $last);
          $res5 = mysqli_query($connection, $last2);
          if ($res4) {
            if ($res5) {
              $llp = mysqli_query($connection, "SELECT * FROM loan where client_id = '$id'");
        if (count([$llp]) == 1) {
          $oo = mysqli_fetch_array($llp);
          $outloanbal = $oo['principal_amount'];
        }
              if ($outloanbal == 0) {
                $updc = mysqli_query($connection, "UPDATE client SET loan_status = 'Not Actve' WHERE id = '$id'");
                $URL="loans.php";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              } else {
                $URL="loans.php";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              }
            } else {
              echo "error at interest port";
            }
          } else {
            echo "error at principal port";
          }
         // test new laon balance to de-activate client loan status
        } else {
          echo "bad in int transaction account";
        }
      } else {
        echo "error in updating institution account";
      }
        } else {
          echo "problem in getting institution account";
        }
      } else {
        echo "problem with loan transaction insert";
      }
      } else {
        echo "problem in loan update";
      }
    } else if ($clamt < 0) {
      $chaclamt = $amt_recieved - $loan_principal;
      echo "i will be dropping the payment into account" . $chaclamt;
      // we update the loan
      // we update loan transaction
      // we update institution account
      // we insert credit institution account transaction
      // we update client account
      // we insert client account transaction
      // test new loan balance to de-activate client loan status
    } else {
      echo "i dont know this character";
    }
  } else {
    $exp_error = "<p>Amount Less then the Expected amount</p>";
  }
} else {
  $exp_error = "";
}
?>
          <!-- your content here -->
          <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">Loan collection</h4>
                    <!-- populate with client's name -->
                    <p class="card-category">Loan Repayment by - <?php echo $display_n ?></p>
                  </div>
                  <div class="card-body">
                    <form method="post">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Expected Amount:</label>
                              <input type="text" name="exp_amt" class="form-control" id="" value="<?php echo $expa; ?>" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Amount Recieved:</label>
                              <input type="number" name="collect" id="" value="" class="form-control">
                              <span class="help-block" style="color: red;"><?php echo $exp_error;?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Payment Method:</label>
                              <select name="payment_method" id="" class="form-control">
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Transfer">Transfer</option>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Transaction ID(Cheque no, Transfer Id):</label>
                              <input type="text" readonly value="<?php echo $transid; ?>" name="transid" class="form-control" id="">
                          </div>
                        </div>
                      </div>    
                            <!-- <button class="btn btn-default">Reset</button> -->
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