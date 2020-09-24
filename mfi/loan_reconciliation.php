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
                <?php
                $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE int_id = '$sessint_id' AND total_outstanding_derived > 0");
                ?>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <tr>
                          <th>Account Name</th>
                          <th>Account Number</th>
                          <th>Loan Term</th>
                          <th>Interest Rate</th>
                          <th>Principal Amount</th>
                          <th>Loan Outstanding</th>
                          <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      if (mysqli_num_rows($query_loan) > 0){
                          while ($row = mysqli_fetch_array($query_loan)) {
                      ?>
                        <tr>
                            <?php
                            $client_id = $row["client_id"];
                            $query_client = mysqli_query($connection, "SELECT * FROM client WHERE id ='$client_id' AND int_id = '$sessint_id'");
                            $cm = mysqli_fetch_array($query_client);
                            $firstname = strtoupper($cm["firstname"]." ".$cm["lastname"]);
                            ?>
                          <td><?php echo $firstname ?></td>
                          <td><?php echo $row["account_no"] ?></td>
                          <td><?php echo $row["loan_term"]." ".$row["repay_every"]."(s)"; ?></td>
                          <td><?php echo $row["interest_rate"]."%"; ?></td>
                          <td><?php echo "₦ ".number_format($row["principal_amount"], 2); ?></td>
                          <td><?php echo "₦ ".number_format($row["total_outstanding_derived"], 2); ?></td>
                          <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-success">View</button>
                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-lg">Pay Loan</a>
                                      <a class="dropdown-item" href="loan_repayment_view.php?id=<?php echo $row["id"]; ?>">Edit Loan Repayment</a>
                                    </div>
                                  </div> 
                          </td>                         
                        </tr>
                        <tr>
                        <?php
                          }
                      } else {
                          ?>
                          <tr>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td> 
                          <td>
                          <div class="btn-group" disabled>
                            <button type="button" disabled class="btn btn-success">View</button>
                            <button type="button" disabled class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                               <a class="dropdown-item" disabled href="#">Pay Loan</a>
                               <a class="dropdown-item" disabled href="#">Edit Loan Repayment</a>
                            </div>
                           </div> 
                          </td>                         
                        </tr>
                        <tr>
                          <?php
                      }
                        ?>
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