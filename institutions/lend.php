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
                      <h5 class="mb-0" data-acc-title>Loan Terms</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <div class="form-group">
                            <label>Loan size:</label>
                            <input type="number" name="" class="form-control" required id="">
                          </div>
                          <div class="form-group">
                            <label>Loan Term:</label>
                            <input type="number" name="" class="form-control" />
                          </div>
                          <div class="form-group">
                            <label>Interest Rate (per month):</label>
                            <input type="number" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Disbusrsement Date:</label>
                            <input type="date" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Loan Officer:</label>
                            <input type="text" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Loan Purpose:</label>
                            <input type="text" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Linked Savings account:</label>
                            <input type="text" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Repayment Start Date:</label>
                            <input type="date" name="" class="form-control" id="">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Collateral</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <div class="form-group">
                            <label>Type:</label>
                            <select name=""class="form-control" id="">
                              <option value="">select an option</option>
                            </select>
                          </div>

                          <div class="form-group">
                            <label>Value:</label>
                            <input type="text" name="" class="form-control" />
                          </div>
                          <div class="form-group">
                            <label for="">Description:</label>
                            <input type="text" name="" class="form-control" id="">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Guarantors</h5>
                      <div data-acc-content>
                        <div class="my-3">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for=""> First Name:</label>
                                <input type="text" name="gau_first_name" id="" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for=""> Last Name:</label>
                                <input type="text" name="gau_last_name" id="" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="">Phone:</label>
                                  <input type="text" name="gau_phone" id="" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="">Phone:</label>
                                  <input type="text" name="gau_phone2" id="" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">Home Address:</label>
                                  <input type="text" name="gau_home_address" id="" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                  <label for="">Office Address:</label>
                                  <input type="text" name="gau_office_address" id="" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="">Position Held:</label>
                                  <input type="text" name="gau_position_held" id="" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Email:</label>
                                <input type="text" name="gau_email" id="" class="form-control">
                            </div>
                            </div>
                        </div>
                        </div>
                      </div>
                    </div>

                    <!-- group 4 -->

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Repayment Schedule</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <!-- replace values with loan data -->
                          <div class="form -group">
                            <label for="">Disbursement:</label> <span>50000</span>
                          </div>
                          <div class="form -group">
                            <label for="">Principal Due &amp; Date:</label> <ul>
                              <li>(DATE) - 667</li>
                            </ul>
                          </div>
                          <div class="form -group">
                            <label for="">Principal Balance:</label> <span>50000</span>
                          </div>
                          <div class="form -group">
                            <label for="">Intrest Rate:</label> <span>7%</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- 5 -->
                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Overview</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <!-- replace values with loan data -->
                          <div class="form-group">
                            <label>Loan size:</label>
                            <input type="number" name="" class="form-control" required id="">
                          </div>
                          <div class="form-group">
                            <label>Loan Term:</label>
                            <input type="number" name="" class="form-control" />
                          </div>
                          <div class="form-group">
                            <label>Interest Rate (per month):</label>
                            <input type="number" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Disbusrsement Date:</label>
                            <input type="date" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Loan Officer:</label>
                            <input type="text" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Loan Purpose:</label>
                            <input type="text" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Linked Savings account:</label>
                            <input type="text" name="" class="form-control" id="">
                          </div>
                          <div class="form-group">
                            <label>Repayment Start Date:</label>
                            <input type="date" name="" class="form-control" id="">
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