<?php

$page_title = "Configuration";
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
                  <h4 class="card-title ">Configuration</h4>
              
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
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                          
                          <th>Asset Depreciation</th>
                          <th>Setup the Depreciation Value for the Assets in the institution</th>
                          <td><a href="dep_setup.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th>Products</th>
                          <th>Add, edit and update the Loan products of the instution</th>
                          <td><a href="products_config.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th>Staff Management</th>
                          <th>Manage all the staff activities and their status</th>
                          <td><a href="staff_mgmt.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th>Branch</th>
                          <th>View and create institution branches</th>
                          <td><a href="branch.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th>SMS Campaign</th>
                          <th>Handle the alerts that the system recieves</th>
                          <td><a href="alert.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <!-- <tr>
                          <th>General Ledger Template</th>
                          <th>Assign General Ledgers to system posting activities</th>
                          <td><a href="gl_template.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr> -->
                        <tr>
                          
                          <th> <b> SEKANI WALLET </b></th>
                          <th>Fund Institution Sekani Wallet, Keep Activity Up to Date</th>
                          <td><a href="sekani_wallet.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th> <b> Loan Reconciliation </b></th>
                          <th>Edit and make sure the loan balances match at the end of a particular accounting period.</th>
                          <td><a href="loan_reconciliation.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th> <b> Track Dormancy </b></th>
                          <th>Keep track of all Accounts that have not been in use</th>
                          <td><a href="trk_dormant.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th> <b> Bulk Update </b></th>
                          <th>Upload Bulk data from institution database</th>
                          <td><a href="bulk_update.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
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