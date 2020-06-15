<?php

$page_title = "Staff Management";
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
        <?php
// right now we will program
// first step - check if this person is authorized
$org_role = $_SESSION['org_role'];

if ($per_con == 1 || $per_con == "1") {
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
                            <i class="material-icons">people</i> Active Users
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#stff" data-toggle="tab">
                            <i class="material-icons">people</i> Staff
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
                        $query = "SELECT users.id, users.int_id, display_name, users.username, staff.int_name, staff.email, users.status, staff.employee_status FROM staff JOIN users ON users.id = staff.user_id WHERE staff.int_id ='$sessint_id'";
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
                    <div class="tab-pane" id="stff">
                    <div class="table-responsive">
                    <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                    <table id="tabledat" class="table" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM staff WHERE int_id ='$sessint_id'";
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
                        <th>Organization Role</th>
                        <th>Employee Status</th>
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
                          <?php
                         $fs = $row["org_role"];
                          $weo = mysqli_query($connection, "SELECT * FROM org_role WHERE id ='$fs'");
                          $ri = mysqli_fetch_array($weo);
                          if (isset($ri['role'])){
                          $rolename = $ri['role'];
                          }else{
                            $rolename = 'Not Assigned';
                          }
                          ?>
                          <th><?php echo $rolename; ?></th>
                          <th><?php echo $row["employee_status"]; ?></th>
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
                      <!-- <a href="role.php" class="btn btn-primary"> Create New Role</a> -->
                      <?php
                    // we are gonna post to get the name of the button
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                      // check the button value
                      $role = $_POST['submit'];
                      $update_perm = $_POST['sumbit'];
                      $update_role = $_POST['submit'];
                      if ($role == 'role') {
                        $r_n = $_POST["role_name"];
                        $r_d = $_POST["descript"];
                        // check if this role exists
                        $selectrole = mysqli_query($connection, "SELECT * FROM org_role WHERE int_id = '$sessint_id' && role = '$r_n'");
                        $cs = mysqli_num_rows($selectrole);
                        if ($cs == 0 || $cs == "0") {
                          $getrole = "INSERT INTO org_role (int_id, role, description, permission) VALUES ('{$sessint_id}', '{$r_n}', '{$r_d}', '0')";
                        $MIB = mysqli_query($connection, $getrole);
                        if ($MIB) {
                          // echo success
                          echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "success",
                             title: "Role Created",
                             text: " Created Successfully",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                        } else {
                          // echo error
                          echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Error During Creation",
                             text: "Couldnt Create",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                        }
                        }
                        else {
                          // echo something
                          echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "(*_*)",
                             text: "Role Exists Already",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                        }
                      } else if ($update_perm == 'update_perm') {
                        $rid = $_POST["org_role"];
                        $rop = "SELECT role_id FROM permission WHERE int_id = '$sessint_id' && role_id = '$rid'";
                        $one = mysqli_query($connection, $rop);
                        $don = mysqli_fetch_array($one);
                        $roleo = $don['role_id'];
                        if($one == $roleo){
                          echo '<script type="text/javascript">
                          $(document).ready(function(){
                              swal({
                                  type: "error",
                                  title: "Cannot add Permission",
                                  text: "The permissions has already been added to this role",
                                  showConfirmButton: false,
                                  timer: 2000
                              })
                          });
                          </script>
                          ';
                        } elseif($one =! $roleo){
                          if ( isset($_POST['approve']) ) {
                            $approve = 1;
                        } else {
                            $approve = 0;
                        }
                        if ( isset($_POST['post_transact']) ) {
                          $post_transact = 1;
                        } else {
                          $post_transact = 0;
                        }
                        if ( isset($_POST['staff_cabal']) ) {
                          $staff_cabal = 1;
                        } else {
                          $staff_cabal = 0;
                        }
                        if ( isset($_POST['access_config']) ) {
                        $access_config = 1;
                        } else {
                        $access_config = 0;
                        }
                        if ( isset($_POST['approve_loan']) ) {
                        $approve_loan = 1;
                        } else {
                        $approve_loan = 0;
                        }
                        if ( isset($_POST['approve_acc']) ) {
                        $approve_acc = 1;
                        } else {
                        $approve_acc = 0;
                        }
                        if ( isset($_POST['vault_trans']) ) {
                        $vault_trans = 1;
                        } else {
                        $vault_trans = 0;
                        }
                        if ( isset($_POST['emai']) ) {
                          $emai = 1;
                          } else {
                          $emai = 0;
                          }
                        if ( isset($_POST['view_report']) ) {
                          $view_report = 1;
                          } else {
                          $view_report = 0;
                          }
                        if ( isset($_POST['accop']) ) {
                          $accop = 1;
                          } else {
                          $accop = 0;
                          }
                        if ( isset($_POST['accup']) ) {
                        $accup = 1;
                        } else {
                        $accup = 0;
                        }
                        if ( isset($_POST['dash']) ) {
                        $dash = 1;
                        } else {
                        $dash = 0;
                        }
                       
                        $perm = "INSERT INTO permission (int_id, role_id, acc_op, acc_update, trans_appv, trans_post, loan_appv, acct_appv, staff_cabal, valut, vault_email, view_report, view_dashboard, configuration)
                         VALUES ('{$sessint_id}', '{$rid}', '{$accop}', '{$accup}', '{$approve}', '{$post_transact}', '{$approve_loan}', '{$approve_acc}','{$staff_cabal}', '{$vault_trans}', '{$emai}', '{$view_report}', '{$dash}', '{$access_config}')";
                        $permm = mysqli_query($connection, $perm);
                        if ($permm) {
                          $permu = "UPDATE org_role SET permission = '1' WHERE int_id = '$sessint_id' && id = '$rid'";
                        $permmj = mysqli_query($connection, $permu);
                          // echo success
                          echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "success",
                             title: "Permission Granted",
                             text: " Created Successfully",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                     
                    }
                        }
                        
                    }elseif($update_role == 'update_role'){
                      $r_n = $_POST["role_name"];
                        $r_d = $_POST["descript"];
                        $ids = $_POST["ids"];
                        // check if this role exists
                        $selectrole = mysqli_query($connection, "SELECT * FROM org_role WHERE int_id = '$sessint_id' && role = '$r_n'");
                        $cs = mysqli_num_rows($selectrole);
                        if ($cs == 0 || $cs == "0") {
                          $getrole = "UPDATE org_role SET role = '$r_n', description = 'r_d' WHERE int_id = '$sessint_id' && id = '$id'";
                        $MIB = mysqli_query($connection, $getrole);
                        if ($MIB) {
                          // echo success
                          echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "success",
                             title: "Role Updated",
                             text: "Updated Successfully",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                        } else {
                          // echo error
                          echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Error During Update",
                             text: "Couldnt Update",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                        }
                    } else {
                      echo "";
                    }
                  }
                     else {
                      echo "";
                    }
                  } else {
                    // echo no add or update
                  }
                    ?>
                      <div class="card-title">Create A Role</div>
                      <br>
                      <form method="POST">
                          <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Role Name</label>
                                <input type="text" name="role_name" id="" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Description</label>
                                <input type="text" name="descript" id="" class="form-control">
                            </div> 
                          </div>
                          <!-- use if statements to print permission definitions -->
                        <button type="submit" value="role" name="submit" class="btn btn-primary pull-right">Create New Role</button>
                      </form>
                      <!-- A new stuff -->
                  <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script>
                  <br>
                  <div class="card-title">Role List</div>
                    <table id="tabledat4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM org_role WHERE int_id ='$sessint_id' ORDER BY id ASC";
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
                          Edit
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo strtoupper($row["role"]); ?></th>
                          <th><?php echo $row["description"]; ?></th>
                          <td><a href="edit_role.php?id=<?php echo $row['id'];?>" class="btn btn-info">Edit</a></td>
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
                        <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary pull-left">Add Permission</button>
                      <!-- form of staff -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Permission to a Staff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12">
            <?php
                  function fill_role($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM org_role WHERE int_id = '$sint_id' AND (permission = '0' OR permission = '' OR permission = NULL) ORDER BY id ASC";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">' .$row["role"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
              <div class="form-group">
               <label class="bmd-label-floating">Role</label>
               <select name="org_role" id="role" class="form-control">
                 <option value="0">choose a role</option>
                <?php echo fill_role($connection); ?>
             </select>
             <input type="text" id="int_id" hidden  value="<?php echo $sessint_id; ?>" style="text-transform: uppercase;" class="form-control">
              </div>
            </div>
            <div class="col-md-12">
            </div>
           <!-- Next -->
           <div class="col-md-12">
           </div>
           <div class="col-md-12">
             <span>Permission</span>
           </div>
           <div class="col-md-12">
             <div>
               <p>
               <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="0" name="sms_active" id="all">
                Check & Uncheck All
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <br>
               </p>
             </div>
           </div>
           <!-- Javascript for the code -->
           <script>
             $(document).ready(function () {
               $('#all').change(function () {
                if ($(this).is(':checked')) {
                  document.getElementById('n1').checked = true;
                  document.getElementById('n2').checked = true;
                  document.getElementById('n3').checked = true;
                  document.getElementById('n4').checked = true;
                  document.getElementById('n5').checked = true;
                  document.getElementById('n6').checked = true;
                  document.getElementById('n7').checked = true;
                  document.getElementById('n8').checked = true;
                  document.getElementById('n9').checked = true;
                  document.getElementById('n10').checked = true;
                  document.getElementById('n11').checked = true;
                  document.getElementById('n12').checked = true;
                  document.getElementById('n13').checked = true;
                } else {
                  document.getElementById('n1').checked = false;
                  document.getElementById('n2').checked = false;
                  document.getElementById('n3').checked = false;
                  document.getElementById('n4').checked = false;
                  document.getElementById('n5').checked = false;
                  document.getElementById('n6').checked = false;
                  document.getElementById('n7').checked = false;
                  document.getElementById('n8').checked = false;
                  document.getElementById('n9').checked = false;
                  document.getElementById('n10').checked = false;
                  document.getElementById('n11').checked = false;
                  document.getElementById('n12').checked = false;
                  document.getElementById('n13').checked = true;
                }
               });
             })
           </script>
           <!-- End of Javascript for the codes -->
            <!-- for the permission -->
            <div class="col-md-5">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="approve" id="n1">
                Approve Transaction
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="post_transact" id="n2">
                Post Transaction
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="access_config" id="n3">
                Access Configuration
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Last -->
           
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="accop" id="n11">
                Account Opening
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="accup" id="n12">
                Account Update
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="staff_cabal" id="n13">
                View All Staff Cabal
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            <!-- Another -->
            <div class="col-md-5">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="approve_acc" id="n5">
                Approve Account
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="vault_trans" id="n6">
                Vault Transaction
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="view_report" id="n7">
                View Report
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="dash" id="n8">
                Dashboard
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <!-- Last -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="emai" id="n9">
                Vault Email
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            <!-- End for Permission -->
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" value="update_perm" type="button" class="btn btn-primary">Save changes</button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>
                      <!-- Table Below -->
                      <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledat1').DataTable();
                  });
                  </script>
                  <br>
                  <div class="card-title">Create Permission to Staff</div>
                    <table id="tabledat1" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT permission.vault_email, org_role.id, permission.staff_cabal, permission.acc_op, permission.acc_update, permission.trans_appv, permission.trans_post, permission.loan_appv, permission.acct_appv, permission.valut, permission.view_report, permission.view_dashboard, permission.configuration, org_role.role, org_role.description FROM org_role JOIN permission ON org_role.id = permission.role_id WHERE org_role.int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Role Name</th>
                        <th>Description</th>
                        <th>Account Opening</th>
                        <th>Account Update</th>
                        <th>Approve Transaction</th>
                        <th>Post Transaction</th>
                        <th>Approve Loan</th>
                        <th>Approve Account</th>
                        <th>vault Transaction</th>
                        <th>View Report</th>
                        <th>Staff Cabal</th>
                        <th>Dashboard</th>
                        <th>Access Config.</th>
                        <th>Vault Email</th>
                        <th>
                          Edit
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row['id']; ?>
                          <th><?php echo strtoupper($row["role"]); ?></th>
                          <th><?php echo strtoupper($row["description"]); ?></th>
                          <th>
                          <?php
                          if($row['acc_op'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['acc_op'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="app">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>                     
                        </div>
                          </th>
                          <th>
                          <?php
                          if($row['acc_update'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['acc_update'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="app">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>                     
                        </div>
                          </th>
                          <th>
                          <?php
                          if($row['trans_appv'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['trans_appv'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="app">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>                     
                        </div>
                          </th>
                          <th>
                          <?php
                          if($row['trans_post'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['trans_post'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="ptr">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>

                          <th>
                          <?php
                          if($row['loan_appv'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['loan_appv'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="apl">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>

                          </th>
                          <th>
                          <?php
                          if($row['acct_appv'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['acct_appv'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="apa">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>

                          <th>
                          <?php
                          if($row['valut'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['valut'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="vtr">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>

                          <th>
                          <?php
                          if($row['view_report'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['view_report'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="vrp">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <?php
                          if($row['staff_cabal'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['staff_cabal'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="oc"/>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <?php
                          if($row['view_dashboard'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['view_dashboard'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="ds">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <?php
                          if($row['configuration'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['configuration'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="acc">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <th>
                          <?php
                          if($row['vault_email'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['vault_email'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="ema"/>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                          </th>
                          <td><a href="edit_permission.php?id=<?php echo $row['id'];?>" class="btn btn-info">Update</a></td>
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
                          $bal = number_format($men["account_balance_derived"], 2);
                          ?>
                          <th><?php echo $bal; ?></th>
                          <th><button class="btn btn-success">View</button></th>
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
<?php
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Access Config. Authorization",
    text: "You Dont Have Access to configurations",
   showConfirmButton: false,
    timer: 2000
    }).then(
    function (result) {
      history.go(-1);
    }
    )
    });
   </script>
  ';
  // $URL="transact.php";
  // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

?>