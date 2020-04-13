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

    while ($row = mysqli_fetch_array($result))
    {
        $output = '<div class="form-group">
        <div class="row">
        <div class="col-md-6">
        <div class="form-group">
        <label>Loan Amount *:</label>
        <input type="number" readonly value="'.$row["principal_amount"].'" name="principal_amount" class="form-control" required id="principal_amount">
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Loan Tenor *:</label>
        <input type="number" value="'.$row["loan_term"].'" name="loan_term" class="form-control" id="loan_term" />
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Interest Rate per *:</label>
        <! -- <input type="text" value="'.$row["repayment_every"].'" name="repay_every" class="form-control" id="repay"> -->
        <select name="repay_every" class="form-control" id="repay" >
        <option value = "day">Day</option>
        <option value = "month">Month</option>
        <option value = "year">Year</option>
        </select>
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Interest Rate *:</label>
        <input type="number" value="'.$row["interest_rate"].'" onchange="tabletag()" name="interest_rate" class="form-control" id="interest_rate">
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Disbursement Date *:</label>
        <input type="date" name="disbursement_date" class="form-control" id="disb_date">
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Grace on Principal Payment:</label>
        <input type="number" value="" name="grace_on_principal" class="form-control" id="act">
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Grace on Interest Payment:</label>
        <input type="number" value="" name="grace_on_interest" class="form-control" id="interest_rate">
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Loan Officer:</label>
        <input type="text" value="" name="loan_officer" class="form-control" id="lof">
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Loan Purpose:</label>
        <input type="text" value="" name="loan_purpose" class="form-control" id="lop">
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Apply Standing instruction:</label>
        <select name="standing_instruction" class="form-control">
          <option value="on">ON</option>
          <option value="off">OFF</option>
        </select>
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Linked Savings account:</label>
        <input type="text" value="'.$row["linked_savings_acct"].'" name="linked_savings_acct" class="form-control" id="lsaa">
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Repayment Starting From:</label>
        <input type="date" value="" name="repay_start" class="form-control" id="repay_start">
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label>Loan Sector:</label>
        <select name="" class="form-control">
          <option value="on">Select loan sector</option>
          <option value="off">OFF</option>
        </select>
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
<script>
                $(document).ready(function() {
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