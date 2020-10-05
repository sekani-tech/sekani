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
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Transactions</h4>
                  <!-- <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script> -->
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Deposit/Withdrawal</td>
                          <td>Make a deposit or withdrawal transaction with an account</td>
                          <td><a href="transact.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        <tr>
                          <td>Group Deposit</td>
                          <td>Make deposits or withdrawal for group accounts</td>
                          <td><a href="grouptrans.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        <tr>
                          <td>FTD Booking</td>
                          <td>Book a Fixed deposit Loan for an account</td>
                          <td><a href="ftd_booking.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        <tr>
                          <td>Book Loan</td>
                          <td>Disburse loans to client registered client</td>
                          <td><a href="lend.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        <tr>
                          <td>CHQ/Pass Book Posting</td>
                          <td>Issue Check/Pass books to clients</td>
                          <td><a href="cheque_book_posting.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        <tr>
                          <td>Vault Posting</td>
                          <td>Perform Vault/GL transactions to Tellers and Banks</td>
                          <td><a href="teller_journal.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        <tr>
                          <td>Funds transfer</td>
                          <td>Transfer Cash Between Accounts in the institution</td>
                          <td><a href="bank_transfer.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        </tbody>
                    </table>
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