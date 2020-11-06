<?php

$page_title = "Configuration";
$destination = "../index.php";
    include("header.php");
    // include("../../functions/connect.php");

?>

<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title text-center">Configuration</h4>
                  <p class="card-category text-center"></p>
                </div>
    </div>

          <div class="row">
          <div class="col-md-4 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Asset Depreciation</h4>
                  <p class="card-description">
                  Setup the Depreciation Value for the Assets in the institution
                  </p>
                  <a href="dep_setup.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>
            

            <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-pricing bg-primary" ><div class="card-body ">
                  
                  <h4 class="card-title">Products</h4>
                  <p class="card-description">
                  Add, edit and update the Loan products of the instution
                  </p>
                  
                  <a href="products_config.php" class="btn btn-white btn-round" style="margin-top: 30px;">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-4 ml-auto mr-auto">

            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Staff Management</h4>
                  <p class="card-description">
                  Manage all the staff activities and their status
                  </p>
                  <a href="staff_mgmt.php" class="btn btn-white btn-round" style="margin-top: 30px;">View</a>
                  </div>
              </div>
            </div>   

            

        </div>         

        <div class="row">
          <div class="col-md-4 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Branch</h4>
                  <p class="card-description">
                  View and create institution branches
                  </p>
                  <a href="branch.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>
            

            <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">SMS Campaign</h4>
                  <p class="card-description">
                  Handle the alerts that the system recieves
                  </p>
                  <a href="alert.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-4 ml-auto mr-auto">

            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">SEKANI WALLET</h4>
                  <p class="card-description">
                  Fund Institution Sekani Wallet, Keep Activity Up to Date
                  </p>
                  <a href="sekani_wallet.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            

        </div>


        <div class="row">
          <div class="col-md-4 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Loan Reconciliation</h4>
                  <p class="card-description">
                  Edit and make sure the loan balances match at the end of a particular accounting period.
                  </p>
                  <a href="loan_reconciliation.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>
            

            <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Track Dormancy</h4>
                  <p class="card-description">
                  Keep track of all Accounts that have not been in use
                  </p>
                  <a href="trk_dormant.php" class="btn btn-white btn-round" style="margin-top: 30px;">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-4 ml-auto mr-auto">

            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Bulk Update</h4>
                  <p class="card-description">
                  Upload Bulk data from institution database
                  </p>
                  <a href="bulk_update.php" class="btn btn-white btn-round" style="margin-top: 30px;">View</a>
                  </div>
              </div>
            </div>   

            

        </div>
        </div>
      </div>

<?php

    include("footer.php");

?>