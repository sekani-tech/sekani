<?php
include("../functions/connect.php");
$output = '';
?>
<?php
if (isset($_POST["id"]))
{
    if ($_POST["id"] != '')
    {
      $sql = "SELECT loan.interest_rate, client.id, client.display_name, client.account_no, loan.id, client.branch_id, loan.product_id, principal_amount, loan_term, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='".$_POST["ist"]."' && loan.account_no = '".$_POST["id"]."'";
      $person = mysqli_query($connection, $sql);
      if (count([$person]) == 1) {
        $x = mysqli_fetch_array($person);
        $pa = $x['principal_amount'];
        $brh = $x['branch_id'];
        $p_id = $x['product_id'];
        $account_no = $x['account_no'];
        $dn = $x['display_name'];
        $interest_R = $x['interest_rate'];
        $lt = $x['loan_term'];
        $ln_id = $x['id'];
        $expa = $pa / $lt;
      }
    }
     $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result))
    {
      $output = '
        <div class="form-group">
          <label for="">First Name:</label>
          <input type="number" name="fn id="" value="'.$dn.'" class="form-control" readonly>
        </div>
      <div class="form-group">
          <label for="">Expected Amount:</label>
          <input type="text" name="exp_amt" class="form-control" id="" value="'.$expa.'" readonly>
      </div>';
      echo $output;
    }
}
?>