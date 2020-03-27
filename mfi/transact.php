<?php

$page_title = "Deposit/ Withdrwal";
$destination = "index.php";
include("header.php");

?>

<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
<?php
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $runaccount = mysqli_query($connection, "SELECT * FROM account WHERE account_no ='$_POST['account_no']' || account_no='$_POST['account_no2']' && int_id = '$sessint_id' ");
//     if (count([$runaccount]) == 1) {
//         $x = mysqli_fetch_array($runaccount);
//         $brnid = $x['branch_id'];
//         $product_id = $x['product_id'];
//         $acct_b_d = $x['account_balance_derived'];
//         $client_id = $x['client_id'];


//         $test = $_POST['test'];
//         $acct_no = $_POST['account_no'];
//         $amt = $_POST['amount'];
//         $type = $_POST['pay_type'];

//         $test2 = $_POST['test2'];
//         $acct_no2 = $_POST['account_no2'];
//         $amt2 = $_POST['amount2'];
//         $type2 = $_POST['pay_type2'];
//         if ($test == "deposit") {

//             $trancache = "INSERT INTO `transact_cache` (`int_id`, `account_no`, `client_id`, `amount`, `pay_type`, `transact_type`, `product_type`, `status`) VALUES
//             ('{$sessint_id}', '{$acct_no}', '{$client_id}', '{$amt}', '{$type}', 'Deposit', '{$product_id}', 'Not Verified') ";
//             if ($trancache) {
//               echo "<script>".swal({ title:"Done!", text: "Deposit Has Been Done, Awaiting Approval!", type: "success", buttonsStyling: false, confirmButtonClass: "btn btn-success"})."<script>";
//             } else {
//                 echo "<script>".swal({ title:"Error!", text: "Transaction Failed!", type: "error", buttonsStyling: false, confirmButtonClass: "btn btn-success"})."<script>";

//                 if ($connection->error) {
//                     try {
//                         throw new Exception("MYSQL error $connection->error <br> $trancache ", $mysqli->error);
//                     } catch (Exception $e) {
//                         echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
//                         echo n12br($e->getTraceAsString());
//                     }
//             }
//             }
//         } else if ($test == "withdraw") {
//            if ($acct_b_d >= $amt2) {
//             $trancache = "INSERT INTO `transact_cache` (`int_id`, `account_no`, `client_id`, `amount`, `pay_type`, `transact_type`, `product_type`, `status`) VALUES
//             ('{$sessint_id}', '{$acct_no2}', '{$client_id}', '{$amt2}', '{$type2}', 'Withdrawal', '{$product_id}', 'Not Verified') ";
//             if ($trancache) {
//               echo "<script>".swal({ title:"Done!", text: "Withdrawal Has Been Done, Awaiting Approval!", type: "success", buttonsStyling: false, confirmButtonClass: "btn btn-success"})."<script>";
//             } else {
//                 echo "<script>".swal({ title:"Error!", text: "Transaction Failed!", type: "error", buttonsStyling: false, confirmButtonClass: "btn btn-success"})."<script>";

//                 if ($connection->error) {
//                     try {
//                         throw new Exception("MYSQL error $connection->error <br> $trancache ", $mysqli->error);
//                     } catch (Exception $e) {
//                         echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
//                         echo n12br($e->getTraceAsString());
//                     }
//             }
//             }
//            } else {
//             echo "<script>".swal({ title:"Error!", text: "Insufficient Fund", type: "error", buttonsStyling: false, confirmButtonClass: "btn btn-success"})."<script>";
//            }
//         } else {
//             echo "Test is Empty";
//         }
//     }
//     if ($connection->error) {
//             try {
//                 throw new Exception("MYSQL error $connection->error <br> $runaccount ", $mysqli->error);
//             } catch (Exception $e) {
//                 echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
//                 echo n12br($e->getTraceAsString());
//             }
//     }
// }
?>
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title">Deposit Cash</h4>
                        <!-- <p class="card-category">Fill in all important data</p> -->
                      </div>
                      <div class="card-body">
                          <form method="post">
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Account Number</label>
                                         <input type="text" class="form-control" name="test" hidden value="deposit">
                                         <input type="text" class="form-control" name="account_no" value="">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Amount</label>
                                         <input type="number" class="form-control" name="amount" value="">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Type</label>
                                         <input type="type" class="form-control" name="pay_type" value="Cash">
                                      </div>
                                  </div>
                              </div>
                              <button type="reset" class="btn btn-danger">Reset</button>
                              <button type="submit" class="btn btn-primary pull-right">Submit</button>
                              <div class="clearfix"></div>
                          </form>
                      </div>
                  </div>
              </div>
              <!-- sweet alert -->
              <!-- <button class="btn btn-primary btn-fill" onclick='swal({ title:"Good job!", text: "You clicked the button!", type: "success", buttonsStyling: false, confirmButtonClass: "btn btn-success"})'>Try me!</button> -->
              <div class="col-md-12">
                  <div class="card">
                  <div class="card-header card-header-primary">
                        <h4 class="card-title">Withdraw Cash</h4>
                        <!-- <p class="card-category">Fill in all important data</p> -->
                      </div>
                      <div class="card-body">
                        <form method="post">
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Account No</label>
                                         <input type="text" class="form-control" name="test2" hidden value="withdraw">
                                         <input type="text" class="form-control" name="account_no2" value="">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Amount</label>
                                         <input type="number" class="form-control" name="amount2" value="">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Type</label>
                                         <input type="type" class="form-control" name="pay_type2" value="Cheque">
                                      </div>
                                  </div>
                              </div>
                              <button type="reset" class="btn btn-danger">Reset</button>
                              <button type="submit" class="btn btn-primary pull-right">Submit</button>
                              <div class="clearfix"></div>
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