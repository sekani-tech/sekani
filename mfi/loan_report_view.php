<?php

$page_title = "Loan Report";
$destination = "report_loan_view.php?view16";
include("header.php");

if(isset($_SESSION["repayment_updated"])) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
    swal({
      type: "success",
      title: "Successfully Updated Repayment",
      text: "Thank you for Updating",
      showConfirmButton: false,
      timer: 3000
    })
  });
  </script>
  ';
  unset($_SESSION["repayment_updated"]);
}

if(isset($_SESSION["repayment_not_updated"])) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
    swal({
      type: "error",
      title: "Error in Updating Repayment",
      text: "Check your Input",
      showConfirmButton: false,
      timer: 3000
    })
  });
  </script>
  ';
  unset($_SESSION["repayment_not_updated"]);
}

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
$intamt = ($interest/100) * $principal;
$first_repayment_date = $w['repayment_date'];
$repay_no = $w['number_of_repayments'];
$repayever = $w['repay_every'];
$disburse = $w['disbursement_date'];
$fee_charges = $w['fee_charges_charged_derived'];
$penalty_charges = $w['penalty_charges_charged_derived'];
$princi_repaid = $w['principal_repaid_derived'];
$int_repaid = $w['interest_repaid_derived'];
$fees_repaid = $w['fee_charges_repaid_derived'];
$penal_repaid = $w['penalty_charges_repaid_derived'];
$principal_out = $w['principal_outstanding_derived'];
$int_out = $w['interest_outstanding_derived'];
$fee_out = $w['fee_charges_outstanding_derived'];
$penal_out = $w['penalty_charges_outstanding_derived'];
$overdue = $w['total_waived_derived'];

/* contract */
$query_sum_principal = mysqli_query($connection, "SELECT principal_amount_proposed FROM `loan` WHERE int_id = '$sessint_id' AND id = '$id'");
$qpo = mysqli_fetch_array($query_sum_principal);
$contract_principal = number_format($qpo["principal_amount_proposed"], 2);

$query_sum_interest =  mysqli_query($connection, "SELECT SUM(interest_amount) AS contract_interest FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$id'");
$qpox = mysqli_fetch_array($query_sum_interest);
$contract_interest = number_format($qpox["contract_interest"], 2);


/* paid */
$query_principal_paid = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$id' AND installment = 0");
if (mysqli_num_rows($query_principal_paid) > 0) {
  while ($qps = mysqli_fetch_array($query_principal_paid)) {
    // make an arrears search
    $pd_loan_id = $qps["id"];
    $query_arrears_loan  = mysqli_query($connection, "SELECT * FROM `loan_arrear` WHERE loan_id = '$pd_loan_id' AND int_id = '$sessint_id'");

    if (mysqli_num_rows($query_arrears_loan) > 0) {
      echo "x";
      
    } else {
      $query_paid_principal = mysqli_query($connection, "SELECT SUM(principal_amount) as principal_amount, SUM(principal_completed_derived) AS principal_outstanding FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$id'");
      $mmx = mysqli_fetch_array($query_paid_principal);
      $paid_principal = $mmx["principal_amount"] - $mmx["principal_outstanding"];
      $paid_principal = number_format($paid_principal, 2);

      $query_paid_interest = mysqli_query($connection, "SELECT SUM(interest_amount) as interest_amount, SUM(interest_completed_derived) AS interest_outstanding FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$id'");
      $mmxx = mysqli_fetch_array($query_paid_interest);
      $paid_interest = $mmxx["interest_amount"] - $mmxx["interest_outstanding"];
      $paid_interest = number_format($paid_interest, 2);
    }
  }
} else {
  $paid_principal = "0.00";
  $paid_interest = "0.00";
}

/* outstanding */
$date_new = date('Y-m-d');
$query_principal_outstanding = mysqli_query($connection, "SELECT principal_outstanding_derived FROM `loan` WHERE int_id = '$sessint_id' AND id = '$id'");
$desx = mysqli_fetch_array($query_principal_outstanding);
$outstanding_principal_x = number_format(round($desx["principal_outstanding_derived"]), 2);

$query_interest_outstanding = mysqli_query($connection, "SELECT interest_outstanding_derived FROM `loan` WHERE int_id = '$sessint_id' AND id = '$id'");
$desxxx = mysqli_fetch_array($query_interest_outstanding);
$outstanding_interest_x = number_format($desxxx["interest_outstanding_derived"], 2);


