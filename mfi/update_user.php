<?php

$page_title = "Edit User";
$destination = "staff_mgmt.php";
include("header.php");

?>
<?php
if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM staff WHERE int_id ='$sessint_id' AND id ='$user_id'");

  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $staff_id = $n['id'];
    $int_name = $n['int_name'];
    $display_name = $n['display_name'];
    $email = $n['email'];
    $first_name = $n['first_name'];
    $last_name = $n['last_name'];
    $phone = $n['phone'];
    $address = $n['address'];
    $date_joined = $n['date_joined'];
    $status = $n['employee_status'];
    $org_role = $n['org_role'];
    $img = $n['img'];
    $branch_id = $n['branch_id'];
    $us_id = $n['user_id'];
    $imagefileL = $n['img'];

    $getrole = mysqli_query($connection, "SELECT * FROM `org_role` WHERE id = '$org_role' && int_id = '$sessint_id'");
    $om = mysqli_fetch_array($getrole);
    $rolename = $om['role'];

    $gettype = mysqli_query($connection, "SELECT * FROM `users` WHERE id = '$us_id' && int_id = '$sessint_id'");
    $pi = mysqli_fetch_array($gettype);
    $usertype = $pi['usertype'];
    $username = $pi['username'];
  }
  $dsido = mysqli_query($connection, "SELECT * FROM `branch` WHERE id = '$branch_id' && int_id = '$sessint_id'");
  $u = mysqli_fetch_array($dsido);
  $bname = $u['name'];

  if($usertype == 'staff'){
    $type = 'Staff';
  }
  else if($usertype == 'admin'){
    $type = 'Admin';
  }
  else if($usertype == 'super_admin'){
    $type = 'Super Admin';
  }
}
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Update Profile</h4>
                  <p class="card-category">Modify user profile</p>
                </div>
                <div class="card-body">
                  <form action="../functions/update_staff.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text" readonly name="staff_id" value="<?php echo $staff_id; ?>" class="form-control">
                          <input type="text" readonly name="user_id" hidden value="<?php echo $us_id; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Institution</label>
                          <input type="text" name="int_name" value="<?php echo $int_name; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Username</label>
                          <script>
                            $(document).ready(function(){
                              $('#usernamewarn').on("change keyup paste click", function(){
                                var usern = $(this).val();
                                $.ajax({
                                  url: "verify_user.php",
                                  method: "POST",
                                  data: {usern:usern},
                                  success: function(data){
                                    $('#warnuser').html(data);
                                  }
                                });
                              });
                            });
                          </script>
                          <input type="text" name="username" value="<?php echo $username; ?>" id="usernamewarn" class="form-control">
                          <span class="help-block" style="color: red;"><div id="warnuser"></div></span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display name</label>
                          <input type="text" name="display_name" value="<?php echo $display_name; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" name="email" value="<?php echo $email; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Branch</label>
                          <select name="branch_id" value="<?php echo $email; ?>" class="form-control">
                          <option hidden value = "<?php echo $branch_id;?>"><?php echo $bname;?></option>
                          <?php echo fill_branch($connection)?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">First Name</label>
                          <input type="text" name="first_name" value="<?php echo $first_name; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" name="last_name" value="<?php echo $last_name; ?>" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" name="address" value="<?php echo $address; ?>" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date Joined:</label>
                          <input type="date" name="date_joined" value="<?php echo $date_joined; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                      <?php
                  function fill_role($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM org_role WHERE int_id = '$sint_id' ORDER BY id ASC";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">' .$row["role"]. '</option>';
                  }
                  return $out;
                  }

                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id' ORDER BY id ASC";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">' .$row["name"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
                        <div class="form-group">
                          <label class="bmd-label-floating">Organization Role:</label>
                          <select name="org_role" id="" class="form-control">
                          <option hidden value="<?php echo $org_role;?>"><?php echo $rolename;?></option>
                          <?php echo fill_role($connection); ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone no</label>
                          <input type="tel" name="phone" value="<?php echo $phone; ?>" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-md-4">
                    <label for="file-upload" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-upload" name="imagefile" type="file" class="inputFileHidden"/>
                    <input type="text" hidden value="<?php echo $imagefileL;?>" name="imagefileL">
                    <label> Select Passport</label>
                    </div>
                    <style>
                        input[type="file"]{
                          display: none;
                        }
                        .custom-file-upload{
                          border: 1px solid #ccc;
                          display: inline-block;
                          padding: 6px 12px;
                          cursor: pointer;
                        }
                      </style>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">UserType</label>
                          <select name="usertype" id="" class="form-control">
                          <option hidden value="<?php echo $usertype; ?>"><?php echo $type; ?></option>
                          <!-- <option value="super_admin">Super Admin</option> -->
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Employee Status</label></br>
                          <script>
                            $(document).ready(function() {
                              var xc = document.getElementById("opo").value;
                              if (xc == "Employed") {
                                document.getElementById('emp').checked = true;
                                document.getElementById('dec').checked = false;
                                $('emp').click(function() {
                                 document.getElementById('emp').checked = true;
                                 document.getElementById('dec').checked = false;
                                });
                                $('dec').click(function() {
                                 document.getElementById('emp').checked = false;
                                 document.getElementById('dec').checked = true;
                                });
                              } else {
                                document.getElementById('emp').checked = false;
                                document.getElementById('dec').checked = true;
                                $('emp').click(function() {
                                 document.getElementById('emp').checked = true;
                                 document.getElementById('dec').checked = false;
                                });
                                $('dec').click(function() {
                                 document.getElementById('emp').checked = false;
                                 document.getElementById('dec').checked = true;
                                });
                              }
                            });
                          </script>
                          <input type="radio" name="employee_status" value="Employed" id="emp">
                          <input type="text" hidden value="<?php echo $status; ?>" id="opo">
                            <label style="color: black;">Employed</label><br>
                            <input type="radio" name="employee_status" id="dec" value="Decommisioned">
                            <label style="color: black;">Decommisioned</label><br>
                        </div>
                      </div>
                    </div>
                    <button value="staff" type="submit" class="btn btn-primary pull-right">Update Profile</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../functions/staff/<?php echo $img;?>" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                  <h4 class="card-title"><?php echo $display_name; ?></h4>
                  <p class="card-description">
                  <?php
                $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
                if (count([$inq]) == 1) {
                  $n = mysqli_fetch_array($inq);
                  $int_name = $n['int_name'];
                }
              ?>
            <?php echo $int_name; ?>
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
            </div>
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>