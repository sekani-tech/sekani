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
                  <h4 class="card-title ">Customer Service</h4>
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
                        <th colspan = "3">
                        </th>
                      </thead>
                      <tbody>
                        <tr>
                          <th>View Client List</th>
                          <th>View the list of all the Clients in the institution</th>
                          <td><a href="client.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Register Client</th>
                          <th>Open a Corporate/Individual account for a client</th>
                          <td><a href="manage_client.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Register Group</th>
                          <th>Open a group account in the instituion</th>
                          <td><a href="#" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Client Summary</th>
                          <th>View the summary of Chosen Client Data</th>
                          <td><a href="report_client_view.php?view4" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Client Balance Report</th>
                          <th>View the list of Clients an their account Balance</th>
                          <td><a href="report_client_view.php?view1" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <!-- <tr>
                          <th>Vault Posting</th>
                          <td><a href="teller_journal.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Bank Transfer</th>
                          <td><a href="teller_journal.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr> -->
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