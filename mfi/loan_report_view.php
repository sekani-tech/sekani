<?php

$page_title = "Loan Report";
$destination = "report_loan_view.php?view16";
    include("header.php");

?>
<?php 
$sint_id = $_SESSION['int_id'];
$id = $_GET['edit'];
$data = mysqli_query($connection, "SELECT * FROM loan WHERE id = '$id ' AND int_id = '$sint_id'");
$w = mysqli_fetch_array($data);

$name = $w['client_id'];
$anam = mysqli_query($connection, "SELECT branch_id, firstname, lastname FROM client WHERE id = '$name'");
$f = mysqli_fetch_array($anam);
$nae = strtoupper($f["firstname"]." ".$f["lastname"]);
$branc = $f['branch_id'];

$dom = $w['loan_officer'];
$sasa = mysqli_query($connection, "SELECT display_name FROM staff WHERE id = '$dom'");
$gd = mysqli_fetch_array($sasa);
$kdm = strtoupper($gd["display_name"]);

$prod = $w['product_id'];
$slll = mysqli_query($connection, "SELECT name FROM savings_product WHERE id = '$prod'");
$gsd = mysqli_fetch_array($slll);
$loanprod = strtoupper($gsd["name"]);

$col = $w['col_id'];
$cold = mysqli_query($connection, "SELECT id, value, type FROM collateral WHERE id = '$col'");
$do = mysqli_fetch_array($cold);
$colvalue = strtoupper($do["type"]);

$clis = $w['client_id'];
$ccd = mysqli_query($connection, "SELECT * FROM loan_gaurantor WHERE client_id = '$clis'");
$gau = mysqli_num_rows($ccd);

$dom = $w['loan_sub_status_id'];
if($dom == 1){
$loan_sec = "Agriculture, Mining & Quarry";
}
else if($dom == 2){
  $loan_sec = "Manufacturing";
}
else if($dom == 3){
  $loan_sec = "Agricultural sector";
}
else if($dom == 4){
  $loan_sec = "Banking";
}
else if($dom == 5){
  $loan_sec = "Public Service";
}
else if($dom == 6){
  $loan_sec = "Health";
}
else if($dom == 7){
  $loan_sec = "Education";
}
else if($dom == 8){
  $loan_sec = "Tourism";
}
else if($dom == 9){
  $loan_sec = "Civil Service";
}
else if($dom == 10){
  $loan_sec = "Trade & Commerce";
}
else if($dom == 11){
  $loan_sec = "Others";
}
else{
  $loan_sec = "Others";
}

