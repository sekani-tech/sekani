<div class="content">
        <div class="container-fluid">
                    <!-- your content here -->
                    <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">Loan Maturity Report</h4>
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
                    <span id="runmature" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
              </div>
              <script>
                    $(document).ready(function () {
                      $('#runmature').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#input').val();
                        var teller = $('#till').val();
                        var int_id = $('#int_id').val();
                        $.ajax({
                          url: "items/maturity_profile.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, teller:teller, int_id:int_id},
                          success: function (data) {
                            $('#shmature').html(data);
                          }
                        })
                      });
                    });
                  </script>
              <div id="shmature" class="card">

              </div>
            </div>
          </div>

        </div>
 </div>
              <?php
              $out = '<div class="card">
                <div class="card-body">
                  <div style="margin:auto; text-align:center;">
                  <img src="op.jpg" alt="sf">
                  <h2>Institution name</h2>
                  <p>Address</p>
                  <h4>Schedule of Deposit Structure and Maturity Profile</h4>
                  <h4>Branch</h4>
                  <P>From: 24/05/2020  ||  To: 24/05/2020</P>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Schedule of Deposit Structure and Maturity Profile</h4>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                    <thead>
                      <th style="font-weight:bold;">TYPE OF DEPOSIT</th>
                      <th style="font-weight:bold; text-align: center;">1- 30 Days <br> &#x20A6</th>
                      <th style="font-weight:bold; text-align: center;">31- 60 Days <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">61- 90 Days <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">91- 180 Days <br> &#x20A6 </th>
                      <th style="text-align: center; font-weight:bold;"> 181- 360 Days <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;"> Above 360 Days <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;"> TOTAL <br> &#x20A6</th>
                    </thead>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="font-weight:bold;">Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">MANDATORY</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">VOLUNTARY</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">TERM/TIME</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">SPECIAL</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">OTHER DEPOSITS</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold; background-color:bisque;">TOTAL</td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                      </tr>
                      <tr>
                        <td style="background-color:bisque;">Number of Account</td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                      </tr>
                      <tr>
                        <td style="background-color:bisque;">Amount (&#x20A6)</td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
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
';
echo $out;?>