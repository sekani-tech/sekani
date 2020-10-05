<?php
$page_title = "Loan Repayment View";
$destination = "configuration.php";
include("header.php");

?>
<!-- new -->
<?php
if (isset($_GET["id"]) AND $_GET["id"] != "") {
    $loan_id = $_GET["id"];
    $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE int_id = '$sessint_id' AND id = '$loan_id'");
    $x = mysqli_fetch_array($query_loan);
    $client_id = $x["client_id"];
    $query_client = mysqli_query($connection, "SELECT * FROM client WHERE id ='$client_id' AND int_id = '$sessint_id'");
    $cm = mysqli_fetch_array($query_client);
    $firstname = strtoupper($cm["firstname"]." ".$cm["lastname"]);
    $account_no = $x["account_no"];
    $outstanding = number_format($x["total_outstanding_derived"], 2);
?>
 <?php
                          $sum_tot = mysqli_query($connection, "SELECT SUM(principal_amount) AS prin_sum FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
                          $sum_tott = mysqli_query($connection, "SELECT SUM(interest_amount) AS int_sum FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
                          $st = mysqli_fetch_array($sum_tot);
                          $stt = mysqli_fetch_array($sum_tott);
                          $outp = $st["prin_sum"];
                          $outt = $stt["int_sum"];
                          $duebalance = $outp + $outt;
                          ?>
<!-- do your front end -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Loan Repayment </h4>
              
                  <!-- Insert number users institutions -->
                </div>
                <!-- end -->
                <div class="card card-profile ml-auto mr-auto" style="max-width: 360px; max-height: 360px">
    <div class="card-body ">
        <h4 class="card-title"><?php echo $firstname; ?></h4>
        <h6 class="card-category text-gray">Account Number: <?php echo $account_no; ?></h6>
    </div>
    <div class="card-footer justify-content-center">
        <b>  Loan Outstanding Balance: NGN <?php echo $outstanding; ?> </b>
    </div>
</div>
                <!-- end new card profile -->
                <?php
                $query_loan = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' ORDER BY duedate ASC");
                ?>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <!-- <tr> -->
                          <th>Disbursement Date</th>
                          <th>Due Date</th>
                          <th>Principal Amount</th>
                          <th>Interest Amount</th>
                          <th>Payment Status</th>
                          <th>Total Due</th>
                          <th>Action</th>
                        <!-- </tr> -->
                      </thead>
                      <tbody>
                      <?php
                      if (mysqli_num_rows($query_loan) > 0){
                          while ($row = mysqli_fetch_array($query_loan)) {
                      ?>
                        <tr>
                          <td><?php echo $row["fromdate"] ?></td>
                          <td> <b> <?php echo $row["duedate"] ?> </b></td>
                          <td><?php echo "₦ ".number_format($row["principal_amount"], 2); ?></td>
                          <td><?php echo "₦ ".number_format($row["interest_amount"], 2); ?></td>
                          <?php
                          $inst = $row["installment"];
                          $current_date = date('Y-m-d');
                          if ($inst <= 0) {
                              $inst = "<span style='color:green'>Paid</span>";
                          } else if ($inst > 0 && $row["duedate"] < $current_date) {
                            $inst = "<span style='color:red'>Not Paid</span>";
                          } else {
                            $inst = "<span style='color:orange'>Pending</span>";
                          }
                          ?>
                          <td><?php echo $inst; ?></td>
                          <td><?php echo "₦ ".number_format($duebalance, 2); ?></td>
                          <td>
                          <div class="btn-group">
                              <?php
                              $current_date = date('Y-m-d');
                              if ($row["installment"] <= 0) {
                                  $option = "disabled";
                              } else {
                                  $option = "";
                              }
                              ?>
                            <button <?php echo $option; ?> onclick="location.href='loan_single_repayment.php?id=<?php echo $row['id'] ?>'" class="btn btn-secondary">Edit</button>
                            <button type="button" <?php echo $option; ?> class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-lg">Delete</a>
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
<!-- end your front end -->
<?php
} else {
    // run script
    echo '<script type="text/javascript">
    $(document).ready(function(){
     swal({
      type: "error",
      title: "Sorry No User Repayment Found",
      text: "Check the Reconciliation Table",
     showConfirmButton: false,
      timer: 2000
      }).then(
      function (result) {
        history.go(-1);
      }
      )
      });
     </script>
    ';
}
?>
<!-- end -->
<?php 
include("footer.php");
?>