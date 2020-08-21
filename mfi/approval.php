<?php

$page_title = "Approval";
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
                  <h4 class="card-title ">Approvals</h4>
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
                        <th colspan = 2>
                        
                        </th>
                      </thead>
                      <tbody>
                        <tr>
                          <th>Account Opening</th>
                          <th>View and approve all newly registered clients in the institution</th>
                          <td><a href="client_approval.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Approve Group</th>
                          <th>View and approve all the Groups</th>
                          <td><a href="approve_group.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Charges </th>
                          <th>Approve all the manual charges to clients</th>
                          <td><a href="charge_approval.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Transactions</th>
                          <th>View and approve all recently made transactions</th>
                          <td><a href="transact_approval.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        </tr>
                          <th>Client Cash Tranfer</th>
                          <th>View and approve all recently made transactions by clients</th>
                          <td><a href="transfer_approval.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                        </tr>
                          <th>Fixed Deposit Accounts</th>
                          <th>View and approve all recently booked FTDs</th>
                          <td><a href="ftd_approval.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                          <th>CHQ/Pass Book</th>
                          <th>Approve all the issued Cheque/pass books</th>
                          <td><a href="chq_approval.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Loan Disbursement</th>
                          <th>View and approve all the Disbursed Loan</th>
                          <td><a href="disbursement_approval.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
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