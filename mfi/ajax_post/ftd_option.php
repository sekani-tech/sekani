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

    if($autore == '1'){
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
          <label class="bmd-label-floating">Amount</label>
          <input type="number" class="form-control" name="amount">
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
          <label class="bmd-label-floating">Tenure(days)</label>
          <select class="form-control" id="lterm" name="l_term" required>
          <option hidden value="'.$autore.'">'.$autore.'</option>
          <option value="30">30</option>
          <option value="60">60</option>
          <option value="90">90</option>
          <option value="120">120</option>
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
              <option value="1">Monthly Repayment</option>
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
</script>