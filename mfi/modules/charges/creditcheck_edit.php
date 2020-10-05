<?php

$page_title = "Edit Credit Check";
$destination = "products_config.php";
    include("header.php");

?>
<?php
if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $query = "SELECT * FROM credit_check WHERE id = '$id' && int_id = '$sessint_id'";
  $result = mysqli_query($connection, $query);
  if(count([$result]) == 1){
    $a = mysqli_fetch_array($result);
    $name = $a['name'];
    $entity = $a['related_entity_enum_value'];
    $severity = $a['severity_level_enum_value'];
    $rating = $a['rating_type'];
    $value = $a['is_active'];

    if($entity == 1){
      $entityb = "Loan";
    }

    if($severity == 1){
      $severityb = "Block Loan";
    }
    else if($severity == 2){
      $severityb = "Warning";
    }
    else if($severity == 3){
      $severityb = "Pass";
    }

    if($rating == 1){
      $ratingb = "Boolean";
    }
    else if($rating == 2){
      $ratingb = "Score";
    }

    if($value == 1){
      $valueb = "Active";
    }
    else if($value == 0){
      $valueb = "Not Active";
    }
  }
}
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Edit Credit Check</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/creditcheck_upload.php" method="POST">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text" readonly value="<?php echo $id;?>" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" value="<?php echo $name;?>" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating">Entity Name</label>
                          <select name="product" id="" class="form-control">
                              <option value="<?php echo $entity;?>"><?php echo $entityb;?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Severity Level</label>
                          <select name="charge_type" id="" class="form-control">
                              <option value="<?php echo $severity;?>"><?php echo $severityb;?></option>
                              <option value="1">Block Loan</option>
                              <option value="2">Warning</option>
                              <option value="3">Pass</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Rating Type</label>
                          <select name="charge_option" id="" class="form-control">
                              <option value="<?php echo $rating;?>"><?php echo $ratingb;?></option>
                              <option value="1">Boolean</option>
                              <option value="2">Score</option>
                          </select>
                        </div>
                      </div>
                      <div class=" col-md-6 form-group">
                          <label for="bmd-label-floating">Value</label>
                          <select name="charge_option" id="" class="form-control">
                          <option value="<?php echo $value;?>"><?php echo $valueb;?></option>
                              <option value="1">Active</option>
                              <option value="2">Not Active</option>
                          </select>
                      </div>
                        <div class=" col-md-6 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="" type="checkbox" value="1">
                                Value
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                      </div>
                      </div>
                      <a href="products_config.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div></div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>