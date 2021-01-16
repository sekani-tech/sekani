<?php

$page_title = "Create Group";
$destination = "index.php";
include("header.php");
$b_id = $_SESSION['branch_id'];
?>

<?php
$int_id = $_SESSION["int_id"];
//Fill Savings Query
$fillSavingQuery = selectAll('savings_product', ['int_id' => $int_id]);

//Fill Officer Query
$fillOfficerQuery = selectAllWithOrder('staff', ['int_id' => $int_id,'employee_status' => 'Employed'],'display_name','ASC');

//Fill Branch Option Query
$fillBranchQuery = selectAllWithOr('branch', ['int_id' => $int_id,'parent_id' => $br_id], 'id', $br_id);


?>

<?php

$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$_SESSION['group_temp'] = $randms;
$group_cache_id = $_SESSION['group_temp'];
?>

<?php if(isset($_POST['submit'])){

$user = $_SESSION['user_id'];
$int_id = $_SESSION["int_id"];
$gname = $_POST['gname'];
$acc_type = $_POST['acct_type'];
$pc_phone = $_POST['pc_phone'];
$branch_id = $_POST['branch_id'];
$acc_off = $_POST['acc_off'];
$reg_date = $_POST['reg_date'];
$reg_type = $_POST['reg_type'];
$meet_day = $_POST['meet_day'];
$meet_frequency = $_POST['meet_frequency'];
$meet_address = $_POST['meet_address'];
$meet_time = $_POST['meet_time'];
$submitted_on = date('Y-m-d h:i:sa');
$digit = 8;
$randms = str_pad(rand(0, pow(10, $digit)-1), 7, '0', STR_PAD_LEFT);

$inttest = str_pad($branch_id, 3, '0', STR_PAD_LEFT);
$digit = 4;
$randms = str_pad(rand(0, pow(10, $digit)-1), 7, '0', STR_PAD_LEFT);
$account_no = $inttest."".$randms;

//Final Insertion will be done into groups
      $groupQuery=[
        'int_id' => $int_id,
        'branch_id' => $branch_id,
        'g_name' => $gname,
        'account_no' => $account_no,
        'account_type' => $acc_type,
        'loan_officer' => $acc_off,
        'reg_date' => $reg_date,
        'reg_type' => $reg_type,
        'meeting_day' => $meet_day,
        'meeting_frequency' => $meet_frequency,
        'meeting_time' => $meet_time,
        'meeting_location' => $meet_address,
        'submittedon_date' => $submitted_on,
        'submittedon_userid' => $user,
        'pc_phone' => $pc_phone,
        'status' => 'Pending'
      ];
$addGroup= create('groups', $groupQuery);

//$fodf = mysqli_query($connection, $qurry);
if ($addGroup) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Group was successfully created!",
          showConfirmButton: false,
          timer: 2000
      }).then(function(){
        window.location="add_group_member.php";
        });
  });
  </script>
  ';
 
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error creating group",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
}

}?>
<!-- Content added here -->
<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Create Group</h4>
            <p class="card-category">Fill in all important data</p>
          </div>

          <div class="card-body">
            <form id="form" action="create_group.php" method="POST">
              <div class = "row">
                <div class = "col-md-12">
                  <div class = "form-group">
                    <!-- Group info _ Tab1 -->
                    <div class="tab"><h3> Group info:</h3>
                      <div class="row">
                        <div class="col-md-6">
                          <label class = "bmd-label-floating">Group Name *:</label>
                          <input type="text" name="gname" id="" class="form-control" required="required" title="Please enter group name">
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Account Type</label>

                            <select required name="acct_type" class="form-control" data-style="btn btn-link" id="collat" title="Please select account type" required="required">
                              <option value="">Select a Account Type</option>
                              <?php foreach ($fillSavingQuery as $key => $savings) { ?>
                              <option value="<?=$savings["id"]?>"><?=$savings["name"]?></option>
                            <?php  } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="">Branch:</label>
                            <select class="form-control" name="branch_id" title="Please select branch">
                              <?php foreach ($fillBranchQuery as $key => $branch) { ?>
                              <option value="<?=$branch["id"]?>"><?=$branch["name"]?></option>
                            <?php  } ?>
                            </select>
                          </div>
                        </div>
                         
                        <div class="col-md-6">
                          <label for="">Loan Officer *:</label>
                          <select name="acc_off" id="" class="form-control" required="required" title="Please select loan officer">
                           <option hidden value="">Select an option</option>
                            <?php foreach ($fillOfficerQuery as $key => $officer) { ?>
                              <option value="<?=$officer["id"]?>"><?=$officer["display_name"]?></option>
                            <?php  } ?>
                         </select>
                       </div>
                       <div class="col-md-6">
                        <label for="">Registration Date *:</label>
                        <input type="date" name="reg_date" class="form-control" id="" required="required" title="Please enter registration date">
                      </div>
                      <div class="col-md-6">
                        <label for="">Registration :</label>
                        <select name="reg_type" id="" class="form-control" title="Please select registration">
                          <option value="Informal">Informal</option>
                          <option value="Formal">Formal</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="">Meeting Day :</label>
                        <select name="meet_day" id="" class="form-control" placeholder="Select an Option" title="Please select meeting day" >
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                          <option value="Sunday">Sunday</option>
                        </select>                        
                      </div>
                      <div class="col-md-6">
                        <label for="">Meeting Frequency :</label>
                        <select name="meet_frequency" id="" class="form-control" placeholder="Select an Option" title="Please select meeting frequency">
                          <option value="weekly">Weekly</option>
                          <option value="monthly">Monthly</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="">Meeting Location :</label>
                        <input type="text" name="meet_address" class="form-control" id="" required="required" title="Please enter meeting location">
                      </div>
                      <div class="col-md-6">
                        <label for="">Meeting Time :</label>
                        <input type="time" name="meet_time" class="form-control" id="" required="required" title="Please enter meeting time">
                      </div>
                      <div class="col-md-6">
                        <label for="">Primary Contact Phone Number:</label>
                        <input type="text" name="pc_phone" class="form-control" id="" required="required" title="Please enter phone number">
                      </div>
                    </div>
                  </div>    

                  <div style="overflow:auto;">
                    <div style="float:right;">
                      <button class="btn btn-primary pull-right" type="submit" name="submit" >Create</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </form>
      </div>


      <!-- /stepper  -->
    </div>
  </div>
</div>

<?php

include("footer.php");

?>