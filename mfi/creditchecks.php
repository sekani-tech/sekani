<?php

$page_title = "Credit Checks";
$destination = "index.php";
    include("header.php");

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
            title: "Success",
            text: "Registration Successful",
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
                  <h4 class="card-title ">Charges</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"> No of credit checks</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="1" style="width:100%">
                      <thead class=" text-primary">
                        <th>
                          Id
                        </th>
                        <th>
                          Name
                        </th>
                        <th>
                          Entity Name
                        </th>
                        <th>
                         Severity Level
                        </th>
                        <th>
                          Rating Type
                        </th>
                        <th>
                         Value
                        </th>
                        <th>View</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Minimum Savings Balance</td>
                          <td>Loan</td>
                          <td>Book loan</td>
                          <td>Boolean</td>
                          <td>Yes</td>
                          <td><a href="#?edit=" class="btn btn-info" >View</a></td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Client Written-off loan checks</td>
                          <td>Loan</td>
                          <td>Book loans</td>
                          <td>Boolean</td>
                          <td>Yes</td>
                          <td><a href="#?edit=" class="btn btn-info" >View</a></td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Same product outstanding</td>
                          <td>Loan</td>
                          <td>warning</td>
                          <td>Boolean</td>
                          <td>Yes</td>
                          <td><a href="#?edit=" class="btn btn-info" >View</a></td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>Group Arrears</td>
                          <td>Loan</td>
                          <td>Book loans</td>
                          <td>Boolean</td>
                          <td>Yes</td>
                          <td><a href="#?edit=" class="btn btn-info" >View</a></td>
                        </tr>
                        <tr>
                          <td>5</td>
                          <td>Outstanding Loan Balance</td>
                          <td>Loan</td>
                          <td>Warning</td>
                          <td>Boolean</td>
                          <td>Yes</td>
                          <td><a href="#?edit=" class="btn btn-info" >View</a></td>
                         </tr>
                      </tbody>
                      <!-- <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
                          <th><?php echo $row["loan_officer_id"]; ?></th>
                          <th><?php echo $row["account_type"]; ?></th>
                          <td><a href="client_view.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                          <td><a href="update_client.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                           <th></th>
                      </tbody>  -->
                    </table>
                   </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /col-md-12 -->
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>