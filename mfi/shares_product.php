<?php

$page_title = "Shares Product";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Create Shares Product</h4>
                        <p class="category">Fill in all important fields</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span style="color: red;">*</span>:</label>
                                    <input type="text" name="name" class="form-control" id="" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shortSharesName">Short Shares Name <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="short_name" value="" placeholder="Short Shares Name..." required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loanDescription">Unit Price <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" name="description" value="" placeholder="Unit Price...." required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="principal">Amount<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="Default_amount" value="" placeholder="Default" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="aviashares">Availabe Shares <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" name="availabe_shares" value="" placeholder="Define Availabe Shares..." required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="glcode">GL Code <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="gl_code" value="" placeholder="Default" required="">
                                </div>
                            </div>

                        </div>
                        <div style="float:right;">
                            <button class="btn btn-primary pull-right" type="button" id="">Submit</button>

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