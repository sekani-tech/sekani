<?php

$page_title = "Loans data";
$destination = "bulk_upload";
include("header.php");
// include("../functions/connect.php");
?>
<?php
  function glaccount_migrate($connection, $branch_id,$sessint_id)
  {  
    $br_id = $_SESSION["branch_id"];
    $sint_id = $_SESSION["int_id"];

    $dd = "SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND gl_code = '$br_id'";
    $dof = mysqli_query($connection, $dd);
    $out = '';
    while ($row = mysqli_fetch_array($dof))
    {
      $do = $row['id'];
    $out .= " OR client.branch_id ='$do'";
    }
    return $out;
  }

?>

<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="row">

            <div class="col-md-12">


                <!-- GL Accounts Transactions Data Card Begins -->
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">GL Accounts Transactions Data</h4>
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
                                                Sample with the first rows as header
                                            </li>
                                            <li>You can upload a maximum of 4,000 rows in 1 file. If you have more
                                                rows, please split them into multiple files.
                                            </li>
                                            <li>
                                                <STRONG style="color: red">
                                                    IMPORTANT: Before upLoading your excel file please always
                                                    remember
                                                    to remove
                                                    the default table header (i.e row 1) completely.
                                                </STRONG>
                                            </li>
                                        </ul>
                                        <div class="card-body text-center">
                                            <!-- <a href="../functions/migrate/gl_account_migration.php" class="btn btn-primary btn-lg">Export Excel</a> -->
                                            <form action="../composer/gl_account_migration.php" method="post">
                                                <button type="submit" name="exportPDF" class="btn btn-primary">Export Excel</button>
                                            </form>
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
                                        <form action="../functions/migrate/gl_account_migration.php" method="post" enctype="multipart/form-data">
                                            <div class="input-group">
                                                <input type="file" name="clientData" class="form-control inputFileVisible">
                                                <span class="input-group-btn">
                                                    <button type="submit" name="exportPDF" class="btn btn-fab btn-round btn-primary">
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
                <!-- GL Accounts Transactions Card Data Ends -->

            </div>

        </div>
    </div>


</div>


<?php

include("footer.php");

?>