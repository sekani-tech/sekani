<?php
include("../../functions/connect.php");
session_start();
$int_id = $_SESSION['int_id'];
$int_name = $_SESSION['int_name'];

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sav_id = $_POST['sav_id'];

    $dfd = mysqli_query($connection, "SELECT * FROM savings_product WHERE int_id ='$int_id' AND id='$sav_id'");
    $podfs = mysqli_fetch_array($dfd);
    $autore = $podfs['auto_renew_on_closure'];
    $dep_amount = $podfs['deposit_amount'];
    $min_dep_amount = $podfs['min_deposit_amount'];
    $max_dep_amount = $podfs['max_deposit_amount'];
    $in_mul_trm = $podfs['in_multiples_deposit_term'];
    $in_mul_trm_time = $podfs['in_multiples_deposit_term_time'];
    $int_post_type = $podfs['interest_posting_period_enum'];
    $min_dep_term = $podfs['minimum_deposit_term'];
    $max_dep_term = $podfs['maximum_deposit_term'];


    if($in_mul_trm_time == 1){
      $inmul_term = "Days";
    }
    else if($in_mul_trm_time == 3){
      $inmul_term = "Months";
    }
    else if($in_mul_trm_time == 4){
      $inmul_term = "Years";
    }

    if($autore == '2'){
      $dssdw = "No";
    }
    else if($autore == '1'){
      $dssdw = "Yes";
    }

    $dfdf = mysqli_query($connection, "SELECT * FROM ftd_booking_account WHERE int_id ='$int_id'");
    $ifo = mysqli_fetch_array($dfdf);
    $ifdo = mysqli_num_rows($dfdf);
    $ft_no = '00'.($ifdo + 1);
    $date = date('dmY');
    $today = date('Y-m-d');
    $ftd_no = 'FTD/'.$int_name.'/'.$ft_no.'/'.$date;

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

        function fill_tenure($in_mul_trm, $in_mul_trm_time, $min_dep_term, $max_dep_term) {
          $out = '';
          $i = $min_dep_term;
          while($i <= $max_dep_term){
            $fio = $i * $in_mul_trm;
            if($in_mul_trm_time == 1){
              $inmul_term = $fio * 1;
            }
            else if($in_mul_trm_time == 3){
              $inmul_term = $fio * 30;
            }
            else if($in_mul_trm_time == 4){
              $inmul_term = $fio * 365;
            }
            $out .= '<option value="'.$inmul_term.'">'.$fio.'</option>';
            $i++;
          }
          return $out;
        }
    function fill_account($connection, $id, $int_id) {
        $id = $_POST["id"];
        $int_id = $_SESSION['int_id'];
         $pen = "SELECT * FROM account WHERE client_id = '$id'";
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

    $fd = '
        <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Deposit Amount (min: '.number_format($min_dep_amount).' | max: '.number_format($max_dep_amount).')</label>
          <div id="verrify"></div>
          <input type="number" id ="dep" value = "'.$dep_amount.'" class="form-control" name="amount">
          <input type="number" id ="min" hidden value = "'.$min_dep_amount.'" class="form-control" name="">
          <input type="number" id ="max" hidden value = "'.$max_dep_amount.'" class="form-control" name="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">FTD Number</label>
          <input type="text" readonly  value="'.$ftd_no.'" class="form-control" name="ftd_no">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Value Date</label>
          <input type="date" id="repay" class="form-control" name="date">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Tenure('.$inmul_term.')</label>
          <select class="form-control" id="lterm" name="l_term">
          '.fill_tenure($in_mul_trm, $in_mul_trm_time, $min_dep_term, $max_dep_term).'
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group" id ="matdate" >
          <label class="bmd-label-floating">Maturity Date</label>
          <input type="date" value = '.$today.' class="form-control" name="mat_date">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="bmd-label-floating">Interest Rate</label>
          <input type="number" class="form-control" name="int_rate">
          <input type="text" class="form-control" value ="'.$int_post_type.'"  name="int_post">
        </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
        <label>Linked Savings account:</label>
        <select name="linked_savings_acct" class="form-control" id="lsaa">
        '.fill_account($connection, $id, $int_id).'
        </select>
      </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
        <label>Account Officer:</label>
        <select name="acc_off" class="form-control" id="lsaa">
        '.fill_officer($connection).'
        </select>
      </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
            <label for="installmentAmount" >Interest Repayment</label>
            <select class="form-control" name="int_repay" >
              <option value="1">Interval Repayment</option>
              <option value="2">Bullet Repayment</option>
            </select>
          </div>
        </div>      
      <div class="col-md-4">
        <div class="form-group">
          <label for="additionalCharges" >Auto Renew on maturity</label>
          <select class="form-control" name="auto_renew" required>
            <option hidden value="'.$autore.'">No</option>
            <option value="2">No</option>
            <option value="1">Yes</option>
          </select>
        </div>
      </div>
    ';
    echo $fd;

    }
    else {
        echo 'ID not posted';
    }
?>
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

    $(document).ready(function () {
    $('#dep').on("change keyup paste click", function () {
        var dd = $(this).val();
        var min = $('#min').val();
        var max = $('#max').val();
        $.ajax({
        url: "ajax_post/sub_ajax/min_max_ftd_check.php", 
        method: "POST",
        data:{dd:dd, min:min, max:max},
        success: function (data) {
            $('#verrify').html(data);
        }
        })
    });
    });
</script>