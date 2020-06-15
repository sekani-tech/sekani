<?php

$page_title = "Post Inventory";
$destination = "index.php";
    include("header.php");

?>
<?php
$sessint_id = $_SESSION['int_id'];
$branch_id = $_SESSION['branch_id'];

$reo = mysqli_query($connection, "SELECT * FROM inventory WHERE int_id ='$sessint_id'");
$mw = mysqli_num_rows($reo);
$sn = $mw + 1;
$date = date('Y-m-d');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check the button value
  $post = $_POST['submit'];
 if($_POST['sumbit'] = 'edit_permission'){
  $item = $_POST['item'];
  $seer = $_POST['srial'];
  $da = $_POST['datce'];
  $quant = $_POST['quant'];
  $unit = $_POST['price'];
  $total = $quant * $unit;

   $rod = "INSERT INTO inventory(int_id, branch_id, serial_no, date, item, quantity, unit_price, total_price)
   VALUES('{$sessint_id}', '{$branch_id}', '{$seer}', '{$da}', '{$item}', '{$quant}', '{$unit}', '{$total}', ) ";
    $rox = mysqli_query($connection, $rod);
    if($rox){
      $URL="staff_mgmt.php";
      echo '<script type="text/javascript">
      $(document).ready(function(){
          swal({
              type: "success",
              title: "Successful",
              text: "The inventory data has been added successfully",
              showConfirmButton: false,
              timer: 2000
          })
      });
      </script>
      ';
      echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    else{
      echo '<script type="text/javascript">
              $(document).ready(function(){
                  swal({
                      type: "error",
                      title: "CannotAdd Inventory",
                      text: "Error Occured in the Posting",
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
                  <h4 class="card-title ">Inventory Posting</h4>
                </div>
                <div class="card-body">
                <div class="col-md-12">
           </div>
           <form method="POST" enctype="multipart/form-data">
           <!-- End of Javascript for the codes -->
            <!-- for the permission -->
            <div class="row">
            <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Date:</label>
              <input type="date" readonly value="<?php echo $date;?>" name="datce" id="office_address" class="form-control">
          </div>
        </div>
            <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Serial No:</label>
              <input type="text" readonly value="<?php echo $sn;?>" name="srial" id="office_address" class="form-control">
          </div>
        </div>
            <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Item:</label>
              <input type="text" name="item" id="office_address" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Quantity:</label>
              <input type="number" name="quant" id="quannt" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Unit Price:</label>
              <input type="number" name="price" id="unit" class="form-control">
          </div>
        </div>
        <script>
        // Script to calculate total
            $(document).ready(function(){
            $('#unit').on("change keyup paste click", function() {
                var unitt = $(this).val();
                var quanti = $('#quannt').val();
                var ans = unitt * quanti;
                if (ans) {
                document.getElementById('tit').readOnly = false;
                $('#tit').val(ans);
                } else {
                $('#tit').val("Nothing");
                }
            });
            });
            $(document).ready(function(){
            $('#quannt').on("change keyup paste click", function() {
                var unitt = $(this).val();
                var quanti = $('#unit').val();
                var ans = unitt * quanti;
                if (ans) {
                document.getElementById('tit').readOnly = false;
                $('#tit').val(ans);
                } else {
                $('#tit').val("Nothing");
                }
            });
            });
        </script>
        <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Total Price:</label>
              <input type="number" readonly name="ttl" id="tit" class="form-control">
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