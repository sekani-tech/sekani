<?php

$page_title = "Financial report";
$destination = "../index.php";
    include("header.php");
    // include("../../functions/connect.php");

?>
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
}
else if (isset($_GET["message4"])) {
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
                  <h4 class="card-title ">Financial Reports</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <!-- <p class="card-category"><?php
                   $query = "SELECT * FROM client WHERE int_id = '$sessint_id' && status = 'Approved'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> Current reports</p> -->
                  6 Current reports
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Name
                        </th>
                        <th>
                          Category
                        </th>
                        <th>
                         Description
                        </th>
                        <th>view </th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <!-- <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
                          <th><?php echo strtoupper($row["first_name"]." ".$row["last_name"]); ?></th>
                          <td><a href="client_view.php?edit=<?php echo $row["id"];?>" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?> -->
                          <!-- <th></th> -->
                          <tr>
                          <th>Statement of Financial Position</th>
                          <th>Financial</th>
                          <th>The report list all the accured interest within the specified time period</th>
                          <td><a href="financial_report_view.php?edit=1" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Statement of Income & Expenditure</th>
                          <th>Financial</th>
                          <th>The report list all the accured interest  disbursed within the specified time period</th>
                          <td><a href="financial_report_view.php?edit=2" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Trial balance</th>
                          <th>Financial</th>
                          <th>Balance Sheet</th>
                          <td><a href="financial_report_view.php?edit=3" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Cashflow Statement</th>
                          <th>Financial</th>
                          <th>Overview of the cash flow within a given account</th>
                          <td><a href="financial_report_view.php?edit=4" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Provisioning</th>
                          <th>Financial</th>
                          <th>trial balance report</th>
                          <td><a href="financial_report_view.php?edit=5" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>General Ledger Report</th>
                          <th>Financial</th>
                          <th>This report show the historical income and expenses broken down per month for the last six month</th>
                          <td><a href="financial_report_view.php?edit=6" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>