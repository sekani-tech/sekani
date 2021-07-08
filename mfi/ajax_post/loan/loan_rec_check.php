<?php
include("../../../functions/connect.php");
session_start();
$sessint_id = $_SESSION["int_id"];
$id = $_POST["id"];
if (isset($_POST["id"]) && $id != "") {
  $query_loan = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND id='$id'");
  $row = mysqli_fetch_array($query_loan);
  $client_id = $row["client_id"];
  $due_date = $row["duedate"];
  $loanId = $row["loan_id"];
  $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE int_id = '$sessint_id' AND id = '$loanId'");
  $x = mysqli_fetch_array($query_loan);
  $account_no = $x["account_no"];
  $query_client = mysqli_query($connection, "SELECT * FROM client WHERE id ='$client_id' AND int_id = '$sessint_id'");
  $cm = mysqli_fetch_array($query_client);
  $firstname = strtoupper($cm["firstname"] . " " . $cm["lastname"]);
}
?>
<!-- end -->
<form action="../../../functions/loans/manual_process.php" method="post">
  <div class="form-group bmd-form-group">
    <label for=""> <b style="color:black;"> Account Name </b></label>
    <div class="input-group">
      <div class="input-group-prepend">
      </div>
      <input style="color:black;" type="text" class="form-control" value="<?php echo $firstname; ?>" readonly>
    </div>
  </div>
  <div class="form-group bmd-form-group">
    <label for=""> <b style="color:black;"> Account Number </b></label>
    <div class="input-group">
      <div class="input-group-prepend">
      </div>
      <input style="color:black;" name="account_no" type="text" class="form-control" value="<?php echo $account_no; ?>" readonly>
    </div>
  </div>
  <div class="form-group bmd-form-group">
    <label for=""> <b style="color:black;"> Amount </b></label>
    <div class="input-group">
      <div class="input-group-prepend">
      </div>
      <input style="color:black;" name="amount" type="decimal" class="form-control" placeholder="0.00">
    </div>
  </div>
  <div class="form-group bmd-form-group">
    <label for=""> <b style="color:black;"> Expected Repayment Date </b></label>
    <div class="input-group">
      <div class="input-group-prepend">
      </div>
      <input style="color:black;" type="date" class="form-control" value="<?php echo $due_date; ?>" readonly>
    </div>
  </div>
  <div class="form-group bmd-form-group">
    <label for=""> <b style="color:black;"> Transaction Date </b></label>
    <div class="input-group">
      <div class="input-group-prepend">
      </div>
      <input style="color:black;" name="payment_date" type="date" class="form-control">
    </div>
  </div>
  <div class="form-group bmd-form-group">
    <label for=""> <b style="color:black;"> Payment Type </b></label>
    <div class="input-group">
      <div class="input-group-prepend">
      </div>
      <select style="color:black;" name="payment_type" class="form-control">
        <option value="1">Pay Interest Amount</option>
        <option value="2">Pay Principal Amount </option>
        <option value="3">Pay Principal and Interest Amount</option>
      </select>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Pay</button>
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</form>