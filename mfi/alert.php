<?php

$page_title = "Alert";
$destination = "../index.php";
    include("header.php");
    // include("../../functions/connect.php");

?>

<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Alerts</h4>
                  
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                <div class="row">

                <div class="col-md-4">
                  <div class="card card-pricing bg-primary">
                    <div class="card-body ">
                        <h4 class="card-title">SMS</h4>
                        <p class="card-description">
                        Manage SMS
                        </p>
                        <a href="alerts_sms.php" class="btn btn-white btn-round">View</a>
                    </div>
                  </div>         
                </div>
                <div class="col-md-4">
                  <div class="card card-pricing bg-primary">
                    <div class="card-body ">
                        <h4 class="card-title">Email Campaign</h4>
                        <p class="card-description">
                        Manage E-mail Content
                        </p>
                        <a href="alerts_email.php" class="btn btn-white btn-round">View</a>
                    </div>
                  </div>
                </div>               
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>