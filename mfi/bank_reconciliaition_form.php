<?php

$page_title = "Bank Reconciliaition";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Bank Reconciliaition Form</h4>

                    </div>
                    <div class="card-body">
                        <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bank</label>
                                    <select name="client" class="form-control" id="collat">
                                        <option value="">select an option</option>
                                        <option value="">select an option</option>
                                        <option value="">option</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6">
                                
                                    <label for="exampleInputPassword1">Upload Bank Statement</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control inputFileVisible" placeholder="Single File">
                                    </div>
                                    <small id="emailHelp" class="form-text text-muted">Upload Excel File.</small>
                                
                            </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
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