$principal = $w['principal_amount'];
$account = $w['account_no'];
$loanterm = $w['loan_term'];
$interest = $w['interest_rate'];
$repayment = $w['repayment_date'];
$repay_no = $w['number_of_repayments'];
$repayever = $w['repay_every'];
$disburse = $w['disbursement_date'];
?>
<input type="text" hidden id = "principal_amount" value="<?php echo $principal;?>" name=""/>
<input type="text" hidden id = "loan_term" value="<?php echo $loanterm;?>" name=""/>
<input type="text" hidden id = "interest_rate" value="<?php echo $interest;?>" name=""/>
<input type="text" hidden id = "repay_start" value="<?php echo $repayment;?>" name=""/>
<input type="text" hidden id = "repay" value="<?php echo $repay_no;?>" name=""/>
<input type="text" hidden id = "disb_date" value="<?php echo $disburse;?>" name=""/>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <!-- <span class="nav-tabs-title">Configuration:</span> -->
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <!-- <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Password Settings
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link active" href="#summary" data-toggle="tab">
                          <!-- visibility -->
                            <i class="material-icons">analytics</i> Summary
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#details" data-toggle="tab">
                            <i class="material-icons">toc</i> Details
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="uxu" href="#repoay" data-toggle="tab">
                            <i class="material-icons">table_view</i>Repayment Schedule
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#transact" data-toggle="tab">
                            <i class="material-icons">account_balance_wallet</i> Transactions
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#secure" data-toggle="tab">
                            <i class="material-icons">security</i> Security
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="summary">
                    <div class="col-md-12">
                    <div class="row">
                         
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Status</h4></div>
                          <div style = "color:green" class="col-md-3">Active</div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Client Name</h4></div>
                          <div class="col-md-3"><?php echo $nae;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Account Officer</h4></div>
                          <div class="col-md-3"><?php echo $kdm;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Loan Cycle</h4></div>
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Date Disbursed</h4></div>
                          <div class="col-md-3"><?php echo $disburse;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Timely Repayments</h4></div>
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Last Payment</h4></div>
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Amount in Arrears</h4></div>
                          <div class="col-md-3"><?php echo $principal;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Next Payment</h4></div>
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Days in Arrears</h4></div>
                          <div class="col-md-3"><?php echo $loanterm;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Final Payment Expected</h4></div>
                          <div class="col-md-3"><?php echo $repayment;?></div>
                      </div>
                      </div>
                      <table class="table table-bordered">
                        <thead>
                        <?php
                        $query = "SELECT * FROM loan WHERE id = '$id' AND int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                            <tr>
                                <th>Principal</th>
                                <th>Interest</th>
                                <th>Fees</th>
                                <th>Penalties</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <td><?php echo $row["principal_amount"]; ?></td>
                          <td><?php echo $row["interest_rate"]; ?></td>
                          <td><?php echo $row["fee_charges_outstanding_derived"]; ?></td>
                          <td><?php echo $row["penalty_charges_outstanding_derived"];?></td>
                         </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                      </table>
                    </div>
                    <!-- /items report-->
                    <div class="tab-pane" id="details">
                    <div class="col-md-12">
                    <div class="row">
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Loan Product</h4></div>
                          <div class="col-md-3"><?php echo $loanprod; ?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Loan Amount</h4></div>
                          <div class="col-md-3"><?php echo $disburse;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Business Expansion</h4></div>
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Interest Rate</h4></div>
                          <div class="col-md-3"><?php echo $interest;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">APR</h4></div>
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Loan Term</h4></div>
                          <div class="col-md-3"><?php echo $loanterm;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">EIR</h4></div>
                          <div class="col-md-3"></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Repayment Every</h4></div>
                          <div class="col-md-3"><?php echo $repay_no." ".$repayever;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Loan Sector</h4></div>
                          <div class="col-md-3"><?php echo $loan_sec;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Linked Account</h4></div>
                          <div class="col-md-3"><?php echo $account;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">No of Gaurantors</h4></div>
                          <div class="col-md-3"><?php echo $gau;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Repayment Date</h4></div>
                          <div class="col-md-3"><?php echo $repayment;?></div>
                          <div class="col-md-3"><h4 style="text-align:right;" class="card-title">Collateral Value</h4></div>
                          <div class="col-md-3"><?php echo $colvalue;?></div>
                      </div>
                      </div>
                      <table class="table table-bordered">
                        <thead>
                        <?php
                        $query = "SELECT * FROM prod_acct_cache WHERE id = '$id' AND int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Collected On</th>
                                <th>Payment Mode</th>
                                <th>Charge Type</th>
                                <th>Waive Penalty</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <td><?php echo $nae; ?></td>
                          <td><?php echo $row["account_no"]; ?></td>
                          <td><?php echo $row["principal_amount"]; ?></td>
                          <td><?php echo $row["repayment_date"];?></td>
                          <!-- <td><?php echo $row["payment_mode"]; ?></td> -->
                          <td><?php echo $row["fee_charges_outstanding_derived"]; ?></td>
                          <td><?php echo $row["penalty_charges_outstanding_derived"];?></td>
                         </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="repoay">
                    <div class="form-group">
                      <script>
                             $(document).ready(function() {
                            $('#uxu').on("change keyup paste click", function(){
                            var id = $(this).val();
                            var ist = $('#int_id').val();
                            var prina = $('#principal_amount').val();
                            var loant = $('#loan_term').val();
                            var intr = $('#interest_rate').val();
                            var repay = $('#repay').val();
                            var repay_start = $('#repay_start').val();
                            var disbd = $('#disb_date').val();
                            $.ajax({
                                url:"loan_calculation_table.php",
                                method:"POST",
                                data:{id:id, ist: ist,prina:prina,loant:loant,intr:intr,repay:repay,repay_start:repay_start,disbd:disbd},
                                success:function(data){
                                $('#accname').html(data);
                                }
                            })
                            });
                        });
                     </script>
                            <table id = "accname" class="table table-bordered">

                            </table>
                      </div>
                    </div>
                    <div class="tab-pane" id="transact">
                    <table class="table table-bordered">
                        <thead>
                        <!-- <?php
                        $query = "SELECT * FROM loan_transaction WHERE loan_id = '$id' AND int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?> -->
                            <tr>
                                <th>Date</th>
                                <th>Submitted On</th>
                                <th>Transaction Type</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <td><?php echo $row["transaction_date"]; ?></td>
                          <td><?php echo $row["submitted_on_date"]; ?></td>

                          <td><?php echo $row["transaction_type"]; ?></td>
                          <td><?php echo $row["transaction_id"];?></td>
                          <td><?php echo $row["amount"];?></td>
                          <td><?php echo $row["outstanding_loan_balance_derived"];?></td>
                         </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="secure">
                    <h5><b>Guarantors</b></h5>
                    <table class="table table-bordered">
                        <thead>
                        <?php
                        $query = "SELECT * FROM loan_gaurantor WHERE int_id = '$sessint_id' AND client_id = '$clis'";
                        $result = mysqli_query($connection, $query);
                      ?>
                            <tr>
                                <th>Name</th>
                                <th>Branch Name</th>
                                <th>Amount Gaurantee</th>
                                <th>Office Address</th>
                                <th>Position Held</th>
                                <th>Phone No</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <td><?php echo $row["first_name"]." ".$row["last_name"]; ?></td>
                          <td><?php
                           $rov = mysqli_query($connection, "SELECT * FROM branch WHERE id = '$branc'");
                           $d = mysqli_fetch_array($rov);
                           $rfs = $d['name'];
                          echo $rfs; ?></td>
                          <td><?php $gamount = $w['guarantee_amount_derived']; echo $gamount; ?></td>
                          <td><?php echo $row["office_address"];?></td>
                          <td><?php echo $row["position_held"]; ?></td>
                          <td><?php echo $row["phone"].", ".$row["phone2"]; ?></td>
                          <td><?php echo $row["email"]; ?></td>
                         </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                      </table>
                      <h5>Collateral</h5>
                      <table class="table table-bordered">
                        <thead>
                        <!-- <?php
                        $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id' AND client_id = '$id'";
                        $result = mysqli_query($connection, $query);
                      ?> -->
                            <tr>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <td><?php echo $row["type"]; ?></td>
                          <td><?php echo $row["description"]; ?></td>
                          <td><?php echo $row["value"];?></td>
                         </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>

                      </tbody>
                      </table>
                    </div>
                    
                    <!-- /maturity profile -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / -->
        </div>
      </div>

<?php

    include("footer.php");

?>