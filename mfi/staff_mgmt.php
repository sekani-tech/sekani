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
        <?php
// right now we will program
// first step - check if this person is authorized
$org_role = $_SESSION['org_role'];

$valut = $proce['configuration'];

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
                    <div class="tab-pane" id="products">
                      <!-- <a href="role.php" class="btn btn-primary"> Create New Role</a> -->
                      <?php
                    // we are gonna post to get the name of the button
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                      // check the button value
                      $role = $_POST['submit'];
                      $update_role = $_POST['submit'];
                      if ($role == 'role') {
                        $r_n = $_POST["role_name"];
                        $r_d = $_POST["descript"];
                        // check if this role exists
                        $selectrole = mysqli_query($connection, "SELECT * FROM org_role WHERE int_id = '$sessint_id' && role = '$r_n'");
                        $cs = mysqli_num_rows($selectrole);
                        if ($cs == 0 || $cs == "0") {
                          $getrole = "INSERT INTO org_role (int_id, role, description) VALUES ('{$sessint_id}', '{$r_n}', '{$r_d}')";
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
                      } else if ($update_role == 'update_role') {
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
                        if ( isset($_POST['update']) ) {
                          $update = 1;
                          } else {
                          $update = 0;
                          }
                        if ( isset($_POST['view_report']) ) {
                        $view_report = 1;
                        } else {
                        $view_report = 0;
                        }
                        if ( isset($_POST['dash']) ) {
                        $dash = 1;
                        } else {
                        $dash = 0;
                        }
                       
                        $perm = "INSERT INTO permission (int_id, role_id, trans_appv, trans_post, loan_appv, acct_appv, valut, vault_email, view_report, view_dashboard, update_client, configuration)
                         VALUES ('{$sessint_id}', '{$rid}', '{$approve}', '{$post_transact}', '{$approve_loan}', '{$approve_acc}', '{$vault_trans}', '{$emai}', '{$view_report}', '{$dash}','{$update}', '{$access_config}')";
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
                        
                    } else {
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
                          <td><div data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-info">Edit</div></td>
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

                  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Role</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label >Account name*</label>
                                  <input type="text" id="give" style="text-transform: uppercase;" class="form-control" name="acct_name" required>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label >Description</label>
                                  <input  id = "tit" type="text" style="text-transform: uppercase;" class="form-control" name="descript" required>
                                </div>
                              </div>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
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
                    // $query = "SELECT * FROM org_role WHERE int_id = '$sint_id'";
                    $query = "SELECT org_role.id, org_role.role FROM org_role LEFT JOIN permission ON permission.role_id = org_role.id WHERE ((permission.id IS NULL) AND org_role.int_id = '$sint_id')";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_array($result);
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                      $out .= '<option value="'.$row["id"].'">' .strtoupper($row["role"]). '</option>';
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
              <!-- a script to get the staff -->
          <script>
          //   $(document).ready(function() {
          //     $('#role').change(function(){
          //       var id = $(this).val();
          //       var int_id = $('#int_id').val();
          //       $.ajax({
          //         url:"ajax_post/role_function.php",
          //         method:"POST",
          //         data:{id:id, int_id:int_id},
          //         success:function(data) {
          //         $('#show_role_staff').html(data);
          //       }
          //     })
          //   });
          //  })
          </script>
              <!-- <div class="form-group">
               <div id="show_role_staff"></div>
              </div> -->
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
                <input class="form-check-input" type="checkbox" value="" name="approve_loan" id="n4">
                Approve Loan
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="update" id="n10">
               Client Update Approval
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
        <button type="submit" name="submit" value="update_role" type="button" class="btn btn-primary">Save changes</button>
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
                        $query = "SELECT permission.vault_email, org_role.id, permission.trans_appv, permission.trans_post, permission.loan_appv, permission.acct_appv, permission.valut, permission.view_report, permission.view_dashboard, permission.update_client, permission.configuration, org_role.role, org_role.description FROM org_role JOIN permission ON org_role.id = permission.role_id WHERE org_role.int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Role Name</th>
                        <th>Description</th>
                        <th>Approve Transaction</th>
                        <th>Post Transaction</th>
                        <th>Approve Loan</th>
                        <th>Approve Account</th>
                        <th>vault Transaction</th>
                        <th>View Report</th>
                        <th>Dashboard</th>
                        <th>Client Update Approval</th>
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
                          if($row['update_client'] == '1'){
                            $check = "checked";
                          }
                          elseif($row['update_client'] == '0'){
                            $check = "unchecked";
                          }
                          ?>   
                          <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" <?php echo $check;?> disabled type="checkbox" value="" name="" id="cc">
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