<?php 

include("header.php");

?>

<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
        <?php
                  if(isset($_GET["loancoll"])) {
                    $id = $_GET["loancoll"];
                    $update = true;
                    $person = mysqli_query($connection, "SELECT * FROM loan WHERE client_id = '$id'");
                    if (count([$person]) == 1) {
                      $x = mysqli_fetch_array($person);
                      $pa = $x['principal_amount'];
                      $lt = $x['loan_term'];
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
                    <form action="./functions/collect_payment.php?sn=<?php echo $id; ?>" method="post">
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
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Payment Method:</label>
                              <select name="status" id="" class="form-control">
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
                          <!-- Change the below input format into conditional statement -->
                            <!-- <div class="form-group">
                              <label for="">Status</label>
                              <select name="status" id="" class="form-control">
                                <option value="">......</option>
                                <option value="1">Not Complete</option>
                                <option value="2">Completed</option>
                                <option value="3">Over Payed</option>
                              </select>
                            </div> -->
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