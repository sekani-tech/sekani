<?php

$page_title = "Approval";
$destination = "approval.php";
    include("header.php");

?>
<?php
if (isset($_GET["message0"])) {
    $key = $_GET["message0"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error",
            text: "This is a Teller\'s Job",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
else if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error",
            text: "Not enough Money in this Account",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
else if (isset($_GET["message2"])) {
    $key = $_GET["message2"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Transfer Successful, Awaiting Approval",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
else if (isset($_GET["message3"])) {
    $key = $_GET["message3"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Transaction Declined",
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
                  <h4 class="card-title ">Transactions</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM transfer_cache WHERE int_id='$sessint_id' && status = 'Pending' && (branch_id ='$br_id' $branches)";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     if($inr == '0'){ 
                        echo 'No Transactions need of approval';
                      }else{
                        echo ''.$inr.' Transactions on the platform';
                      }
                   }
                   ?>  || Approve Transaction</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM transfer_cache WHERE int_id = '$sessint_id' AND status = 'Pending' && (branch_id ='$br_id' $branches)";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <tr>
                        <th class="th-sm">
                          Transfer From
                        </th>
                        <th class="th-sm">
                          Transfer To
                        </th>
                        <th class="th-sm">
                          Posted By
                        </th>
                        <th class="th-sm">
                          Branch
                        </th>
                        <th class="th-sm">
                         Amount
                        </th>
                        <th class="th-sm">Status</th>
                        <th colspan="2">Approval</th>
                        </tr>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <?php
                          $transfrom = $row["trans_from"];
                          $dfo = "SELECT * FROM client WHERE id = '$transfrom'";
                          $rfd = mysqli_query($connection, $dfo);
                          $d = mysqli_fetch_array($rfd);
                          $fdo = $d['firstname']." ".$d['lastname'];
                          ?>
                          <th><?php echo $fdo; ?></th>
                          <?php
                          $transfrom = $row["trans_to"];
                          $dfo = "SELECT * FROM client WHERE id = '$transfrom'";
                          $rfd = mysqli_query($connection, $dfo);
                          $d = mysqli_fetch_array($rfd);
                          $dsd = $d['firstname']." ".$d['lastname'];
                          ?>
                          <th><?php echo $dsd; ?></th>
                          <?php
                          $transfrom = $row["account_officer_id"];
                          $dfo = "SELECT * FROM staff WHERE id = '$transfrom'";
                          $rfd = mysqli_query($connection, $dfo);
                          $d = mysqli_fetch_array($rfd);
                          $sdsd = $d['display_name'];
                          ?>
                          <th><?php echo $sdsd; ?></th>
                          <?php
                          $wpeo = $row["branch_id"];
                          $wepoa = "SELECT * FROM branch WHERE int_id = '$sessint_id' AND id = '$wpeo'";
                          $sdpoe = mysqli_query($connection, $wepoa);
                          $i = mysqli_fetch_array($sdpoe);
                          $sgger = $i['name'];
                          ?>
                          <th><?php echo $sgger; ?></th>
                          <th><?php echo number_format($row["amount"]); ?></th>
                          <th><?php echo $row["status"]; ?></th>
                          <td><a href="../functions/cash_trans.php?approve=<?php echo $row["id"];?>" class="btn btn-info">Approve</a></td>
                          <td><a href="../functions/cash_trans.php?decline=<?php echo $row["id"];?>" class="btn btn-Danger">Decline</a></td>
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
    title: "Transaction Authorization",
    text: "You Dont Have permission to Approve",
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
