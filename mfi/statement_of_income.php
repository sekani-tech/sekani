<?php

$page_title = "STATEMENT OF INCOME";
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
                    <h4 class="card-title">Statement of Financial Position</h4>
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
                        <label for="">Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">Head Office</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
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
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="">Initial Year</label>
                        <select name="" id="" class="form-control">
                          <option value="">2018</option>
                          <option value="">2019</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Comparing Year</label>
                        <select name="" id="" class="form-control">
                          <option value="">2018</option>
                          <option value="">2019</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div style="margin:auto; text-align:center;">
                  <img src="op.jpg" alt="sf">
                  <h2>Institution name</h2>
                  <p>Address</p>
                  <h4>Statement of Income</h4>
                  <h4></h4>
                  <P>24/05/2020</P>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Operating Revenue</h4>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <th style="font-weight:bold;">Codes</th>
                      <th style="font-weight:bold;">GL Account</th>
                      <th style="text-align: center; font-weight:bold;">2020 &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">2018 &#x20A6</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td>Interest on Loans:</td>
                        <td style="text-align: center">23,809,347</td>
                        <td style="text-align: center">23,809,347</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Less interest on borrowings and deposit liabilities:</td>
                        <td style="text-align: center">3,605,801</td>
                        <td style="text-align: center">3,605,801</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Net Interest Income</b></td>
                        <td style="text-align: center"><b>20,203,547</b></td>
                        <td style="text-align: center"><b>20,203,547</b></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Services fees, fines and penalties</td>
                        <td style="text-align: center">6,694,511</td>
                        <td style="text-align: center">6,694,511</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Other services and other income</td>
                        <td style="text-align: center">491,685</td>
                        <td style="text-align: center">491,685</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Total Income</b></td>
                        <td style="text-align: center"><b>27,389,742</b></td>
                        <td style="text-align: center"><b>27,389,742</b></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Operating Expenses</h4>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <th style="font-weight:bold;">Codes</th>
                      <th style="font-weight:bold;">GL Account</th>
                      <th style="text-align: center; font-weight:bold;">2020 &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">2018 &#x20A6</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td>Salaries, Wages and Allowances</td>
                        <td style="text-align: center">15,586,836</td>
                        <td style="text-align: center">15,586,836</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Fueling and Lubricant</td>
                        <td style="text-align: center">724,350</td>
                        <td style="text-align: center">724,350</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Transport and Traveling</td>
                        <td style="text-align: center">2,667,200</td>
                        <td style="text-align: center">2,667,200</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Office Rent</td>
                        <td style="text-align: center">1,290,000</td>
                        <td style="text-align: center">1,290,000</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Printing and Stationaries</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Electricity and other unilities expenses</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Professional and Consultancy fee</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Annual Subscription</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Trafic and Vehicle Licence</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>General Repairs and Maintenance</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Bank Charges</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Public Relations</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Hotel and Lodging</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Bad debt Written Off</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Security & Sanition</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Miscelious Expense</td>
                        <td style="text-align: center">504,600</td>
                        <td style="text-align: center">504,600</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: center"><b> 25,445,674</b></td>
                        <td style="text-align: center"><b> 25,445,674</b></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td style="font-weight:bold;">NET SURPLUS FROM OPERATIONS</td>
                        <td style="font-weight:bold; text-align: center"> 1,944,068 </td>
                        <td style="font-weight:bold; text-align: center">1,944,068</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Depreciation</td>
                        <td style="text-align: center">1,429,000</td>
                        <td style="text-align: center">1,429,000</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Income Tax</td>
                        <td style="text-align: center">139,700</td>
                        <td style="text-align: center">139,700</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td style="font-weight:bold;">SURPLUS FOR THE YEAR</td>
                        <td style="font-weight:bold; text-align: center">  375,368  </td>
                        <td style="font-weight:bold; text-align: center">375,368</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
               <!--//report ends here -->
               <div class="card">
                 <div class="card-body">
                  <a href="" class="btn btn-primary">Print</a>
                 </div>
               </div>
            </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>