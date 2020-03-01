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
        <label>Loan size:</label>
        <input type="number" value="'.$row["principal_amount"].'" name="principal_amount" class="form-control" required id="principal_amount">
      </div>
      <div class="form-group">
        <label>Loan Term:</label>
        <input type="number" value="'.$row["loan_term"].'" name="loan_term" class="form-control" id="loan_term" />
      </div>
      <div class="form-group">
        <label>Interest Rate per:</label>
        <input type="text" value="'.$row["repayment_every"].'" name="repayp" class="form-control" id="repay">
      </div>
      <div class="form-group">
        <label>Interest Rate:</label>
        <input type="number" value="'.$row["interest_rate"].'" name="interest_r" class="form-control" id="interest_rate">
      </div>
      <div class="form-group">
        <label>Disbusrsement Date:</label>
        <input type="date" name="disb_date" class="form-control" id="disb_date">
      </div>
      <div class="form-group">
        <label>Loan Officer:</label>
        <input type="text" value="" name="" class="form-control" id="">
      </div>
      <div class="form-group">
        <label>Loan Purpose:</label>
        <input type="text" value="" name="" class="form-control" id="">
      </div>
      <div class="form-group">
        <label>Linked Savings account:</label>
        <input type="text" value="" name="" class="form-control" id="">
      </div>
      <div class="form-group">
        <label>Repayment Start Date:</label>
        <input type="date" value="" name="repay_start" class="form-control" id="repay_start">
      </div>';
    }
    echo $output;
}
// session_start();
//    $_SESSION['load_term'] = "batman";
//    $_SESSION['interest_rate'] = "batman";
//    $_SESSION['disbursment_date'] = "batman";
?>

<script>
      $(document).ready(function(){
        $('#repay_start').change(function(){
          console.log('changed');
          var prina = document.getElementById("principal_amount").value;
          var loant = document.getElementById("loan_term").value;
          var intr = document.getElementById("interest_rate").value;
          var repay = document.getElementById("repay").value;
          var repay_start = document.getElementById("repay_start").value;
          var disbd = document.getElementById("disb_date").value;
          $.ajax({
            url:"loan_calculation.php",
            method:"POST",
            data:{prina: prina, loant: loant, intr: intr, repay: repay, disbd: disbd, repay_start: repay_start},
            success: function(data){
              $('#result').html(data);
            }
          })
        });
      })
</script>