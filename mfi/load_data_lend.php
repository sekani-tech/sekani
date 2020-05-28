<?php
include("../functions/connect.php");

$output = '';
if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT * FROM product WHERE id = '".$_POST["id"]."'";
    }
    else
    {
        $sql = "SELECT * FROM product";
    }

    $result = mysqli_query($connection, $sql);

    function fill_account($connection) {
      $id = $_POST["id"];
      $org = mysqli_query($connection, "SELECT * FROM product WHERE id = '$id'");
      if (count([$org]) == 1) {
        $a = mysqli_fetch_array($org);
        $int_id = $a['int_id'];
       }
       $client_id = $_POST['client_id'];
       $pen = "SELECT * FROM account WHERE client_id = '$client_id'";
      $res = mysqli_query($connection, $pen);
      $out = '';
      while ($row = mysqli_fetch_array($res))
      {
        $out .= '<option value="'.$row["id"].'">'.$row["account_no"].'</option>';
      }
      return $out;
    }
    function fill_loanofficer($connection) {
      $id = $_POST["id"];
      $org = mysqli_query($connection, "SELECT * FROM product WHERE id = '$id'");
      if (count([$org]) == 1) {
        $a = mysqli_fetch_array($org);
        $int_id = $a['int_id'];
       }
       $pen = "SELECT * FROM staff WHERE int_id = '$int_id'";
      $res = mysqli_query($connection, $pen);
      $out = '';
      while ($row = mysqli_fetch_array($res))
      {
        $out .= '<option value="'.$row["id"].'">'.$row["first_name"].' '.$row["last_name"].'</option>';
      }
      return $out;
    }
    while ($row = mysqli_fetch_array($result))
    {
        $output = '
        <div class="form-group">
          <div class="row">
          <style>
          label{
            color: dimgrey;
          }
          </style>
            <div class="col-md-4">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label>Loan Size *:</label>
                  </div>
                  <div class="col-md-8">
                    <label>(Min Loan Amt *: N'.$row["min_principal_amount"].')</label>
                    <label>(Max Loan Amt *: N'.$row["max_principal_amount"].')</label>
                    <input type="number" hidden readonly value="'.$row["max_principal_amount"].'" name="max_principal_amount" class="form-control" required id="maximum_Lamount">
                    <input type="number" hidden readonly value="'.$row["min_principal_amount"].'" name="min_principal_amount" class="form-control" required id="minimum_Lamount">
                  </div>
                </div>
                <div id="verifyl"></div>
                <input type="number"  value="" name="principal_amount" class="form-control" required id="principal_amount">
              </div>
            </div>

      <div class="col-md-4">
        <div class="form-group">
          <div class="row">
            <div class="col-md-4">
              <label>Loan Term *:</label>
              <input type="number" value="" name="loan_term" class="form-control" id="loan_term" />
            </div>
            <div class="col-md-5">
            <label> </label>
              <select id="repay" class="form-control">
                <option value ="day">Days</option>
                <option value ="week">Weeks</option>
                <option value ="month">Months</option>
                <option value ="year">Years</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <div class="row">
            <div class="col-md-4">
              <label>Interest rate *:</label>
            </div>
            <div class="col-md-8">
              <label>Min Interest Allowed *: '.$row["min_interest_rate"].'%</label>
              <label>Max Interest Allowed *: '.$row["max_interest_rate"].'%</label>
              <input type="number" hidden readonly value="'.$row["max_interest_rate"].'" name="max_interest_rate" class="form-control" required id="maximum_intrate">
              <input type="number" hidden readonly value="'.$row["min_interest_rate"].'" name="min_interest_rate" class="form-control" required id="minimum_intrate">
            </div>
          </div>
          <div id="verifyi"></div>
          <input type="number" step= "1" value="" name="interest_rate" class="form-control" id="interest_rate">
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <div class="row">
            <div class="col-md-5">
              <label>Repayment Every:</label>
              <input type="number" name="repay_every_no" class="form-control id="repayno"/>
            </div>
            <div class="col-md-5">
            <label> </label></br>
            <label> </label></br>
            <div id="change_term">
            </div>
            </div>
          </div>
        </div>
      </div>
 
      <div class="col-md-4">
      <div class="form-group">
        <label>Repayment Start Date:</label>
        <input type="date" value="" name="repay_start" class="form-control" id="repay_start">
      </div>
      </div>
      
      <div class="col-md-4">
      <div class="form-group">
        <label>Disbursement Date *:</label>
        <input type="date" name="disbursement_date" class="form-control" id="disb_date">
      </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
        <label>Account Officer:</label>
        <select type="text" value="" name="loan_officer" class="form-control" id="lof">
        '.fill_loanofficer($connection).'
        </select>
      </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
        <label>Loan Purpose:</label>
        <input type="text" value="" name="loan_purpose" class="form-control" id="lop">
      </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
        <label>Linked Savings account:</label>
        <select name="linked_savings_acct" class="form-control" id="lsaa">
        '.fill_account($connection).'
        </select>
      </div>
      </div>
      
      <div class="col-md-4">
      <div class="form-group">
        <label>Loan Sector:</label>
        <select name="loan_sector" class="form-control">
          <option value="0">Select loan sector</option>
          <option value="1">Education</option>
          <option value="2">Finance</option>
          <option value="3">Agricultural sector</option>
          <option value="4">Manufacturing</option>
          <option value="5">Construction</option>
          <option value="6">Others</option>
        </select>
        </div>
        </div>
        <div class="col-md-4">
      <div class="form-group">
        <label>Fund Source:</label>
        <select name="fund_source" class="form-control">
          <option value="1">Cash</option>
          <option value="2">Bank</option>
        </select>
        </div>
        </div>
        <div class="col-md-4">
      <div id = "sekat"class="form-group">
        </div>
        </div>
        </div>
      </div>
      ';
    }
    echo $output;
}
// session_start();
//    $_SESSION['load_term'] = "batman";
//    $_SESSION['interest_rate'] = "batman";
//    $_SESSION['disbursment_date'] = "batman";
?>

