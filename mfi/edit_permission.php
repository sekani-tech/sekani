<?php

$page_title = "Edit Permissions";
$destination = "staff_mgmt.php";
    include("header.php");

?>
<?php
if(isset($_GET['id'])){
   // Code to display values
   $id = $_GET['id'];
   $rom = mysqli_query($connection, "SELECT * FROM permission WHERE role_id = '$id' && int_id = '$sessint_id'");
   $v = mysqli_fetch_array($rom);
   $trans_approv= $v['trans_appv'];
   $trans_post = $v['trans_post'];
   $loan_approv = $v['loan_appv'];
   $acct_approv = $v['acct_appv'];
   $valut = $v['valut'];
   $vault_email = $v['vault_email'];
   $view_report = $v['view_report'];
   $view_dashbord = $v['view_dashboard'];
   $configuration = $v['configuration'];
   $acc_op = $v['acc_op'];
   $acc_update = $v['acc_update'];
   $pole = $v['role_id'];
   $rpo = mysqli_query($connection, "SELECT * FROM org_role WHERE id = '$pole' && int_id = '$sessint_id'");
   $u = mysqli_fetch_array($rpo);
   $rolename = $u['role'];

   if($trans_approv == 1){
    $a = 'checked';
   }
   else{
     $a = 'unchecked';
   }
   if($trans_post == 1){
    $b = 'checked';
   }else{
    $b = 'unchecked';
  }
   if($loan_approv == 1){
    $c = 'checked';
   }
   else{
     $c = 'unchecked';
   }
   if($acct_approv == 1){
    $d = 'checked';
   }
   else{
     $d = 'unchecked';
   }
   if($valut == 1){
    $e = 'checked';
   }
   else{
     $e = 'unchecked';
   }
   if($vault_email == 1){
    $f = 'checked';
   }
   else{
     $f = 'unchecked';
   }
   if($view_report == 1){
    $g = 'checked';
   }
   else{
     $g = 'unchecked';
   }
   if($view_dashbord == 1){
    $i = 'checked';
   }
   else{
     $i = 'unchecked';
   }
   if($configuration == 1){
    $j = 'checked';
   }
   else{
     $j = 'unchecked';
   }
   if($acc_op == 1){
    $k = 'checked';
   }
   else{
     $k = 'unchecked';
   }
   if($acc_update == 1){
    $l = 'checked';
   }
   else{
     $l = 'unchecked';
   }
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check the button value
  $post = $_POST['submit'];
 if($_POST['sumbit'] = 'edit_permission'){
   if(isset($_POST['approve'])){
     $approve = 1;
   }else{
     $approve = 0;
   }
  if(isset($_POST['post_transact'])){
    $post_transact = 1;
   }else{
    $post_transact = 0;
   }
  if(isset($_POST['access_config'])){
    $access_config = 1;
   }else{
    $access_config = 0;
   }
  if(isset($_POST['approve_loan'])){
    $approve_loan = 1;
   }else{
    $approve_loan = 0;
   }

  if(isset($_POST['approve_acc'])){
    $approve_acc = 1;
   }else{
    $approve_acc = 0;
   }
  if(isset($_POST['vault_trans'])){
    $vault_trans = 1;
   }else{
    $vault_trans = 0;
   }
  if(isset($_POST['view_report'])){
    $view_report = 1;
   }else{
    $view_report = 0;
   }
  if(isset($_POST['approve'])){
    $dash = 1;
   }else{
    $dash = 0;
   }
   if(isset($_POST['accup'])){
    $accup = 1;
   }else{
    $accup = 0;
   }
   if(isset($_POST['accop'])){
    $accop = 1;
   }else{
    $accop = 0;
   }
  if(isset($_POST['emai'])){
    $emai = 1;
   }else{
    $emai = 0;
   }
   $rod = "UPDATE permission SET acc_op = '$accop', acc_update = '$accup', trans_appv = '$approve', trans_post = '$post_transact', loan_appv = '$approve_loan', acct_appv = '$approve_acc', valut = '$vault_trans',
    vault_email = '$emai', view_report = '$view_report', view_dashboard = '$dash', configuration = '$access_config' WHERE int_id = '$sessint_id'
    && role_id = '$id'";
    $rox = mysqli_query($connection, $rod);
    if($rox){
      $URL="staff_mgmt.php";
      echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    else{
      echo '<script type="text/javascript">
              $(document).ready(function(){
                  swal({
                      type: "error",
                      title: "Cannot Edit Permission",
                      text: "The permissions has already been added to this role",
                      showConfirmButton: false,
                      timer: 2000
                  })
              });
              </script>
              ';
    }
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
                  <h4 class="card-title ">Edit Roles</h4>
                </div>
                <div class="card-body">
                <h4> Edit <?php echo $rolename;?></h4>
                <div class="col-md-12">
             <div>
               <p>
               <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="0" name="sms_active" id="all">
                Check & Uncheck All
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           <br/>
               </p>
             </div>
           </div>
           <form method="POST" enctype="multipart/form-data">
           <script>
             $(document).ready(function () {
               $('#all').change(function () {
                if ($(this).is(':checked')) {
                  document.getElementById('n1').checked = true;
                  document.getElementById('n2').checked = true;
                  document.getElementById('n3').checked = true;
                  document.getElementById('n4').checked = true;
                  document.getElementById('n5').checked = true;
                  document.getElementById('n6').checked = true;
                  document.getElementById('n7').checked = true;
                  document.getElementById('n9').checked = true;
                  document.getElementById('n8').checked = true;
                  document.getElementById('n11').checked = true;
                  document.getElementById('n12').checked = true;
                } else {
                  document.getElementById('n1').checked = false;
                  document.getElementById('n2').checked = false;
                  document.getElementById('n3').checked = false;
                  document.getElementById('n4').checked = false;
                  document.getElementById('n5').checked = false;
                  document.getElementById('n6').checked = false;
                  document.getElementById('n7').checked = false;
                  document.getElementById('n9').checked = false;
                  document.getElementById('n8').checked = false;
                  document.getElementById('n11').checked = false;
                  document.getElementById('n12').checked = false;
                }
               });
             })
           </script>
           <!-- End of Javascript for the codes -->
            <!-- for the permission -->
            <div class="row">
            <div class="col-md-4">
           <!-- Last -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $k;?> class="form-check-input" type="checkbox" value="" name="accop" id="n11">
                Account Opening
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            <div class="col-md-4">
           <!-- Last -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $l;?> class="form-check-input" type="checkbox" value="" name="accup" id="n12">
                Account Update
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            <div class="col-md-4">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $a;?> class="form-check-input" type="checkbox" value="" name="approve" id="n1">
                Approve Transaction
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           </div>
           <!-- Next -->
           <div class="col-md-4">
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $b;?>  class="form-check-input" type="checkbox" value="" name="post_transact" id="n2">
                Post Transaction
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           </div>
           <div class="col-md-4">
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $j;?>  class="form-check-input" type="checkbox" value="" name="access_config" id="n3">
                Access Configuration
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           </div>
           <!-- Last -->
           <div class="col-md-4">
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $c;?>  class="form-check-input" type="checkbox" value="" name="approve_loan" id="n4">
                Approve Loan
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           </div>
            <!-- Another -->
            <div class="col-md-4">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $d;?>  class="form-check-input" type="checkbox" value="" name="approve_acc" id="n5">
                Approve Account
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           </div>
           <div class="col-md-4">
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $e;?> class="form-check-input" type="checkbox" value="" name="vault_trans" id="n6">
                Vault Transaction
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           </div>
           <div class="col-md-4">
           <!-- Next -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $g;?> class="form-check-input" type="checkbox" value="" name="view_report" id="n7">
                View Report
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           </div>
           <div class="col-md-4">
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $i;?> class="form-check-input" type="checkbox" value="" name="dash" id="n8">
                Dashboard
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
           </div>
           <div class="col-md-4">
           <!-- Last -->
           <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input <?php echo $f;?> class="form-check-input" type="checkbox" value="" name="emai" id="n9">
                Vault Email
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            </div>
            <div class="modal-footer">
        <button type="submit" name="submit" value="edit_permission" type="button" class="btn btn-primary">Save changes</button>
      </div>
           </form>
            <!-- End for Permission -->
                </div>
              </div>
            </div>
          </div>
        </div>
<?php

  include("footer.php");

?>