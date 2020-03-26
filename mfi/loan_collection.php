<?php 

$page_title = "Loan Collection";
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
                    <h4 class="card-title">Loan collection</h4>
                    <!-- populate with client's name -->
                    <p class="card-category">Loan Repayment by - Client's Name</p>
                  </div>
                  <div class="card-body">
                    <form action="./functions/collect_payment.php?sn=<?php echo $id; ?>" method="post">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Expected Amount:</label>
                              <input type="text" name="" class="form-control" id="" value="" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Amount Recieved:</label>
                              <input type="number" name="collect" id="" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Payment Method:</label>
                              <select name="status" id="" class="form-control">
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Transfer">Transfer</option>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Transaction ID(Cheque no, Transfer Id):</label>
                              <input type="text" name="" class="form-control" id="">
                          </div>
                          <!-- Change the below input format into conditional statement -->
                            <!-- <div class="form-group">
                              <label for="">Status</label>
                              <select name="status" id="" class="form-control">
                                <option value="">......</option>
                                <option value="1">Not Complete</option>
                                <option value="2">Completed</option>
                                <option value="3">Over Payed</option>
                              </select>
                            </div> -->
                        </div>
                      </div>    
                            <button class="btn btn-default">Reset</button>
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>

<?php 

include("footer.php");

?>