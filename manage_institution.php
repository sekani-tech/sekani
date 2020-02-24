<?php

    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
        <?php
          if (isset($_GET["edit"])) {
            $int_id = $_GET["edit"];
            $update = true;
            $person = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$int_id'");

            if (count([$person]) == 1) {
              $n = mysqli_fetch_array($person);
              $int_id = $n['int_id'];
              $int_name = $n['int_name'];
              $rcn = $n['rcn'];
              $lga = $n['lga'];
              $int_state = $n['int_state'];
              $email = $n['email'];
              $office_address = $n['office_address'];
              $website = $n['website'];
              $office_phone = $n['office_phone'];
              $pc_title = $n['pc_title'];
              $pc_surname = $n['pc_surname'];
              $pc_other_name = $n['pc_other_name'];
              $pc_designation = $n['pc_designation'];
              $pc_phone = $n['pc_phone'];
              $pc_email = $n['pc_email'];
            }
          }
        ?>
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Institutions</h4>
                  <p class="card-category">Complete institution profile</p>
                </div>
                <div class="card-body">
                  <form action="functions/update_institution.php" method="post">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text" readonly value="<?php echo $int_id; ?>" class="form-control" name="int_id">
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" value="<?php echo $int_name; ?>" class="form-control" name="int_name">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">RCN</label>
                          <input type="text" value="<?php echo $rcn; ?>" class="form-control" name="rcn">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="bmd-label-floating">LGA</label>
                          <input type="text" value="<?php echo $lga; ?>" class="form-control" name="lga">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">State</label>
                          <input type="text" value="<?php echo $int_state; ?>" class="form-control" name="int_state">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">E-mail</label>
                          <input type="email" value="<?php echo $email; ?>" class="form-control" name="email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Office Address</label>
                          <input type="text" value="<?php echo $office_address; ?>" class="form-control" name="office_address">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Website</label>
                          <input type="text" value="<?php echo $website; ?>" class="form-control" name="website">
                        </div>
                      </div>
                      <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Phone</label>
                                <input type="text" value="<?php echo $office_phone; ?>" name="office_phone" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Title</label>
                                <select name="pc_title" value="<?php echo $pc_title; ?>" class="form-control" id="">
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Master">Master</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="clearfix"></div> -->
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Surname</label>
                                <input type="text" value="<?php echo $pc_surname; ?>" name="pc_surname" class="form-control" id="">
                            </div>
                        </div>
                        
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Other Names</label>
                                <input type="text" value="<?php echo $pc_other_name; ?>" name="pc_other_name" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Designation</label>
                                <input type="text" value="<?php echo $pc_designation; ?>" name="pc_designation" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Phone</label>
                                <input type="tel" value="<?php echo $pc_phone; ?>" name="pc_phone" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Email</label>
                                <input type="email" value="<?php echo $pc_email; ?>" name="pc_email" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                    <button type="reset" class="btn btn_default">Reset</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="assets/img/faces/marc.jpg" />
                  </a>
                </div>
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
                  <h6 class="card-category text-gray"><?php echo $org_role ?></h6>
                  <h4 class="card-title"> <?php echo $fullname ?></h4>
                  <p class="card-description">
                  <?php echo $int_name ?>
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>