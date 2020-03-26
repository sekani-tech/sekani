<?php

$page_title = "Edit Product";
$destination = "products.php";
    include("header.php");

?>
<?php
 if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $value = mysqli_query($connection, "SELECT * FROM product WHERE id='$user_id'");

  if (count([$value] == 1)) {
    $n = mysqli_fetch_array($value);
    $int_id = $n['int_id'];
    $charge_id = $n['charge_id'];
    $name = $n['name'];
    $short_name = $n['short_name'];
    $description = $n['description'];
    $fund_id = $n['fund_id'];
    $in_amt_multiples = $n['in_amt_multiples'];
    $principal_amount = $n['principal_amount'];
    $min_principal_amount = $n['min_principal_amount'];
    $max_principal_amount = $n['max_principal_amount'];
    $loan_term = $n['loan_term'];
    $min_loan_term = $n['min_loan_term'];
    $max_loan_term = $n['max_loan_term'];
    $repayment_frequency = $n['repayment_frequency'];
    $repayment_every = $n['repayment_every'];
    $interest_rate = $n['interest_rate'];
    $min_interest_rate = $n['min_interest_rate'];
    $max_interest_rate = $n['max_interest_rate'];
    $interest_rate_applied = $n['interest_rate_applied'];
    $interest_rate_methodology = $n['interest_rate_methodology'];
    $ammortization_method = $n['ammortization_method'];
    $cycle_count = $n['cycle_count'];
    $auto_allocate_overpayment = $n['auto_allocate_overpayment'];
    $additional_charge = $n['additional_charge'];
    $auto_disburse = $n['auto_disburse'];
    $linked_savings_acct = $n['linked_savings_acct'];
  }
}
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Update Branch</h4>
                  <p class="card-category">Modify Branch Data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/product_update.php" method="post">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text" readonly class="form-control" value="<?php echo $user_id; ?>" name="id">
                        </div>
                    </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Institution ID</label>
                          <input type="text" readonly class="form-control" value="<?php echo $int_id; ?>" name="int_id">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Charge ID</label>
                          <input type="text" class="form-control" value="<?php echo $charge_id; ?>" name="charge_id">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" class="form-control" value="<?php echo $name; ?>" name="name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Abbreviation</label>
                          <input type="text" class="form-control" value="<?php echo $short_name; ?>" name="short_name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <input type="text"  class="form-control" value="<?php echo $description; ?>" name="description">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Fund ID</label>
                          <input type="text"  class="form-control" value="<?php echo $fund_id; ?>" name="fund_id">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">initial Amount Multiples</label>
                          <input type="text"  class="form-control" value="<?php echo $in_amt_multiples; ?>" name="in_amt_multiples">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Principal Amount</label>
                          <input type="text"  class="form-control" value="<?php echo $principal_amount; ?>" name="principal_amount">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Min Principal Amount</label>
                          <input type="text"  class="form-control" value="<?php echo $min_principal_amount; ?>" name="min_principal_amount">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Max Principal Amount</label>
                          <input type="text"  class="form-control" value="<?php echo $max_principal_amount; ?>" name="max_principal_amount">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Loan Term</label>
                          <input type="text"  class="form-control" value="<?php echo $loan_term; ?>" name="loan_term">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Min Loan Term</label>
                          <input type="text"  class="form-control" value="<?php echo $min_loan_term; ?>" name="min_loan_term">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Max Loan Term</label>
                          <input type="text"  class="form-control" value="<?php echo $max_loan_term; ?>" name="max_loan_term">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Repayment Frequency</label>
                          <input type="text"  class="form-control" value="<?php echo $repayment_frequency; ?>" name="repayment_frequency">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Repayment Every</label>
                          <input type="text"  class="form-control" value="<?php echo $repayment_every; ?>" name="repayment_every">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Interest Rate</label>
                          <input type="text"  class="form-control" value="<?php echo $interest_rate; ?>" name="interest_rate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Min Interest Rate</label>
                          <input type="text"  class="form-control" value="<?php echo $min_interest_rate; ?>" name="min_interest_rate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Max Interest Rate</label>
                          <input type="text"  class="form-control" value="<?php echo $max_interest_rate; ?>" name="max_interest_rate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Interest Rate Applied</label>
                          <input type="text"  class="form-control" value="<?php echo $interest_rate_applied; ?>" name="interest_rate_applied">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Interest Rate Methodology</label>
                          <input type="text"  class="form-control" value="<?php echo $interest_rate_methodology; ?>" name="interest_rate_methodology">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Ammortization Method</label>
                          <input type="text"  class="form-control" value="<?php echo $ammortization_method; ?>" name="ammortization_method">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Cycle Count</label>
                          <input type="text"  class="form-control" value="<?php echo $cycle_count; ?>" name="cycle_count">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Auto Allocate Overpayment</label>
                          <input type="text"  class="form-control" value="<?php echo $auto_allocate_overpayment; ?>" name="auto_allocate_overpayment">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Additional Charge</label>
                          <input type="text"  class="form-control" value="<?php echo $additional_charge; ?>" name="additional_charge">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Auto Disburse</label>
                          <input type="text"  class="form-control" value="<?php echo $auto_disburse; ?>" name="auto_disburse">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Linked Savings Account</label>
                          <input type="text"  class="form-control" value="<?php echo $linked_savings_acct; ?>" name="linked_savings_acct">
                        </div>
                    </div>
                      </div>
                    <button type="submit" class="btn btn-primary pull-right">Update Product</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../assets/img/faces/marc.jpg" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <?php
                $fullname = $_SESSION["fullname"];
                $sessint_id = $_SESSION["int_id"];
                $org_role = $_SESSION["org_role"];
                ?>
                <div class="card-body">
                  <h6 class="card-category text-gray"><?php echo $org_role?></h6>
                  <h4 class="card-title"> <?php echo $fullname?></h4>
                  <p class="card-description">
                  <?php echo $int_name?>
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
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