<?php
include("../../functions/connect.php");
session_start();
$sessint_id = $_SESSION["int_id"];
// include("../../functions/connect.php");
$query_build = "SELECT client.id, 
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
// COUNTER
if ($_SESSION["table_counter"] != NULL) {
  $count = $_SESSION["table_counter"];
} else {
  $count = "25";
}
if (isset($_POST["search_data"]) AND $_POST["search_data"] != "") {
  $search_data = $_POST["search_data"];
  $result = mysqli_query($connection, "$query_build AND client.id AND client.firstname LIKE '%$search_data%' OR client.lastname LIKE '%$search_data%' OR client.display_name LIKE '%$search_data%' OR client.account_no LIKE '%$search_data%' ORDER BY client.id ASC LIMIT $count");
  // GET ONE FIRST
  $first_result = mysqli_query($connection, "$query_build AND client.id AND client.firstname LIKE '%$search_data%' OR client.lastname LIKE '%$search_data%' OR client.display_name LIKE '%$search_data%' OR client.account_no LIKE '%$search_data%' ORDER BY client.id ASC LIMIT 1");
  $ga = mysqli_fetch_array($first_result);
  $first_row = $ga["id"];
  // GET ONE LAST
  $last_result = mysqli_query($connection, "$query_build AND client.id AND client.firstname LIKE '%$search_data%' OR client.lastname LIKE '%$search_data%' OR client.display_name LIKE '%$search_data%' OR client.account_no LIKE '%$search_data%' ORDER BY client.id DESC LIMIT 1");
  $gx = mysqli_fetch_array($last_result);
  $last_row = $gx["id"];
  ?>
  <script>
  document.getElementById('get_f').disabled = true;
  </script>
  <?php
} else {
  // MAKING MOVE
  if (isset($_POST["move"]) && $_POST["move"] != "") {
    $move = $_POST["move"];
    $move = intval($move);
    echo $move;
    // make move
    $result = mysqli_query($connection, "$query_build AND client.id > $move ORDER BY client.id ASC LIMIT $count");
  } else {
    $move = 0;
    $result = mysqli_query($connection, "$query_build AND client.id > $move ORDER BY client.id ASC LIMIT $count");
  }
  // GET ONE FIRST
  $first_result = mysqli_query($connection, "$query_build AND client.id > $move ORDER BY client.id ASC LIMIT 1");
  $ga = mysqli_fetch_array($first_result);
  $first_row = $ga["id"];
  // GET ONE LAST
  $last_result = mysqli_query($connection, "$query_build AND client.id > $move ORDER BY client.id DESC LIMIT 1");
  $gx = mysqli_fetch_array($last_result);
  $last_row = $gx["id"];
  ?>
  <script>
  document.getElementById('get_f').disabled = false;
  </script>
  <?php
}

$get_query_total = mysqli_num_rows($result);
// Apply
?>
<div class="table-responsive">
<table class="display nowrap" style="width:100%">
                      <thead class=" text-primary">
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
                      <!-- refresh -->
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
                          } else {
                            echo "NO DATA";
                            ?>
                             <tr>
                          <th>--</th>
                          <th>--</th>
                          <th>--</th>
                          <th>--</th>
                          <th>--
                          </th>
                          <th>--</th>
                          <td><a href="#" class="btn btn-info">View</a></td>
                          <td><a href="#" class="btn btn-info">Close</a></td>
                        </tr>
                            <?php
                          }
                          ?>
                          </tbody>
                      <!-- end refresh -->
                    </table>
                    </div>
                    <!-- THE FOOTER -->
                    <?php 
                    // echo $get_query_total." -- ";
                    // echo $first_row." -- ";
                    // echo $last_row;
                    ?>
                    <div style="float: right; margin-top: 20px;">
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item">
      <a data-prev="<?php echo $first_row; ?>" id="previously" class="page-link" href="javascript:;">Previous</a>
    </li>
    <!-- <li class="page-item"><a class="page-link" href="javascript:;">1</a></li>
    <li class="page-item active">
      <span class="page-link">
        2
        <span class="sr-only">(current)</span>
      </span>
    </li>
    <li class="page-item"><a class="page-link" href="javascript:;">3</a></li> -->
    <li class="page-item">
      <a data-next="<?php echo $last_row; ?>" id="nextgen" class="page-link" href="javascript:;">Next</a>
    </li>
  </ul>
</nav>
</div>
<!-- moving it down -->
<script>
                $(document).ready(function() {
                    $('#previously').on("click", function(){
                    var move = $(this).data("prev");
                    console.log(move);
                    $.ajax({
                      url:"datatable/client_query.php",
                      method:"POST",
                      data:{move:move},
                      success:function(data){
                        $('#display_client').html(data);
                      }
                    })
                  });
                  $('#nextgen').on("click", function(){
                    var move = $(this).data("next");
                    console.log(move);
                    $.ajax({
                      url:"datatable/client_query.php",
                      method:"POST",
                      data:{move:move},
                      success:function(data){
                        $('#display_client').html(data);
                      }
                    })
                  });
                });
                  </script>