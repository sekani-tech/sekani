<?php

$page_title = "Loan report";
$destination = "reports.php";
include("header.php");
// include("../../functions/connect.php");

?>

<style>
  .card .card-body {
    padding: 0.9375rem 20px;
    position: relative;
    height: 200px;
  }
</style>

<?php
//  Sweet alert Function

// If it is successfull, It will show this message
if (isset($_GET["message1"])) {
  $key = $_GET["message1"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Registration Successful",
            text: "Awaiting Approval of New client",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
  $_SESSION["lack_of_intfund_$key"] = null;
}
// If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error during Registration",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = null;
}
if (isset($_GET["message3"])) {
  $key = $_GET["message3"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Client was Updated successfully!",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = null;
} else if (isset($_GET["message4"])) {
  $key = $_GET["message4"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error",
        text: "Error updating client!",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
  $_SESSION["lack_of_intfund_$key"] = null;
}
?>
<!-- Content added here -->
<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Loan Reports</h4>

            <!-- Insert number users institutions -->
            <p class="card-category"><?php
                                      $query = "SELECT * FROM reports WHERE category = 'loan'";
                                      $result = mysqli_query($connection, $query);
                                      if ($result) {
                                        $inr = mysqli_num_rows($result);
                                        echo $inr;
                                      } ?> Current reports</p>
          </div>
        </div>
      </div>
    </div>

    <?php
    if (mysqli_num_rows($result) > 0) {
    ?>

    
      <div class="row">
        <?php
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>

          <div class="col-md-6 ">
            <div class="card card-pricing bg-primary">
              <div class="card-body ">

                <h4 class="card-title"><?php echo $row["name"]; ?></h4>
                <p class="card-description">
                  <small><?php echo strtoupper($row["description"]); ?></small>
                </p>
                <a href="report_view.php?edit=<?php echo $row["id"]; ?>" class="btn btn-white btn-round">View</a>
              </div>
            </div>
          </div>
      <?php }
      } else {
        // echo "0 Document";
      }
      ?>
       <div class="col-md-6 ">
            <div class="card card-pricing bg-primary">
              <div class="card-body ">

                <h4 class="card-title">Portfolio Aging Schedule</h4>
                <p class="card-description">
                  <small>Get the Portfolio Aging Schedule</small>
                </p>
                <a href="report_view.php?edit=48" class="btn btn-white btn-round">View</a>
              </div>
            </div>
          </div>
      </div>
  </div>
</div>

<?php

include("footer.php");

?>