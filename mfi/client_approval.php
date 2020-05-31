<?php

$page_title = "Approval";
$destination = "index.php";
    include("header.php");

?>
<?php
          if (isset($_GET["message"])) {
            $key = $_GET["message"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "success",
                            title: "Success",
                            text: "Client Approved",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
              $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message2"])) {
            $key = $_GET["message2"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "success",
                        title: "Success",
                        text: "Client Rejected",
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
if ($acct_appv == 1 || $acct_appv == "1") {
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <!-- <span class="nav-tabs-title">Staff Management:</span> -->
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <!-- <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Password Settings
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link active" href="#messages" data-toggle="tab">
                            <i class="material-icons">check</i> Approval
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#products" data-toggle="tab">
                            <i class="material-icons">cancel</i>Pending
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="messages">
                    <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="card">

                <?php
                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"]. '</option>';
                  }
                  return $out;
                  }
                  function fill_officer($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM staff WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["display_name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                <div class="card-body">
                <form action="">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="">Branch</label>
                        <select name="" id="brid" class="form-control">
                            <option value="0">select an option</option>
                            <?php echo fill_branch($connection);?>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Account Officer</label>
                        <select name="" id="account" class="form-control">
                            <option value="0">select an option</option>
                            <?php echo fill_officer($connection); ?>
                        </select>
                      </div>
                      <script>
                              $(document).ready(function() {
                                $('#brid').on("change keyup paste", function(){
                                  var id = $(this).val();
                                  var branchid = $('#brid').val();
                                  var acctid = $('#account').val();
                                  $.ajax({
                                    url:"./ajax_post/clientapproval_input.php",
                                    method:"POST",
                                    data:{id:id, branchid:branchid, acctid:acctid},
                                    success:function(data){
                                      $('#coll').html(data);
                                    }
                                  })
                                });
                              });
                              $(document).ready(function() {
                                $('#account').on("change keyup paste", function(){
                                  var id = $(this).val();
                                  var branchid = $('#brid').val();
                                  var acctid = $('#account').val();
                                  $.ajax({
                                    url:"./ajax_post/clientapproval_input.php",
                                    method:"POST",
                                    data:{id:id, branchid:branchid, acctid:acctid},
                                    success:function(data){
                                      $('#coll').html(data);
                                    }
                                  })
                                });
                              });
                            </script>
                    </div>
                    <div id="coll">

                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Search</button>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script>
                    <table id="tabledat4" class="table">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT client.id, client.account_type, client.account_no, client.branch_id, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON (client.loan_officer_id = staff.id) WHERE (client.int_id = '$sessint_id' && client.status = 'Not Approved')";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>
                          First Name
                        </th>
                        <th>
                          Last Name
                        </th>
                        <th>Account Type</th>
                        <th>
                          Account officer
                        </th>
                        <th>
                          Registration date
                        </th>
                        <th>
                          Account Number
                        </th>
                        <th>View</th>
                        <th>Approve</th>
                        <th>Move to Pending</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
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
                          <th><?php echo strtoupper($row["first_name"]." ".$row["last_name"]); ?></th>
                          <th><?php echo "4/4/2020" ?></th>
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
                          <td><a href="client_approvalEdit.php?edit=<?php echo $row["id"];?>" class="btn btn-info"><i class="material-icons">visibility</i></a></td>
                          <td><a href="../functions/approveClient.php?edit=<?php echo $row["id"];?>" class="btn btn-info"><i class="material-icons">check</i></a></td>
                          <td><a href="../functions/rejectClient.php?edit=<?php echo $row["id"];?>" class="btn btn-danger"><i class="material-icons">cancel</i></a></td>

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
               <!--//report ends here -->
            </div>
          </div>
        </div>
                      </div>
                    <div class="tab-pane" id="products">
                    <div class="row">
            <div class="col-md-12">
              <div class="card">
              <div class="card-header card-header-primary">
                    <h4 class="card-title">Rejected Clients</h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script>
                    <table id="tabledat4" class="table">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT client.id, client.account_type, client.account_no, client.branch_id, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON (client.loan_officer_id = staff.id) WHERE (client.int_id = '$sessint_id' && client.status = 'Pending')";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>
                          First Name
                        </th>
                        <th>
                          Last Name
                        </th>
                        <th>Account Type</th>
                        <th>
                          Account officer
                        </th>
                        <th>
                          Registration date
                        </th>
                        <th>
                          Account Number
                        </th>
                        <th>Edit</th>
                        <th>Approve</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
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
                          <th><?php echo strtoupper($row["first_name"]." ".$row["last_name"]); ?></th>
                          <th><?php echo "4/4/2020" ?></th>
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
                          <td><a href="client_approvalEdit.php?edit=<?php echo $row["id"];?>" class="btn btn-info"><i class="material-icons">edit</i></a></td>
                          <td><a href="../functions/approveClient.php?edit=<?php echo $row["id"];?>" class="btn btn-info"><i class="material-icons">check</i></a></td>
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
               <!--//report ends here -->
            </div>
          </div>
              </div>
            </div>
          </div>
          <!-- / -->
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
    title: "Account Opening Access",
    text: "You Dont Have permission to the Account Opening Approval",
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