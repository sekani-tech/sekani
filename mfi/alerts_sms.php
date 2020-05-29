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
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Pending SMS
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#perform" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Sent SMS
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#analysis" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Delivered SMS
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#structure" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Fixed SMS
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
                      <a href="#" class="btn btn-primary"> Create Campaign</a>
                      <?php include("items/campaign.php"); ?>
                      <!-- items report -->
                    </div>
                    <!-- /items report-->
                    <div class="tab-pane" id="messages">
                    <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                      <?php include("items/pending_sms.php"); ?>
                    </div>
                    <div class="tab-pane" id="perform">
                    <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                      <?php include("items/sent_sms.php"); ?>
                    </div>
                    <div class="tab-pane" id="analysis">
                    <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                      <?php include("items/delivered_sms.php"); ?>
                    </div>
                    <div class="tab-pane" id="structure">
                    <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                      <?php include("items/failed_sms.php"); ?>
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