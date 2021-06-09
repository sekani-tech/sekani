<?php

$page_title = "Support Functions";
$destination = "../index.php";
include("header.php");



?>

<!-- Content added here -->

<style>
    .card .card-body {
        padding: 0.9375rem 20px;
        position: relative;
        height: 200px;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title text-center">Support Functions</h4>
                <p class="card-category text-center"></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 ml-auto mr-auto">
                <div class="card card-pricing bg-primary" style="height: auto;">
                    <div class="card-body ">

                        <h4 class="card-title">Client Statement Correction</h4>
                        <p class="card-description">
                            Delete Wrong or Duplicate Transactions from clients Account
                        </p>
                        <a href="client_statement_correction.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>


        </div>

     

    </div>
</div>

<?php

include("footer.php");

?>