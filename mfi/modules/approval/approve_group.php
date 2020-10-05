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
          text: "Group Successfully Approved",
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
          text: "Error updating Group",
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
                  <h4 class="card-title ">Group Opening Approval</h4>
                  
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM client_charge WHERE int_id = '$sessint_id' AND (branch_id ='$br_id' $branches)";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     if($inr == '0'){ 
                        echo 'No Groups in need of approval';
                      }else{
                        echo ''.$inr.' Charges on the platform';
                      }
                   }
                   ?></p>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                   <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && (branch_id ='$br_id' $branches) && status = 'Pending'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>sn</th>
                        <th>
                          Group
                        </th>
                        <th>
                          Branch
                        </th>
                    
                        <th width="20px">Edit</th>
                        <th width="20px">Approve</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th></th>
                          <th><?php echo $row["g_name"]; ?></th>
                          <?php
                          $ds= $row["branch_id"];
                           $query = "SELECT * FROM branch WHERE int_id = '$sessint_id' && id = '$ds'";
                           $erre = mysqli_query($connection, $query);
                           $ds = mysqli_fetch_array($erre);
                           $dfd = $ds['name'];
                          ?>
                          <th><?php echo $dfd; ?></th>
                          <td><a href="update_group.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                          <td><a href="../functions/updategroup.php?app=<?php echo $row["id"];?>" class="btn btn-info">Approve</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
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
    title: "Group Approval Authorizaation",
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
