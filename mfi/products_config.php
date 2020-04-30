<?php

$page_title = "Prducts Configuration";
$destination = "index.php";
    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <!-- <span class="nav-tabs-title">Configuration:</span> -->
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <!-- <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Password Settings
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link active" href="#products" data-toggle="tab">
                          <!-- visibility -->
                            <i class="material-icons">attach_money</i> Loan Products
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Charges
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#credit" data-toggle="tab">
                            <i class="material-icons">find_in_page</i> Credit Check
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <!-- <div class="tab-pane active" id="profile">
                      <div class="card-title">Auto Logout</div>
                      <form action="">
                        <div class="form-group">
                          <label for="">Toggle on and off </label>
                          <select name="" class="form-control" id="">
                            <option value="On">On</option>
                            <option value="Off">Off</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Duration</label>
                          <input type="number" name="" class="form-control" id="">
                        </div>
                        <button class="btn btn-primary">Update</button>
                      </form>
                    </div> -->
                    <div class="tab-pane active" id="products">
                      <a href="manage_product.php" class="btn btn-primary"> Create New Product</a>
                      <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script>
                    <table id="tabledat4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM product WHERE int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Name</th>
                        <th>
                          Description
                        </th>
                        <th>
                          Product Group
                        </th>
                        <th>
                          Edit
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["name"]; ?></th>
                          <th><?php echo $row["description"]; ?></th>
                          <th><?php echo $row["short_name"]; ?></th>
                          <td><a href="update_product.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <div class="tab-pane" id="messages">
                    <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                    <a href="create_charge.php" class="btn btn-primary"> Add Charge</a>
                      <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM `charge` WHERE int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Name
                        </th>
                        <th>
                          Product
                        </th>
                        <th>
                         Active
                        </th>
                        <th>
                          Charge Type
                        </th>
                        <th>
                         Amount
                        </th>
                        <th>View</th>
                        <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                         <?php $row["id"]; ?>
                          <th><?php echo $row["name"]; ?></th>
                          <?php
                          if ($row["charge_applies_to_enum"] == 1) {
                            $me = "Loan";
                          } else if ($row["charge_applies_to_enum"] == 2) {
                            $me = "Savings";
                          }
                         ?>
                         <th><?php echo $me; ?></th>
                          <th><?php echo $row["is_active"]; ?></th>
                          <?php
                          if ($row["charge_time_enum"] == 1) {
                            $xs = "Disbursement";
                          } else if ($row["charge_time_enum"] == 2) {
                            $xs = "Specified Due Date";
                          } else if ($row["charge_time_enum"] == 3) {
                            $xs = "Savings Activiation";
                          } else if ($row["charge_time_enum"] == 5) {
                            $xs = "Withdrawal Fee";
                          } else if ($row["charge_time_enum"] == 6) {
                            $xs = "Annual Fee";
                          } else if ($row["charge_time_enum"] == 8) {
                            $xs = "Installment Fees";
                          } else if ($row["charge_time_enum"] == 9) {
                            $xs = "Overdue Installment Fee";
                          } else if ($row["charge_time_enum"] == 12) {
                            $xs = "Disbursement - Paid With Repayment";
                          } else if ($row["charge_time_enum"] == 13) {
                            $xs = "Loan Rescheduling Fee";
                          } 
                         ?>
                         <th><?php echo $xs; ?></th>
                          <th><?php echo $row["amount"]; ?></th>
                          <td><a href="#?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                          <td><a href="#?delete=<?php echo $row["id"];?>" class="btn btn-info">Delete</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                          <!-- <th></th> -->
                      </tbody>
                      </table>
                    </div>
                    <!-- credit checks -->
                    <div class="tab-pane" id="credit">
                    <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                    <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM `credit_check` WHERE int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Id
                        </th>
                        <th>
                          Name
                        </th>
                        <th>
                          Entity Name
                        </th>
                        <th>
                         Severity Level
                        </th>
                        <th>
                          Rating Type
                        </th>
                        <th>
                         Value
                        </th>
                        <th>View</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                         <th><?php echo $row["id"]; ?></th>
                          <th><?php echo $row["name"]; ?></th>
                          <?php
                          if ($row["related_entity_enum_value"] == 1) {
                            $me = "Loan";
                          }
                          ?>
                          <th><?php echo $me; ?></th>
                          <?php
                          if ($row["severity_level_enum_value"] == 1) {
                            $xs = "Block Loan";
                          } else if ($row["severity_level_enum_value"] == 2) {
                            $xs = "Warning";
                          } else if ($row["severity_level_enum_value"] == 3) {
                            $xs = "Pass";
                          } 
                          ?>
                          <th><?php echo $xs; ?></th>
                          <?php
                          if ($row["rating_type"] == 1) {
                            $rt = "Boolean";
                          } else if ($row["rating_type"] == 2) {
                            $rt = "Score";
                          }
                          ?>
                          <th><?php echo $rt; ?></th>
                          <?php
                          if ($row["is_active"] == 1) {
                            $isa = "Active";
                          } else if ($row["is_active"] == 0) {
                            $isa = "Not Active";
                          }
                          ?>
                          <th><?php echo $isa; ?></th>
                          <td><a href="#?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                          <!-- <th></th> -->
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <!-- end of credit checkss -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / -->
        </div>
      </div>

<?php

    include("footer.php");

?>