<?php
include("../functions/connect.php");
$output = '';
?>
<?php
if (isset($_POST["id"]))
{
    if ($_POST["id"] != '')
    {
      $sql = "SELECT loan.interest_rate, client.id, client.firstname, client.account_no, loan.id, client.branch_id, loan.product_id, principal_amount, loan_term, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='".$_POST["ist"]."' && loan.account_no = '".$_POST["id"]."'";
      $person = mysqli_query($connection, $sql);
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
      }
    } else {
      $sql = "SELECT loan.interest_rate, client.id, client.firstname, client.account_no, loan.id, client.branch_id, loan.product_id, principal_amount, loan_term, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='".$_POST["ist"]."'";
     }
     $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result))
    {
      $output = '
      <div class="col-md-4">
        <div class="form-group">
          <label for="">First Name:</label>
          <input type="number" name="fn id="" value="'.$row["firstname"].'" class="form-control" readonly>
        </div>
    </div>
      <div class="col-md-4">
      <div class="form-group">
          <label for="">Expected Amount:</label>
          <input type="text" name="exp_amt" class="form-control" id="" value="'.$expa;'" readonly>
      </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
          <label for="">Amount Recieved:</label>
          <input type="number" name="collect" id="" value="" class="form-control">
          <span class="help-block" style="color: red;"><?php echo $exp_error;?></span>
        </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          <label for="">Payment Method:</label>
          <select name="payment_method" id="" class="form-control">
            <option value="Cash">Cash</option>
            <option value="Cheque">Cheque</option>
            <option value="Transfer">Transfer</option>
          </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          <label for="">Transaction ID(Cheque no, Transfer Id):</label>
          <input type="text" readonly value="<?php echo $transid; ?>" name="transid" class="form-control" id="">
      </div>
    </div>';
      echo $output;
    }
}
?>