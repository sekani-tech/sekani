<?php

$page_title = "Create Group";
$destination = "index.php";
include("header.php");
$b_id = $_SESSION['branch_id'];
?>

<?php
//Fetch all the last group data having the same institution id as the current session
$int_id = $_SESSION["int_id"];
$groupsDetails = selectOneWithOrder('groups', ['int_id'=>$int_id], 'id', 'desc', 1);

?>

<?php if(isset($_POST['submit'])){
  $group_cache_id = $_POST['group_cache_id'];
  $int_id = $_SESSION["int_id"];

//Fetch data in group_client_cache
  $cacheQuery = [
    'int_id' => $int_id,
    'group_cache_id' => $group_cache_id
  ];
  $cacheResult = selectAll('group_client_cache', ['int_id'=>$int_id]);

  if ($cacheResult) {
    foreach ($cacheResult as $key => $cacheValue) {
      $clientId = $cacheValue['client_id'];

//Fetch Client Details
      $clientQuery=[
        'int_id' => $int_id,
        'id' => $clientId
      ];
      $clientQueryResult = selectSpecificData('client', ['firstname','lastname'], $clientQuery);
      $clientName = $clientQueryResult['firstname']." ".$clientQueryResult['lastname'];

//Fetch all group details
      $groupQuery = [
        'int_id' => $int_id,
        'id' => $group_cache_id
      ];
      $groupQueryResult = selectSpecificData('groups', ['id','g_name','branch_id'], $groupQuery);

      $groupId = $groupQueryResult['id'];
      $groupName = $groupQueryResult['g_name'];
      $branchId = $groupQueryResult['branch_id'];

//Final Insertion will be done into group_clients

      $groupClientsQuery=[
        'int_id' => $int_id,
        'group_name' => $groupName,
        'branch_id' => $branch_id,
        'client_id' => $clientId,
        'client_name' => $clientName,
        'group_id' => $groupId

      ];


      $addGroupClients= create('group_clients', $groupClientsQuery);

    }

  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Group data was successfully created!",
          showConfirmButton: false,
          timer: 2000
     }).then(function(){
        window.location="groups.php";
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
          text: "No data was found for group in group client cache",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
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
            <h4 class="card-title">Add Group Member</h4>
            <p class="card-category">Fill in all important data</p>
          </div>

          <div class="card-body">
            <form id="form" action="add_group_member.php" method="POST">
              <div class = "row">
                <div class = "col-md-12">
                  <div class = "form-group">
                    <!-- Group info _ Tab1 -->
                    <div class="tab"><h3> Group info:</h3>
                      <div class="row">

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Group Name *:</label>
                            <input type="text" name="" value="<?php echo $groupsDetails['g_name'] ?>" readonly class="form-control">
                            <input type="hidden" name="group_cache_id" value="<?php echo $groupsDetails['id'] ?>" id="group_cache_id" hidden>
                            <!-- <select name="group_cache_id" class="form-control" id="group_cache_id" data-style="btn btn-link" id="collat" title="Please select group" required="required" readonly>
                              <?php ($connection); ?> -->
                              <!-- <option >'.strtoupper($row["g_name"]).'</option> -->
                              <!-- </select>  -->
                            </div>
                          </div>

                          <div class="col-md-6">
                            <label for="">Select Client *:</label>
                            <input type="text" name="search" id="search" class="form-control" title="Please select client">
                            <div id="display"></div>
                          </div>

                        </div>
                      </div>    


                      <script>
                       $(document).ready(function () {

                        $('#add').on("click", function () {
                          var group_cache_id = $('#group_cache_id').val();
                          var client_id = $('#client_id').val();
                          $.ajax({
                            url: "ajax_post/post_client_group.php", 
                            method: "POST",
                            data:{client_id:client_id, cache_id:group_cache_id},
                            success: function(data) {
                              $('#erio').html(data);
                            }
                          })
                        });
                      });



                       $(document).ready(function () {
                        $('#search').on("keyup", function () {
                          var search = $('#search').val();
                          if (search != '') {
                            $.ajax({
                              url: "ajax_post/sub_ajax/fetch_client.php", 
                              method: "POST",
                              data:{search:search},
                              success: function(data) {
                               $('#display').fadeIn();  
                               $('#display').html(data); 
                             }
                           })
                          }
                          else{
                            $('#display').hide();
                          }
                        });

                        $(document).on('click', 'li', function(){  
                         $('#search').val($(this).text());  
                         $('#display').fadeOut();  
                       });
                      });


                    </script>


                    <div style="overflow:auto;">
                      <div style="float:right;">
                       <a href="#" class="btn btn-primary pull-right" type="submit" id="add">Add Group member</a>
                       <button class="btn btn-primary pull-right" type="submit" name="submit" onclick="return confirm('You are about to submit this request, are you sure?')" >Submit</button>
                       <!--<a href="groups.php" class="btn btn-primary pull-right">Finish</a>-->
                     </div>
                   </div>

                 </div>
               </div>
             </div>
           </div>
         </form>

         <p id="delshow"></p>

         <div class="col-md-4" id="erio">
         </div>
       </div>


       <!-- /stepper  -->
     </div>
   </div>
 </div>

 <?php

 include("footer.php");

 ?>