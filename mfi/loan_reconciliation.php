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
                               <a class="dropdown-item" href="#">Pay Loan</a>
                               <a class="dropdown-item" href="#">Edit Loan Repayment</a>
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