<?php

$page_title = "Reconciliation";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Bank Reconciliation Matching</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <div class="card card-pricing bg-success">
                <div class="card-header card-header-primary">
                        <h4 class="card-title">Sekani Bank Statement</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body ">
                        <h3 class="card-title">Transaction ID: </h3>
                        <h3 class="card-title">Amount: </h3>
                        <h3 class="card-title">Transaction Date: </h3>
                        <h3 class="card-title">Deposited by: </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6 ml-auto mr-auto">
                <div class="card card-pricing bg-success">
                <div class="card-header card-header-primary">
                        <h4 class="card-title">Uploaded Bank Statement</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body ">
                        <h3 class="card-title">Transaction ID: </h3>
                        <h3 class="card-title">Amount: </h3>
                        <h3 class="card-title">Transaction Date: </h3>
                        <h3 class="card-title">Deposited by: </h3>
                    </div>
                </div>
            </div>


        </div>

        
        <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <div class="card card-pricing bg-warning">
                <div class="card-header card-header-primary">
                        <h4 class="card-title">Sekani Bank Statement</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body ">
                        <h3 class="card-title">Transaction ID: </h3>
                        <h3 class="card-title">Amount: </h3>
                        <h3 class="card-title">Transaction Date: </h3>
                        <h3 class="card-title">Deposited by: </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6 ml-auto mr-auto">
                <div class="card card-pricing bg-danger">
                <div class="card-header card-header-primary">
                        <h4 class="card-title">Uploaded Bank Statement</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body ">
                        <h3 class="card-title">Transaction ID: </h3>
                        <h3 class="card-title">Amount: </h3>
                        <h3 class="card-title">Transaction Date: </h3>
                        <h3 class="card-title">Deposited by: </h3>
                    </div>
                </div>
            </div>


        </div>




    </div>

</div>



<?php
include("footer.php");
?>