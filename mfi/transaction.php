<?php

$page_title = "Transaction";
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
                  <h4 class="card-title text-center">Transactions</h4>
                  <p class="card-category text-center"></p>
                </div>
    </div>

          <div class="row">
          <div class="col-md-4 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Book Loan</h4>
                  <p class="card-description">
                  Disburse loans to client registered client
                  </p>
                  <a href="lend.php" class="btn btn-white btn-round" style="margin-top: 30px;">View</a>
                  </div>
              </div>
            </div>
            

            <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Deposit/Withdrawal</h4>
                  <p class="card-description">
                  Make a deposit or withdrawal transaction with an account
                  </p>
                  <a href="transact.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-4 ml-auto mr-auto">

            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Group Deposit</h4>
                  <p class="card-description">
                  Make deposits or withdrawal for group accounts
                  </p>
                  <a href="grouptrans.php" class="btn btn-white btn-round" style="margin-top: 30px;">View</a>
                  </div>
              </div>
            </div>   

        </div>

        <div class="row">
            <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">CHQ/Pass Book Posting</h4>
                  <p class="card-description">
                  Issue Check/Pass books to clients
                  </p>
                  <a href="cheque_book_posting.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
              
            </div>

            <div class="col-md-4 ml-auto mr-auto">
            <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">FTD Booking</h4>
                  <p class="card-description">
                  Book a Fixed deposit Loan for an account
                  </p>
                  <a href="ftd_booking.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>   

            <div class="col-md-4 ml-auto mr-auto">
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
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
              <div class="card card-pricing bg-primary"><div class="card-body ">
                  
                  <h4 class="card-title">Funds transfer</h4>
                  <p class="card-description">
                  Transfer Cash Between Accounts in the institution
                  </p>
                  <a href="bank_transfer.php" class="btn btn-white btn-round">View</a>
                  </div>
              </div>
            </div>

        </div>
        </div>
      </div>

<?php

    include("footer.php");

?>