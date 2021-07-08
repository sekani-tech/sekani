<?php

$page_title = "Create Budget";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Budget Setup</h4>
                    <!-- <p class="category">Category subtitle</p> -->
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col">
                                <label>GL <span style="color: red;">*</span></label>
                                <select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1" required>
                                    <option>Expense</option>
                                </select>
                            </div>
                            <div class="col">
                                <label>GL Code <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter GL Code" readonly>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label>Budget Amount <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Budget Amount" required>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <button type="button" class="btn btn-primary">Create Budget</button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php
include("footer.php");
?>