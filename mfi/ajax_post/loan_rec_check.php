<?php
include("../../functions/connect.php");
session_start();
$sessint_id = $_SESSION["int_id"];
$id = $_POST["id"];
if (isset($_POST["id"]) && $id != "") {
    $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE int_id = '$sessint_id' AND (total_outstanding_derived > 0) AND id='$id'");
    $row = mysqli_fetch_array($query_loan);
    $client_id = $row["client_id"];
    $query_client = mysqli_query($connection, "SELECT * FROM client WHERE id ='$client_id' AND int_id = '$sessint_id'");
    $cm = mysqli_fetch_array($query_client);
    $firstname = strtoupper($cm["firstname"]." ".$cm["lastname"]);
?>
<!-- end -->
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
                                  <input style="color:black;" name="account_no" type="text" class="form-control" value="<?php echo $row["account_no"]; ?>" readonly>
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
                            <label for=""> <b style="color:black;"> Payment Date </b></label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                  </div>
                                  <input style="color:black;" name="payment_date" type="date" class="form-control" placeholder="yyyy-mm-dd">
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
                            <!-- making a new move -->
                            <?php
                            $query_rep = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$id' AND (installment > 0) ORDER BY duedate ASC LIMIT 1");
                            if (mysqli_num_rows($query_rep) > 0) {
                            $ro = mysqli_fetch_array($query_rep);
                            echo '<script type="text/javascript">
                            $(document).ready(function(){
                                $("#pay_man").prop("disabled", false);
                            });
                            </script>
                            ';
                            ?>
                            <div class="form-group bmd-form-group">
                            <label for=""> <b style="color:black;"> Current Repayment Outstanding </b></label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                  </div>
                                  <input style="color:black;" hidden name="out_id" value="<?php echo $ro["id"]; ?>" type="text" class="form-control" readonly>
                                </div>
                                <p>
                                      Due Date: <?php echo $ro["duedate"]." <br/> "; ?>
                                      Principal Amount: <?php echo "NGN ".number_format($ro["principal_amount"], 2)." <br> "; ?>
                                      Interest Amount: <?php echo "NGN ".number_format($ro["interest_amount"], 2)." <br> "; ?>
                                      Principal and Interest Amount: <?php echo "NGN ".number_format(($ro["interest_amount"] + $ro["principal_amount"]), 2)." <br> "; ?>
                                  </p>
                                </div>
                            <?php
                            } else {
                                echo '<script type="text/javascript">
                                $(document).ready(function(){
                                    $("#pay_man").prop("disabled", true);
                                });
                                </script>
                                ';
                                ?>
                                <div class="form-group bmd-form-group">
                                    <p style="color:green;">REPAYMENT COMPLETED</p>
                                </div>
                                <?php

                            }
                            ?>
                            <center>
                    <button id="pay_man" type="submit" class="btn btn-primary btn-link btn-wd btn-lg"> <b>Pay</b></button>
                    </center>

<?php
} else {
    echo '<script type="text/javascript">
    $(document).ready(function(){
     swal({
      type: "error",
      title: "Sorry No Loan Found",
      text: "Click on the loan pay button",
     showConfirmButton: false,
      timer: 2000
      })
      });
     </script>
    ';
}
?>