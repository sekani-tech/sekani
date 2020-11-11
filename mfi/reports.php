<?php

$page_title = "Reports";
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
                  <h4 class="card-title text-center">Reports</h4>
                  <p class="card-category text-center"></p>
                </div>
    </div>

          <div class="row">

          <div class="col-md-3 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">General Client Report</h4>
                  <p class="card-description">
                  View and manage all reports concerning the client
                  </p>
                  <a href="report_client.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>
            

            <div class="col-md-3 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Group Report</h4>
                  <p class="card-description">
                  View and manage all reports concerning group accounts
                  </p>
                  <a href="report_group.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-3 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  <h4 class="card-title">Savings Account Report</h4>
                  <p class="card-description">
                  View and manage all reports concerning the savings accounts
                  </p>
                  <a href="report_savings.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-3 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  <h4 class="card-title">Current Account Report</h4>
                  <p class="card-description">
                  View and manage all reports concerning the current accounts
                  </p>
                  <a href="report_current.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div> 

        </div>

         <div class="row">

          <div class="col-md-3 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Loan Account Report</h4>
                  <p class="card-description">
                  View and manage all reports concerning Loan disbursement activities
                  </p>
                  <a href="report_loan.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>
            

            <div class="col-md-3 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Financial reports</h4>
                  <p class="card-description">
                  View and manage all reports concerning financial aspect of the institution
                  </p>
                  <a href="report_financial.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-3 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  <h4 class="card-title">Fixed Deposit report</h4>
                  <p class="card-description">
                  View and manage all reports concerning the fixed deposit accounts
                  </p>
                  <a href="report_fixed_deposit.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-3 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  <h4 class="card-title">Institutional reports</h4>
                  <p class="card-description">
                  View and manage all reports concerning the status of the institution and its activities
                  </p>
                  <a href="report_institution.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div> 

        </div>
        </div>
      </div>

<?php

    include("footer.php");

?>