<?php
$page_title = "Loan Reconciliation";
$destination = "configuration.php";
include("header.php");
?>
<!-- do your front end -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Loan Reconciliation</h4>
              
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <tr>
                          <th>Account Name</th>
                          <th>Account Number</th>
                          <th>Loan Product</th>
                          <th>Interest Rate</th>
                          <th>Principal Amount</th>
                          <th>Loan Outstanding</th>
                          <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Dennis</td>
                          <td>1023465798</td>
                          <td>120,000</td>
                          <td>10</td>
                          <td>2,000,000</td>
                          <td>3,000,000</td> 
                          <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-success">View</button>
                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-lg">Pay Loan</a>
                                      <a class="dropdown-item" href="#">Edit Loan Repayment</a>
                                    </div>
                                  </div> 
                          </td>                         
                        </tr>
                        <tr>
                      </tbody>
                    </table>
                    <!-- popup -->
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="card card-signup card-plain">
                <div class="modal-header">
                 Repay Loan Manually
                  </div>
    </div>
    <div class="modal-body">
                   
                    <form class="form" method="" action="">
                       
                        <div class="card-body">

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                   
                                  </div>
                                  <input type="text" class="form-control" placeholder="Amount">
                                </div>
                            </div>

                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    
                                  </div>
                                  <input type="date" class="form-control" placeholder="yyyy-mm-dd">
                                </div>
                            </div>
                            <div class="form-group bmd-form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    
                                  </div>
                                  <select name="" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="">Principal Amount</option>
                                    <option value="">Interest Amount </option>
                                    <option value="">Principal Interest</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                <div class="modal-footer justify-content-center">
                    <a href="#pablo" class="btn btn-primary btn-link btn-wd btn-lg">Pay</a>
                </div>
                    
                </div>
  </div>
  <!-- body -->

</div>
                    <!-- end -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- end your front end -->
<?php
include("footer.php");
?>