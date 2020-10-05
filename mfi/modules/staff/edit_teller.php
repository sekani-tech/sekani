<?php

$page_title = "Edit Teller";
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
$id = $_GET['id'];
$sint_id = $_SESSION["int_id"];
$odsp = "SELECT * FROM tellers WHERE id = '$id' AND int_id = '$sint_id'";
$fio = mysqli_query($connection, $odsp);
$fk = mysqli_fetch_array($fio);
$t_name = $fk['name'];
$branchin = $fk['branch_id'];
$desc = $fk['description'];
$post_lim = $fk['post_limit'];

$sdop = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '$sint_id' AND id = '$branchin'");
$dfop = mysqli_fetch_array($sdop);
$bname = $dfop['name'];

$sdo = mysqli_query($connection, "SELECT * FROM staff WHERE int_id = '$sint_id' AND id = '$t_name'");
$sio = mysqli_fetch_array($sdo);
$sname = $sio['display_name'];

$kdl = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sint_id' AND teller_id = '$t_name'");
$fop = mysqli_fetch_array($kdl);
$gll = $fop['gl_code'];


$poc = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND gl_code = '$gll'");
$osp = mysqli_fetch_array($poc);
$gname = $osp['name'];
?>
<!-- Content added here -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $do = $_POST['submit'];
    if($do == 'edi'){
        $post_l = $_POST['post_limit'];
        $gl_code = $_POST['till_no'];
        $description = $_POST['teller_no'];
        $oint_id = $_POST['inut_id'];
        $t_id = $_POST['t_id'];
        $staff_id = $_POST['tell_name'];

        $dfklf = "SELECT * FROM tellers WHERE id = '$t_id' AND int_id = '$oint_id'";
        $ofp = mysqli_query($connection, $dfklf);
        $fk = mysqli_fetch_array($ofp);
        $wpeo = $fk['post_limit'];
        $sdpdo = $fk['description'];
        $covp = $fk['int_id'];
        $wpeo = $fk['name'];

        $spdo = "SELECT * FROM institution_account WHERE int_id = '$oint_id' AND teller_id = '$wpeo'";
        $fjdif = mysqli_query($connection, $spdo);
        $we = mysqli_fetch_array($fjdif);
        $dopf = $we['gl_code'];

        if($sdpdo == $description && $wpeo == $post_l && $dopf == $gl_code){
            echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                     type: "success",
                      title: "hello EDIT",
                        text: "Successfully edited",
                     showConfirmButton: false,
                   timer: 2000
                    })
                    });
             </script>';
        }else
        {

        $cvoi = "UPDATE tellers SET description = '$description', post_limit = '$post_l' WHERE id = '$t_id' AND int_id = '$oint_id'";
        $dfo = mysqli_query($connection, $cvoi);
        if($dfo){
            $dfpo = "UPDATE institution_account SET gl_code='$gl_code' WHERE int_id = '$oint_id' AND teller_id = '$staff_id'";
            $jk = mysqli_query($connection, $dfpo);

            if ($jk) {
                echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                     type: "success",
                      title: "TELLER EDIT",
                        text: "Successfully edited",
                     showConfirmButton: false,
                   timer: 2000
                    })
                    });
             </script>';
             $URL="../mfi/staff_mgmt.php?message1=$randms";

             echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
              } else {
                echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                     type: "error",
                      title: "TELLER EDIT",
                        text: "Error in editing",
                     showConfirmButton: false,
                   timer: 2000
                    })
                    });
             </script>';
              }
        }
    }
    }
    else if($do == 'rem'){
        $post_l = $_POST['post_limit'];
        $gl_code = $_POST['till_no'];
        $description = $_POST['teller_no'];
        $oint_id = $_POST['inut_id'];
        $t_id = $_POST['t_id'];
        $staff_id = $_POST['tell_name'];

        $spdo = "SELECT * FROM institution_account WHERE int_id = '$oint_id' AND teller_id = '$staff_id'";
        $fjdif = mysqli_query($connection, $spdo);
        $we = mysqli_fetch_array($fjdif);
        $account_bal = $we['account_balance_derived'];

        if($account_bal > 0){
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                 type: "error",
                  title: "Termination Error",
                    text: "Teller\'s Till still has Money!",
                 showConfirmButton: false,
               timer: 2000
                })
                });
         </script>';
        }
        else{
            $fido = "DELETE FROM tellers WHERE id = '$t_id' AND int_id = '$oint_id'";
            $dpo = mysqli_query($connection, $fido);
            if($dpo){
            $doi = "DELETE FROM institution_account WHERE int_id = '$oint_id' AND teller_id = '$staff_id'";
            $dkofi = mysqli_query($connection, $doi);
            if($dkofi){
                echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                     type: "success",
                      title: "TELLER Terminated",
                        text: "Successfully edited",
                     showConfirmButton: false,
                   timer: 2000
                    })
                    });
             </script>';
             $URL="../mfi/staff_mgmt.php?message1=$randms";

             echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            }
            }
        }
    }
}
else{

}
?>
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Edit teller</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Branch</label>
                          <input type="text" value="<?php echo $bname;?>" name="branch" id="input" class="form-control" readonly>
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
                        <input type="text" value="<?php echo $sname;?>" id="show_branch" name="" class="form-control" readonly>
                        <input type="text" value="<?php echo $t_name;?>" hidden name="tell_name" class="form-control" readonly>
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
                            <div id="show_read">
                            <label class="bmd-label-floating" >Description</label>
                            <input type="text" name="teller_no" value="<?php echo $desc;?>" value="" id="tell_desc" class="form-control" required>
                            </div>
                            <input type="text" name="inut_id" value="<?php echo $sessint_id; ?>" hidden class="form-control">
                            <input type="text" name="t_id" value="<?php echo $id; ?>" hidden class="form-control">

                      </div>
                      <div class="col-md-4 form-group">
                          <label class="bmd-label-floating" >Posting Limit</label>
                          <input type="number" value = "<?php echo $post_lim;?>" name="post_limit" id="" class="form-control" required>
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
                            <option hidden value="<?php echo $gll;?>"><?php echo $gname;?></option>
                            <?php echo fill_gl($connection) ?>
                          </select>
                      </div>
                      </div>
                      <button type="submit" name="submit" value="rem" class="btn btn-danger pull-right">Remove Teller</button>
                    <button type="submit" name="submit" value="edi" class="btn btn-primary pull-right">Edit Teller</button>
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