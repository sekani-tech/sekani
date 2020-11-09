<?php

$page_title = "Post Inventory";
$destination = "accounting.php";
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
    if ($post == 'edit_permission') {
        $item = $_POST['item'];
        $seer = $_POST['srial'];
        $da = $_POST['datce'];
        $quant = $_POST['quant'];
        $unit = $_POST['price'];
        $total = $quant * $unit;

        $rod = "INSERT INTO inventory(int_id, branch_id, serial_no, date, item, quantity, unit_price, total_price)
   VALUES('{$sessint_id}', '{$branch_id}', '{$seer}', '{$da}', '{$item}', '{$quant}', '{$unit}', '{$total}' ) ";
        $ccccx = mysqli_query($connection, $rod);
        if ($ccccx) {
            $URL = "inventory.php";
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
        } else {
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
//  else if($post == 'chq'){
//     $digits = 6;
//     $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
//     $sessint_id = $_SESSION["int_id"];
//     $branch = $_SESSION["branch_id"];
//     $name = $_POST['acc_name'];
//     $account_no = $_POST['acc_no'];
//     $leaves_no = $_POST['no_leaves'];
//     $range = $_POST['range'];

//     // credit checks and accounting rules
//     // insertion query for product
//     $query ="INSERT INTO chq_book(int_id, name, branch_id, account_no, leaves_no, range, date)
//     VALUES ('{$sessint_id}', '{$name}','{$branch}', '{$account_no}', '{$leaves_no}', '{$range}', '{$date}')";

//     $rox = mysqli_query($connection, $query);
//     if($rox){
//         $URL="inventory.php";
//         echo '<script type="text/javascript">
//         $(document).ready(function(){
//             swal({
//                 type: "success",
//                 title: "Successful",
//                 text: "The Cheque Book has been posted",
//                 showConfirmButton: false,
//                 timer: 2000
//             })
//         });
//         </script>
//         ';
//         echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
//       }
//       else{
//         echo '<script type="text/javascript">
//                 $(document).ready(function(){
//                     swal({
//                         type: "error",
//                         title: "CannotAdd Inventory",
//                         text: "Error Occured in the Posting",
//                         showConfirmButton: false,
//                         timer: 2000
//                     })
//                 });
//                 </script>
//                 ';
//       }
//  }
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
                                        <label class="bmd-label-floating" for="">Date:</label>
                                        <input type="date" readonly value="<?php echo $date; ?>" name="datce"
                                               id="office_address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Serial No:</label>
                                        <input type="text" readonly value="<?php echo $sn; ?>" name="srial"
                                               id="office_address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Item:</label>
                                        <input type="text" name="item" id="office_address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Quantity:</label>
                                        <input type="number" name="quant" id="quannt" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Unit Price:</label>
                                        <input type="number" name="price" id="unit" class="form-control">
                                    </div>
                                </div>
                                <script>
                                    // Script to calculate total
                                    $(document).ready(function () {
                                        $('#unit').on("change keyup paste click", function () {
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
                                    $(document).ready(function () {
                                        $('#quannt').on("change keyup paste click", function () {
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
                                        <label class="bmd-label-floating" for="">Total Price:</label>
                                        <input type="number" readonly name="ttl" id="tit" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="submit" value="edit_permission" type="button"
                                        class="btn btn-primary">Save changes
                                </button>
                            </div>
                        </form>
                        <!-- End for Permission -->
                    </div>
                </div>
                <!-- <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">CHQ Book Portal</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-4">
                          <?php
                // a function for client data fill
                function fill_client($connection)
                {
                    $sint_id = $_SESSION["int_id"];
                    $org = "SELECT * FROM client WHERE int_id = '$sint_id'";
                    $res = mysqli_query($connection, $org);
                    $out = '';
                    while ($row = mysqli_fetch_array($res)) {
                        $out .= '<option value="' . $row["id"] . '">' . $row["display_name"] . '</option>';
                    }
                    return $out;
                }

                ?>
                          <script>
                              $(document).ready(function() {
                                $('#acc_name').change(function(){
                                  var id = $(this).val();
                                  $.ajax({
                                    url:"ajax_post/chq_accno.php",
                                    method:"POST",
                                    data:{id:id},
                                    success:function(data){
                                      $('#showing').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                        <div class="form-group">
                          <label class="bmd-label-floating"> Accural Name</label>
                          <select name="acc_name" class="form-control" id="acc_name">
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Account No</label>
                          <select name="acc_no" class="form-control" id="showing">
                          <option value="">select an option</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">No of Leaves</label>
                          <select name="no_leaves" class="form-control" id="acc_name">
                          <option value="">select an option</option>
                          <option value="">1-50</option>
                          <option value="">51-100</option>
                          <option value="">101-150</option>
                          <option value="">151-200</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range No</label>
                          <input type="text" class="form-control" name="range">
                        </div>
                      </div>
                      </div>
                      <a href="client.php" class="btn btn-secondary">Back</a>
                    <button type="submit" value = "chq" class="btn btn-primary pull-right">Post Cheque</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div> -->
            </div>
        </div>
    </div>
<?php

include("footer.php");

?>