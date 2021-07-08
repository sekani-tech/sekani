<?php

$page_title = "Create Teller";
$destination = "staff_mgmt.php";
    include("header.php");

    function fill_client($connection) {
      $sint_id = $_SESSION["int_id"];
      $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
      $res = mysqli_query($connection, $org);
      $out = '';
      while ($row = mysqli_fetch_array($res))
      {
        $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
      }
      return $out;
    }

?>
<?php
$m_id = $_SESSION["user_id"];
$getacct1 = mysqli_query($connection, "SELECT * FROM staff WHERE user_id = '$m_id' && int_id = '$sessint_id'");
if (count([$getacct1]) == 1) {
    $uw = mysqli_fetch_array($getacct1);
    $staff_id = $uw["id"];
}
?>
<!-- Content added here -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // for the post
  $branch = $_POST['branch'];
  $tell_name = $_POST['tell_name'];
  $tell_no = $_POST['teller_no'];
  $post_lim = $_POST['post_limit'];
  $int_id = $sessint_id;
  $vf = date('Y-m-d H:i:s');
  $vt = date('Y-m-d H:i:s');
  $st = 300;
  $checkx = $_POST['till_no'];
  // adding a till number
    $query = "SELECT * FROM tellers WHERE int_id = '$sessint_id'";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $inr = mysqli_num_rows($result);
        $till_no = $checkx.$inr + 1;
    }
    $till = $checkx;
  // now we will upload
  $sqltell = "INSERT INTO `tellers` (`int_id`, `branch_id`,
  `name`, `description`, `till_no`, `post_limit`, `valid_from`, `valid_to`, `state`, `is_deleted`, `till`) 
  VALUES ('{$int_id}', '{$branch}', '{$tell_name}', '{$tell_no}',
  '{$till_no}', '{$post_lim}', '{$vf}', '$vt', '$st', '0', '{$till}')";
  $done = mysqli_query($connection, $sqltell);
if ($done) {
  $digits = 4;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$account_no = $int_id.$branch.$randms;
// done with account number preparation
$submitted_on = date("Y-m-d");
$currency = "NGN";
$abdc = 0;
  $queryx = "INSERT INTO institution_account (int_id, branch_id, account_no,
  teller_id, account_balance_derived,
    submittedon_date, submittedon_userid, currency_code, gl_code) VALUES ('{$int_id}',
    '{$branch}', '{$account_no}',
    '{$tell_name}', '{$abdc}', '{$submitted_on}', '{$staff_id}', '{$currency}', '{$checkx}')";
    $gogoo = mysqli_query($connection, $queryx);
    if ($gogoo) {
      echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
       type: "success",
        title: "TELLER",
          text: "Successfully Created",
       showConfirmButton: false,
     timer: 2000
      })
      });
</script>';
    } else {
      echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
       type: "error",
        title: "TELLER",
          text: "Error in Creation",
       showConfirmButton: false,
     timer: 2000
      })
      });
</script>';
    }
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
       type: "error",
        title: "TELLER",
          text: "Error in Creation",
       showConfirmButton: false,
     timer: 2000
      })
      });
</script>';
}
}
?>
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
                  <form method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Branch</label>
                          <select name="branch" class="form-control" id="input" required>
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                        </select>
                        </div>
                      </div>
                  <script>
                        $(document).ready(function() {
                          $('#input').change(function(){
                            var id = $(this).val();
                            var tell_name = $('#input').val();
                            var int_id = $('#int_id').val();
                            $.ajax({
                              url:"create_teller_branch.php",
                              method:"POST",
                              data:{id:id, int_id:int_id},
                              success:function(data){
                                $('#show_branch').html(data);
                              }
                            })
                          });
                        })
                      </script>
                            <!-- another -->
                            <!-- da -->
                      <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">Teller Name</label>
                        <!-- <div id="show_branch"></div> -->
                        <select id="show_branch" name="tell_name" class="form-control" required>
                        </select>
                      </div>
                      </div>
                      <script>
                              $(document).ready(function() {
                                $('#tell_desc').on('change keyup paste click', function(){
                                  var me = $(this).val();
                                  var id = $('#input').val();
                                  var tell_name = $('#input').val();
                                  var int_id = $('#int_id').val();
                                  $.ajax({
                                    url:"ajax_post/tellme.php",
                                    method:"POST",
                                    data:{id:id, int_id:int_id, me:me},
                                    success:function(data){
                                      $('#tellers').html(data);
                                    }
                                  })
                                });
                              })
                        </script>
                      <div class="col-md-4 form-group">
                      <script>
                              $(document).ready(function() {
                                $('#input').change(function(){
                                  var id = $(this).val();
                                  var tell_name = $('#input').val();
                                  var int_id = $('#int_id').val();
                                  $.ajax({
                                    url:"ajax_post/read_record.php",
                                    method:"POST",
                                    data:{id:id, int_id:int_id},
                                    success:function(data){
                                      $('#show_read').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                            <div id="show_read"></div>
                            <div id="tellers"></div>
                            <input type="text" id="int_id" value="<?php echo $sessint_id; ?>" hidden class="form-control">
                      </div>
                      <div class="col-md-4 form-group">
                          <label class="bmd-label-floating" >Posting Limit</label>
                          <input type="number" name="post_limit" id="" class="form-control" required>
                      </div>
                      <div class="col-md-4 form-group">
                        <?php
                        function fill_gl($connection) {
                        $sint_id = $_SESSION["int_id"];
                        $cla = 1;
                        $getgl = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && name LIKE 'Teller%' && classification_enum = '$cla' && parent_id IS NOT NULL ORDER BY name ASC";
                        $res = mysqli_query($connection, $getgl);
                        $out = '';
                        while ($row = mysqli_fetch_array($res))
                        {
                          $out .= '<option value="'.$row["gl_code"].'">'.$row["name"].'</option>';
                        }
                        return $out;
                        }
                        ?>
                          <label class="bmd-label-floating" >Gl Acct.</label>
                          <select name="till_no" id=""  class="form-control" >
                            <option value="">select Gl Account</option>
                            <?php echo fill_gl($connection) ?>
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