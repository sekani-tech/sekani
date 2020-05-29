<?php

$page_title = "Payment Type";
$destination = "index.php";
    include("header.php");

?>
<?php
//  Sweet alert Function

// If it is successfull, It will show this message
  if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
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
          text: "Error in Creating Branch",
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
          text: "Branch was Updated successfully!",
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
        text: "Error updating Branch!",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
$_SESSION["lack_of_intfund_$key"] = null;
}
?>
<?php
// right now we will program
// first step - check if this person is authorized

if ($per_con == 1 || $per_con == "1") {
?>
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check the button value
    $rog = $_POST['submit'];
    $add_pay = $_POST['submit'];
    if ($add_pay == 'add_payment'){
      $name = $_POST['name'];
      $desc = $_POST['des'];

      if(isset($_POST['is_cash'])){
        $is_cash = 1;
      }else{
        $is_cash = 0;
      }

      $query = mysqli_query($connection, "INSERT INTO payment_type (int_id, value, description, is_cash_payment)
      VALUES('{$sessint_id}', '{$name}', '{$desc}', '{$is_cash}')");
      if($query){
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Created Successfully",
                text: " Payment type Created",
                showConfirmButton: false,
                timer: 2000
            })
        });
        </script>
        ';
      }
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
                  <h4 class="card-title ">Payment Type</h4>
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary pull-left">Add</button>
                      <!-- form of staff -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Permission to a Staff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating">Name</label>
               <input type = "text" class="form-control" name = "name"/>
              </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating">Description</label>
               <input type = "text" class="form-control" name = "des"/>
              </div>
            </div>
            <div class="col-md-12">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="is_cash">
                Is Cash payment
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating"></label>
               <input type = "text" hidden class="form-control"/>
              </div>
            </div>
           <!-- Next -->
                    </div>
                    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" value="add_payment" type="button" class="btn btn-primary">Save changes</button>
      </div>
                </form>
                </div>
                </div>
            </div>
            </div>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script>
                    <table id="tabledat4" class="table">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM payment_type WHERE int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Name</th>
                        <th>
                          Description
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
                          <th><?php echo $row["value"]; ?></th>
                          <th><?php echo $row["description"]; ?></th>
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
