<?php

$page_title = "Transaction";
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
        <h4 class="card-title text-center">Transactions</h4>
        <p class="card-category text-center"></p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Book Loan</h4>
            <p class="card-description">
              Disburse loans to client registered client
            </p>
            <a href="lend.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>


      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Deposit/Withdrawal</h4>
            <p class="card-description">
              Make a deposit or withdrawal transaction with an account
            </p>
            <a href="transact.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 ml-auto mr-auto">

        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Loan Collection</h4>
            <p class="card-description">
              Perform a Manual Loan Collection
            </p>
            <a href="loan_reconciliation.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">CHQ/Pass Book Posting</h4>
            <p class="card-description">
              Issue Check/Pass books to clients
            </p>
            <a href="cheque_book_posting.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>

      </div>

      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">FTD Booking</h4>
            <p class="card-description">
              Book a Fixed deposit Loan for an account
            </p>
            <a href="ftd_booking.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Vault Posting</h4>
            <p class="card-description">
              Perform Vault/GL transactions to Tellers and Banks
            </p>
            <a href="teller_journal.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title"> Disburse Group Loan</h4>
            <p class="card-description">
              Disburse Loans to registered Groups
            </p>
            <a href="group_loan.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Bulk Deposit/Withdrawal</h4>
            <p class="card-description">
              Make Bulk Deposit in different Branches
            </p>
            <a href="bulk_deposit.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Funds transfer</h4>
            <p class="card-description">
              Transfer Cash Between Accounts in the institution
            </p>
            <a href="bank_transfer.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

    </div>

    <div class="row">
      
      <div class="col-md-4 ml-auto mr-auto">

        <div class="card card-pricing bg-primary">
          <div class="card-body ">

            <h4 class="card-title">Group Deposit</h4>
            <p class="card-description">
              Make deposits or withdrawal for group accounts
            </p>
            <a href="grouptrans.php" class="btn btn-white btn-round">View</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php

include("footer.php");

?>