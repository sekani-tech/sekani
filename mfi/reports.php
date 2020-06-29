<?php

$page_title = "Reports";
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
                  <h4 class="card-title ">Reports</h4>
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
                          <th>General Client Report</th>
                          <th>View and manage all reports concerning the client</th>
                          <td><a href="report_client.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Group Report</th>
                          <th>View and manage all reports concerning group accounts</th>
                          <td><a href="report_group.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Savings Account Report</th>
                          <th>View and manage all reports concerning the savings accounts</th>
                          <td><a href="report_savings.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Current Account Report</th>
                          <th>View and manage all reports concerning the current accounts</th>
                          <td><a href="report_current.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Loan Account Report</th>
                          <th>View and manage all reports concerning Loan disbursement activities</th>
                          <td><a href="report_loan.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Financial reports</th>
                          <th>View and manage all reports concerning financial aspect of the institution</th>
                          <td><a href="report_financial.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Fixed Deposit report</th>
                          <th>View and manage all reports concerning the fixed deposit accounts</th>
                          <td><a href="report_fixed_deposit.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Institutional reports</th>
                          <th>View and manage all reports concerning the status of the institution and its activities</th>
                          <td><a href="report_institution.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
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