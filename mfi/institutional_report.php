<?php

$page_title = "Insitutional Report";
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
                            <i class="material-icons">attach_money</i> Items Report
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Deposit Stucture and Maturity Profile
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <!-- <div class="tab-pane active" id="profile">
                      <div class="card-title">Auto Logout</div>
                      <form action="">
                        <div class="form-group">
                          <label for="">Toggle on and off </label>
                          <select name="" class="form-control" id="">
                            <option value="On">On</option>
                            <option value="Off">Off</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Duration</label>
                          <input type="number" name="" class="form-control" id="">
                        </div>
                        <button class="btn btn-primary">Update</button>
                      </form>
                    </div> -->
                    <div class="tab-pane active" id="products">
                      <!-- <a href="manage_product.php" class="btn btn-primary"> Memorandum Items Report </a> -->
                      <?php include("items/items_report.php"); ?>
                    </div>
                    <!-- /items report-->
                    <div class="tab-pane" id="messages">
                        <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                        <?php include("items/maturity_profile.php"); ?>
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