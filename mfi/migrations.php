<?php

$page_title = "Migrations";
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
        <h4 class="card-title text-center">Migrations</h4>
        <p class="card-category text-center"></p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Branch</h4>
            <p class="card-description">
              Upload Branch Data
            </p>
            <a href="migrate_branch.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>


      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Staff</h4>
            <p class="card-description">
              Upload Staff Data
            </p>
            <a href="migrate_staff_data.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 ml-auto mr-auto">

        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Clients and Accounts</h4>
            <p class="card-description">
              Upload Clients and Accounts Data
            </p>
            <a href="migrate_client_data.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Loans</h4>
            <p class="card-description">
              Upload Loans Data
            </p>
            <a href="migrate_loans_data.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>

      </div>

      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">GL Accounts Transactions</h4>
            <p class="card-description">
              Upload GL Accounts Transaction
            </p>
            <a href="migrate_gl_acct_trans.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">GL Accounts</h4>
            <p class="card-description">
              Upload GL Accounts
            </p>
            <a href="migrate_gl_accounts_data.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

    </div>


  </div>
</div>

<?php

include("footer.php");

?>