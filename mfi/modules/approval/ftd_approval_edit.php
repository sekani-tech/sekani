
<?php
$page_title = "Edit FTD Account";
$destination = "chart_account.php";
include("header.php");
?>
<!-- Content added here -->
<?php
// editing the chart account
if(isset($_GET["delete"])) {
  $id = $_GET["delete"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM ftd_booking_account WHERE id='$id' && int_id='$sessint_id'");
// joke
  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $id = $n['id'];
    $account_no = $n['account_no'];
    $client_id = $n['client_id'];
    $prod_id = $n['product_id'];
    $ftd_id = $n['ftd_id'];
    $amount = $n['account_balance_derived'];
    $term = $n['term'];
    $int_rate = $n['int_rate'];
    $l_saa = $n['linked_savings_account'];
    $value_date = $n['submittedon_date'];
    $int_repay = $n['interest_repayment'];
    $auto_renew = $n['auto_renew_on_closure'];
    $staff = $n['field_officer_id'];
    $matdate = $n['maturedon_date'];

  }
  if($int_repay == 1){
    $int_rep = "Monthly Repayment";
  }
  else if($int_repay == 2){
    $int_rep = "Bullet Repayment";
  }
  if($auto_renew == 1){
    $auto_re = "Yes";
  }
  else if($auto_renew == 2){
    $auto_re = "No";
  }
}
?>
<?php
$fweip = mysqli_query($connection, "SELECT * FROM account WHERE id = '$l_saa'");
$fdio = mysqli_fetch_array($fweip);
$l_account = $fdio['account_no'];

        $sint_id = $_SESSION["int_id"];
        $branc = $_SESSION["branch_id"];
        $org = "SELECT client.id, client.firstname, client.lastname, client.middlename FROM client JOIN branch ON client.branch_id = branch.id WHERE client.int_id = '$sint_id' AND (branch.id = '$branc' OR branch.parent_id = '$branc') AND status = 'Approved' AND client.id = '$client_id'";
        $res = mysqli_query($connection, $org);
        $sdi = mysqli_fetch_array($res);
        $name = $sdi['firstname']." ".$sdi['lastname'];
        $c_id = $sdi['id'];

        function fill_account($connection, $c_id, $int_id) {
            $id = $_GET["delete"];
            $int_id = $_SESSION['int_id'];
             $pen = "SELECT * FROM account WHERE client_id = '$c_id'";
            $res = mysqli_query($connection, $pen);
            $out = '';
            while ($row = mysqli_fetch_array($res))
            {
              $product_type = $row["product_id"];
              $get_product = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$product_type' AND int_id = '$int_id'");
             while ($mer = mysqli_fetch_array($get_product)) {
               $p_n = $mer["name"];
               $out .= '<option value="'.$row["id"].'">'.$row["account_no"].' - '.$p_n.'</option>';
             }
            }
            return $out;
          }
          function fill_officer($connection)
        {
            $sint_id = $_SESSION["int_id"];
            $org = "SELECT * FROM staff WHERE int_id = '$sint_id' AND employee_status = 'Employed' ORDER BY staff.display_name ASC";
            $res = mysqli_query($connection, $org);
            $out = '';
            while ($row = mysqli_fetch_array($res))
            {
            $out .= '<option value="'.$row["id"].'">' .$row["display_name"]. '</option>';
            }
            return $out;
        }

        $xcjkxj = "SELECT * FROM staff WHERE int_id ='$sessint_id' AND id = '$staff'";
        $sddio = mysqli_query($connection, $xcjkxj);
        $we = mysqli_fetch_array($sddio);
        $dis_name = $we['display_name'];
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
                <script>
    $(document).ready(function () {
    $('#lterm').on("change keyup paste click", function () {
        var term = $(this).val();
        var repay = $('#repay').val();
        $.ajax({
        url: "ajax_post/sub_ajax/ftd_date_calc.php", 
        method: "POST",
        data:{term:term, repay:repay},
        success: function (data) {
            $('#matdate').html(data);
        }
        })
    });
    });

    $(document).ready(function () {
    $('#repay').on("change keyup paste click", function () {
        var term = $('#lterm').val();
        var repay = $(this).val();
        $.ajax({
        url: "ajax_post/sub_ajax/ftd_date_calc.php", 
        method: "POST",
        data:{term:term, repay:repay},
        success: function (data) {
            $('#matdate').html(data);
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
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Edit FTD Account</h4>
                  <p class="card-category"><?php echo $name;?></p>
                </div>
                <div class="card-body">
                  <form action="../functions/ftdapprove.php" method="POST">
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="bmd-label-floating">Amount</label>
                        <input type="number" value="<?php echo $amount;?>" class="form-control" name="amount">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="bmd-label-floating">FTD Number</label>
                        <input type="text" readonly  value="<?php echo $ftd_id;?>" class="form-control" name="ftd_no">
                        <input type="text" hidden  value="<?php echo $id;?>" class="form-control" name="id">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="bmd-label-floating">Value Date</label>
                        <input type="date" id="repay" value="<?php echo $value_date;?>" class="form-control" name="date">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="bmd-label-floating">Tenure</label>
                        <select class="form-control" id="lterm" name="l_term" required>
                          <option hidden value="<?php echo $term;?>"><?php echo $term;?></option>
                          <option value="30">30</option>
                          <option value="60">60</option>
                          <option value="90">90</option>
                          <option value="120">120</option>
                        </select>                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" id ="matdate" >
                        <label class="bmd-label-floating">Maturity Date</label>
                        <input type="date" value="<?php echo $matdate;?>" class="form-control" name="mat_date">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="bmd-label-floating">Interest Rate</label>
                        <input type="number" value="<?php echo $int_rate;?>" class="form-control" name="int_rate">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-floating">Linked Savings account:</label>
                            <select class="form-control" name="linked">
                            <option hidden value="<?php echo $l_saa;?>"><?php echo $l_account;?></option>
                            <?php echo fill_account($connection, $c_id, $int_id);?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Account Officer:</label>
                            <select name="acc_off" class="form-control" id="lsaa">
                            <option hidden value="<?php echo $staff;?>"><?php echo $dis_name;?></option>
                            <?php echo fill_officer($connection);?>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="installmentAmount" >Interest Repayment</label>
                                <select class="form-control" name="int_repay" >
                                    <option hidden value="<?php echo $int_repay;?>"><?php echo $int_rep;?></option>
                                    <option value="1">Monthly Repayment</option>
                                    <option value="2">Bullet Repayment</option>
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                            <label for="additionalCharges" >Auto Renew on maturity</label>
                            <select class="form-control" name="auto_renew" required>
                                <option hidden value="<?php echo $auto_renew;?>"><?php echo $auto_re;?></option>
                                <option value="2">No</option>
                                <option value="1">Yes</option>
                            </select>
                            </div>
                        </div> 
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Book FTD</button>
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
