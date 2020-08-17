<?php

$page_title = " Charge approval";
$destination = "approval.php";
    include("header.php");

?>
<?php
if (isset($_GET["message1"])) {
  $key = $_GET["message1"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Charge Successfully Approved",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
 }
} else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error updating Cache",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["message5"])) {
  $key = $_GET["message2"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Charge Deleted",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["message6"])) {
  $key = $_GET["message8"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error Deleting Client",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}

} else {
  echo "";
}
?>
<?php
// right now we will program
// first step - check if this person is authorized

if ($can_transact == 1 || $can_transact == "1") {
?>
<!-- <link href="vendor/css/addons/datatables.min.css" rel="stylesheet">
<script type="text/javascript" src="vendor/js/addons/datatables.min.js"></script> -->
<!-- Content added here -->
<?php
                        function branch_opt($connection)
                        {  
                            $br_id = $_SESSION["branch_id"];
                            $sint_id = $_SESSION["int_id"];
                            $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
                            $dof = mysqli_query($connection, $dff);
                            $out = '';
                            while ($row = mysqli_fetch_array($dof))
                            {
                              $do = $row['id'];
                            $out .= " OR branch_id ='$do'";
                            }
                            return $out;
                        }
                        $br_id = $_SESSION["branch_id"];
                        $branches = branch_opt($connection);
                        ?>
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Charge Approval</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM client_charge WHERE int_id = '$sessint_id' AND (branch_id ='$br_id' $branches)";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     if($inr == '0'){ 
                        echo 'No Charges';
                      }else{
                        echo ''.$inr.' Charges on the platform';
                      }
                   }
                   ?></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM client_charge WHERE int_id = '$sessint_id' AND (branch_id ='$br_id' $branches)";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <tr>
                        <th class="th-sm">
                          Date
                        </th>
                        <th class="th-sm">
                         Client Name
                        </th>
                        <th class="th-sm">
                         Branch
                        </th>
                        <th class="th-sm">
                         Charges
                        </th>
                        <th class="th-sm">
                        Amount
                        </th>
                        <th class="th-sm">
                       Description
                        </th>
                        <th>Approval</th>
                        <th>Decline</th>
                        </tr>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["date"]; ?></th>
                          <?php
                          
                           $client = $row["client_id"];
                           if($client == "0"){
                            $clientname = "All Clients";
                           }
                           else{
                          $frei = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client'");
                          $ds = mysqli_fetch_array($frei);
                          $clientname = $ds["display_name"];
                           }
                          ?>
                          <th><?php echo $clientname; ?></th>
                          <?php
                          $wpeo = $row["branch_id"];
                          $wepoa = "SELECT * FROM branch WHERE int_id = '$sessint_id' AND id = '$wpeo'";
                          $sdpoe = mysqli_query($connection, $wepoa);
                          $i = mysqli_fetch_array($sdpoe);
                          $sgger = $i['name'];
                          ?>
                          <th><?php echo $sgger; ?></th>
                          <?php $charge = $row["charge_id"];
                          $dfd = mysqli_query($connection, "SELECT * FROM charge WHERE id = '$charge'");
                          $df = mysqli_fetch_array($dfd);
                          $chargename = $df["name"];
                          ?>
                          <th><?php echo $chargename; ?></th>
                          <?php
                           $sdd = mysqli_query($connection, "SELECT * FROM charge WHERE id = '$charge'");
                           $er = mysqli_fetch_array($sdd);
                           $dj = $er["charge_calculation_enum"];
                              if($dj == "7"){
                                $dom = number_format($row["amount"])."%";
                              }
                              else{
                                $dom = number_format($row["amount"]);
                              }
                          ?>
                          <th><?php echo $dom; ?></th>
                          <th><?php echo $row["description"]; ?></th>
                          <td><a id="wait" href="../functions/charger.php?approve=<?php echo $row["id"];?>" class="btn btn-info">Approve</a></td>
                          <td><a href="../functions/charger.php?delete=<?php echo $row["id"];?>" class="btn btn-danger">Decline</a></td>
                          </tr>
                            <script>
                              $(document).ready(function () {
                              $('#wait').on("click", function () {
                                swal({
                                    type: "info",
                                    title: "Charge",
                                    text: "Transaction in Progress",
                                    showConfirmButton: false,
                                    timer: 20000
                                })
                              });
                            });
                              </script>
                          <!-- <th></th> -->
                          <?php }
                          }
                          else {
                            // echo "0 Staff";
                          }
                          ?>
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
<?php
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Charge Authorizaation",
    text: "You Dont Have permission",
   showConfirmButton: false,
    timer: 2000
    }).then(
    function (result) {
      history.go(-1);
    }
    )
    });
   </script>
  ';
  // $URL="transact.php";
  // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

?>
