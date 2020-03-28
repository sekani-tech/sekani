<?php

$page_title = "Edit User";
$destination = "users.php";
    include("header.php");

?>
<?php
if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM staff WHERE user_id='$user_id'");

  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $staff_id = $n['id'];
    $user_id = $n['user_id'];
    $int_name = $n['int_name'];
    $username = $n['username'];
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
    $ut = mysqli_query($connection, "SELECT usertype FROM users WHERE id='$user_id'");
    if (count([$ut]) == 1) {
      $j = mysqli_fetch_array($ut);
      $usertype = $j['usertype'];
    }
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
                  <form action="../functions/update_staff.php" method="POST">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text" readonly name="staff_id" value="<?php echo $staff_id; ?>" class="form-control">
                          <input type="text" readonly name="user_id" hidden value="<?php echo $user_id; ?>" class="form-control">
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
                          <input type="text" name="username" value="<?php echo $username; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
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
                        <div class="form-group">
                          <label class="bmd-label-floating">Organization Role:</label>
                          <select name="org_role" id="" class="form-control">
                              <option value="<?php echo $org_role; ?>"><?php echo $org_role; ?></option>
                              <option value="">Staff</option>
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
                    <!-- insert passport -->
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-raised">
                            <!-- <img src="http://style.anu.edu.au/_anu/4/images/placeholders/person_8x10.png" rel="nofollow" alt="..."> -->
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                        <div>
                            <!-- <span class="btn btn-raised btn-round btn-default btn-file"> -->
                                <span class="fileinput-new">Select picture</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="picture" />
                            <!-- </span> -->
                            <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                    </div>
                  </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">UserType</label>
                          <select name="usertype" id="" class="form-control">
                          <option value="<?php echo $usertype; ?>"><?php echo $usertype; ?></option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Employee Status</label></br>
                          <input type="radio" name="employee_status" value="Employed">
                            <label style="color: black;">Employed</label><br>
                            <input type="radio" name="employee_status" value="Decommisioned">
                            <label style="color: black;">Decommisioned</label><br>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
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