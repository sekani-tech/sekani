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
    
            <!-- Charge Card Begins -->
            <div class="card">
                 <div class="card-header card-header-primary">
                            <h4 class="card-title">Charge</h4>
                            <p class="category"></p>
                     </div>
                                
                     <div class="card-body">
                            
                         <div class="row">
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

                                <div class="col-md-6">
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
                            
                                        
                    </div>


                                   

     </div>
<!-- Charge Card Ends -->


                             <!-- Auto Charge Card Begins -->
                                        <div class="card">
                                        <div class="card-header card-header-primary">
                                                <h4 class="card-title">Auto Charge</h4>
                                                <p class="category"></p>
                                            </div>
                                            <div class="card-body">
                                            <div class="row">
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

                                            <div class="col-md-6">
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
                                            </div>
                                        </div>
                                        <!-- Auto Charge Card Ends -->


                                        


    


</div>

</div>
        </div>              

</div>






<?php

    include("footer.php");

?>