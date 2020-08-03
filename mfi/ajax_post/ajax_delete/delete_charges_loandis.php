<?php
include("../../../functions/connect.php");

if ($_POST['id_to_be_deleted']) {
$delete = $_POST['id_to_be_deleted'];
//do db delete query here i.e 
$dom = "DELETE FROM product_loan_charge WHERE id='$delete'";
$cms = mysqli_query($connection, $dom);
}
?>
<table class="table table-bordered">
                    <?php
                    $p_id = $_POST["id"];
                   $query = "SELECT * FROM product_loan_charge WHERE product_loan_id = '$p_id' && int_id = '$sessint_id'";
                   $result = mysqli_query($connection, $query);
                   ?>
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Charge</th>
                              <th>Amount</th>
                              <th>Collected On</th>
                              <th>Delete</th>
                              <!-- <th>Date</th> -->
                            </tr>
                          </thead>
                          <tbody> 
                          <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                            <?php
                            $c_id = $row["charge_id"];
                            $select_chg = mysqli_query($connection, "SELECT * FROM charge WHERE id = '$c_id' && int_id = '$sessint_id'");
                            while ($xm = mysqli_fetch_array($select_chg)) {
                                $values = $xm["charge_time_enum"];
                             $nameofc = $xm["name"];
                             $amt = '';
                             $amt2 = '';
                            $forp = $xm["charge_calculation_enum"];
                            $rmt = $_POST["prin"];
                            $amt_2 = $xm["amount"];
                            if ($forp == 1) {
                                $amt = number_format($xm["amount"], 2);
                                $chg2 = $amt." Flat";
                              } else {
                                $chg2 = $amt_2. "% of Loan Principal";
                                $calc = ($amt_2 / 100) * $rmt;
                                $amt2 = number_format($calc, 2);
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
                          <td><?php echo $nameofc; ?></td>
                          <td><?php echo $chg2; ?></td>
                          <td><?php echo $amt."".$amt2; ?></td>
                          <td><?php echo $xs; ?></td>
                          <td><div class="media-body media-right">
                            <span onclick="delete_charge(<?php echo $c_id;?>)" class="btn btn-danger">Delete</span>
                          </div></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>  
                          <script>
                             function delete_charge(I) {
                              // delete methodology
                                var id_to_be_deleted = I;
                                var formData = new FormData();
                                formData.append("id_to_be_deleted", id_to_be_deleted);
                                $.ajax({
                                    method: "POST",
                                    url: "ajax_post/ajax_delete/delete_charges_loandis.php",
                                    contentType: false,
                                    processData: false,
                                    //contentType: "application/json; charset=utf-8",
                                    // dataType: "json",
                                    data : formData,
                                    success:function(data){
                                      $('#lend_charge').html(data);
                                      // document.getElementById("off_me").setAttribute("hidden", "");
                                      alert('success' + data);
                                    }
                                    });
                                  }
                            </script>
                          </tbody>
                        </table>