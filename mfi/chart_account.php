<?php

$page_title = "Chart of Account";
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
            text: "Registration Successful",
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
          text: "Error during Registration",
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
          text: "Staff was Updated successfully!",
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
$key = $_GET["message4"];
// $out = $_SESSION["lack_of_intfund_$key"];
$tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error",
        text: "Error updating Staff!",
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
<!-- Content added here -->
<!-- POST INTO -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // on her i will be posting data
  $acct_name = $_POST['acct_name'];
  $gl_code = $_POST['gl_code'];
  $acct_type = $_POST['acct_type'];
  $ext_id = $_POST['ext_id'];
  $acct_tag = $_POST['acct_tag'];
  $acct_use = $_POST['acct_use'];
  $man_ent_all = $_POST['man_ent'];
  $bank_rec = $_POST['bank_rec'];
  $desc = $_POST['desc'];
  $int_id = $sessint_id;
  $bnc_id = $branch_id;

  // alright check this out

  $chat_acct = "INSERT INTO `acc_gl_account`
  (`int_id`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`,
  `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`,
  `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`)
  VALUES ('{$int_id}', '{$bnc_id}', '{$acct_name}',
  '{replace}', '{}', '{}',
  '0', '1', '2', '',
  NULL, NULL, '0', NULL, NULL)";
}
?>
<!-- DONE POSTING -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Chart of Accounts</h4>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> Chart of Accounts || <a style = "color: white;" data-toggle="modal" data-target=".bd-example-modal-lg" href="#">Add Account</a></p>
                  <!-- Insert number users institutions -->
                  <script>
                  $(document).ready(function() {
                  $('#tabledat2').DataTable();
                  });
                  </script>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat2" class="table" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM acc_gl_account WHERE int_id ='$sessint_id' ORDER BY classification_enum ASC, name ASC";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          GL No
                        </th>
                        <th>
                          Account Name
                        </th>
                        <th>
                          Account Type
                        </th>
                        <th>
                          Account ID
                        </th>
                        <th>
                         Balance
                        </th>
                        <th>Unreconciled Balance</th>
                        <th>Edit</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["gl_code"]; ?></th>
                          <?php
                          // using the parent_id to sort them out
                          $nameofacct = "";
                          $rid = $row["id"];
                          $nameid = strtoupper($row["name"]);
                          $pid = $row["parent_id"];
                          if ($pid == "" || $pid == NULL || $pid == 0) {
                            $nameofacct = "<b style='font-size: 21; color: black;'>".$nameid."</b>";
                          } else {
                            $iman = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE id = '$pid' && int_id = '$sessint_id'");
                            $hmm = mysqli_fetch_array($iman);
                            $gen = strtoupper($hmm["name"]);
                            $nameofacct = "<b style='font-size: 21; color: black;'>".$gen."</b>"." - ".$nameid;
                          }
                          
                          ?>
                          <th><?php echo $nameofacct; ?></th>
                          <!-- this is for account type classification_enum -->
                          <?php
                          // get classification for account type using conditions
                          $class = "";
                          $row["classification_enum"];
                          if ($row["classification_enum"] == 1 || $row["classification_enum"] == "1") {
                            $class = "ASSETS";
                          } else if ($row["classification_enum"] == 2 || $row["classification_enum"] == "2") {
                            $class = "LIABILITY";
                          } else if ($row["classification_enum"] == 3 || $row["classification_enum"] == "3") {
                            $class = "EQUITY";
                          } else if ($row["classification_enum"] == 4 || $row["classification_enum"] == "4") {
                            $class = "INCOME";
                          } else if ($row["classification_enum"] == 5 || $row["classification_enum"] == "5") {
                            $class = "EXPENSE";
                          }
                          ?>
                          <th><?php echo $class; ?></th>
                          <th><?php echo $row["tag_id"]; ?></th>
                          <th><?php if ($row["organization_running_balance_derived"] < 0) {
                            echo '<div style="color: red;">'.$row["organization_running_balance_derived"].'</div>';
                          } else {
                            echo $row["organization_running_balance_derived"];
                          } ?></th>
                          <th><?php echo $row["reconciliation_enabled"]; ?></th>
                          <td><a href="edit_chart_account.php?edit=<?php echo $row["id"];?>" class="btn btn-info sm" ><i style="color:#ffffff;" class="material-icons">create</i></a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                    <!-- start dialog -->
                    <!-- <button type="button" class="btn btn-primary" >Large modal</button> -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Add Chart of Account</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
        <div class="modal-body">
         <form method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account name*</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="acct_name" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >GL Code*</label>
                      <input type="text" id="tit" style="text-transform: uppercase;" class="form-control" value="" name="gl_code" required readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account Type*</label>
                      <script>
                        // coment on later
                          $(document).ready(function(){
                            $('#give').change(function() {
                              var id = $(this).val();
                              if (id == "") {
                                document.getElementById('tit').readOnly = false;
                                $('#tit').val("choose an account type");
                              } else if (id == "1") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("1" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "2") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("2" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "3") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("3" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "4") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("4" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "5") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("5" + Math.floor(1000 + Math.random() * 9000));
                              } else {
                                $('#tit').val("Nothing");
                              }
                            });
                          });
                        </script>
                      <select class="form-control" name="acct_type" id="give">
                        <option value="">Select an option</option>
                        <option value="1">ASSET</option>
                        <option value="2">LIABILITY</option>
                        <option value="3">EQUITY</option>
                        <option value="4">INCOME</option>
                        <option value="5">EXPENSE</option>
                      </select>
                      <input hidden type="text" id="int_id" value="<?php echo $sessint_id; ?>" style="text-transform: uppercase;" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >External ID</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="ext_id">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account Tag</label>
                      <select class="form-control" name="acct_tag" id="">
                        <option value="">Select an option</option>
                      </select>                    
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account Usage</label>
                      <select id="atu" class="form-control" name="acct_use" required>
                        <option value="">Select an option</option>
                        <option value="1">GL ACCOUNT</option>
                        <option value="2">GL GROUP</option>
                      </select>                    
                    </div>
                  </div>
                  <script>
                    $(document).ready(function() {
                      $('#atu').change(function() {
                        var gl = $(this).val();
                        var ch = $('#give').val();
                        var id = $('#int_id').val();
                        $.ajax({
                          url:"ajax_post/chart_acct_post.php",
                          method: "POST",
                          data:{gl:gl, ch:ch, id:id},
                          success:function(data){
                            $('#dropping').html(data);
                          }
                        })
                      });
                      $('#give').change(function() {
                        var ch = $(this).val();
                        var gl = $('#atu').val();
                        $.ajax({
                          url:"ajax_post/chart_acct_post.php",
                          method: "POST",
                          data:{ch:ch, gl:gl},
                          success:function(data){
                            $('#dropping').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <!-- checking out the group 2 -->
                  <div class="col-md-6">
                    <div class="form-group">    
                    <div id="dropping"></div>           
                    </div>
                  </div>
                  <!-- end of group  -->
                  <br>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Manual Entires Allowed</label><br/>
                      <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input class="form-check-input" name="man_ent" type="checkbox" value="1">
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                      </label>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Allow Bank reconciliation?</label><br/>
                      <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input class="form-check-input" name="bank_rec" type="checkbox" value="1">
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                      </label>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label> Description:</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="desc">  
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                  <div style="float:right;">
                        <button type="submit" class="btn btn-primary pull-right">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                </form>
      </div>
    </div>
  </div>
</div>
                    <!-- end dialog -->
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