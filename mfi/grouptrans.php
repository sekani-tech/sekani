<?php

$page_title = "Group Transactions";
$destination = "branch.php";
    include("header.php");

?>
<?php
                      function fill_branch($connection)
                      {
                        $sint_id = $_SESSION["int_id"];
                        $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                        $res = mysqli_query($connection, $org);
                        $output = '';
                        while ($row = mysqli_fetch_array($res))
                        {
                          $output .= '<option value = "'.$row["id"].'"> '.$row["name"].' </option>';
                        }
                        return $output;
                      }
                              function fill_in($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && parent_id !='0' && classification_enum = '1' && disabled = '0' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                          function fill_state($connection)
                            {
                            $org = "SELECT * FROM states";
                            $res = mysqli_query($connection, $org);
                            $out = '';
                            while ($row = mysqli_fetch_array($res))
                            {
                              $out .= '<option value="'.$row["name"].'">' .$row["name"]. '</option>';
                            }
                            return $out;
                            }
                            $digits = 6;
                            $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
                            $transid1 = $randms;
                            ?>
                  <script>
                    $(document).ready(function() {
                      $('#static').on("change", function(){
                        var id = $(this).val();
                        $.ajax({
                          url:"ajax_post/lga.php",
                          method:"POST",
                          data:{id:id},
                          success:function(data){
                            $('#showme').html(data);
                          }
                        })
                      });
                    });
                </script>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="col-md-12">
                  <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title">Deposit/Withdrawal</h4>
                        <!-- <p class="card-category">Fill in all important data</p> -->
                      </div>
                      <div class="card-body">
                      <form action="../functions/withdep.php" method="post">
    <div class="row">
        <div class="col-md-4">
            <script>
                $(document).ready(function() {
                  $('#act').on("change keyup paste click", function(){
                    var id = $(this).val();
                    var ist = $('#int_id').val();
                    $.ajax({
                      url:"acct_name.php",
                      method:"POST",
                      data:{id:id, ist: ist},
                      success:function(data){
                        $('#accname').html(data);
                      }
                    })
                  });
                });
              </script>
            <div class="form-group">
                <label for="">Type</label>
                <select class="form-control" name="test">
                    <option hidden>select an option</option>
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                 </select>
            </div>
            <div id="acct_name"></div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
               <label class="bmd-label-floating">Account Number</label>
               <input type="text" class="form-control" name="account_no" id="act">
               <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id;?>" id="int_id">
            </div>
            <div id="accname"></div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
               <label class="bmd-label-floating">Amount</label>
               <input type="number" step="any" class="form-control" name="amount" value="">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <?php
                  function fill_payment($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM payment_type WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["value"].'</option>';
                  }
                  return $out;
                  }
                  ?>
              <label>Payment Method</label>
               <select class="form-control" name="pay_type" id="opo">
                  <?php echo fill_payment($connection)?>
               </select>
            </div>
        </div>
        <div id="rd"></div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Transaction ID(Cheque no, Transfer Id, Deposit Id):</label>
                <input type="text" value="<?php echo $transid1; ?>" name="transid" class="form-control" id="ti">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="">Description</label>
                <input type="text" value="" name="description" class="form-control" id="ti">
            </div>
          </div>
    </div>
    <button type="reset" class="btn btn-danger">Reset</button>
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