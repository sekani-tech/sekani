<?php

$page_title = "View Charge";
$destination = "products_config.php";
    include("header.php");

?>
<?php
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $sessint_id = $_SESSION['int_id'];
    $query = "SELECT * FROM charge WHERE id = '$id' && int_id ='$sessint_id'";
    $chargequery = mysqli_query($connection, $query);
    if (count([$chargequery])) {
        $a = mysqli_fetch_array($chargequery);
        $name = $a['name'];
        $product = $a['charge_applies_to_enum'];
        $charge_type = $a['charge_time_enum'];
        $amount = $a['amount'];
        $charge_payment = $a['charge_payment_mode_enum'];
        $charge_option = $a['charge_calculation_enum'];
        $penalty = $a['is_penalty'];
        $active = $a['is_active'];
        $override = $a['allow_override'];
    }
}
?>
<?php
// Query for the production options
    if($product == 1){
        $productb = 'Loan';
    }
    else if($product == 2){
        $productb = 'Savings';  
    }
    else if($product == 3){
        $productb = 'Shares'; 
    }
    
    // Query for Charge type
    if($charge_type == 1){
        $charge_typeb = 'Disbursement';
    }
    else if($charge_type == 2){
        $charge_typeb = 'Specified Due Date';  
    }
    else if($charge_type == 3){
        $charge_typeb = 'Installment Fees'; 
    }
    else if($charge_type == 4){
        $charge_typeb = 'Disbursement - Paid with Repayment'; 
    }
    else if($charge_type == 5){
        $charge_typeb = 'Disbursement - Paid with Repayment'; 
    }
    else if($charge_type == 6){
        $charge_typeb = 'Loan Rescheduling Fee'; 
    }
// Query for charge option
    if($charge_option == 1){
        $charge_optionb = 'Flat';
    }
    else if($charge_option == 2){
        $charge_optionb = 'Principal Due';  
    }
    else if($charge_option == 3){
        $charge_optionb = 'Principal + Interest Due on Installment';  
    }
    else if($charge_option == 4){
        $charge_optionb = 'Interest Due on Installment';  
    }
    else if($charge_option == 5){
        $charge_optionb = 'Total Oustanding Loan Principal';  
    }
    else if($charge_option == 6){
        $charge_optionb = 'Original Loan Principal';  
    }
    if($charge_payment == 1){
        $charge_paymentb = 'Regular';
    }
    else if($charge_payment == 2){
        $charge_paymentb = 'Account_transfer';  
    }
    else{
        $charge_paymentb = 'Regular';  
    }
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Update Charge</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/charge_upload.php" method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input readonly type="text" value="<?php echo $name;?>" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating">Product</label>
                          <select readonly name="product" id="" class="form-control">
                              <option value="<?php echo $product ;?>"><?php echo $productb ;?></option>
                              <option value="1">Loan</option>
                              <option value="2">Savings</option>
                              <option value="3">Shares</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Charge Type</label>
                          <select readonly name="charge_type" id="" class="form-control">
                             <option value="<?php echo $charge_type;?>" ><?php echo $charge_typeb;?></option>
                              <option value="1">Disbursement</option>
                              <option value="2">Specified Due Date</option>
                              <option value="3">Installment Fees</option>
                              <option value="4">Overdue Installment Fees</option>
                              <option value="5">Disbursement - Paid with Repayment</option>
                              <option value="6">Loan Rescheduling Fee</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input readonly value="<?php echo $amount;?>" type="number" class="form-control" name="amount">
                        </div>
                      </div>
                      <div class=" col-md-4 form-group">
                          <label for="bmd-label-floating">Charge Option</label>
                          <select readonly name="charge_option" id="" class="form-control">
                              <option value="<?php echo $charge_option;?>"><?php echo $charge_optionb;?></option>
                              <option value="1">Flat</option>
                              <option value="2">Principal Due</option>
                              <option value="3">Principal + Interest Due on Installment</option>
                              <option value="4">Interest Due on Installment</option>
                              <option value="5">Total Oustanding Loan Principal</option>
                              <option value="6">Original Loan Principal</option>
                          </select>
                      </div>
                      <div class=" col-md-4 form-group">
                          <label for="bmd-label-floating">Charge Payment Mode</label>
                          <select readonly name="charge_payment" id="" class="form-control">
                              <option value="<?php echo $charge_payment;?>"><?php echo $charge_paymentb;?></option>
                              <option value="1">Regular</option>
                              <option value="2">Account Transfer</option>
                          </select>
                      </div>
                      <div class=" col-md-4 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="" type="checkbox" value="1">
                                Penalty
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        </div>
                        <div class=" col-md-4 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="" type="checkbox" value="1">
                                Active
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        </div>
                        <div class=" col-md-4 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="" type="checkbox" value="1">
                                Allowed to Override
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                      </div>
                      </div>
                      <a href="products_config.php" class="btn btn-secondary">Back</a>
                    <!-- <button type="submit" class="btn btn-primary pull-right">Create Charge</button> -->
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