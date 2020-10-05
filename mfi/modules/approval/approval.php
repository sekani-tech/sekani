<?php

$page_title = "Approval";
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
                  <h4 class="card-title ">Approvals</h4>
                  
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <tr>
                          <th>sn</th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td>Account Opening</td>
                          <td>View and approve all newly registered clients in the institution</td>
                          <td><a href="client_approval.php" class="btn btn-info"><i class="material-icons" style="margin:auto;">description</i></a></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Approve Group</td>
                          <td>View and approve all the Groups</td>
                          <td><a href="approve_group.php" class="btn btn-info"><i class="material-icons" style="margin:auto;">description</i></a></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Charges </td>
                          <td>Approve all the manual charges to clients</td>
                          <td><a href="charge_approval.php" class="btn btn-info"><i class="material-icons" style="margin:auto;">description</i></a></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Transactions</td>
                          <td>View and approve all recently made transactions</td>
                          <td><a href="transact_approval.php" class="btn btn-info"><i class="material-icons" style="margin:auto;">description</i></a></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Client Cash Tranfer</td>
                          <td>View and approve all recently made transactions by clients</td>
                          <td><a href="transfer_approval.php" class="btn btn-info"><i class="material-icons" style="margin:auto;">description</i></a></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Fixed Deposit Accounts</td>
                          <td>View and approve all recently booked FTDs</td>
                          <td><a href="ftd_approval.php" class="btn btn-info"><i class="material-icons" style="margin:auto;">description</i></a></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>CHQ/Pass Book</td>
                          <td>Approve all the issued Cheque/pass books</td>
                          <td><a href="chq_approval.php" class="btn btn-info"><i class="material-icons" style="margin:auto;">description</i></a></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Loan Disbursement</td>
                          <td>View and approve all the Disbursed Loan</td>
                          <td><a href="disbursement_approval.php" class="btn btn-info"><i class="material-icons" style="margin:auto;">description</i></a></td>
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