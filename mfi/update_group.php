<?php

$page_title = "View Group";
$destination = "branch.php";
    include("header.php");

?>
<?php
 if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $value = mysqli_query($connection, "SELECT * FROM groups WHERE id='$user_id'");

  if (count([$value] == 1)) {
    $n = mysqli_fetch_array($value);
    $name = $n['g_name'];
    $regtyp = $n['reg_type'];
    $meet_dat = $n['meeting_day'];
    $time = $n['meeting_time'];
    $phone = $n['meeting_location'];
    $location = $n['meeting_location'];
    $meet_freq = $n['meeting_frequency'];

  }
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
                  <h4 class="card-title">Edit</h4>
                  <p class="card-category">Modify Group Data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/updategroup.php" method="post">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text"  readonly class="form-control" value="<?php echo $user_id; ?>" name="id">
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" class="form-control" value="<?php echo $name; ?>" name="name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Group Type</label>
                          <select name="gtype" class="form-control">
                                <option hidden value="<?php echo $regtyp;?>"><?php echo $regtyp;?></option>
                                <option  value="formal">Formal</option>
                                <option  value="informal">Informal</option>
                              </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Meeting Day</label>
                          <input  type="date" class="form-control" value="<?php echo $meet_dat; ?>" name="meet_day">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6">
                            <label class="bmd-label-floating">Time</label>
                            <input type="time" class="form-control" value="<?php echo $time; ?>" name="meet_time">
                            </div>
                            <div class="col-md-6">
                              <label class="bmd-label-floating">Frequency</label>
                              <select name="freq" class="form-control">
                                <option hidden value="<?php echo $meet_freq;?>"><?php echo $meet_freq;?></option>
                                <option  value="daily">Daily</option>
                                <option  value="weekly">Weekly</option>
                                <option  value="monthly">Monthly</option>
                                <option  value="annually">Annually</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Location</label>
                          <input type="text" class="form-control" value="<?php echo $location; ?>" name="location">
                        </div>
                      </div>
                      <script>
                        $(document).ready(function () {
                          $('#sds').on("click", function () {
                            var id = $(this).val();
                            $.ajax({
                              url: "ajax_post/delete_group_client.php", 
                              method: "POST",
                              data:{id:id},
                              success: function (data) {
                                $('#huh').html(data);
                              }
                            })
                          });
                        });
                      </script>
                      <div id = "huh" class="col-md-12">
                      <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM group_clients WHERE group_name = '$name'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                         Members
                        </th>
                        <th>
                          Account Number
                        </th>
                        <th width="20px">Delete</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["client_name"]; ?></th>
                          <th><?php echo $row[""]; ?></th>
                          <td><a href="../functions/delete_group_client.php?edit=<?php echo $row["id"];?>" class="btn btn-danger">Remove</a></td>
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
                    <button type="submit" class="btn btn-primary pull-right">Update Group</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>