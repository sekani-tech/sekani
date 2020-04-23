
<?php

$page_title = "Add Charges";
$destination = "client.php";
include("header.php");

?>
<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
      <!-- your content here -->
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Create Charges</h4>
              <p class="card-category">Fill in all important data</p>
            </div>
            <div class="card-body">
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Product</label>
                      <select class="form-control" name="" id="">
                        <option value="">Select an option</option>
                        <option value="">Loans</option>
                        <option value="">Savings</option>
                        <option value="">Shares</option>
                      </select>                    
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Amount</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Charge Options</label>
                      <select class="form-control" name="" id="">
                        <option value="">Select an option</option>
                      </select>                    
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Currency</label><br/>
                      <select class="form-control" name="" id="">
                        <option value="">Select an option</option>
                      </select> 
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Charge Payment mode</label><br/>
                      <select class="form-control" name="" id="">
                        <option value="">Select an option</option>
                      </select> 
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Penalty</label><br/>
                      <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input class="form-check-input" name="" type="checkbox" value="1">
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                      </label>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Active</label><br/>
                      <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input class="form-check-input" name="" type="checkbox" value="1">
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                      </label>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Allowed to Override</label><br/>
                      <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input class="form-check-input" name="" type="checkbox" value="1">
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                      </label>
                    </div>
                    </div>
                  </div>
                </div>
                <a href="client.php" class="btn btn-danger">Back</a>
                <button type="submit" name="submit" id="submit" class="btn btn-primary pull-right">Add Account</button>
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
        <!-- /form card -->
      </div>
      <!-- /content -->
    </div>
  </div>

<?php

include("footer.php");

?>
