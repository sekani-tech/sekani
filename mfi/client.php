<?php

$page_title = "Clients";
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
                  <h4 class="card-title ">Clients</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM client WHERE int_id = '$sessint_id' && status = 'Approved'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> registered clients || <a style = "color: white;" href="manage_client.php">Create New client</a></p>
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
                          First Name
                        </th>
                        <th>
                          Last Name
                        </th>
                        <th>
                          Account officer
                        </th>
                        <th>
                          Account Type
                        </th>
                        <th>
                          Account Number
                        </th>
                        <th>
                          Phone
                        </th>
                        <th>View</th>
                        <th>Edit </th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
                          <th><?php echo strtoupper($row["first_name"]." ".$row["last_name"]); ?></th>
                          <?php
                            $class = "";
                            $row["account_type"];
                            $cid= $row["id"];
                            $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
                            if (count([$atype]) == 1) {
                                $yxx = mysqli_fetch_array($atype);
                                $actype = $yxx['product_id'];
                              $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                           if (count([$spn])) {
                             $d = mysqli_fetch_array($spn);
                             $savingp = $d["name"];
                           }
                            }
                           
                            ?>
                          <th><?php echo $savingp; ?></th>
                          <?php
                          $soc = $row["account_no"];
                          $length = strlen($soc);
                          if ($length == 1) {
                            $acc ="000000000" . $soc;
                          }
                          elseif ($length == 2) {
                            $acc ="00000000" . $soc;
                          }
                          elseif ($length == 3) {
                            $acc ="00000000" . $soc;
                          }
                          elseif ($length == 4) {
                            $acc ="0000000" . $soc;
                          }
                          elseif ($length == 5) {
                            $acc ="000000" . $soc;
                          }
                          elseif ($length == 6) {
                            $acc ="0000" . $soc;
                          }
                          elseif ($length == 7) {
                            $acc ="000" . $soc;
                          }
                          elseif ($length == 8) {
                            $acc ="00" . $soc;
                          }
                          elseif ($length == 9) {
                            $acc ="0" . $soc;
                          }
                          elseif ($length == 10) {
                            $acc = $row["account_no"];
                          }else{
                            $acc = $row["account_no"];
                          }
                          ?>
                          <th><?php echo $acc; ?></th>
                          <th><?php echo $row["mobile_no"]; ?></th>
                          <td><a href="client_view.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                          <td><a href="update_client.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Close</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                          <!-- <th></th> -->
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