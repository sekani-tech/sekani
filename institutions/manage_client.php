<?php

    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create new Client</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/institution_client_upload.php" method="post">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Client Type</label>
                          <input type="text" class="form-control" name="ctype" value="Individual" readonly>
                        </div>
                      </div>
                      <!-- </div> -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display name</label>
                          <input type="text" class="form-control" name="display_name">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Fist Name</label>
                          <input type="text" class="form-control" name="first_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Middle Name</label>
                          <input type="text" class="form-control" name="middle_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" class="form-control" name="last_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No</label>
                          <input type="tel" class="form-control" name="phone">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No2</label>
                          <input type="tel" class="form-control" name="phone2">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" class="form-control" name="email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" class="form-control" name="addres">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Gender:</label>
                          <select class="form-control" name="gender" id="">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="">Date of Birth:</label>
                          <input type="date" class="form-control" name="date_of_birth">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="">Branch:</label>
                          <input type="text" class="form-control" name="branch">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Country:</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <label for="">State:</label>
                        <input type="text" name="" class="form-control" id="">
                      </div>
                      <div class="col-md-4">
                        <label for="">LGA:</label>
                        <input type="text" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label for="">BVN:</label>
                        <input type="text" name="" class="form-control" id="">
                      </div>
                      <div class="col-md-4">
                        <p><label for="">Active Alerts:</label></p>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              SMS
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              Email
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <select name="" class="form-control" id="">
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <!-- insert passport -->
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail img-raised">
                                <!-- <img src="http://style.anu.edu.au/_anu/4/images/placeholders/person_8x10.png" rel="nofollow" alt="..."> -->
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <div>
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                    <span class="fileinput-new">Select passport</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="..." />
                                </span>
                                <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <!-- insert passport -->
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail img-raised">
                                <!-- <img src="http://style.anu.edu.au/_anu/4/images/placeholders/person_8x10.png" rel="nofollow" alt="..."> -->
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <div>
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                    <span class="fileinput-new">Select signature</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="..." />
                                </span>
                                <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                            </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-4">
                        <label for="">Id Type</label>
                        <select name="" class="form-control" id="">
                          <option value="National ID">National ID</option>
                          <option value="Voters ID">Voters ID</option>
                          <option value="International Passport">International Passport</option>
                          <!-- <option value="Drivers Liscense"></option> -->
                        </select>
                      </div>
                      <div class="col-md-8">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail img-raised">
                                <!-- <img src="http://style.anu.edu.au/_anu/4/images/placeholders/person_8x10.png" rel="nofollow" alt="..."> -->
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <div>
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                    <span class="fileinput-new">Select signature</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="..." />
                                </span>
                                <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                            </div>
                        </div>
                      </div>
                    </div>
                    <a href="client.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Create Client</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /form card -->
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>