<?php

$page_title = "Customer Service";
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
                  <h4 class="card-title ">Customer Service</h4>
                  
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <th>sn</th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </thead>
                      <tbody>
                        <tr>
                          <th></th>
                          <th>Register Client</th>
                          <th>Register a Corporate/Individual account for a client</th>
                          <td><a href="manage_client.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        <tr>
                          <th></th>
                          <th>Register Group</th>
                          <th>Register a group account in the instituion</th>
                          <td><a href="create_group.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        <tr>
                          <th></th>
                          <th>View Approved Client List</th>
                          <th>View the list of all the approved clients in the institution</th>
                          <td><a href="client.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
                        </tr>
                        <tr>
                          <th></th>
                          <th>View Groups List</th>
                          <th>View the list of all the approved clients in the institution</th>
                          <td><a href="groups.php" class="btn btn-info"><i class="material-icons" style="margin:auto">description</i></a></td>
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