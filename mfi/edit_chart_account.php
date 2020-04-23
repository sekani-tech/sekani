
<?php

$page_title = "Edit Account";
$destination = "chart_account.php";
include("header.php");
?>
<!-- Content added here -->
<?php
// editing the chart account
if(isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE id='$id' && int_id='$sessint_id'");

  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $vd = $n['id'];
    $acct_name = $n['name'];
    $gl_code = $n['gl_code'];
    $acct_type = $n['account_type'];
    $ext_id = $n['external_id'];
    $acct_tag = $n['tag_id'];
    $acct_use = $n['account_usage'];
    $dis = $n['description'];
    $man_ent = $n['manual_jornal_entries_allowed'];
    $disable_acct = $n['disabled'];
    $enb_bank_recon = $n['reconciliation_enabled'];
  }
}
?>
<div class="content">
    <div class="container-fluid">
      <!-- your content here -->
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Edit a General Ledger Account</h4>
              <p class="card-category">Fill in all important data</p>
            </div>
            <div class="card-body">
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Account name</label>
                      <input type="text" value="<?php echo $acct_name; ?>" style="text-transform: uppercase;" class="form-control" name="acct_name" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >GL Code</label>
                      <input type="text" value="<?php echo $gl_code; ?>" style="text-transform: uppercase;" class="form-control" name="gl_code" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Account Type</label>
                      <select class="form-control" name="" id="" requireds>
                        <option value="">Select an option</option>
                        <option value="">ASSET</option>
                        <option value="">LIABILITY</option>
                        <option value="">EQUITY</option>
                        <option value="">INCOME</option>
                        <option value="">EXPENSE</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >External ID</label>
                      <input type="text" value="<?php echo $ext_id; ?>" style="text-transform: uppercase;" class="form-control" name="" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Account Tag</label>
                      <select class="form-control" name="" id="" required>
                        <option value="<?php echo $acct_tag; ?>"><?php echo $acct_tag; ?></option>
                        <option value="">...</option>
                        <option value="">...</option>
                      </select>                    
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Account Usage</label>
                      <select class="form-control" name="" id="" required>
                        <option value="<?php echo $acct_use;?>">...</option>
                        <option value="1">GL GROUP</option>
                        <option value="2">GL ACCOUNT</option>
                      </select>                    
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Manual Entires Allowed</label><br/>
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
                      <label >Allow Bank reconciliation?</label><br/>
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
                      <label >Disable</label><br/>
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
                  <div class="col-md-12">
                    <div class="form-group">
                      <label> Description:</label>
                      <input type="text" value="<?php echo $des; ?>" style="text-transform: uppercase;" class="form-control" name="descript">  
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
