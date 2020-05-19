<?php

$page_title = "Vault Transaction";
$destination = "index.php";
    include("header.php");
?>
<!-- Content added here -->
<?php
// right now we will program
// first step - check if this person is authorized
$org_role = $_SESSION['org_role'];
$query = "SELECT * FROM org_role WHERE role = '$org_role'";
$process = mysqli_query($connection, $query);
$role = mysqli_fetch_array($process);
$role_id = $role['id'];

$query2 = "SELECT * FROM permission WHERE role_id = '$role_id'";
$process2 = mysqli_query($connection, $query2);
$proce = mysqli_fetch_array($process2);
$valut = $proce['valut'];

if ($valut == 1 || $valut == "1") {
?>
<?php
// output the branch name
  $bch_name =  mysqli_query($connection, "SELECT * FROM branch WHERE id = '$bch_id' && int_id = '$sessint_id'");
  $grn = mysqli_fetch_array($bch_name);
  $get_b_r_n = $grn['name'];
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
                          <select name="type" id="" class="form-control">
                            <option value="0">select a transaction type in/out</option>
                            <option value="valut_in">DEPOSIT INTO VAULT</option>
                            <option value="valut_out">WITHDRAW FROM VAULT</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Branch Name</label>
                          <!-- populate available balance -->
                          <input type="text" value="<?php echo $get_b_r_n; ?>" name="branch" id="branch_id" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                            <?php 
                            function fill_teller($connection, $bch_id) {
                              $sint_id = $_SESSION["int_id"];
                              $org = "SELECT * FROM tellers WHERE int_id = '$sint_id' && branch_id = '$bch_id'";
                              $res = mysqli_query($connection, $org);
                              $out = '';
                              while ($row = mysqli_fetch_array($res))
                              {
                                $out .= '<option value="'.$row["name"].'">'.$row["description"].'</option>';
                              }
                              return $out;
                            }
                            ?>

                          <label class="bmd-label-floating"> Teller Name</label>
                          <select name="teller_name" id="" class="form-control">
                            <option value="0">SELECT A TELLER</option>
                            <?php echo fill_teller($connection, $bch_id); ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="number" name="amount" id="" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Current Balance</label>
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