<!-- uphere restric back date -->
<script>
  $(document).ready(function() {
    $('#principal_amount').on("change keyup paste click", function(){
      var id = $('#charges').val();
      var prin = $(this).val();
      $.ajax({
        url: "ajax_post/lend_charge.php",
        method: "POST",
        data:{id:id, prin:prin},
        success:function(data) {
          $('#lend_charge').html(data);
        }
      });
    });
    $('#act').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var prina = $('#principal_amount').val();
      var loant = $('#loan_term').val();
      var intr = $('#interest_rate').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"loan_calculation_table.php",
        method:"POST",
        data:{id:id, ist: ist,prina:prina,loant:loant,intr:intr,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#accname').html(data);
        }
      })
    });
  });
  $(document).ready(function() {
    $('#loan_term').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var prina = $('#principal_amount').val();
      var loant = $('#loan_term').val();
      var intr = $('#interest_rate').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"loan_calculation_table.php",
        method:"POST",
        data:{id:id, ist: ist,prina:prina,loant:loant,intr:intr,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#accname').html(data);
        }
      })
    });
  });
  $(document).ready(function() {
    $('#interest_rate').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var prina = $('#principal_amount').val();
      var loant = $('#loan_term').val();
      var intr = $('#interest_rate').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"loan_calculation_table.php",
        method:"POST",
        data:{id:id, ist: ist,prina:prina,loant:loant,intr:intr,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#accname').html(data);
        }
      })
    });
  });
  $(document).ready(function() {
    $('#repay').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var prina = $('#principal_amount').val();
      var loant = $('#loan_term').val();
      var intr = $('#interest_rate').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"loan_calculation_table.php",
        method:"POST",
        data:{id:id, ist: ist,prina:prina,loant:loant,intr:intr,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#accname').html(data);
        }
      })
    });
  });
  $(document).ready(function() {
    $('#repay_start').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var prina = $('#principal_amount').val();
      var loant = $('#loan_term').val();
      var intr = $('#interest_rate').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"loan_calculation_table.php",
        method:"POST",
        data:{id:id, ist: ist,prina:prina,loant:loant,intr:intr,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#accname').html(data);
        }
      })
    });
  });
  $(document).ready(function() {
    $('#disb_date').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var prina = $('#principal_amount').val();
      var loant = $('#loan_term').val();
      var intr = $('#interest_rate').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"loan_calculation_table.php",
        method:"POST",
        data:{id:id, ist: ist,prina:prina,loant:loant,intr:intr,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#accname').html(data);
        }
      })
    });
  });

  // Date calculation
  $(document).ready(function() {
    $('#principal_amount').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var prina = $('#principal_amount').val();
      var loant = $('#loan_term').val();
      var intr = $('#interest_rate').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      var max_Lamount = $('#maximum_Lamount').val();
      var min_Lamount = $('#minimum_Lamount').val();
      var max_intrate = $('#maximum_intrate').val();
      var min_intrate = $('#minimum_intrate').val();
      $.ajax({
        url:"loan_verify.php",
        method:"POST",
        data:{id:id, ist: ist,prina:prina,loant:loant,intr:intr,repay:repay,repay_start:repay_start,disbd:disbd,max_Lamount:max_Lamount,min_Lamount:min_Lamount,max_intrate:max_intrate,min_intrate:min_intrate},
        success:function(data){
          $('#verifyl').html(data);
        }
      })
    });
  });
  $(document).ready(function() {
    $('#interest_rate').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var prina = $('#principal_amount').val();
      var loant = $('#loan_term').val();
      var intr = $('#interest_rate').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      var max_Lamount = $('#maximum_Lamount').val();
      var min_Lamount = $('#minimum_Lamount').val();
      var max_intrate = $('#maximum_intrate').val();
      var min_intrate = $('#minimum_intrate').val();
      $.ajax({
        url:"loan_verify2.php",
        method:"POST",
        data:{id:id, ist: ist,prina:prina,loant:loant,intr:intr,repay:repay,repay_start:repay_start,disbd:disbd,max_Lamount:max_Lamount,min_Lamount:min_Lamount,max_intrate:max_intrate,min_intrate:min_intrate},
        success:function(data){
          $('#verifyi').html(data);
        }
      })
    });
  });
  $(document).ready(function() {
    $('#loan_term').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var loant = $('#loan_term').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"date_calculation.php",
        method:"POST",
        data:{id:id, ist: ist,loant:loant,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#sekat').html(data);
        }
      });
    });
  });
  $(document).ready(function() {
    var id = $('#repay').val();
    $.ajax({
        url:"ajax_post/change_term.php",
        method:"POST",
        data:{id:id},
        success:function(data){
          $('#change_term').html(data);
        }
      });
    $('#repay').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var loant = $('#loan_term').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"date_calculation.php",
        method:"POST",
        data:{id:id, ist: ist,loant:loant,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#sekat').html(data);
        }
      });
      $.ajax({
        url:"ajax_post/change_term.php",
        method:"POST",
        data:{id:id},
        success:function(data){
          $('#change_term').html(data);
        }
      });
    });
  });
  $(document).ready(function() {
    $('#repay_start').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var loant = $('#loan_term').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"date_calculation.php",
        method:"POST",
        data:{id:id, ist: ist,loant:loant,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#sekat').html(data);
        }
      })
    });
  });
  $(document).ready(function() {
    $('#disb_date').on("change keyup paste click", function(){
      var id = $(this).val();
      var ist = $('#int_id').val();
      var loant = $('#loan_term').val();
      var repay = $('#repay').val();
      var repay_start = $('#repay_start').val();
      var disbd = $('#disb_date').val();
      $.ajax({
        url:"date_calculation.php",
        method:"POST",
        data:{id:id, ist: ist,loant:loant,repay:repay,repay_start:repay_start,disbd:disbd},
        success:function(data){
          $('#sekat').html(data);
        }
      })
    });
  });
