<?php

$page_title = "Configuration";
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
                  <h4 class="card-title ">Configuration</h4>
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
                          <th>Products</th>
                          <th>Add, edit and update the Loan products of the instution</th>
                          <td><a href="products_config.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Staff Management</th>
                          <th>Manage all the staff activities and their status</th>
                          <td><a href="staff_mgmt.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Branch</th>
                          <th>View and create institution branches</th>
                          <td><a href="branch.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Alerts</th>
                          <th>Handle the alerts that the system recieves</th>
                          <td><a href="#" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th> <b> SEKANI WALLET </b></th>
                          <th>Fund Institution Sekani Wallet, Keep Activity Up to Date</th>
                          <td><a href="sekani_wallet.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
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