<?php

$page_title = "Register Assets";
$destination = "branch.php";
include("header.php");

?>
<?php
$sint_id = $_SESSION['int_id'];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
$asset_no = $sint_id . "00" . $randms;
$date = date('Y-m-d h:i:sa');

$message = $_SESSION['feedback'];
?>
<input type="text" value="<?php echo $message ?>" id="feedback" hidden>
<?php

// feedback messages 0 for success and 1 for errors

if (isset($_GET["message0"])) {
  $key = $_GET["message0"];
  $tt = 0;

  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
      $(document).ready(function(){
        let feedback =  document.getElementById("feedback").value;
          swal({
              type: "success",
              title: "Success",
              text: feedback,
              showConfirmButton: true,
              timer: 7000
          })
      });
      </script>
      ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
} else if (isset($_GET["message1"])) {
  $key = $_GET["message1"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
      $(document).ready(function(){
        let feedback =  document.getElementById("feedback").value;
          swal({
              type: "error",
              title: "Error",
              text: feedback,
              showConfirmButton: true,
              timer: 7000
          })
      });
      </script>
      ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}

?>
<script>
  $(document).ready(function() {
    $('#static').on("change", function() {
      var id = $(this).val();
      $.ajax({
        url: "ajax_post/depreciation.php",
        method: "POST",
        data: {
          id: id
        },
        success: function(data) {
          $('#showme').html(data);
        }
      })
    });
  });
  $(document).ready(function() {
    $('#static').on("change", function() {
      var asset_no = $(this).val();
      $.ajax({
        url: "ajax_post/depreciation.php",
        method: "POST",
        data: {
          asset_no: asset_no
        },
        success: function(data) {
          $('#fd').html(data);
        }
      })
    });
  });
</script>
<!-- Content added here -->
<?php
function fill_asset($connection)
{
  $sint_id = $_SESSION["int_id"];
  $org = "SELECT * FROM asset_type WHERE int_id = '$sint_id'";
  $res = mysqli_query($connection, $org);
  $out = '';
  while ($row = mysqli_fetch_array($res)) {
    $out .= '<option value="' . $row["id"] . '">' . $row["asset_name"] . '</option>';
  }
  return $out;
}

function branch_option($connection)
{
  $br_id = $_SESSION["branch_id"];
  $sint_id = $_SESSION["int_id"];
  $fod = "SELECT * FROM branch WHERE int_id = '$sint_id' AND parent_id='$br_id' || id = '$br_id'";
  $dof = mysqli_query($connection, $fod);
  $out = '';
  while ($row = mysqli_fetch_array($dof)) {
    $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
  }
  return $out;
}
?>
<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Register Assets</h4>
            <p class="card-category">Fill in all important data</p>
          </div>
          <div class="card-body">
            <form action="../functions/asset_upload.php" method="POST">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Name of Asset</label>
                    <input type="text" class="form-control" name="assname">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Type of Asset:</label>
                    <select id="static" class="form-control" style="text-transform: uppercase;" name="asstype">
                      <option hidden value="">select asset type</option>
                      <?php echo fill_asset($connection); ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="bmd-label-floating">Quantity</label>
                    <input type="tel" class="form-control" name="qty">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label class="bmd-label-floating">Unit Price</label>
                    <input type="number" class="form-control" name="price">
                  </div>
                </div>
                <div class="col-md-4" id="fd">
                  <div class="form-group">
                    <label class="bmd-label-floating">Asset No</label>
                    <input type="number" class="form-control" name="ass_no">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Branch:</label>
                    <select id="static" class="form-control" name="branch">
                      <option hidden value="">select branch</option>
                      <?php echo branch_option($connection); ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <script>
                    $(document).ready(function() {
                      $('#gl_income').on("change keyup paste", function() {
                        var id = $(this).val();
                        var ist = $('#int_id').val();
                        $.ajax({
                          url: "ajax_post/gl/find_income_gl.php",
                          method: "POST",
                          data: {
                            id: id,
                            ist: ist
                          },
                          success: function(data) {
                            $('#income').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <div class="form-group">
                    <label for="shortSharesName">Asset GL<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="gl_code" id="gl_income" required>
                    <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                  </div>
                  <div id="income"></div>
                </div>
                <!-- Expense GL comes here -->
                <div class="col-md-4">
                  <script>
                    $(document).ready(function() {
                      $('#gl_expense').on("change keyup paste", function() {
                        var id = $(this).val();
                        var ist = $('#int_id').val();
                        $.ajax({
                          url: "ajax_post/gl/acct_rep.php",
                          method: "POST",
                          data: {
                            id: id,
                            ist: ist
                          },
                          success: function(data) {
                            $('#expense').html(data);
                          }
                        })
                      });
                    });
                  </script>

                  <div class="form-group">
                    <label for="">Asset Expense Journal:</label>
                    <input type="text" class="form-control" name="expense_gl" id="gl_expense" required>
                    <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                  </div>
                  <div id="expense"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Location</label>
                    <input type="text" class="form-control" name="location">
                  </div>
                </div>
                <div id="showme" class="col-md-2">
                  <div class="form-group">
                    <label class="bmd-label-floating">Depreciation(%)</label>
                    <input type="number" class="form-control" name="depre">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Purchase Date</label>
                    <input type="date" min="<?php echo $minDate; ?>" max="<?php echo $today; ?>" name="purdate" class="form-control" required />
                  </div>
                </div>
              </div>
              <a href="client.php" class="btn btn-secondary">Back</a>
              <button type="submit" class="btn btn-primary pull-right">Submit</button>
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