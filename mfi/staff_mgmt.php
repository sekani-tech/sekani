<?php

$page_title = "Branch";
$destination = "index.php";
    include("header.php");

?>
<?php
          if (isset($_GET["message"])) {
            $key = $_GET["message"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "success",
                            title: "Success",
                            text: "Teller Created Successfully",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
              $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message2"])) {
            $key = $_GET["message2"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Error",
                        text: "Error in Posting For Approval",
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
                </script>
                ';
            $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }
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
                      <!-- <span class="nav-tabs-title">Staff Management:</span> -->
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
                        $query = "SELECT * FROM tellers WHERE int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Branch
                        </th>
                        <th>
                          Staff
                        </th>
                        <th>
                          Description
                        </th>
                        <th>
                          Till Number
                        </th>
                        <th>Balance</th>
                        <th></th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <?php
                          // tellers
                          // end of tellers
                          // $nom = $row["till_no"];
                          // $cll = strlen($nom);
                          // $rest = substr("$nom", 0, -1);
                          $staff2 = $row["branch_id"];
                          $checking3 = "SELECT * FROM `branch` WHERE id ='$staff2'";
                          $done3 = mysqli_query($connection, $checking3);
                          $men3 = mysqli_fetch_array($done3);
                          $brc = $men3["name"];
                          ?>
                          <th><?php echo $brc; ?></th>
                          <?php
                          // tellers
                          // end of tellers
                          // $nom = $row["till_no"];
                          // $cll = strlen($nom);
                          // $rest = substr("$nom", 0, -1);
                          $staff= $row["name"];
                          $checking2 = "SELECT * FROM `staff` WHERE id ='$staff'";
                          $done2 = mysqli_query($connection, $checking2);
                          $men2 = mysqli_fetch_array($done2);
                          $name = $men2["display_name"];
                          ?>
                          <th><?php echo $name; ?></th>
                          <th><?php echo $row["description"]; ?></th>
                          <th><?php echo $row["till_no"]; ?></th>
                          <?php
                          // tellers
                          // end of tellers
                          // $nom = $row["till_no"];
                          // $cll = strlen($nom);
                          // $till = $row["till"];
                          // $checking = "SELECT * FROM `acc_gl_account` WHERE gl_code ='$till'";
                          // $done = mysqli_query($connection, $checking);
                          // $men = mysqli_fetch_array($done);
                          // $bal = $men["organization_running_balance_derived"];
                          // $rest = substr("$nom", 0, -1);
                          $till = $row["name"];
                          $checking = "SELECT * FROM `institution_account` WHERE teller_id ='$till' && int_id = '$sessint_id'";
                          $done = mysqli_query($connection, $checking);
                          $men = mysqli_fetch_array($done);
                          $bal = $men["account_balance_derived"];
                          ?>
                          <th><?php echo $bal; ?></th>
                          <th><a href="view_teller.php?id=<?php echo $row["name"];?>" class="btn btn-success">View</a></th>
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