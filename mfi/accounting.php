<?php

$page_title = "Accounting";
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
                  <h4 class="card-title ">Accounting</h4>
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
                          <th>Chart of Account</th>
                          <th>View, add and edit all the gl account for the institution</th>
                          <td><a href="chart_account.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Inventory Posting</th>
                          <th>Manage and Add records of the inventory items in the institution</th>
                          <td><a href="inventory.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Assets Registration</th>
                          <th>To register assets belonging to the institution</th>
                          <td><a href="#" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Bank Reconciliation</th>
                          <th>Reconciliation of Bank</th>
                          <td><a href="#" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Budget Template</th>
                          <th>Create and review Budgets and other planning activities</th>
                          <td><a href="#" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>End of Day</th>
                          <th>Closing of the Business Day</th>
                          <td><a href="#" class="btn btn-info"><i class="material-icons">description</i></a></td>
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