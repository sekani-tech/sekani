<?php

$page_title = "Accounting";
$destination = "../index.php";
    include("header.php");
    // include("../../functions/connect.php");

?>

<style>
.card .card-body {
    padding: 0.9375rem 20px;
    position: relative;
    height: 200px;
  }

</style>


<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title text-center">Accounting</h4>
                  <p class="card-category text-center"></p>
                </div>
    </div>

          <div class="row">
          <div class="col-md-4 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Chart of Account</h4>
                  <p class="card-description">
                  View, add and edit all the gl account for the institution
                  </p>
                  <a href="chart_account.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>
            

            <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-pricing bg-primary" ><div class="card-body ">
                  
                  <h4 class="card-title">Inventory Posting</h4>
                  <p class="card-description">
                  Manage and Add records of the inventory items in the institution
                  </p>
                  
                  <a href="inventory.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-4 ml-auto mr-auto">

            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Assets Registration</h4>
                  <p class="card-description">
                  To register assets belonging to the institution
                  </p>
                  <a href="asset_register.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            

        </div>         

        <div class="row">
          <div class="col-md-4 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Bank Reconciliation</h4>
                  <p class="card-description">
                  Reconciliation of Bank
                  </p>
                  <a href="#" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>
            

            <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Budget Template</h4>
                  <p class="card-description">
                  Create and review Budgets and other planning activities
                  </p>
                  <a href="budget_setup.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-4 ml-auto mr-auto">

            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">End of Day</h4>
                  <p class="card-description">
                  Closing of the Business Day
                  </p>
                  <a href="end_of_business.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   
            
        </div>
        </div>
      </div>

<?php

    include("footer.php");
    
?>