/* overdue */
$query_overdue_principal = mysqli_query($connection, "SELECT SUM(principal_amount) AS overdue_principal FROM `loan_arrear` WHERE int_id = '$sessint_id' AND loan_id = '$id'");
$wty = mysqli_fetch_array($query_overdue_principal);
$overdue_principal = $wty["overdue_principal"];

$query_overdue_interest = mysqli_query($connection, "SELECT SUM(interest_amount) AS overdue_interest FROM `loan_arrear` WHERE int_id = '$sessint_id' AND loan_id = '$id'");
$wtyx = mysqli_fetch_array($query_overdue_interest);
$overdue_interest = $wtyx["overdue_interest"];

?>
<input type="text" hidden id = "principal_amount" value="<?php echo $principal;?>" name=""/>
<input type="text" hidden id = "loan_term" value="<?php echo $loanterm;?>" name=""/>
<input type="text" hidden id = "interest_rate" value="<?php echo $interest;?>" name=""/>
<input type="text" hidden id = "repay_start" value="<?php echo $first_repayment_date;?>" name=""/>
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
                        <li class="nav-item">
                          <a class="nav-link active" href="#summary" data-toggle="tab">
                          <!-- visibility -->
                            <i class="material-icons">analytics</i> Summary
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <!-- <li class="nav-item">
                          <a class="nav-link" href="#details" data-toggle="tab">
                            <i class="material-icons">toc</i> Details
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link" href="#secure" data-toggle="tab">
                            <i class="material-icons">security</i> Security
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="uxu" href="#repoay" data-toggle="tab">
                            <i class="material-icons">table_view</i>Repayment Schedule
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <!-- <li class="nav-item">
                            <i class="material-icons">account_balance_wallet</i> Transactions
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="summary">
                      <div class="col-12">
                        <div class="row">
                          <style>
                            b{
                              font-weight: 100px;
                            }
                          </style>

                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Status</h4></b>
                          </div>
                          <div class="col-md-3" style="color:green">
                            <?php
                              $today = date('Y-m-d');
                              $thirty_days_before_today = date("Y-m-d", strtotime("-30 Days", strtotime($today)));
                              $loan_id = $_GET["edit"];

                              $performingQuery = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND loan_id NOT IN (SELECT loan_id FROM loan_arrear) AND installment >= '1' AND (duedate BETWEEN '$thirty_days_before_today' AND '$today')";
                              // *(duedate BETWEEN '$thirty_days_before_today' AND '$today')
                              $performing = mysqli_query($connection, $performingQuery);
                              $performing = mysqli_fetch_array($performing);
                              $performing_principal = $performing['principal_amount'];
                              if($performing_principal != '') {
                                echo "<b>Performing</b>";
                              }

                              $pandwQuery = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1' AND (counter BETWEEN '31' AND '60') AND (duedate BETWEEN '$thirty_days_before_today' AND '$today')";
                              $pandw = mysqli_query($connection, $pandwQuery);
                              $pandw = mysqli_fetch_array($pandw);
                              $pandw_principal = $pandw['principal_amount'];
                              if($pandw_principal != '') {
                                echo "<b>Pass and Watch</b>";
                              }

                              $substandardQuery = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1' AND (counter BETWEEN '61' AND '90') AND (duedate BETWEEN '$thirty_days_before_today' AND '$today')";
                              $substandard = mysqli_query($connection, $substandardQuery);
                              $substandard = mysqli_fetch_array($substandard);
                              $substandard_principal = $substandard['principal_amount'];
                              if($substandard_principal != '') {
                                echo "<b>Substandard</b>";
                              }

                              $doubtfulQuery = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1' AND (counter BETWEEN '91' AND '180') AND (duedate BETWEEN '$thirty_days_before_today' AND '$today')";
                              $doubtful = mysqli_query($connection, $doubtfulQuery);
                              $doubtful = mysqli_fetch_array($doubtful);
                              $doubtful_principal = $doubtful['principal_amount'];
                              if($doubtful_principal != '') {
                                echo "<b>Doubtful</b>";
                              }

                              $lostQuery = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1' AND counter > '180' AND (duedate BETWEEN '$thirty_days_before_today' AND '$today')";
                              $lost = mysqli_query($connection, $lostQuery);
                              $lost = mysqli_fetch_array($lost);
                              $lost_principal = $lost['principal_amount'];
                              if($lost_principal != '') {
                                echo "<b>Lost</b>";
                              }
                            ?>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="font-weight: 100px; text-align:right;" class="card-title">Client Name</h4></b>
                          </div>
                          <div class="col-md-3">
                            <b><?php echo $nae;?></b>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Account Officer</h4></b>
                          </div>
                          <div class="col-md-3">
                            <?php echo $kdm;?>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Loan Cycle</h4></b>
                          </div>
                          <div class="col-md-3">
                            <?php echo $loanterm;?>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Date Disbursed</h4></b>
                          </div>
                          <div class="col-md-3">
                            <?php echo $disburse;?>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Timely Repayments</h4></b>
                          </div>
                          <div class="col-md-3">
                            <?php
                              // Query below is meant to calculate timely repayments for a client who has taken one or more loans
                              // $query = "SELECT * FROM loan_repayment_schedule l JOIN client c ON l.client_id = c.id WHERE l.client_id = '$client_id' AND duedate >= obligations_met_on_date";

                              // Query below is meant to calculate timely repayments for a specific loan taken
                              $loan_id = $_GET["edit"];
                              $query = "SELECT * FROM loan_repayment_schedule WHERE loan_id = '$loan_id' AND duedate >= obligations_met_on_date";
                              $result = mysqli_query($connection, $query);

                              if(mysqli_num_rows($result) > 0) {
                                $timely_repayments = mysqli_num_rows($result);
                              } else {
                                $timely_repayments = 0;
                              }

                              echo $timely_repayments;
                            ?>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Last Payment</h4></b>
                          </div>
                          <div class="col-md-3">
                            <?php
                              $loan_id = $_GET["edit"];
                              $query = "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' ORDER BY id DESC LIMIT 1";
                              $result = mysqli_query($connection, $query);
                              if(mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_array($result);
                                $lastPayment = $row['principal_completed_derived'] + $row['interest_completed_derived'] + $row['penalty_charges_completed_derived'];
                                echo '&#x20A6; ' . number_format($lastPayment, 2);
                              } else {
                                echo 'NIL';
                              }
                            ?>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Amount in Arrears</h4></b>
                          </div>
                          <div class="col-md-3">
                            <?php echo '&#x20A6; ' . number_format(round($overdue_principal + $overdue_interest), 2); ?>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Next Payment</h4></b>
                          </div>
                          <div class="col-md-3">
                              <?php
                                $today = date('Y-m-d');
                                $query = "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND duedate < '$today'";
                                $result = mysqli_query($connection, $query);

                                $principal_outstanding_derived = 0;
                                $interest_outstanding_derived = 0;
                                $fee_charges_outstanding_derived = 0;
                                $penalty_charges_outstanding_derived = 0;

                                while($row = mysqli_fetch_array($result)) {
                                  $principal_outstanding_derived += $row['principal_amount'];
                                  $interest_outstanding_derived += $row['interest_amount'];
                                  $fee_charges_outstanding_derived += $row['fee_charges_amount'];
                                  $penalty_charges_outstanding_derived += $row['penalty_charges_amount'];
                                }

                                $outstanding_derived1 = $principal_outstanding_derived + $interest_outstanding_derived + $fee_charges_outstanding_derived + $penalty_charges_outstanding_derived;
                                  
                                $query = "SELECT * FROM `loan_repayment_schedule` where loan_id = '$loan_id' AND duedate >= '$today' ORDER BY id LIMIT 1";
                                $result = mysqli_query($connection, $query);

                                if(mysqli_num_rows($result) > 0) {
                                  $row = mysqli_fetch_array($result);
                                  $principal_outstanding_derived = $row['principal_amount'];
                                  $interest_outstanding_derived = $row['interest_amount'];
                                  $fee_charges_outstanding_derived = $row['fee_charges_amount'];
                                  $penalty_charges_outstanding_derived = $row['penalty_charges_amount'];
                                } else {
                                  $principal_outstanding_derived = 0;
                                  $interest_outstanding_derived = 0;
                                  $fee_charges_outstanding_derived = 0;
                                  $penalty_charges_outstanding_derived = 0;
                                }

                                $outstanding_derived2 = $principal_outstanding_derived + $interest_outstanding_derived + $fee_charges_outstanding_derived + $penalty_charges_outstanding_derived;

                                $next_payment = $outstanding_derived1 + $outstanding_derived2;

                                echo '&#x20A6; ' . number_format(round($next_payment), 2);
                              ?>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Days in Arrears</h4></b>
                          </div>
                          <div class="col-md-3">
                            <?php
                              $daysInArrears = mysqli_query($connection, "SELECT counter FROM loan_arrear WHERE loan_id = '$id'");
                              if(mysqli_num_rows($daysInArrears) > 0) {
                                $daysInArrears = mysqli_fetch_array($daysInArrears);
                                echo $daysInArrears["counter"];
                              } else {
                                echo "0";
                              }
                            ?>
                          </div>
                          <div class="col-md-3">
                            <b><h4 style="text-align:right;" class="card-title">Final Payment Expected</h4></b>
                          </div>
                          <div class="col-md-3">
                            <?php
                              $final_repayment_date = date("Y-m-d", strtotime("+" . $loanterm - 1 . "Months", strtotime($first_repayment_date)));
                              echo $final_repayment_date;
                            ?>
                          </div>
                        </div>
                      </div>
                      <table class="table table-bordered mt-4">
                        <thead>
                          <tr>
                              <th></th>
                              <th>Contract</th>
                              <th>Paid</th>
                              <th>Outstanding</th>
                              <th>Overdue</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <th>Principal</th>
                              <th> <?php echo "₦ ".$contract_principal;?></th>
                              <th> <?php echo "₦ ".$paid_principal;?></th>
                              <th> <?php echo "₦ ".$outstanding_principal_x;?></th>
                              <th> <?php echo "₦ ".number_format(round($overdue_principal), 2);?></th></th>
                          </tr>
                          <tr>
                              <th>Interest</th>
                              <th> <?php echo "₦ ".$contract_interest;?></th>
                              <th> <?php echo "₦ ".$paid_interest;?></th>
                              <th> <?php echo "₦ ".$outstanding_interest_x;?></th>
                              <th> <?php echo "₦ ".number_format(round($overdue_interest), 2);?></th></th>
                          </tr>
                          <tr>
                              <th>Fees</th>
                              <th> <?php echo "₦ ".$fee_charges;?></th>
                              <th> <?php echo "₦ ".$fee_out;?></th>
                              <th> <?php echo "₦ ".$princi_repaid;?></th>
                              <th> <?php echo "₦ ".$overdue;?></th></th>
                          </tr>
                          <tr>
                              <th>Penalties</th>
                              <th> <?php echo "₦ ".$penalty_charges;?></th>
                              <th> <?php echo "₦ ".$penal_repaid;?></th>
                              <th> <?php echo "₦ ".$penal_out;?></th>
                              <th> <?php echo "₦ ".$overdue;?></th></th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- /items report-->
                    <!-- <div class="tab-pane" id="transact">
                    <table class="table table-bordered">
                      </tbody>
                      </table>
                    </div> -->
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
                      <h5> <b> Collateral</b></h5>
                      <table class="table table-bordered">
                        <thead>
                        <!-- <?php
                        $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'";
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
                    <div class="tab-pane" id="repoay">
                    <?php
                    if (isset($_GET["edit"]) AND $_GET["edit"] != "") {
                        $loan_id = $_GET["edit"];
                        $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE int_id = '$sessint_id' AND id = '$loan_id'");
                        $x = mysqli_fetch_array($query_loan);
                        $client_id = $x["client_id"];
                        $query_client = mysqli_query($connection, "SELECT * FROM client WHERE id ='$client_id' AND int_id = '$sessint_id'");
                        $cm = mysqli_fetch_array($query_client);
                        $firstname = strtoupper($cm["firstname"]." ".$cm["lastname"]);
                        $account_no = $x["account_no"];
                    
                        $sum_tot = mysqli_query($connection, "SELECT SUM(principal_amount) AS prin_sum FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
                        $sum_tott = mysqli_query($connection, "SELECT SUM(interest_amount) AS int_sum FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
                        $st = mysqli_fetch_array($sum_tot);
                        $stt = mysqli_fetch_array($sum_tott);
                        $outp = $st["prin_sum"];
                        $outt = $stt["int_sum"];
                        $duebalance = $outp + $outt;
                    ?>
                <!-- do your front end -->
                <div class="content">
                        <div class="container-fluid">
                          <!-- your content here -->
                          <div class="row">
                            <div class="col-md-12">
                              <div class="card">
                                <!-- end -->
                                <div class="card card-profile ml-auto mr-auto" style="max-width: 360px; max-height: 360px">
                    <div class="card-body ">
                        <h4 class="card-title"><?php echo $firstname; ?></h4>
                        <h6 class="card-category text-gray">Account Number: <?php echo $account_no; ?></h6>
                    </div>
                    <div class="card-footer justify-content-center">
                        <b>  Loan Outstanding Balance: <?php echo "₦ " .number_format(round($duebalance), 2); ?> </b>
                    </div>
                </div>
                <!-- end new card profile -->
                <?php
                $query_loan = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' ORDER BY duedate ASC");
                ?>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <!-- <tr> -->
                          <th>Disbursement Date</th>
                          <th>Due Date</th>
                          <th>Principal Amount</th>
                          <th>Interest Amount</th>
                          <th>Payment Status</th>
                          <th>Total Due</th>
                          <th>Action</th>
                        <!-- </tr> -->
                      </thead>
                      <tbody>
                      <?php
                      if (mysqli_num_rows($query_loan) > 0){
                          while ($row = mysqli_fetch_array($query_loan)) {
                      ?>
                        <tr>
                          <td><?php echo $row["fromdate"]; ?></td>
                          <td> <b> <?php echo $row["duedate"]; ?> </b></td>
                          <td><?php echo "₦ ".number_format($row["principal_amount"], 2); ?></td>
                          <td><?php echo "₦ ".number_format($row["interest_amount"], 2); ?></td>
                          <?php
                          $inst = $row["installment"];
                          $current_date = date('Y-m-d');
                          $due_d = $row["duedate"];
                          
                          $query_arrears = mysqli_query($connection, "SELECT * FROM `loan_arrear` WHERE ((loan_id = '$loan_id' AND duedate = '$due_d') AND installment > 0) ORDER BY id DESC LIMIT 1");
                          if (mysqli_num_rows($query_arrears) > 0) {
                              $mxv = mysqli_fetch_array($query_arrears);
                              $pina = $mxv["principal_amount"];
                              $inam = $mxv["interest_amount"];
                              $vbdt = number_format(($pina + $inam), 2);
                              $inst = "<span style='color:red'>₦ $vbdt in Arrears</span>";
                          } else {
                              if ($inst <= 0) {
                                  $inst = "<span style='color:green'>Paid</span>";

                              } else if ($inst > 0 && $row["duedate"] < $current_date) {
                                  $inst = "<span style='color:red'>Not Paid</span>";

                              } else {
                                  $inst = "<span style='color:orange'>Pending</span>";
                              }
                          }
                          ?>
                          <td><?php echo $inst; ?></td>

                          <?php
                          $query_principal_due = mysqli_query($connection, "SELECT principal_amount, principal_completed_derived FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND id = {$row['id']}");
                          $query_interest_due = mysqli_query($connection, "SELECT interest_amount, interest_completed_derived FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND id = {$row['id']}");
                          $fetch_principal_val = mysqli_fetch_array($query_principal_due);
                          $fetch_interest_val = mysqli_fetch_array($query_interest_due);
                          $principal_due = $fetch_principal_val["principal_amount"] - $fetch_principal_val["principal_completed_derived"];
                          $interest_due = $fetch_interest_val["interest_amount"] - $fetch_interest_val["interest_completed_derived"];
                          $total_due = $principal_due + $interest_due;
                          ?>
                          <td><?php echo "₦ ".number_format(round($total_due), 2); ?></td>
                          <td>
                            <div class="btn-group">
                              <?php
                              $current_date = date('Y-m-d');
                              if ($row["installment"] <= 0) {
                                  $option = "disabled";
                              } else {
                                  $option = "";
                              }
                              ?>
                              <button <?php echo $option; ?> onclick="location.href='loan_single_repayment.php?id=<?php echo $row['id'] ?>'" class="btn btn-default">Edit</button>
                              <!-- <button type="button" <?php echo $option; ?> class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-lg">Delete</a>
                              </div> -->
                            </div> 
                          </td>                         
                        </tr>
                        <tr>
                        <?php
                          }
                      } else {
                          ?>
                          <tr>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td> 
                          <td>
                          <div class="btn-group" disabled>
                            <button type="button" disabled class="btn btn-success">View</button>
                            <button type="button" disabled class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                               <a class="dropdown-item" disabled href="#">Pay Loan</a>
                               <a class="dropdown-item" disabled href="#">Edit Loan Repayment</a>
                            </div>
                           </div> 
                          </td>                         
                        </tr>
                        <tr>
                          <?php
                      }
                        ?>
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- end your front end -->
<?php
} else {
    // run script
    echo '<script type="text/javascript">
    $(document).ready(function(){
     swal({
      type: "error",
      title: "Sorry No User Repayment Found",
      text: "Check the Reconciliation Table",
     showConfirmButton: false,
      timer: 2000
      }).then(
      function (result) {
        history.go(-1);
      }
      )
      });
     </script>
    ';
}
?>
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