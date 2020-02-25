<?php

    include("header.php");
?>
<?php
// load user role data
$sint_id = $_SESSION["int_id"];
$org = "SELECT * FROM org_role WHERE int_id = '$sint_id'";
$res = mysqli_query($connection, $org);
while ( $results[] = mysqli_fetch_object ( $res ) );
  array_pop ( $results );
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create new Staff</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/int_staff_upload.php" method="POST">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Institution</label>
                          <input readonly value="<?php echo $int_name; ?>" type="text" name="int_name" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Username</label>
                          <input type="text" class="form-control" name="username">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display name</label>
                          <input type="text" class="form-control" name="display_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" class="form-control" name="email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">First Name</label>
                          <input type="text" class="form-control" name="first_name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" class="form-control" name="last_name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Password: (default - bateis1)</label>
                          <input type="password" value="bateis1" name="password" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <input type="text" class="form-control" name="description">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" class="form-control" name="address">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date Joined:</label>
                          <input type="date" class="form-control" name="date_joined">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="role" class="bmd-label-floating">Organization Role:</label>
                          <select name="org_role" id="" class="form-control">
                              <option value="">...</option>
                              <?php foreach ( $results as $option ) : ?>
                              <option value="<?php echo $option->role; ?>"><?php echo $option->role; ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone no</label>
                          <input type="tel" class="form-control" name="phone">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Profile Photo</label>
                          <div class="form-group">
                            <label class="bmd-label-floating"> Use .jpg or png files other file types are not acceptible.</label>
                            <input type="text" name="img" class="form-control" id="">
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Create Profile</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../assets/img/faces/marc.jpg" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <?php
                $fullname = $_SESSION["fullname"];
                $sessint_id = $_SESSION["int_id"];
                $org_role = $_SESSION["org_role"];
                $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
                if (count([$inq]) == 1) {
                  $n = mysqli_fetch_array($inq);
                  $int_name = $n['int_name'];
                }
                ?>
                <div class="card-body">
                  <h6 class="card-category text-gray"><?php echo $org_role?></h6>
                  <h4 class="card-title"> <?php echo $fullname?></h4>
                  <p class="card-description">
                  <?php echo $int_name?>
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