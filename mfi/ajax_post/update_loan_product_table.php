<?php
include("../../functions/connect.php");
session_start();
$output = '';
$sessint_id = $_SESSION['int_id'];
$user_id = $_POST['user'];
$charge = $_POST['id'];
?>
<?php
$dsd = "SELECT * FROM `product_loan_charge` WHERE int_id = '$sessint_id' AND product_loan_id = '$user_id' AND charge_id='$charge'";
$wpme = mysqli_query($connection, $dsd);
$i = mysqli_fetch_array($wpme);
$dfe = $i['charge_id'];

if ($dfe == $charge) {
echo "Charge Already Applied";
}
else{
$fdfg = "INSERT INTO product_loan_charge (int_id, product_loan_id, charge_id) VALUES('{$sessint_id}', '{$user_id}', '{$charge}')";
$derifv = mysqli_query($connection, $fdfg);
}
?>
<table id="tabledat4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM product_loan_charge WHERE int_id ='$sessint_id' AND product_loan_id = '$user_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                      <th>Name</th>
                      <th>Charge</th>
                      <th>Collected On</th>
                      <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <?php
                          $charge_id = $row['charge_id'];
                            $fid = "SELECT * FROM charge WHERE int_id = '$sessint_id' AND id ='$charge_id'";
                            $dfdf = mysqli_query($connection, $fid);
                            $d = mysqli_fetch_array($dfdf);
                            $name = $d['name'];
                            $amt = $d['amount'];
                            $ds = $d['charge_calculation_enum'];
                            $values = $d["charge_time_enum"];
                            if ($ds == 1) {
                              $chg = $amt." Flat";
                            } else {
                              $chg = $amt. "% of Loan Principal";
                            }
                            if ($values == 1) {
                              $xs = "Disbursement";
                            } else if ($values == 2) {
                              $xs = "Manual Charge";
                            } else if ($values == 3) {
                              $xs = "Savings Activiation";
                            } else if ($values == 5) {
                              $xs = "Deposit Fee";
                            } else if ($values == 6) {
                              $xs = "Annual Fee";
                            } else if ($values == 8) {
                              $xs = "Installment Fees";
                            } else if ($values == 9) {
                              $xs = "Overdue Installment Fee";
                            } else if ($values == 12) {
                              $xs = "Disbursement - Paid With Repayment";
                            } else if ($values == 13) {
                              $xs = "Loan Rescheduling Fee";
                            } 
                          ?>
                          <th><?php echo $name; ?></th>
                          <th><?php echo $chg; ?></th>
                          <th><?php echo $xs; ?></th>
                          <td><a class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>