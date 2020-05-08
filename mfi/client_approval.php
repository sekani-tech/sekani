<?php

$page_title = "Client Approval";
$destination = "client.php";
include('header.php');

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
                        <select name="" id="" class="form-control">
                            <option value="">select an option</option>
                            <?php echo fill_branch($connection); ?>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Account Officer</label>
                        <select name="" id="" class="form-control">
                            <option value="">select an option</option>
                            <?php echo fill_officer($connection); ?>
                        </select>
                      </div>
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
                        $query = "SELECT client.id, client.account_type, client.account_no, client.branch_id, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id'";
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
                          $so = $row["branch_id"];
                           $que = mysqli_query($connection, "SELECT * FROM branch WHERE id = '$so'");
                          if (count([$que]) == 1) {
                            $yxx = mysqli_fetch_array($que);
                            $bid = $yxx['id'];
                            $brname = $yxx['name'];
                        }
                          $class = "";
                          if ( $row["branch_id"] == $bid || $row["branch_id"] == "1") {
                            $class = $brname;
                          } else {
                            $class = "LIABILITY";
                          }
                          ?>
                          <th><?php echo $class; ?></th>
                          <th><?php echo strtoupper($row["first_name"]." ".$row["last_name"]); ?></th>
                          <th><?php echo "4/4/2020" ?></th>
                          <th><?php echo $row["account_no"]; ?></th>
                          <td><a href="client_view.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
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