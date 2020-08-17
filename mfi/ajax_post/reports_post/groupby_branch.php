<?php
include('../../../functions/connect.php');
$sessint_id = $_POST['intid'];
$br_id = $_POST['cid'];
?>
<div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">General Group Report</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && branch_id = '$br_id' && status = 'Approved'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> registered groups
                </div>
                <div class="card-body">
                <div class="form-group">
                <form method = "POST" action = "../composer/group_listby_branch.php">
              <input hidden name ="id" type="text" value="<?php echo $id;?>"/>
              <input hidden name ="start" type="text" value="<?php echo $start;?>"/>
              <input hidden name ="end" type="text" value="<?php echo $end;?>"/>
              <input hidden name ="branc" type="text" value="<?php echo $br_id;?>"/>
              <button type="submit" id="clientlist" class="btn btn-primary pull-left">Download PDF</button>
              <script>
              $(document).ready(function () {
              $('#clientlist').on("click", function () {
                swal({
                    type: "success",
                    title: "CLIENT REPORT",
                    text: "Printing Successful",
                    showConfirmButton: false,
                    timer: 5000
                          
                  })
              });
            });
     </script>
            </form>
            </div>
                  <div class="table-responsive">
                    <table id="tableddat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && branch_id = '$br_id'  AND status = 'Approved' ORDER BY g_name ASC";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Group Name
                        </th>
                        <th>
                          Reg Type
                        </th>
                        <th>
                          Meeting Day
                        </th>
                        <th>
                         Meeting Frequency
                        </th>
                        <th>
                          Meeting Time
                        </th>
                        <th>
                         Meeting Location
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["g_name"]; ?></th>
                          <th><?php echo $row["reg_type"]; ?></th>
                          <th><?php echo $row["meeting_day"]; ?></th>
                          <th><?php echo $row["meeting_frequency"]; ?></th>
                          <th><?php echo $row["meeting_time"]; ?></th>
                          <th><?php echo $row["meeting_location"]; ?></th>
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