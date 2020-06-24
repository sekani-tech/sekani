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
        $income_gl = $a["gl_code"];
        // $fee_m = $a["fee"];
    }
    $select_gl = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE gl_code = '$income_gl' && int_id = '$sessint_id'");
    $xmx = mysqli_fetch_array($select_gl);
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
    else if($product == 4){
        $productb = 'Current'; 
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
    else if($charge_type == 7){
        $charge_typeb = 'Transaction'; 
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
    else if($charge_option == 7){
        $charge_optionb = 'Percentage';  
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
    // Query for Allow Overide
    if($penalty){
        $check = "checked";
    }
    else{
        $check = "unchecked";
    }
    if($override){
        $checking = "checked";
    }
    else{
        $checking = "unchecked";
    }
    if($active){
        $checked = "checked";
    }
    else{
        $checked = "unchecked";
    }
?>
<!-- Content added here -->
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     if (isset($_POST['name']) && isset($_POST['charge_type'])) {
         $charge_n = $_POST["name"];
         $productt = $_POST["product"];
         $charge_t = $_POST["charge_type"];
         $charge_a = $_POST["amount"];
         $charge_o = $_POST["charge_option"];
         $charge_pay = $_POST["charge_payment"];
         $income_account = $_POST["gl_code"];
        //  $fee_new = $a["fee"];
         if(isset($_POST['penalty'])){
            $pena = 1;
         }
         else{
            $pena = 0;
         }
         if(isset($_POST['active'])){
            $act = 1;
         }
         else{
            $act = 0;
         }
         if(isset($_POST['allowed'])){
            $allow = 1;
         }
         else{
            $allow = 0;
         }
         $updat = "UPDATE charge SET name ='$charge_n', charge_applies_to_enum ='$productt', charge_payment_mode_enum ='$charge_pay',
         charge_time_enum ='$charge_t', amount ='$charge_a', charge_calculation_enum ='$charge_o',
         is_active = '$act', is_penalty = '$pena', allow_override = ' $allow', gl_code = '$income_account' WHERE id = '$id' && int_id = '$sessint_id'";
         $updrgoe = mysqli_query($connection, $updat);
         if ($updrgoe) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "success",
                    title: "Charge Updated Successfully",
                    text: "Thank You!",
                    showConfirmButton: false,
                    timer: 2000
                })
            });
            </script>
            ';
            $URL="products_config.php";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
         } else {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "Error in Updating Charge",
                    text: "Call - The System Support",
                    showConfirmButton: false,
                    timer: 2000
                })
            });
            </script>
            ';
            $URL="charge_edit.php?edit=$id";
           echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
         }
     } else {
        //  echo an error that name is not found
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Please check",
                text: "Input a value",
                showConfirmButton: false,
                timer: 2000
            })
        });
        </script>
        ';
     }
 }
?>
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
                  <form method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" value="<?php echo $name;?>" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating">Product Type</label>
                          <select name="product" id="" class="form-control">
                              <option value="<?php echo $product ;?>"><?php echo $productb ;?></option>
                              <option value="1">Loan</option>
                              <option value="2">Savings</option>
                              <option value="3">Shares</option>
                              <option value="4">Current </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Charge Type</label>
                          <select name="charge_type" id="" class="form-control">
                             <option value="<?php echo $charge_type;?>" ><?php echo $charge_typeb;?></option>
                              <option value="1">Disbursement</option>
                              <option value="2">Specified Due Date</option>
                              <option value="3">Installment Fees</option>
                              <option value="4">Overdue Installment Fees</option>
                              <option value="5">Disbursement - Paid with Repayment</option>
                              <option value="6">Loan Rescheduling Fee</option>
                              <option value="7">Transaction</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input value="<?php echo $amount;?>" type="number" class="form-control" name="amount">
                        </div>
                      </div>
                      <div class=" col-md-4 form-group">
                          <label for="bmd-label-floating">Charge Option</label>
                          <select name="charge_option" id="" class="form-control">
                              <option value="<?php echo $charge_option;?>"><?php echo $charge_optionb;?></option>
                              <option value="1">Flat</option>
                              <option value="2">Principal Due</option>
                              <option value="3">Principal + Interest Due on Installment</option>
                              <option value="4">Interest Due on Installment</option>
                              <option value="5">Total Oustanding Loan Principal</option>
                              <option value="6">Original Loan Principal</option>
                              <option value="7">Percentage</option>
                          </select>
                      </div>
                      <div class=" col-md-4 form-group">
                          <label for="bmd-label-floating">Charge Payment Mode</label>
                          <select name="charge_payment" id="" class="form-control">
                              <option value="<?php echo $charge_payment;?>"><?php echo $charge_paymentb;?></option>
                              <option value="1">Regular</option>
                              <option value="2">Account Transfer</option>
                          </select>
                      </div>
                      <div class=" col-md-4 form-group">
                      <?php
                              function fill_in($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '4' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
                          <label for="bmd-label-floating">Income GL</label>
                          <select name="gl_code" id="" class="form-control">
                          <option value="<?php echo $income_gl;?>"><?php echo $xmx["name"]; ?></option>
                              <?php echo fill_in($connection) ?>
                          </select>
                          <!-- heloo -->
                      </div>
                      <div class=" col-md-2 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input <?php echo $check;?> class="form-check-input" name="penalty" type="checkbox">
                                Penalty
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        </div>
                        <div class=" col-md-2 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input <?php echo $checked;?> class="form-check-input" name="active" type="checkbox">
                                Active
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        </div>
                        <div class=" col-md-2 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input <?php echo $checking;?> class="form-check-input" name="allowed" type="checkbox">
                                Allowed to Override
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                      </div>
                      </div>
                      <a href="products_config.php" class="btn btn-secondary">Back</a>
                      <button type="submit" class="btn btn-primary pull-right">Update</button>
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