<?php

$page_title = "Institution Report";
$destination = "report_institution.php";
    include("header.php");
?>
<?php
 if (isset($_GET["view35"])) {
?>
<div class="content">
        <div class="container-fluid">
                    <!-- your content here -->
                    <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">Staff Cabal Report</h4>
            </div>
            <?php
                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  function fill_role($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM org_role WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["role"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                  <script>
                    $(document).ready(function () {
                      $('#brne').on("change click", function () {
                        var id = $(this).val();
                        $.ajax({
                          url: "ajax_post/reports_post/staff.php", 
                          method: "POST",
                          data:{id:id},
                          success: function (data) {
                            $('#outstaff').html(data);
                          }
                        })
                      });
                    });
                  </script>
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="start" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="end" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="brne" class="form-control">
                            <?php echo fill_branch($connection); ?>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Roles</label>
                        <select name="" id="role" class="form-control">
                        <option value="all">All</option>
                        <?php echo fill_role($connection); ?>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="runstaff" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
              <script>
                    $(document).ready(function () {
                      $('#runstaff').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#brne').val();
                        var role = $('#role').val();
                        $.ajax({
                          url: "ajax_post/reports_post/view_cabal.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, role:role},
                          success: function (data) {
                            $('#shstaff').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <div class="card-body">
                      <div class="col-md-8">
                      </div>
                  </div>

                  </div>
            </div>
            <div id = "shstaff"> </div>
          </div>

        </div>
 </div>
<?php
 }
 else if(isset($_GET["view36"])){
?>
<div class="content">
        <div class="container-fluid">
                    <!-- your content here -->
                    <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">Inventory Schedule Report</h4>
            </div>
            <?php
                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="start" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="end" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="brne" class="form-control">
                            <?php echo fill_branch($connection); ?>
                        </select>
                      </div>
                      <!-- <div class="form-group col-md-3">
                        <label for="">Account Officer</label>
                        <select name="" id="outstaff" class="form-control">
                            <option value="">select option</option>
                        </select>
                      </div> -->
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="rom" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
              <script>
                    $(document).ready(function () {
                      $('#rom').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#brne').val();
                        var staff = $('#outstaff').val();
                        $.ajax({
                          url: "ajax_post/reports_post/inventory_list.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, staff:staff},
                          success: function (data) {
                            $('#shstaff').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <div class="card-body">
                      <div class="col-md-12">
                      </div>
                  </div>

                  </div>
            </div>
            <div class="col-md-12" id="shstaff"> </div>
          </div>

        </div>
 </div>
 <?php
 }
 else if(isset($_GET["view44"])){
?>
<?php
$year = date('Y');
$startdate = $year."-01-01";
?>
<!-- Content added here -->
<!-- print content -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Non-Financial Data Report</h4>
                </div>
                <div class="card-body">
                <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">As At:</label>
                        <input type="date" name="" id="end" class="form-control">
                      </div>
                      <?php
                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="brne" class="form-control">
                            <?php echo fill_branch($connection); ?>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for=""></label>
                        <input type="date" hidden value="<?php echo $startdate; ?>" name="" id="start" class="form-control">
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="input" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
                <script>
                    $(document).ready(function () {
                      $('#input').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#brne').val();
                        $.ajax({
                          url: "ajax_post/reports_post/n_financial_report.php", 
                          method: "POST",
                          data:{start:start, end:end, branch:branch},
                          success: function (data) {
                            $('#outjournal').html(data);
                          }
                        })
                      });
                    });
                  </script>
            </div>
            <div id="outjournal" class="col-md-10">

              </div>
          </div>
        </div>
      </div>
<?php
 }
?>