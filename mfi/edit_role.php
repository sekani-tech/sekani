<?php

$page_title = "Edit Permissions";
$destination = "staff_mgmt.php";
    include("header.php");

?>
<?php
if(isset($_GET['id'])){}
?>
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Edit Roles</h4>
                </div>
                <div class="card-body">
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Role Name</label>
                    <input type="text" value="<?php echo $rolen;?>" style="text-transform: uppercase;" class="form-control" name="acct_name" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Description</label>
                      <input type="text" value="<?php echo $desc;?>" style="text-transform: uppercase;" class="form-control" name="acct_name" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
