<?php

$page_title = "Approval";
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
          text: "Transaction Successfully Approved",
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
} else if (isset($_GET["message3"])) {
  $key = $_GET["message2"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "'.$out = $_SESSION["lack_of_intfund_$key"].'",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["message8"])) {
  $key = $_GET["message8"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Transaction Has Been Declined",
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
 if ($_SERVER['REQUEST_METHOD'] == 'GET') {
     if (isset($_GET['approve'])) {
         $chq_id = $_GET["approve"];
         $stats = "Approved";
         
         $somr = "SELECT * FROM charge WHERE int_id = '$sd' AND id = '$'";

         $updat = "UPDATE chq_book SET status = '$stats' WHERE id = '$chq_id'";
         $updrgoe = mysqli_query($connection, $updat);


         if ($updrgoe) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "success",
                    title: "Cheque/Pass Book",
                    text: "Thank You!",
                    showConfirmButton: false,
                    timer: 2000
                })
            });
            </script>
            ';
         } else {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "Error in Approving Cheque/Pass Book",
                    text: "Call - The System Support",
                    showConfirmButton: false,
                    timer: 2000
                })
            });
            </script>
            ';
         }
     } else {
        // //  echo an error that name is not found
        // echo '<script type="text/javascript">
        // $(document).ready(function(){
        //     swal({
        //         type: "error",
        //         title: "Please check",
        //         text: "Input a value",
        //         showConfirmButton: false,
        //         timer: 2000
        //     })
        // });
        // </script>
        // ';
     }
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
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">CHQ Book Approval</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM chq_book WHERE int_id = '$sessint_id' && status = 'Pending'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     if($inr == '0'){ 
                        echo 'No Cheque Books Issued';
                      }else{
                        echo ''.$inr.' Cheque book on the platform';
                      }
                   }
                   ?>  || Approve CHQ Book</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM chq_book WHERE int_id = '$sessint_id' AND status = 'Pending'";
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
                          no of leaves
                        </th>
                        <th class="th-sm">
                          Range Number
                        </th>
                        <th class="th-sm">Status</th>
                        <th>Approval</th>
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
                          $idd = $row["id"];
                            $query = "SELECT * FROM client WHERE int_id = '$sessint_id' AND id = '$idd'";
                            $resi = mysqli_query($connection, $query);
                            $c = mysqli_fetch_array($resi);
                            $client_name = $c['firstname']." ".$c['lastname'];
                          ?>
                          <th><?php echo $client_name; ?></th>
                          <?php
                          $gom = $row["leaves_no"];
                          if($gom == "1_50"){
                            $don = "1 - 50";
                          }
                          else if($gom == "51_100"){
                            $don = "51 - 100";
                            
                          }
                          else if($gom == "101_150"){
                            $don = "101 - 150";
                            
                          }
                          else if($gom == "151_200"){
                            $don = "151 - 200";
                            
                          }
                          ?>
                          <th><?php echo $don; ?></th>
                          <th><?php echo $row["range_amount"]; ?></th>
                          <th><?php echo $row["status"]; ?></th>
                          <td><a href="chq_approval.php?approve=<?php echo $row["id"];?>" class="btn btn-info">Approve</a></td>
                          </tr>
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
    title: "Vault Authorization",
    text: "You Dont Have permission to Make Transaction From Vault",
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
