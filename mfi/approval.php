<?php

$page_title = "Approval";
$destination = "../index.php";
include("header.php");
// include("../../functions/connect.php");

?>
<!-- Content added here -->
<style>
  .card .card-body {
    padding: 0.9375rem 20px;
    position: relative;
    height: 200px;
  }
</style>


<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title text-center">Approval</h4>
        <p class="card-category text-center"></p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Account Opening</h4>
            <p class="card-description">
              View and approve all newly registered clients in the institution
            </p>
            <a href="client_approval.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>


      <div class="col-md-6 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Approve Group</h4>
            <p class="card-description">
              View and approve all the Groups
            </p>

            <a href="approve_group.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

    </div>

    <div class="row">

      <div class="col-md-6 ml-auto mr-auto">

        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Charges</h4>
            <p class="card-description">
              Approve all the manual charges to clients
            </p>
            <a href="charge_approval.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

      <div class="col-md-6 ml-auto mr-auto">

        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Transactions</h4>
            <p class="card-description">
              View and approve all recently made transactions
            </p>
            <a href="transact_approval.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>



    </div>


    <div class="row">

      <div class="col-md-6 ml-auto mr-auto">

        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Expense</h4>
            <p class="card-description">
              View and approve all recently made Expenses
            </p>
            <a href="expense_approval.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>
      <div class="col-md-6 ml-auto mr-auto">

        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">CHQ/Pass Book</h4>
            <p class="card-description">
              Approve all the issued Cheque/pass books
            </p>
            <a href="chq_approval.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-6 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Client Cash Tranfer</h4>
            <p class="card-description">
              View and approve all recently made transactions by clients
            </p>
            <a href="transfer_approval.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>


      <div class="col-md-6 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Fixed Deposit Accounts</h4>
            <p class="card-description">
              View and approve all recently booked FTDs
            </p>
            <a href="ftd_approval.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

    </div>

    <div class="row">


      <div class="col-md-6 ml-auto mr-auto">

        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Individual Loan Disbursement</h4>
            <p class="card-description">
              View and approve all the Disbursed Individual Loan
            </p>
            <a href="disbursement_approval.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

      <div class="col-md-6 ml-auto mr-auto">

        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Group Loan Disbursement</h4>
            <p class="card-description">
            View and approve all the Disbursed Group Loan
            </p>
            <a href="group_loan_approval.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

include("footer.php");

?>