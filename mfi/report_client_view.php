<?php

$page_title = "Client Report";
$destination = "report_client.php";
    include("header.php");
?>
<?php
 if (isset($_GET["view5"])) {
?>
<!-- Data for clients registered this month -->
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Registered Clients</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                  $std = date("Y-m-d");
                  $thisyear = date("Y");
                  $thismonth = date("m");
                  // $end = date('Y-m-d', strtotime('-30 days'));
                  $curren = $thisyear."-".$thismonth."-01";
                        $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std'";
                        $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                     $date = date("F");
                   }?> registered clients this month  || <a style = "color: white;" href="manage_client.php">Create New client</a></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std'";
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
                          <td><a href="client_view.php?edit=<?php echo $cid;?>" class="btn btn-info">View</a></td>
                          <td><a href="update_client.php?edit=<?php echo $cid;?>" class="btn btn-info">Close</a></td>
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
 }
 else if(isset($_GET["view4"])){
?>
    <?php
function fill_client($connection) {
  $sint_id = $_SESSION["int_id"];
  $org = "SELECT * FROM client WHERE int_id = '$sint_id'";
  $res = mysqli_query($connection, $org);
  $out = '';
  while ($row = mysqli_fetch_array($res))
  {
    $out .= '<option value="'.$row["id"].'">'.$row["firstname"].' '.$row["lastname"].'</option>';
  }
  return $out;
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
                  <h4 class="card-title">Client Summary Report</h4>
                  <!-- <p class="card-category">Fill in all important data</p> -->
                </div>
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" hidden required id="intt" value = "<?php echo $sessint_id;?>"/>
                        <label class="bmd-label-floating">Pick Client</label>
                          <select name="branch" class="form-control" id="input" required>
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                          </select>
                          
                        </div>
                      </div>
                      
                      <div class="clearfix"></div>
                    </div>
                  </form>
                      </div>
                      <!-- <button type="reset" class="btn btn-danger pull-left">Reset</button> -->
                    <!-- <button class="btn btn-primary pull-right">Run Report</button> -->
                  <!-- writing a code to the run the reort at click -->
                  <script>
                    $(document).ready(function () {
                      $('#input').on("change", function () {
                        var cid = $(this).val();
                        var intid = $('#intt').val();
                        $.ajax({
                          url: "ajax_post/reports_post/client_summary.php", 
                          method: "POST",
                          data:{cid:cid, intid:intid},
                          success: function (data) {
                            $('#outjournal').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <!-- this section is the end of run report -->
                  
                </div>
                <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Generate Account Report</h4>
                </div>
                <div class="card-body">
                <form method = "POST" action="client_statement.php">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Start Date:</label>
                          <input type="text" name="id" class="form-control" hidden value="<?php echo $id;?>">
                          <input type="date" name="start" id="" class="form-control" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">End Date:</label>
                          <input type="date" name="end" id="" class="form-control" value="">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Account Report</button>
                  </form>
                </div>
              </div>
              </div>
            </div>
            <!-- teller report -->
            <!-- populate for print with above data --> 
            <div id="outjournal"></div>
            <!-- end  -->
          </div>
          <!-- /content -->
        </div>
      </div>

<?php
 }
 ?>
