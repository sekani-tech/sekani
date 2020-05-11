<?php

$page_title = "Account Opening Approval";
$destination = "client.php";
include('header.php');

?>
<?php
//  Sweet alert Function

// If it is successfull, It will show this message
  if (isset($_GET["message"])) {
    $key = $_GET["message"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Client Approved!",
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
          text: "Error approving client",
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
<!-- print content -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Pending Approval</h4>
                </div>
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
                        $query = "SELECT client.id, client.account_type, client.account_no, client.branch_id, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Not Approved'";
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
                        <th>Group</th>
                        <th>Branch</th>
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
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
                          <th></th>
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
                          <th><?php echo $row["account_no"]; ?></th>
                          <td><a href="client_view.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                          <td><a href="../functions/approveClient.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Approve</a></td>
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

<?php

include('footer.php');

?>