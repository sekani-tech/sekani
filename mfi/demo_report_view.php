<?php

$page_title = "Client Report";
$destination = "report_savings.php";
    include("header.php");
?>

<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                Voluntary Savings Report
                </div>
                <div class="card-body">
                <div class="form-group">
                <form method = "POST" action = "">
                <div class="col-md-6">
                <input hidden name ="acc_bal" type="text" value=""/>
                        <div class="form-group">
                          <label class="bmd-label-floating">Total Account Balances</label>
                          <input type="text" readonly class="form-control" value="" name="">
                        </div>
                      </div>
              <button type="submit" id="clientlist" class="btn btn-primary pull-left">Download PDF</button>
                </form>
                </div>

                <div class="table-responsive">
                    <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                     
                        <th>
                          First Name
                        </th>
                        <th>
                          Last Name
                        </th>
                        <th>
                          Client Type
                        </th>
                        <th>
                          Account Type
                        </th>
                        <th>
                          Account Number
                        </th>
                        <th>
                          Account Balances
                        </th>
                      </thead>
                      <tbody>
                     
                        <tr>
                       
                          <th></th>
                          <th></th>
                          <th></th>
                        
                          <th></th>

                          <th></th>
                          
                          <th></th>
                        </tr>
                        
                          <!-- <th></th> -->
                      </tbody>
                    </table>
                  </div>


                </div>
                
              </div>
            </div>
          </div>
        </div>
</div>