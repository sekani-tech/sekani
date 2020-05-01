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
  // now we will upload
  $sqltell = "INSERT INTO `tellers` (`int_id`, `branch_id`,
  `name`, `description`, `till_no`, `post_limit`, `valid_from`, `valid_to`, `state`, `is_deleted`) 
  VALUES ('{$int_id}', '{$branch}', '{$tell_name}', '{$tell_no}',
  '{$till_no}', '{$post_lim}', '{$vf}', '$vt', '$st', '0')";
  $done = mysqli_query($connection, $sqltell);
if ($done) {
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
                      <div class="col-md-4 form-group">
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
                          <label class="bmd-label-floating" >Description</label>
                          <input type="text" name="teller_no" value="<?php echo "Teller id"; ?>"" id="tell_desc" class="form-control" required>
                          <div id="tellers"></div>
                          <input type="text" id="int_id" value="<?php echo $sessint_id; ?>" hidden class="form-control">
                          <!-- damn -->
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
                        $getgl = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && name LIKE 'Teller Fund%' && classification_enum = '$cla' && parent_id IS NOT NULL ORDER BY name ASC";
                        $res = mysqli_query($connection, $getgl);
                        $out = '';
                        while ($row = mysqli_fetch_array($res))
                        {
                          $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
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