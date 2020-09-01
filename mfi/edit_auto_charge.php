<?php

$page_title = "Edit Auto Charge";
$destination = "products_config.php";
    include("header.php");

    function fill_charge($connection)
    {
        $sint_id = $_SESSION["int_id"];
        $org = "SELECT * FROM charge WHERE int_id = '$sint_id'";
        $res = mysqli_query($connection, $org);
        $out = '';
        while ($row = mysqli_fetch_array($res))
        {
        $out .= '<option value="'.$row["id"].'">' .$row["name"]. '</option>';
        }
        return $out;
    }
?>
<?php
$sint = $_SESSION['int_id'];
$id = $_GET['edit'];

$fdio = "SELECT * FROM auto_charge WHERE id = '$id'";
$fjoed = mysqli_query($connection, $fdio);
$a = mysqli_fetch_array($fjoed);
        $name = $a['name'];
        $charge_type = $a['charge_type'];
        $amount = $a['amount'];
        $fee = $a['fee_on_day'];
        $charge_option = $a['charge_cal'];
        $active = $a['is_active'];
        $override = $a['allow_override'];
        $income_gl = $a["gl_code"];
?>
<?php
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
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create Charge</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/auto_charge_upload.php" method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" value="<?php echo $name; ?>" name="name" class="form-control"/>
                        </div>
                      </div>
                      </div>
                      <div class="row" id="qwo">
                      <div class="col-md-4">
<div class="form-group">
    <label class="bmd-label-floating">Charge Type</label>
    <select name="charge_type" id="" class="form-control">
        <option hidden value="<?php echo $charge_type;?>"><?php echo $charge_typeb?></option>
        <option value="1">Disbursement</option>
        <option value="2">Specified Due Date</option>
        <option value="3">Installment Fees</option>
        <option value="4">Overdue Installment Fees</option>
        <option value="5">Disbursement - Paid with Repayment</option>
        <option value="6">Loan Rescheduliing Fee</option>
        <option value="7">Transaction</option>
    </select>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
    <label class="bmd-label-floating">Amount</label>
    <input type="number" value = "<?php echo $amount;?>" class="form-control" name="amount">
</div>
</div>
<div class=" col-md-4 form-group">
    <label for="bmd-label-floating">Charge Option</label>
    <select name="charge_option" id="" class="form-control">
        <option hidden value="<?php echo $charge_option;?>"><?php echo $charge_optionb;?></option>
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
    <label for="bmd-label-floating">Fee Day</label>
    <input type="number" value="<?php echo $fee;?>" name="days" class="form-control"/>
</div>
<div class=" col-md-4 form-group">
<?php
        function fill_in($connection)
        {
        $sint_id = $_SESSION["int_id"];
        $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && parent_id !='0' && classification_enum = '4' && disabled = '0' ORDER BY gl_code ASC";
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
    <select name="Income_gl" id="" class="form-control">
        <option value="">Choose Income Account Gl</option>
        <?php echo fill_in($connection) ?>
    </select>
</div>
<div class=" col-md-2 form-group">
<div class="form-check form-check-inline">
    <label class="form-check-label">
        <input class="form-check-input" <?php echo $checked;?> name="is_active" type="checkbox" value="1">
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
        <input class="form-check-input" <?php echo $checking;?> name="allow_over" type="checkbox" value="1">
        Allowed to Override
        <span class="form-check-sign">
            <span class="check"></span>
        </span>
    </label>
</div>
</div>
                      </div>
                      <a href="products_config.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Create Charge</button>
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