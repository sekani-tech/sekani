<?php

$page_title = "Valut Transaction";
$destination = "index.php";
    include("header.php");
$staff_id = $_SESSION["staff_id"];
?>
<!-- Content added here -->
<?php
// right now we will program
// first step - check if this person is authorized
// check the branch_name
// check the current balance
$getpermission = mysqli_query($connection, "SELECT * FROM `permisson` WHERE staff_id = '$staff_id' && int_id = '$sessint_id'");


// when posting you can now check again who posted if the person is authorized or not
// then we will do the transaction - stored 
// then if will reflect inside of int_transaction for the teller that will be picked
// then you can display a message that the transaction is successful.
?>
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Valut Transaction (In & Out)</h4>
                  <!-- <p class="card-category">Fill in all important data</p> -->
                </div>
                <div class="card-body">
                  <form action="" method="post">
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating"> Transaction Type</label>
                          <select name="type" id="" class="form-control">
                            <option value="0">SELECT A TRANSACTION TYPE IN/OUT</option>
                            <option value="valut_in">DEPOSIT INTO VALUT</option>
                            <option value="valut_out">WITHDRAW FROM VALUT</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Branch Name</label>
                          <!-- populate available balance -->
                          <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating"> Teller Name</label>
                          <input type="text" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="number" name="" id="" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Current Balance</label>
                          <!-- populate available balance -->
                          <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Transaction id</label>
                          <!-- populate available balance -->
                          <input type="text" name="" id="" class="form-control" readonly>
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