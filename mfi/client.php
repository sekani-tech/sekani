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
} else if (isset($_GET["message4"])) {
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
} else if (isset($_GET["message5"])) {
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
<link href='datatable/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
<script src="datatable/DataTables/datatables.min.js"></script>
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Clients</h4>
                        <p class="card-category">
                            <?php
                            $query = "SELECT COUNT(firstname) FROM client WHERE int_id = '$sessint_id' AND status = 'Approved'";
                            $result = mysqli_query($connection, $query);
                            if ($result) {
                                $inr = mysqli_fetch_array($result);
                                echo $inr['COUNT(firstname)'];
                            }
                            ?> registered clients || <a style="color: white;" href="manage_client.php">Create New client</a></p>

                    </div>
                    <div class="card-body">
                        <!-- end search -->
                        <div class="table-responsive">
                            <table id="empTable" class="display nowrap dataTable" style="width:100%">
                                <thead class="text-primary">
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
                                    <th>View</th>
                                    <th>Close</th>
                                    <!-- <th>Phone</th> -->
                                </thead>
                                <!-- refresh
                      end refresh -->
                            </table>

                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#empTable').DataTable({
                                    'processing': true,
                                    'serverSide': true,
                                    'serverMethod': 'post',
                                    'ajax': {
                                        'url': 'datatable/ajaxfile.php'
                                    },
                                    'columns': [{
                                            data: 'firstname'
                                        },
                                        {
                                            data: 'lastname'
                                        },
                                        {
                                            data: 'account_officer'
                                        },
                                        {
                                            data: 'account_type'
                                        },
                                        {
                                            data: 'account_no'
                                        },
                                        {
                                            data: 'view'
                                        },
                                        {
                                            data: 'close'
                                        },
                                    ]
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>