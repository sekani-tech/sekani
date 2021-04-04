<?php

$page_title = "Post Inventory";
$destination = "accounting.php";
include("header.php");

?>

<style>
.list-group{  
    cursor: pointer;  
}
.list-group-item{  
    color: #972FB0;
    padding: 8px;
    border-bottom: 1px solid #E9ECEF;
}  
.list-group-item:hover{  
    background-color: #972FB0;
    color: #FFFFFF;  
}
</style> 

<?php
$int_id = $_SESSION['int_id'];
$branch_id = $_SESSION['branch_id'];

$date = date('Y-m-d');

if(isset($_SESSION['error'])) { 
    echo "
    <script>
        swal('{$_SESSION['error']}', ' ', 'error', {
        button: false,
        timer: 3000
        });
    </script>"
    ;
    unset($_SESSION['error']);
}

if(isset($_SESSION['success'])) {
    echo "
    <script>
        swal('{$_SESSION['success']}', ' ', 'success', {
        button: false,
        timer: 3000
        });
    </script>"
    ;
    unset($_SESSION['success']);
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
                        <form method="POST" action="ajax_post/inventory_submit.php" enctype="multipart/form-data">
                            <input type="hidden" name="int_id" value="<?php echo $int_id; ?>">
                            <input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>">
                            <!-- End of Javascript for the codes -->
                            <!-- for the permission -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Date:</label>
                                        <input type="date" readonly value="<?php echo $date; ?>" name="date"
                                               id="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Transaction ID:</label>
                                        <?php
                                            $charset = '0123456789';
                                            $rand_str = '';
                                            $numLength = '11';
                                            while(strlen($rand_str) < $numLength) {
                                                $rand_str .= substr(str_shuffle($charset), 0, 1);
                                            }
                                            $transaction_id = 'inv-' . $rand_str;
                                        ?>
                                        <input type="text" readonly value="<?php echo $transaction_id; ?>" name="transaction_id"
                                               id="transactionId" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Item:</label>
                                        <input type="text" name="item" id="item" class="form-control" autocomplete="off" required>
                                        <span id="itemList"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Quantity:</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Unit Price:</label>
                                        <input type="number" name="price" id="unit" class="form-control" required>
                                    </div>
                                </div>
                                <script>
                                    // Script to calculate total
                                    $(document).ready(function () {
                                        $('#quantity').on("change keyup paste click", function () {
                                            var quantity = $(this).val();
                                            var unit = $('#unit').val();
                                            var ans = quantity * unit;
                                            if (ans) {
                                                // document.getElementById('total').readOnly = false;
                                                $('#total').val(ans);
                                            } else {
                                                $('#total').val("Nothing");
                                            }
                                        });

                                        $('#unit').on("change keyup paste click", function () {
                                            var unit = $(this).val();
                                            var quantity = $('#quantity').val();
                                            var ans = unit * quantity;
                                            if (ans) {
                                                // document.getElementById('total').readOnly = false;
                                                $('#total').val(ans);
                                            } else {
                                                $('#total').val("Nothing");
                                            }
                                        });
                                    });
                                </script>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Total Price:</label>
                                        <input type="number" readonly name="total" id="total" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Type:</label>
                                        <select name="is_book" class="form-control" id="is_book" required>
                                            <option value="">select an option</option>
                                            <option value="1">Cheque Book</option>
                                            <option value="2">Pass Book</option>
                                            <option value="0">None of the above</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating" for="">Charge:</label>
                                        <input type="text" name="charge" id="charge" class="form-control" required>
                                        <input type="hidden" name="charge_id" id="charge_id">
                                        <span id="chargeList"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="submit" value="edit_permission" type="button"
                                        id="submit" class="btn btn-primary">Save changes
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

    <script>  
        $(document).ready(function(){  
            $('#item').on("change keyup paste click", function(){ 
                var item = $(this).val();
                if(item != '')  
                {  
                    $.ajax({  
                        url:"ajax_post/inventory_search.php",  
                        method:"POST",
                        data:{item:item},  
                        success:function(data)  
                        {  
                            $('#itemList').fadeIn();  
                            $('#itemList').html(data);
                            // since at this point no item is selected,
                            // set the value of the date field to the current date
                            var today = '<?php echo $date; ?>';
                            $('#date').val(today);
                            // since at this point no item is selected, 
                            // set the value of the transaction id field to the auto-generated id
                            var transactionId = '<?php echo $transaction_id; ?>';
                            $('#transactionId').val(transactionId);
                            // since at this point no item is selected, 
                            // set the value of the quantity, unit and total fields to an empty string
                            $('#quantity').val('');
                            $('#unit').val('');
                            $('#total').val('');
                            $('#is_book').val('');
                            $('#charge').val('');
                            $('#charge_id').val('');
                        }
                    });
                } 
                else {
                    $('#itemList').fadeOut();
                }
            });

            $(document).on('click', '.inv-item', function(){  
                $('#item').val($(this).text());  
                $('#itemList').fadeOut();
                
                var item = $(this).text();
                $.ajax({  
                    url:"ajax_post/inventory_search.php",  
                    method:"POST",
                    data:{existingItem:item},
                    dataType: 'JSON',
                    success:function(data)  
                    {
                        $('#date').val(data.date);
                        $('#transactionId').val(data.transaction_id);
                        $('#quantity').val(data.quantity);
                        $('#unit').val(data.unit_price);
                        $('#total').val(data.total_price);
                        $('#is_book').val(data.is_book);
                        $('#charge').val(data.charge);
                        $('#charge_id').val(data.charge_id);
                    } 
                });
            });

            $('#charge').on("change keyup paste click", function(){ 
                var charge = $(this).val();
                if(charge != '')
                {  
                    $.ajax({  
                        url:"ajax_post/charges_search.php",  
                        method:"POST",
                        data:{charge_name:charge},  
                        success:function(data)  
                        {  
                            $('#chargeList').fadeIn();  
                            $('#chargeList').html(data);
                        }
                    });
                } 
                else {
                    $('#chargeList').fadeOut();
                }
            });
            
            $(document).on('click', '.charge-item', function(){  
                $('#charge').val($(this).text());  
                $('#chargeList').fadeOut();

                var charge = $(this).text();
                $.ajax({  
                    url:"ajax_post/charges_search.php",  
                    method:"POST",
                    data:{charge_selected:charge},
                    success:function(data)  
                    {
                        $('#charge_id').val(data);
                    }
                });
            });

            $('#item').focus(function() { 
                $('#chargeList').fadeOut(); 
            });

            $('#quantity').focus(function() { 
                $('#itemList').fadeOut();
                $('#chargeList').fadeOut(); 
            });

            $('#unit').focus(function() { 
                $('#itemList').fadeOut();
                $('#chargeList').fadeOut(); 
            });
            
            $('#charge').focus(function() { 
                $('#itemList').fadeOut(); 
            });
        });  
    </script>

<?php

include("footer.php");

?>