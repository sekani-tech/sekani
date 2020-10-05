<?php

$page_title = "LOAN REPAYMENT SCHEDULE";
$destination = "client.php";
include('header.php');

?>

<!-- Content added here -->
<!-- print content -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">LOAN REPAYMENT SCHEDULE</h4>
            </div>
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Hide Zero Balances</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Run report</button>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div style="margin:auto; text-align:center;">
                  <img src="op.jpg" alt="sf">
                  <h2>Institution name</h2>
                  <p>Address</p>
                  <h4><b>Daniel Amodu</b></h4>
                  <h4><b>Date:</b> </h4>
                  <hr>
                  <h4><b>Loan id:</b> </h4>
                  <P><b>Released Date:</b> 24/05/2020  || <b>Maturity:</b> 24/05/2020</P>
                  <p><b>Repayment Cycle:</b> Monthly || <b>Interest rate:</b> 2.5%/Monthly</p>
                  <P><b>Principal Amount:</b> </P>
                  <p><b>Deducatable Fees:</b> 0 || <b>Non Deductable Fees:</b> 0</p>
                  <p><b>Principal Released After Deductable Fees:</b> </p>
                  <p><b>Interest Amount:</b> ||  <b>Penalty Amount:</b> </p>
                  <p><b>Total Due Amount:</b> || <b>Paid Amount:</b></p>
                  <h4><b>Balance Amount:</b></h4>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">SCHEDULE</h4>
                </div>
                <div class="card-body">
                  <table class="rtable display nowrap" style="width:100%">
                    <thead>
                      <th>sn</th>
                      <th style=" font-weight:bold;">Date</th>
                      <th style=" font-weight:bold;">Description</th>
                      <th style=" font-weight:bold;">Principal</th>
                      <th style=" font-weight:bold;">Interest</th>
                      <th style=" font-weight:bold;">Fees</th>
                      <th style=" font-weight:bold;">Penalty</th>
                      <th style=" font-weight:bold;">Due</th>
                      <th style=" font-weight:bold;">Total Due</th>
                      <th style=" font-weight:bold;">Principal  Balance</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td>Total Due</td>
                        <td>1,270,025.40</td>
                        <td>215,700.00</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1,485,725.40</td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--//report ends here -->
              <div class="card">
                 <div class="card-body">
                  <a href="" class="btn btn-primary">Back</a>
                  <a href="" class="btn btn-success btn-left">Print</a>
                 </div>
               </div> 
            </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>