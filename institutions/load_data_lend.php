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
        <input type="number" value="'.$row["principal_amount"].'" name="" class="form-control" required id="">
      </div>
      <div class="form-group">
        <label>Loan Term:</label>
        <input type="number" value="'.$row["loan_term"].'" name="" class="form-control" />
      </div>
      <div class="form-group">
        <label>Interest Rate (per '.$row["repayment_every"].'):</label>
        <input type="number" value="'.$row["interest_rate"].'" name="" class="form-control" id="">
      </div>
      <div class="form-group">
        <label>Disbusrsement Date:</label>
        <input type="date" name="" class="form-control" id="">
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
        <input type="date" value="" name="" class="form-control" id="">
      </div>';
    }
    echo $output;
}
?>