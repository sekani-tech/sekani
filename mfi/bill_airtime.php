<?php

$page_title = "Bill & Artime";
$destination = "../index.php";
    include("header.php");
    // include("../../functions/connect.php");

?>

<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <<div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title text-center">Bills & Airtime</h4>
                  <p class="card-category text-center"></p>
                </div>
    </div>

          <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Bills Payment</h4>
                  <p class="card-description">
                  Pay Bills - Electricity, Cable Tv e.t.c 
                  </p>
                  <a href="bill.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>

            <div class="col-md-6 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Airtime and Data</h4>
                  <p class="card-description">
                  Recharge Airtime and Data.
                  </p>
                  <a href="airtime.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

        </div>
        </div>
      </div>

<?php

    include("footer.php");

?>