<?php

$page_title = "Clients";
$destination = "index.php";
    include("header.php");
    $br_id = $_SESSION['branch_id'];

?>
<?php
//  Sweet alert Function

// If it is successfull, It will show this message
  if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
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
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
// If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
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
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
if (isset($_GET["message3"])) {
  $key = $_GET["message3"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
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
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
else if (isset($_GET["message4"])) {
$key = $_GET["message4"];
// $out = $_SESSION["lack_of_intfund_$key"];
$tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
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
$_SESSION["lack_of_intfund_$key"] = 0;
  }
}
else if (isset($_GET["message5"])) {
  $key = $_GET["message5"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Client Closed!",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
    }
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
                  <p class="card-category"><?php
                        $query = "SELECT client.id, 
                                    client.BVN, 
                                    client.date_of_birth, 
                                    client.gender, 
                                    client.account_type, 
                                    client.account_no, 
                                    client.mobile_no, 
                                    client.firstname, 
                                    client.lastname,  
                                    staff.first_name, 
                                    staff.last_name 
                                    FROM client 
                                    JOIN staff ON client.loan_officer_id = staff.id 
                                    WHERE client.int_id = '$sessint_id'
                                    && client.status = 'Approved'";
                        $result = mysqli_query($connection, $query);
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   ?> registered clients || <a style = "color: white;" href="manage_client.php">Create New client</a></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT client.id, 
                                        client.BVN, 
                                        client.date_of_birth, 
                                        client.gender, 
                                        client.account_type, 
                                        client.account_no, 
                                        client.mobile_no, 
                                        client.firstname, 
                                        client.lastname,  
                                        staff.first_name, 
                                        staff.last_name 
                                        FROM client JOIN staff ON 
                                        client.loan_officer_id = staff.id 
                                        WHERE client.int_id = '$sessint_id'
                                        && client.status = 'Approved'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th></th>
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
                        <th>View</th>
                        <th>Close</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th></th>
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
                                if(isset($yxx['product_id'])){
                                $actype = $yxx['product_id'];}
                              $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype' AND int_id = '$sessint_id'");
                           if (count([$spn])) {
                             $d = mysqli_fetch_array($spn);
                             if(isset($d["name"])){
                             $savingp = $d["name"];}
                           }
                            }
                            ?>
                          <th>
                            <?php
                            if($row['account_type'] == "") {
                              echo $row['account_type'];
                            }else{
                              echo $savingp;
                            }
                            ?>
                          </th>
                          <?php
                          $get_one_account = mysqli_query($connection, "SELECT * FROM `account` WHERE client_id = '$cid' ORDER BY id ASC LIMIT 1");
                          if (mysqli_num_rows($get_one_account) == 1) {
                            $rowa = mysqli_fetch_array($get_one_account);
                            $soc = $rowa["account_no"];
                          } else {
                            $soc = "No Account";
                          }

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
                            $acc = $rowa["account_no"];
                          }else{
                            $acc = $rowa["account_no"];
                          }
                          ?>
                          <th><?php echo $acc; ?></th>
                          <td><a href="client_view.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                          <td><a href="../functions/close_client.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Close</a></td>
                        </tr>
                        <?php }
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