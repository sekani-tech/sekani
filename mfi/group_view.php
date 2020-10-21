<?php

$page_title = "View Group";
$destination = "groups.php";
include('header.php');

?>


<div class="content">
        <div class="container-fluid">
          <!-- your content here -->

          <div class="row">

          <div class="col-md-12">
          
          <div class="card">
          <div class="card-header card-header-primary">
                  <h4 class="card-title">Group Account Deatils</h4>
                </div>

                <div class="card-body">
                <div class="form-group">

                <label for="">Group Name:</label>
               <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="" readonly name="display_name">
                </div>
               <div class="row">

               <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Type:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="" readonly>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Loan Officer:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="" readonly>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Branch:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="" readonly>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Registration Date</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="" readonly>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Registration Type</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="" readonly>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Meeting Day:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="" readonly>
                        </div>
                      </div>

                      <div class="col-md-12">
                      <div class="card">
          <div class="card-header text-center">
                  <h4 class="card-title">Group Members</h4>


                </div>

                <div class="card-body">
                <div class="table-responsive">
                    <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                      
                        <th></th>
                        <th>
                          First Name
                        </th>
                        <th>
                          Last Name
                        </th>
                       
                        <th>
                          Account Type
                        </th>
                        <th>
                          Account Number
                        </th>
                        <th>View</th>
                       
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                     
                        <tr>
                        
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          
                          
                          
                          <th></th>
                          <td><a href="" class="btn btn-info">View</a></td>
                         
                        </tr>
                          <!-- <th></th> -->
                      </tbody>
                    </table>
                  </div>
                </div>


                      </div>

                    


                      </div>

                      <div class="col-md-6">
                      <a href="" class="btn btn-primary">Edit Group</a>
                    <a href="" class="btn btn-primary">Add Member to Group</a>
                      </div>
               </div>

                </div>
                </div>

          </div>



         
          </div>


          

          </div>



        </div>
      





<?php

include('footer.php');

?>