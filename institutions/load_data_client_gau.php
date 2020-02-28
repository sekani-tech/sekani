<?php
include("../functions/connect.php");

$output = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT * FROM clients WHERE id = '".$_POST["id"]."'";
    }
    else
    {
        $sql = "SELECT * FROM clients";
    }
    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_array($result))
    {
        $output = '<div class="my-3"> <div class="row">
        <div class="col-md-6">
        <div class="form-group">
            <label for=""> First Name:</label>
            <input value="'.$row["gau_first_name"].'" type="text" name="gau_first_name" id="" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <label for=""> Last Name:</label>
            <input value="'.$row["gau_last_name"].'" type="text" name="gau_last_name" id="" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
              <label for="">Phone:</label>
              <input value="'.$row["gau_phone"].'" type="text" name="gau_phone" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <label for="">Phone:</label>
              <input value="'.$row["gau_phone2"].'" type="text" name="gau_phone2" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
              <label for="">Home Address:</label>
              <input value="'.$row["gau_home_address"].'" type="text" name="gau_home_address" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
              <label for="">Office Address:</label>
              <input value="'.$row["gau_office_address"].'" type="text" name="gau_office_address" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <label for="">Position Held:</label>
              <input value="'.$row["gau_position_held"].'" type="text" name="gau_position_held" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="">Email:</label>
            <input value="'.$row["gau_email"].'" type="text" name="gau_email" id="" class="form-control">
        </div>
        </div>
                </div>
                </div>';
    }
    echo $output;
}
?>