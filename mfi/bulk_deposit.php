<?php

$page_title = "Charge data";
$destination = "bulk_update";
include("header.php");

?>  


<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
        <!-- Begining of Charge Row !-->

        <div class="row">

        <div class="col-md-12">
     
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title">Bulk Deposit</h4>
        <p class="category">Make Bulk Deposit in different Branches </p>
      </div>
      <div class="card-body">

              <div class="row">
              <div class="col-md-6">
              

              <!-- SELECT BRANCH CARD BEGINS -->
              <div class="card">
        <div class="card-body">
      <div class="form-group">
                <label for="exampleFormControlSelect1">Select Branch</label>
                <select class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
                <option>Lagos</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
            </div>
      </div>
              </div>

              <!-- SELECT BRANCH CARD ENDS -->
              


                        <div class="card">
                    
                    <div class="card-body">
                        <div class="row">
                    <!-- INDIVIDUAL RADIO BUTTON BEGINS -->
                    <div class="col-md-6">
                    <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >
                        Individual
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>

                    </div>
                     <!-- INDIVIDUAL RADIO BUTTON ENDS -->

                   
                   
                     <!-- GROUP RADIO BUTTON BEGINS -->
                    <div class="col-md-6">
                    <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >
                    Group
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>

                    </div>
                    <!-- GROUP RADIO BUTTON ENDS -->

                    </div>

                    <div class="row">

                    <!-- SELECT INDIVIDUAL DROPDOWN BEGINS -->
                    <div class="col-md-12">

                    <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Individual</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                </select>
                            </div>

                    </div>
                     <!-- SELECT INDIVIDUAL DROPDOWN ENDS -->
                    </div>



                    <!-- SELECT GROUP DROPDOWN BEGINS -->
                    <div class="row">

                    <div class="col-md-12">

                    <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Group</label>
                                <select class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                </select>
                            </div>
                            
                    </div>
                    </div>
                    <!-- SELECT GROUP DROPDOWN ENDS -->
                    
                    </div>

                    </div>
              
              </div>

                            <!-- REQUIREMENTS SAMPLE COLUMN BEGINS -->

                            <div class="col-md-6">
                                            <div class="card card-info">
                                            <div class="card-header">
                                                <h4 class="card-title"> <i class="material-icons">info</i> Requirements </h4>
                                            
                                            </div>
                                            <div class="card-body">
                                            <ul>
                                        <li>Files must be in <b>.csv</b></li>
                                        <li>CSV files should contain all the columns as stated on the Data Sample</li>
                                        <li>The order of the columns should be the same as stated on the Data Sample with the first rows as header</li>
                                        <li>You can upload a maximum of 4,000 rows in 1 file. If you have more rows, please split them into multiple files.</li>
                                        </ul>
                                        <div class="card-body text-center">
                                        <button class="btn btn-primary btn-lg ">
                                                Download Data Sample</button>
                                        </div>
                                            </div>
                                            </div>
                </div>
                <!-- REQUIREMENTS SAMPLE COLUMN BEGINS -->
                    </div>

                 
                 
                     <!-- UPLOAD SECTION BEGINS -->
                    <div class="row">

                    <div class="col-md-12">
                            <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Upload CSV File(.csv)</h4>
                                <p class="category"></p>
                            </div>
                            <div class="card-body">
                                
                            
                                <div class="input-group">
                                    
                                    <input type="file" class="form-control inputFileVisible" placeholder="Single File">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-primary">
                                            <i class="material-icons">attach_file</i>
                                        </button>
                                    </span>
                            </div>
                            </div>
                            </div>
                                </div>

                  </div>
                   <!-- UPLOAD SECTION ENDS -->


    </div>
  </div>
        
                    
                                        
      </div>
     </div>

        </div>

</div>