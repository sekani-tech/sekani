<?php

$page_title = "Approve Expense";
$destination = "transact_approval.php";
include("header.php");
include("ajaxcall.php");
require_once "../bat/phpmailer/PHPMailerAutoload.php";
?>
<!-- IMPORTING FO THE EXPENSE -->
<?php
// the session
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$appuser_id = $_SESSION['user_id'];
$sender_id = $_SESSION["sender_id"];
$gen_date = date('Y-m-d h:i:sa');
$pint = date('Y-m-d h:i:sa');
$gends = date('Y-m-d h:i:sa');
?>
<?php
if (isset($_GET['approve']) && $_GET['approve'] !== '') {
  $appod = $_GET['approve'];

  $checkm = mysqli_query($connection, "SELECT * FROM transact_cache WHERE id = '$appod' AND transact_type = 'Expense' AND int_id = '$sessint_id' AND status = 'Pending'");
  if (count([$checkm]) == 1) {
    $x = mysqli_fetch_array($checkm);

    $cn = $x['client_name'];
    $client_id = $x['client_id'];
    $id = $client_id;
    $acct_no = $x['account_no'];
    $account_display = substr("$acct_no", 0, 3) . "*****" . substr("$acct_no", 8);
    $teller_id = $x['teller_id'];
    $ao = $x['account_off_name'];
    $amount = $x['amount'];
    $famt = number_format("$amount", 2);
    $pay_type = $x['pay_type'];
    $transact_type = $x['transact_type'];
    $description = $x['description'];
    $transid = $x['transact_id'];
    $product_type = $x['product_type'];
    $stat = $x['status'];
    $branch_idm = $x['branch_id'];
    $teller_id = $x['staff_id'];
    $transaction_date = $x['date'];
    $is_bank = $x["is_bank"];
    $bank_gl_code = $x["bank_gl_code"];
    $irvs = 0;

    $glv = selectOne('acc_gl_account', ['int_id' => $sessint_id, 'gl_code' => $bank_gl_code]);
    //      $gl_manq = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$bank_gl_code' && int_id = '$sessint_id'");
    //      $glv = mysqli_fetch_array($gl_manq);
    $E_acct_bal = $glv["organization_running_balance_derived"];
    // DMAN
    $new_gl_balx = $E_acct_bal + $amount;
    $new_gl_bal2x = $E_acct_bal - $amount;
  }
}
$gen_date = date('Y-m-d h:i:sa');
$gends = date('Y-m-d h:i:sa');
// we will call the institution account

?>

<!-- Content added here -->

<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Approve Transaction</h4>
            <p class="card-category">Make sure everything is in order</p>
          </div>
          <div class="card-body">
            <form method="post" action="../functions/transactions/expense/approve_expense.php">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Transaction Type:</label>
                    <input type="text" class="form-control" name="name" readonly value="<?php echo $transact_type; ?>">
                    <input type="text" name="id" value="<?php echo $appod ?>"  readonly hidden>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Posted By</label>
                    <input type="text" class="form-control" name="email" readonly value="
                    <?php if ($ao != "") {
                      echo $ao;
                    } else {
                      $findResponsible = mysqli_query($connection, "SELECT display_name FROM staff WHERE id = '$teller_id'");
                      $data = mysqli_fetch_array($findResponsible);
                      echo $staffName = $data['display_name'];
                    } ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Expense Name</label>
                    <input type="text" class="form-control" name="phone" readonly value="<?php echo $cn; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Amount</label>
                    <input type="text" class="form-control" name="location" readonly value="<?php echo $amount; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Description</label>
                    <input type="text" class="form-control" name="descript" readonly value="<?php echo $description; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Transaction Narration</label>
                    <?php if ($is_bank == 1) { ?>
                      <input type="text" value="Bank" class="form-control" readonly>
                    <?php } else if ($is_bank == 0) { ?>
                      <input type="text" value="Cash" class="form-control" readonly>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Transaction ID</label>
                    <input type="text" class="form-control" name="transidddd" readonly value="<?php echo $transid; ?>">
                  </div>
                </div>
              </div>
              <!-- <a href="client.php" class="btn btn-secondary">Back</a> -->
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