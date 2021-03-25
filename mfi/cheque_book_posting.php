<?php

$page_title = "CHQ/Pass Book Posting";
$destination = "transaction.php";
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
  if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    // $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Posting Successful",
            text: "Cheque book has been posted",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
// If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error During Posting",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
else if (isset($_GET["message3"])) {
  $key = $_GET["message3"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Incomplete Input",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
// $digits = 6;
// $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// $transid = $randms;

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">CHQ Book Portal</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/chq_upload.php" method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <?php
                          // a function for client data fill
                          function fill_client($connection) {
                            $sint_id = $_SESSION["int_id"];
                            $branc = $_SESSION["branch_id"];
                            $org = "SELECT client.id, client.firstname, client.lastname, client.display_name FROM client JOIN branch ON client.branch_id = branch.id WHERE client.int_id = '$sint_id' AND (branch.id = '$branc' OR branch.parent_id = '$branc') AND status = 'Approved' ORDER BY firstname ASC";
                            $res = mysqli_query($connection, $org);
                            $out = '';
                            while ($row = mysqli_fetch_array($res))
                            {
                              $out .= '<option value="'.$row["id"].'">'.$row["display_name"].'</option>';
                            }
                            return $out;
                          }

                          function fill_charge($connection) {
                            $sint_id = $_SESSION["int_id"];
                            $org = "SELECT * FROM charge WHERE int_id = '$sint_id' AND ((name LIKE '%cheque%') OR (name LIKE '%chq%') OR (name LIKE '%check%'))";
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
                            <label class="bmd-label-floating" for="">Account Name</label>
                            <input type="text" name="acc_name" id="acc_name" class="form-control" autocomplete="off" required>
                            <span id="acc_name_list"></span>
                        </div>
                        <script>
                          $(document).ready(function() {
                            $('#acc_name').on("change keyup paste click", function() {
                              var acc_name = $(this).val();
                              if(acc_name != '')  
                              {
                                $.ajax({
                                  url:"ajax_post/chq_accno.php",
                                  method:"POST",
                                  data:{acc_name:acc_name},
                                  success:function(data){
                                    $('#acc_name_list').fadeIn();  
                                    $('#acc_name_list').html(data);
                                  }
                                })
                              } else {
                                $('#acc_name_list').fadeOut();
                              }
                            });

                            $(document).on('click', '.acc-name', function(){  
                                $('#acc_name').val($(this).text());  
                                $('#acc_name_list').fadeOut();
                                
                                var acc_name = $(this).text();
                                $.ajax({  
                                    url:"ajax_post/chq_accno.php",  
                                    method:"POST",
                                    data:{existing_acc_name:acc_name},
                                    success:function(data)  
                                    {
                                      $('#acc_no').html(data);
                                    } 
                                });
                            });
                          })
                        </script>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Account No</label>
                          <select name="acc_no" id="acc_no" class="form-control">
                            <option value="">select an account name</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Item</label>
                          <select id="item" name="book_type" class="form-control">
                            <option value="chq">Chq Book</option>
                            <option value="pas">Pass Book</option>
                          </select>
                        </div>
                        <script>
                          $(document).ready(function() {
                            $('#item').on("change", function(){
                              var id = $(this).val();
                              $.ajax({
                                url:"ajax_post/book_type.php",
                                method:"POST",
                                data:{id:id,},
                                success:function(data){
                                  $('#done').html(data);
                                }
                              })
                            });
                          });
                        </script>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range No</label>
                          <input type="text" class="form-control" name="range">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Transaction ID:</label>
                          <script>
                            $(document).ready(function() {
                              <?php
                                $charset = '0123456789';
                                $rand_str = '';
                                $numLength = '11';
                                while(strlen($rand_str) < $numLength) {
                                    $rand_str .= substr(str_shuffle($charset), 0, 1);
                                }
                              ?>

                              var defaultItem = $('#item').val();
                              var randomDigits = '<?php echo $rand_str; ?>';
                              var transId = defaultItem + "-" + randomDigits;
                              $('#trans_id').val(transId);

                              $('#item').on("change", function(){
                                var itemSelected = $(this).val();
                                var transId = itemSelected + "-" + randomDigits;
                                $('#trans_id').val(transId);
                              });
                            });
                          </script>
                          <input type="text" readonly value="" name="transid" class="form-control" id="trans_id">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div id="done" class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">No of Leaves</label>
                            <select name="no_leaves" class="form-control">
                              <option hidden value="0">select an option</option>
                              <option value="50">1-50</option>
                              <option value="100">1-100</option>
                              <option value="150">1-150</option>
                              <option value="200">1-200</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div id="" class="form-group">
                            <label class="bmd-label-floating">Charge Applied</label>
                            <select name="charge_app" class="form-control">
                              <?php echo fill_charge($connection);?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- </div> -->
                    <a href="client.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Issue</button>
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