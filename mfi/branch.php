<?php

$page_title = "Branch";
$destination = "index.php";
    include("header.php");

?>
<?php
//  Sweet alert Function

// If it is successfull, It will show this message
if (isset($_GET["message1"])) {
  $key = $_GET["message1"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
        type: "success",
        title: "Success",
        text: "Branch Created",
        showConfirmButton: false,
        timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
  }
  }
// If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
        type: "error",
        title: "Error",
        text: "Error in Creating Branch",
        showConfirmButton: false,
        timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
if (isset($_GET["message3"])) {
  $key = $_GET["message3"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
        type: "success",
        title: "Success",
        text: "Branch Updated",
        showConfirmButton: false,
        timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
else if (isset($_GET["message4"])) {
  $key = $_GET["message1"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
        type: "error",
        title: "Error",
        text: "Error Updating Branch",
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

if ($per_con == 1 || $per_con == "1") {
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Branch</h4>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM branch WHERE int_id = '$sessint_id'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> Branch(s) || <a href="manage_branch.php">Create New Branch</a></p>
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
                        $query = "SELECT * FROM branch WHERE int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Name</th>
                        <th>
                          Phone
                        </th>
                        <th>
                         Parent Branch
                        </th>
                        <th>
                         Opening Date
                        </th>
                        <th>
                          Location
                        </th>
                        <th>
                          Edit
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["name"]; ?></th>
                          <th><?php echo $row["phone"]; ?></th>
                          <?php 
                          $parent = $row['parent_id'];
                          $fd = mysqli_query($connection, "SELECT * FROM branch WHERE id = '$parent'");
                          $fdf = mysqli_fetch_array($fd);
                          $pname= $fdf['name'];?>
                          <th><?php echo $pname; ?></th>
                          <th><?php echo $row["opening_date"]; ?></th>
                          <th><?php echo $row["location"]; ?></th>
                          <td><a href="update_branch.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
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
    title: "Access Config. Authorization",
    text: "You Dont Have  Access to configurations",
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
