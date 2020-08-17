<?php

$page_title = "Edit Payment Type";
$destination = "branch.php";
    include("header.php");

?>
<?php
 if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $value = mysqli_query($connection, "SELECT * FROM payment_type WHERE id='$user_id'");

  if (count([$value] == 1)) {
    $n = mysqli_fetch_array($value);
    $name = $n['value'];
    $desc = $n['description'];
    $gl_code = $n['gl_code'];
    $is_bank = $n['is_bank'];
    $is_cash = $n['is_cash_payment'];
    $def = $n['order_position'];

    if($is_bank == '1'){
        $check = "checked";
    }else{
        $check = "unchecked";
    }
    if($is_cash == '1'){
        $dheeck = "checked";
    }else{
        $dheeck = "unchecked";
    }
    if($def == '1'){
        $deff = "Yes";
    }else{
        $deff = "No";
    }

    $coe = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$gl_code' AND int_id = '$sessint_id'");
    $do =mysqli_fetch_array($coe);
    $p_id =$do['parent_id'];
    $gl_name = $do['name'];

    $sdpo = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE id = '$p_id' AND int_id = '$sessint_id'");
    $do =mysqli_fetch_array($sdpo);
    $p_id_name =$do['name'];
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
                  <h4 class="card-title">Update Payment Type</h4>
                  <p class="card-category">Fill important Data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/paytype_update.php" method="post">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text"  readonly class="form-control" value="<?php echo $user_id; ?>" name="id">
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" class="form-control" value="<?php echo $name; ?>" name="name">
                          <input hidden type="text" class="form-control" value="<?php echo $sessint_id; ?>" name="int_id">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <input type="text" class="form-control" value="<?php echo $desc; ?>" name="desc">
                        </div>
                      </div>
                      <div class="col-md-6">
            <?php
                  function fill_gl($connection) {
                    $sint_id = $_SESSION["int_id"];
                    $org = "SELECT * FROM acc_gl_account WHERE (int_id = '$sint_id' AND (parent_id = '' OR parent_id = '0'))";
                    $res = mysqli_query($connection, $org);
                    $out = '';
                    while ($row = mysqli_fetch_array($res))
                    {
                      $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                    }
                    return $out;
                  }
                  ?>
                 
              <div class="form-group">
               <label class="bmd-label-floating">GL Group</label>
               <select name="gl_type" id="role" class="form-control">
                 <option value="<?php echo $p_id;?>"><?php echo $p_id_name;?></option>
                <?php echo fill_gl($connection); ?>
             </select>
             <input type="text" id="int_id" hidden  value="<?php echo $sessint_id; ?>" style="text-transform: uppercase;" class="form-control">
              </div>
            </div>
            <script>
                    $(document).ready(function () {
                      $('#role').on("change", function () {
                        var ch = $('#role').val();
                        $.ajax({
                          url: "ajax_post/glss.php", 
                          method: "POST",
                          data:{ch:ch},
                          success: function (data) {
                            $('#tit').html(data);
                          }
                        })
                      });
                    });
                  </script>
            <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">GL Account</label>
                      <select id ="tit" class="form-control" name= "gl_code">
                      <option hidden value="<?php echo $gl_code;?>"><?php echo $gl_name;?></option>
                      </select>    
                    </div>
                  </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Default</label>
                          <select id ="tit" class="form-control" name= "default">
                            <option hidden value="<?php echo $def;?>"><?php echo $deff;?></option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>                        
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                        <div class="col-md-6">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $check;?> class="form-check-input" type="checkbox" value="" name="is_bank">
                Is Bank
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            <div class="col-md-6">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $dheeck;?> class="form-check-input" type="checkbox" value="" name="is_cash">
                Is Cash payment
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
                        </div>
                        </div>
                        </div>
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
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