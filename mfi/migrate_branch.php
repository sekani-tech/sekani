<?php

$page_title = "Branch Data";
$destination = "bulk_upload";
include("header.php");


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


<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <!-- Begining of Charge Row !-->
        <div class="row">

            <div class="col-md-12">


                <!-- Branch Data Begins -->
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Branch Data</h4>
                        <p class="category"></p>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Files must be in <b>.csv</b></li>
                                            <li>CSV files should contain all the columns as stated on the Data
                                                Sample
                                            </li>
                                            <li>The order of the columns should be the same as stated on the Data
                                                Sample, all information is important.
                                            </li>
                                            <li>You can upload a maximum of 120 rows in 1 file. If you have more
                                                rows, please split them into multiple files.
                                            </li>
                                            <li>
                                                <STRONG style="color: red">
                                                    IMPORTANT: Before upLoading your excel file please always
                                                    remember
                                                    to remove
                                                    the default table header (i.e row 1) completely.
                                                    Clarify your data before uploading because deleting, because a branch cannot be deleted.
                                                </STRONG>
                                            </li>
                                        </ul>
                                        <div class="card-body text-center">
                                            <a href='bulkWork/getFile.php?name=branchData&loc=2' class="btn btn-primary btn-lg">Download Data Sample</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Upload CSV File(.csv)</h4>
                                        <p class="category"></p>
                                    </div>
                                    <div class="card-body">
                                        <form action="../functions/migrate/branch_migrate.php" method="post" enctype="multipart/form-data">
                                            <div class="input-group">
                                                <input type="file" name="clientData" class="form-control inputFileVisible">
                                                <span class="input-group-btn">
                                                    <button type="submit" name="submitClient" class="btn btn-fab btn-round btn-primary">
                                                        <i class="material-icons">send</i>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Branch Card Data Ends -->

            </div>


            <!-- End of Charge Row -->

        </div>
    </div>


</div>


<?php

include("footer.php");

?>