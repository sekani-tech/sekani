<?php

$page_title = "Transaction";
$destination = "../index.php";
    include("header.php");
    // include("../../functions/connect.php");

?>
<style>
    td{
        text-align: right;
    }
</style>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Transactions</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                        <th colspan = 3>
                        
                        </th>
                      </thead>
                      <tbody>
                        <tr>
                          <th>Deposit/Withdrawal</th>
                          <th>Make a deposit or withdrawal transaction with an account</th>
                          <td><a href="transact.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Group Deposit</th>
                          <th>Make deposits or withdrawal for group accounts</th>
                          <td><a href="grouptrans.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>FTD Booking</th>
                          <th>Book a Fixed deposit Loan for an account</th>
                          <td><a href="ftd_booking.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Book Loan</th>
                          <th>Disburse loans to client registered client</th>
                          <td><a href="lend.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>CHQ/Pass Book Posting</th>
                          <th>Issue Check/Pass books to clients</th>
                          <td><a href="cheque_book_posting.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Vault Posting</th>
                          <th>Perform Vault/GL transactions to Tellers and Banks</th>
                          <td><a href="teller_journal.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Cash transfer</th>
                          <th>Transfer Cash Between Accounts in the institution</th>
                          <td><a href="bank_transfer.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
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