</script>
<script>
$(document).ready(function() { 
    $('#principal_amount').change(function() {
      $('#ls').val($('#principal_amount').val());
      $('#lt').val($('#loan_term').val());
      $('#irp').val($('#repay').val());
      $('#ir').val($('#interest_rate').val());
      $('#db').val($('#disb_date').val());
      $('#lo').val($('#lof').val());
      $('#lp').val($('#lop').val());
      $('#lsa').val($('#lsaa').val());
      $('#rsd').val($('#repay_start').val());
    });
    $('#loan_term').change(function() {
      $('#ls').val($('#principal_amount').val());
      $('#lt').val($('#loan_term').val());
      $('#irp').val($('#repay').val());
      $('#ir').val($('#interest_rate').val());
      $('#db').val($('#disb_date').val());
      $('#lo').val($('#lof').val());
      $('#lp').val($('#lop').val());
      $('#lsa').val($('#lsaa').val());
      $('#rsd').val($('#repay_start').val());
      $('#end').val($('#ed').val());
    });
    $('#repay').change(function() {
      $('#ls').val($('#principal_amount').val());
      $('#lt').val($('#loan_term').val());
      $('#irp').val($('#repay').val());
      $('#ir').val($('#interest_rate').val());
      $('#db').val($('#disb_date').val());
      $('#lo').val($('#lof').val());
      $('#lp').val($('#lop').val());
      $('#lsa').val($('#lsaa').val());
      $('#rsd').val($('#repay_start').val());
    });
    $('#interest_rate').change(function() {
      $('#ls').val($('#principal_amount').val());
      $('#lt').val($('#loan_term').val());
      $('#irp').val($('#repay').val());
      $('#ir').val($('#interest_rate').val());
      $('#db').val($('#disb_date').val());
      $('#lo').val($('#lof').val());
      $('#lp').val($('#lop').val());
      $('#lsa').val($('#lsaa').val());
      $('#rsd').val($('#repay_start').val());
    });
    $('#disb_date').change(function() {
      $('#ls').val($('#principal_amount').val());
      $('#lt').val($('#loan_term').val());
      $('#irp').val($('#repay').val());
      $('#ir').val($('#interest_rate').val());
      $('#db').val($('#disb_date').val());
      $('#lo').val($('#lof').val());
      $('#lp').val($('#lop').val());
      $('#lsa').val($('#lsaa').val());
      $('#rsd').val($('#repay_start').val());
    });
    $('#lof').change(function() {
      $('#ls').val($('#principal_amount').val());
      $('#lt').val($('#loan_term').val());
      $('#irp').val($('#repay').val());
      $('#ir').val($('#interest_rate').val());
      $('#db').val($('#disb_date').val());
      $('#lo').val($('#lof').val());
      $('#lp').val($('#lop').val());
      $('#lsa').val($('#lsaa').val());
      $('#rsd').val($('#repay_start').val());
    });
    $('#lop').change(function() {
      $('#ls').val($('#principal_amount').val());
      $('#lt').val($('#loan_term').val());
      $('#irp').val($('#repay').val());
      $('#ir').val($('#interest_rate').val());
      $('#db').val($('#disb_date').val());
      $('#lo').val($('#lof').val());
      $('#lp').val($('#lop').val());
      $('#lsa').val($('#lsaa').val());
      $('#rsd').val($('#repay_start').val());
    });
    $('#lsaa').change(function() {
      $('#ls').val($('#principal_amount').val());
      $('#lt').val($('#loan_term').val());
      $('#irp').val($('#repay').val());
      $('#ir').val($('#interest_rate').val());
      $('#db').val($('#disb_date').val());
      $('#lo').val($('#lof').val());
      $('#lp').val($('#lop').val());
      $('#lsa').val($('#lsaa').val());
      $('#rsd').val($('#repay_start').val());
    });
    $('#repay_start').change(function() {
      $('#ls').val($('#principal_amount').val());
      $('#lt').val($('#loan_term').val());
      $('#irp').val($('#repay').val());
      $('#ir').val($('#interest_rate').val());
      $('#db').val($('#disb_date').val());
      $('#lo').val($('#lof').val());
      $('#lp').val($('#lop').val());
      $('#lsa').val($('#lsaa').val());
      $('#rsd').val($('#repay_start').val());
    });
});
      $(document).ready(function(){
        $('#repay_start').change(function(){
          console.log('it changed');
          var prina = document.getElementById("principal_amount").value;
          var loant = document.getElementById("loan_term").value;
          var intr = document.getElementById("interest_rate").value;
          var repay = document.getElementById("repay").value;
          var repay_start = document.getElementById("repay_start").value;
          var disbd = document.getElementById("disb_date").value;
          $.ajax({
            url:"loan_calculation_table.php",
            method:"POST",
            data:{prina: prina, loant: loant, intr: intr, repay: repay, disbd: disbd, repay_start: repay_start},
            success: function(data){
              $('#result').html(data);
            }
          })
        });
      })
      $(document).ready(function(){
        $('#loan_term').change(function(){
          console.log('changed');
          var prina = document.getElementById("principal_amount").value;
          var loant = document.getElementById("loan_term").value;
          var intr = document.getElementById("interest_rate").value;
          var repay = document.getElementById("repay").value;
          var repay_start = document.getElementById("repay_start").value;
          var disbd = document.getElementById("disb_date").value;
          $.ajax({
            url:"loan_calculation_table.php",
            method:"POST",
            data:{prina: prina, loant: loant, intr: intr, repay: repay, disbd: disbd, repay_start: repay_start},
            success: function(data){
              $('#result').html(data);
            }
          })
        });
      })
      $(document).ready(function(){
        $('#principal_amount').change(function(){
          console.log('changed');
          var prina = document.getElementById("principal_amount").value;
          var loant = document.getElementById("loan_term").value;
          var intr = document.getElementById("interest_rate").value;
          var repay = document.getElementById("repay").value;
          var repay_start = document.getElementById("repay_start").value;
          var disbd = document.getElementById("disb_date").value;
          $.ajax({
            url:"loan_calculation_table.php",
            method:"POST",
            data:{prina: prina, loant: loant, intr: intr, repay: repay, disbd: disbd, repay_start: repay_start},
            success: function(data){
              $('#result').html(data);
            }
          })
        });
      })
      $(document).ready(function(){
        $('#interest_rate').change(function(){
          console.log('changed');
          var prina = document.getElementById("principal_amount").value;
          var loant = document.getElementById("loan_term").value;
          var intr = document.getElementById("interest_rate").value;
          var repay = document.getElementById("repay").value;
          var repay_start = document.getElementById("repay_start").value;
          var disbd = document.getElementById("disb_date").value;
          $.ajax({
            url:"loan_calculation_table.php",
            method:"POST",
            data:{prina: prina, loant: loant, intr: intr, repay: repay, disbd: disbd, repay_start: repay_start},
            success: function(data){
              $('#result').html(data);
            }
          })
        });
      })
</script>