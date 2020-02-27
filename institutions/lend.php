<?php

    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Lend Money</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                <form id="form">

                  <div class="list-group">

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Name &amp; Email</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <div class="form-group">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" />
                          </div>
                          <div class="form-group">
                            <label>Email:</label>
                            <input type="text" name="email" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Contact</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <div class="form-group">
                            <label>Telephone:</label>
                            <input type="text" name="telephone" class="form-control" />
                          </div>

                          <div class="form-group">
                            <label>Mobile:</label>
                            <input type="text" name="mobile" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Payment</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <div class="form-group">
                            <label>Credit card:</label>
                            <input type="text" name="card" class="form-control">
                          </div>
                          <div class="form-group form-row">
                            <div class="col-sm-4">
                              <label>Expiry:</label>
                              <input type="text" name="expiry" class="form-control">
                            </div>
                            <div class="col-sm-4">
                              <label>CVV:</label>
                              <input type="text" name="cvv" class="form-control">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

                  </form>
                  <!-- /stepper  -->
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../assets/img/faces/marc.jpg" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                  <h4 class="card-title">Alec Thompson</h4>
                  <p class="card-description">
                    Sekani Systems
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
            </div>
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>