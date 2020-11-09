<?php

$page_title = "Clients";
$destination = "index.php";
    include("header.php");
    $br_id = $_SESSION['branch_id'];

?>
<?php
//  Sweet alert Function

// If it is successfull, It will show this message
  if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    // $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Registration Successful",
            text: "Awaiting Approval of New client",
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
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  // $out = $_SESSION["lack_of_intfund_$key"];
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
          text: "Client was Updated successfully!",
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
        text: "Error updating client!",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
$_SESSION["lack_of_intfund_$key"] = 0;
  }
}
else if (isset($_GET["message5"])) {
  $key = $_GET["message5"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Client Closed!",
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
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Clients</h4>
                  <p class="card-category"><?php
                        $query = "SELECT client.id, 
                                    client.BVN, 
                                    client.date_of_birth, 
                                    client.gender, 
                                    client.account_type, 
                                    client.account_no, 
                                    client.mobile_no, 
                                    client.firstname, 
                                    client.lastname,  
                                    staff.first_name, 
                                    staff.last_name
                                    FROM client 
                                    JOIN staff ON client.loan_officer_id = staff.id 
                                    WHERE client.int_id = '$sessint_id'
                                    AND client.status = 'Approved'";
                        $result = mysqli_query($connection, $query);
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   ?> registered clients || <a style = "color: white;" href="manage_client.php">Create New client</a></p>
                  
                </div>
                <div class="card-body">
                <?php include("datatable/table_start.php") ?>
                  <script>
                $(document).ready(function() {
                    var def = 0;
                    $.ajax({
                      url:"datatable/client_query.php",
                      method:"POST",
                      data:{def:def},
                      success:function(data){
                        $('#display_client').html(data);
                      }
                    });
                    $('#general_search').on("change keyup paste", function(){
                    var search_data = $(this).val();
                    $.ajax({
                      url:"datatable/client_query.php",
                      method:"POST",
                      data:{search_data:search_data},
                      success:function(data){
                        $('#display_client').html(data);
                      }
                    })
                  });
                });
                  </script>
                  <!-- end search -->
                  <div id="display_client"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php
    include("footer.php");
?>