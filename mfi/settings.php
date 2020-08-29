<?php

$page_title = "Reports";
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
                  <h4 class="card-title ">Settings</h4>
                  
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-6">
                          <form action="" method="post">
                            <legend>Change Password:</legend>
                            <div class="row">
                                <div class=" col-md-6 form-group">
                                    <label class = "bmd-label-floating">Old Password:</label>
                                    <input type="password" value="" name="oldpasskey" class="form-control" required>
                                </div>
                                <div class=" col-md-6 form-group">
                                    <label class = "bmd-label-floating">New Password:</label>
                                    <input type="password" value="" name="newpasskey" class="form-control" required>
                                </div>
                            </div>
                            <input type="submit" value="Change" name="submit" id="submit" class="btn btn-primary"/>
                            <input type="reset" value="Reset" name="reset" id="reset" class="btn btn-danger"/>
                            <div class="clearfix"></div>
                          </form>
                      </div>
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