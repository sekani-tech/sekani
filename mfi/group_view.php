<?php

$page_title = "View Group";
$destination = "groups.php";
include('header.php');

?>


<div class="content">
        <div class="container-fluid">
          <!-- your content here -->

          <div class="row">

          <div class="col-md-8">
          
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

                      <div class="col-md-6">
                      <a href="update_client.php?edit=<?php echo $id;?>" class="btn btn-primary">Edit Group</a>
                    <a href="add_account.php?edit=<?php echo $id;?>" class="btn btn-primary">Add Member to Group</a>
                      </div>
               </div>

                </div>
                </div>

          </div>



          <div class="col-md-4">
              <!-- Dialog box for signature -->
              <div id="sig" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src=""/>
                      </div>
                    </div>
                  </div>      
                </div>
                <!-- dialog ends -->
                <!-- Dialog box for passport -->
              <div id="pas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                       
                      </div>
                    </div>
                  </div>
                </div>
                <!-- dialog ends -->
                <!-- Dialog box for id img -->
              <div id="id" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src=""/>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- dialog ends -->
                <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#pas">
                    <img class="img" src="" />
                  </a>
                </div>
                <!-- Get client data -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Group Image</h6>
                  <h4 class="card-title"></h4>
                  <p class="card-description">
           
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
              <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#id">
                    <img class="img" src="" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">ID Card</h6>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
                <!-- /id card -->
                <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#sig">
                    <img class="img" src="" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Signature</h6>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
                <!-- signature -->
            </div>

          </div>


          

          </div>



        </div>
      





<?php

include('footer.php');

?>