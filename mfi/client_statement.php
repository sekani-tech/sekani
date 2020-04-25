<?php

$page_title = "Client Statement";
$destination = "client.php";
include('header.php');

?>

<!-- Content added here -->
<!-- print content -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Customer Statement</h4>
                </div>
                <div class="card-body">
                  <form action="">
                    <div class="form-group">
                      <label for="">Name:</label>
                      <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="Tunde Biodun" readonly name="display_name">
                    </div>
                    
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Account Statement</h4>
                </div>
                <div class="card-body">
                <table id="tabledat4" class="table">
                        <th>Transfer Date</th>
                        <th>Value Date</th>
                        <th>Reference</th>
                        <th>Debits</th>
                        <th>Credits</th>
                        <th>Balance</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          </tr>
                      </tbody>
                    </table>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Loan Statement</h4>
                </div>
                <div class="card-body">
                <table id="tabledat4" class="table">
                        <th>Transfer Date</th>
                        <th>Value Date</th>
                        <th>Reference</th>
                        <th>Debits</th>
                        <th>Credits</th>
                        <th>Balance</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          </tr>
                      </tbody>
                    </table>
                    <a href="" class="btn btn-primary">Print</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <!-- <div class="card-avatar">
                  <a href="#pablo">
                  </a>
                </div> -->
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Statement Period</h6>
                  <h4>01/01/2020 - 01/04/2020</h4>
                  <h6 class="card-category text-gray">Branch Name</h6>
                  <h4>Gudu</h4>
                  <h6 class="card-category text-gray">Account No</h6>
                  <h4>0320382454</h4>
                  <h6 class="card-category text-gray">Account Type</h6>
                  <h4>Savings</h4>
                  <h6 class="card-category text-gray">Currency Type</h6>
                  <h4>Naira</h4>
                  <h6 class="card-category text-gray">Opening Balance</h6>
                  <h4>20</h4>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
                <!-- /account statement -->
                <br>
              </div>
              <div class="card card-profile">
                <!-- <div class="card-avatar">
                  <a href="#pablo">
                  </a>
                </div> -->
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Statement Period</h6>
                  <h4>01/01/2020 - 01/04/2020</h4>
                  <h6 class="card-category text-gray">Branch Name</h6>
                  <h4>Gudu</h4>
                  <h6 class="card-category text-gray">Account No</h6>
                  <h4>0320382454</h4>
                  <h6 class="card-category text-gray">Account Type</h6>
                  <h4>Quick Credit</h4>
                  <h6 class="card-category text-gray">Currency Type</h6>
                  <h4>Naira</h4>
                  <h6 class="card-category text-gray">Opening Balance</h6>
                  <h4>0</h4>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
            </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>