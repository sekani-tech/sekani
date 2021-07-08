<?php

$page_title = "End of Business";
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
                  <h4 class="card-title text-center">End of Period</h4>
                  <p class="card-category text-center"></p>
                </div>
    </div>

          <div class="row">
          <div class="col-md-4 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">End of Day</h4>
                  <p class="card-description">
                  Closing of the Business Day
                  </p>
                  <a href="end_of_day.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>
            

            <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-pricing bg-primary" ><div class="card-body ">
                  
                  <h4 class="card-title">End of Month</h4>
                  <p class="card-description">
                  Closing of the Business Month
                  </p>
                  
                  <a href="end_of_month.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-4 ml-auto mr-auto">

            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">End of Year</h4>
                  <p class="card-description">
                  Closing of the Business Year
                  </p>
                  <a href="end_of_year.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            

        </div>         

        
        </div>
      </div>

<?php

    include("footer.php");
    
?>