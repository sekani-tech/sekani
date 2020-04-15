<?php

$page_title = "Create Teller";
$destination = "staff_mgmt.php";
    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create teller</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="" method="post">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Teller Name</label>
                          <input type="text" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating">Office</label>
                          <select name="" id="" class="form-control">
                              <option value="">select an option</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 form-group">
                          <label class="bmd-label-floating" >Description</label>
                          <input type="text" name="" id="" class="form-control">
                      </div>
                      <div class=" col-md-4 form-group">
                          <label class="bmd-label-floating">Status</label>
                          <select name="" id="" class="form-control">
                              <option value="">Active</option>
                              <option value="">Inactive</option>
                          </select>
                      </div>
                      </div>
                      <a href="staff_mgmt.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Create Teller</button>
                    <div class="clearfix"></div>
                  </form>
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