<?php
include ('../path.php');
$page_title = "Customer Service";
$destination = "../index.php";
    include("header.php");
//     include("../../functions/connect.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title text-center">Customer Service</h4>
                  <p class="card-category text-center"></p>
                </div>
    </div>

          <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Register Client</h4>
                  <p class="card-description">
                  Register a Corporate/Individual account for a client.
                  </p>
                  <a href="manage_client.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>

            <div class="col-md-6 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Register Group</h4>
                  <p class="card-description">
                  Register a group account in the instituion
                  </p>
                  <a href="create_group.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

        </div>


          <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">View Active Client List</h4>
                  <p class="card-description">
                  View the list of all the approved clients in the institution
                  </p>
                  <a href="client.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>

            <div class="col-md-6 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                 
                  <h4 class="card-title">View Groups List</h4>
                  <p class="card-description">
                  View the list of all the approved Groups in the institution
                  </p>
                  <a href="groups.php?id=<?php echo $_SESSION['int_id']; ?>" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

        </div>
          
        </div>
      </div>

<?php

    include("footer.php");

?>