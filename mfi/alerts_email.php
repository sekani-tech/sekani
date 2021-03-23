<?php

$page_title = "SMS";
$destination = "../../index.php";
    include("header.php");

?>
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
                    <a class="nav-link active" href="#products" data-toggle="tab">
                      <!-- visibility -->
                      <i class="material-icons">attach_money</i> Campaign
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#holiday" data-toggle="tab">
                      <i class="material-icons">supervisor_account</i> Holiday
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#loans" data-toggle="tab">
                      <i class="material-icons">supervisor_account</i> Loans
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#fixed-deposits" data-toggle="tab">
                      <i class="material-icons">supervisor_account</i> Fixed Deposits
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="products">
                <div id="coll"></div>
                <!-- <button type="button" class="btn btn-primary" name="button" onclick="showDialog()"> <i class="fa fa-plus"></i> Create SMS</button> -->
                <?php include("items/campaign_email.php"); ?>
                <!-- items report -->
              </div>
              <!-- test SMS -->

              <!-- ebd SMS test -->
              <!-- /items report-->
              <div class="tab-pane" id="holiday">
                <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                <?php include("items/holiday_email.php"); ?>
              </div>
              <div class="tab-pane" id="loans">
                <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                <?php include("items/loans_email.php"); ?>
              </div>
              <div class="tab-pane" id="fixed-deposits">
                <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                <?php include("items/fixed_deposits_email.php"); ?>
              </div>
              <!-- nxt -->
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