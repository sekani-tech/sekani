<?php

$page_title = "Branch";
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
                      <span class="nav-tabs-title">Staff Management:</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <!-- <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Password Settings
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link active" href="#messages" data-toggle="tab">
                            <i class="material-icons">people</i> Users
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#products" data-toggle="tab">
                            <i class="material-icons">visibility</i> Roles
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#per" data-toggle="tab">
                            <i class="material-icons">visibility_off</i> Access Permissions
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#teller" data-toggle="tab">
                            <i class="material-icons">account_balance_wallet</i> Teller
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="messages">
                    <a href="user.php" class="btn btn-primary"> Create new User</a>
                    <div class="table-responsive">
                    <table id="tabledat2" class="table" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT users.id, users.int_id, display_name, users.username, staff.int_name, staff.email, users.status, staff.employee_status FROM staff JOIN users ON users.id = staff.user_id WHERE users.int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>
                          Display Name
                        </th>
                        <th>
                          Username
                        </th>
                        <th>
                          Insitution
                        </th>
                        <th>
                          E-mail
                        </th>
                        <th>Active</th>
                        <th>Employee Status</th>
                        <th>Action</th>
                        <th>Edit</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["display_name"]; ?></th>
                          <th><?php echo $row["username"]; ?></th>
                          <th><?php echo $row["int_name"]; ?></th>
                          <th><?php echo $row["email"]; ?></th>
                          <th><?php echo $row["status"]; ?></th>
                          <th><?php echo $row["employee_status"]; ?></th>
                          <th>
                          <label class="switch">
                                <input type="checkbox" name="employee_status[]" value="<?php echo $row["employee_status"]; ?>">
                                <span class="slider round"></span>
                              </label>
                              <script>
                                var button = new Ext.button({
                                  text: 'test',
                                  enableToggle: true,
                                  stateful: true
                              });
                              
                              button.getState = function() {
                                  if (this.enableToggle == true) {
                                      var config = {};
                                      config.pressed = this.pressed;
                                      return config;
                                  }
                                  return null;
                              }
                                </script>
                          </th>
                          <!-- <a href="update_user.php?edit=<?php echo $row["id"];?>"><form action="../functions/update_staff.php"><label class="switch">
                                <input type="checkbox" name="employee_status" value="<?php echo $row["employee_status"]; ?>">
                                <span class="slider round"></span>
                              </label>
                              </form>
                              </a> -->
                          <td><a href="update_user.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
                        </tr>
                        <?php }
                          }
                        //   else {
                        //     echo "0 Staff";
                        //   }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <div class="tab-pane" id="products">
                      <a href="manage_product.php" class="btn btn-primary"> Create New Role</a>
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
                        <th>Active</th>
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
                    <!-- /roles -->
                    <div class="tab-pane" id="per">
                      <div class="card-title">Permissions</div>
                      <form action="">
                          <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Select Role</label>
                                <select name="" class="form-control" id="">
                                    <option value="On">Super USer</option>
                                    <option value="Off">GM</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Description</label>
                                <input type="text" name="" id="" class="form-control">
                            </div>   
                          </div>
                          <!-- use if statements to print permission definitions -->
                        <button class="btn btn-primary">Update</button>
                      </form>
                    </div>
                    <!-- /permission -->
                    <div class="tab-pane" id="teller">
                      <a href="create_teller.php" class="btn btn-primary"> Create New Teller</a>
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
                        <th>
                          Branch
                        </th>
                        <th>Teller</th>
                        <th>
                          Cashier
                        </th>
                        <th>Balance</th>
                        <th>
                          Status
                        </th>
                        <th></th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <th></th>
                          <th><?php //echo $row["name"]; ?></th>
                          <th><?php // echo $row["description"]; ?></th>
                          <th><?php //echo $row["short_name"]; ?></th>
                          <th></th>
                          <th></th>
                          <th><a href="view_teller.php" class="btn btn-success">View</a></th>
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
                    <!-- /teller -->
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