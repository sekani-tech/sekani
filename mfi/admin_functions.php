<?php

$page_title = "Administrative Functions";
$destination = "";
include("header.php");
?>

<style>
    .card .card-body {
        padding: 0.9375rem 20px;
        position: relative;
        height: 200px;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title text-center">Administrative Functions</h4>
                    <p class="card-category text-center"></p>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4 ml-auto mr-auto">
                <div class="card card-pricing bg-primary" style="height: auto;">
                    <div class="card-body ">

                        <h4 class="card-title">Rent Prepayment</h4>
                        <p class="card-description">
                            Setup Rent Prepayment for your institution
                        </p>
                        <a href="rent_repayment.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ml-auto mr-auto">
                <div class="card card-pricing bg-primary" style="height: auto;">
                    <div class="card-body ">

                        <h4 class="card-title">Inventory Schedule</h4>
                        <p class="card-description">
                            Setup Inventory Schedule for your institution
                        </p>
                        <a href="inventory_schedule.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>


    


        </div>
    </div>

</div>




<?php

include("footer.php");

?>