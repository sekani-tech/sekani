<?php
$page_title = "Loan Repayment View";
$destination = "configuration.php";
include("header.php");
// include("items/loans/manual_process.php");

if (isset($_GET["view"]) && $_GET["view"] != "") {
    $loan_id = $_GET["view"];
    // dd($loan_id);
    $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE int_id = '$sessint_id' AND id = '$loan_id'");
    $x = mysqli_fetch_array($query_loan);
    $client_id = $x["client_id"];
    $account_no = $x["account_no"];
    $query_client = mysqli_query($connection, "SELECT * FROM client WHERE id ='$client_id' AND int_id = '$sessint_id'");
    $cm = mysqli_fetch_array($query_client);
    $firstname = strtoupper($cm["firstname"] . " " . $cm["lastname"]);
    $outstanding = number_format($x["total_outstanding_derived"], 2);

    $sum_tot = mysqli_query($connection, "SELECT SUM(principal_amount) AS prin_sum FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
    $sum_tott = mysqli_query($connection, "SELECT SUM(interest_amount) AS int_sum FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
    $st = mysqli_fetch_array($sum_tot);
    $stt = mysqli_fetch_array($sum_tott);
    $outp = $st["prin_sum"];
    $outt = $stt["int_sum"];
    $duebalance = $outp + $outt;

    
    $exp_error = "";
    $message = $_SESSION['feedback'];
    if($message != ""){
    ?>
    <input type="text" value="<?php echo $message?>" id="feedback" hidden>
    <?php
    }
    // feedback messages 0 for success and 1 for errors
    
    if (isset($_GET["message0"])) {
        $key = $_GET["message0"];
        $tt = 0;
      
        if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
          echo '<script type="text/javascript">
          $(document).ready(function(){
            let feedback =  document.getElementById("feedback").value;
              swal({
                  type: "success",
                  title: "Success",
                  text: feedback,
                  showConfirmButton: true,
                  timer: 7000
              })
          });
          </script>
          ';
          $_SESSION["lack_of_intfund_$key"] = 0;
        }
      } else if (isset($_GET["message1"])) {
        $key = $_GET["message1"];
        $tt = 0;
        if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
          echo '<script type="text/javascript">
          $(document).ready(function(){
            let feedback =  document.getElementById("feedback").value;
              swal({
                  type: "error",
                  title: "Error",
                  text: feedback,
                  showConfirmButton: true,
                  timer: 7000
              })
          });
          </script>
          ';
          $_SESSION["lack_of_intfund_$key"] = 0;
        }
      }
    
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
                                <b> Loan Outstanding Balance: NGN <?php echo $outstanding; ?> </b>
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
                                        <th>Amount Repaid</th>
                                        <th>Payment Status</th>
                                        <th>Total Due</th>
                                        <th>Action</th>
                                        <!-- </tr> -->
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($query_loan) > 0) {
                                            while ($row = mysqli_fetch_array($query_loan)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $row["fromdate"] ?></td>
                                                    <td> <b> <?php echo $row["duedate"] ?> </b></td>
                                                    <td><?php echo "₦ " . number_format($row["principal_amount"], 2); ?></td>
                                                    <td><?php echo "₦ " . number_format($row["interest_amount"], 2); ?></td>
                                                    <td><?php echo "₦ " . number_format($row["amount_collected"], 2); ?></td>
                                                    <?php
                                                    $inst = $row["installment"];
                                                    $current_date = date('Y-m-d');
                                                    $due_d = $row["duedate"];

                                                    $query_arrears = mysqli_query($connection, "SELECT * FROM `loan_arrear` WHERE ((loan_id = '$loan_id' AND duedate = '$due_d') AND installment > 0) ORDER BY id DESC LIMIT 1");
                                                    if (mysqli_num_rows($query_arrears) > 0) {
                                                        $mxv = mysqli_fetch_array($query_arrears);
                                                        $pina = $mxv["principal_amount"];
                                                        $inam = $mxv["interest_amount"];
                                                        $vbdt = number_format(($pina + $inam), 2);
                                                        $inst = "<span style='color:red'>₦ $vbdt in Arrears</span>";
                                                    } else {
                                                        if ($inst <= 0) {
                                                            $inst = "<span style='color:green'>Paid</span>";
                                                        } else if ($inst > 0 && $row["duedate"] < $current_date) {
                                                            $inst = "<span style='color:red'>Not Paid</span>";
                                                        } else {
                                                            $inst = "<span style='color:orange'>Pending</span>";
                                                        }
                                                    }

                                                    ?>
                                                    <td><?php echo $inst; ?></td>
                                                    <td><?php 
                                                        $completedDerived = ($row["principal_amount"] + $row["interest_amount"]) - ($row["principal_completed_derived"] + $row["interest_completed_derived"]);
                                                        echo "₦ " . number_format($completedDerived, 2); ?></td>
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
                                                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a href="" class="dropdown-item" data-toggle="modal" data-target="#exampleModal<?php echo $row["id"]; ?>">Pay Loan</a>
                                                                <!-- <a href="" class="dropdown-item" data-toggle="modal" data-target="#bd-example-modal-lg<?php //echo $row["id"]; 
                                                                                                                                                            ?>">Edit</a> -->
                                                                <input type="text" name="" id="account_no" value="<?php echo $account_no; ?>" hidden>
                                                                <a class="dropdown-item" href="loan_repayment_view.php?id=<?php echo $row["id"]; ?>">Edit Loan Repayment</a>
                                                                <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-lg">Delete</a>
                                                            </div>
                                                            <!-- POP UP BEGINS -->
                                                            <form action="../functions/loans/manual_process.php" method="POST">
                                                                <div class="modal fade" id="exampleModal<?php echo $row["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h3 class="modal-title" id="exampleModalLabel">Reverse Transaction</h3>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <div class="form-group bmd-form-group">
                                                                                    <label for=""> <b style="color:black;"> Account Name </b></label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                        </div>
                                                                                        <input style="color:black;" type="text" class="form-control" value="<?php echo $firstname; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group bmd-form-group">
                                                                                    <label for=""> <b style="color:black;"> Account Number </b></label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                        </div>
                                                                                        <input style="color:black;" name="account_no" type="text" class="form-control" value="<?php echo $account_no; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group bmd-form-group">
                                                                                    <label for=""> <b style="color:black;"> Amount </b></label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                        </div>
                                                                                        <input style="color:black;" name="amount" type="decimal" class="form-control" placeholder="0.00">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group bmd-form-group">
                                                                                    <label for=""> <b style="color:black;"> Expected Repayment Date </b></label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                        </div>
                                                                                        <input style="color:black;" type="date" class="form-control" value="<?php echo $row['duedate']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group bmd-form-group">
                                                                                    <label for=""> <b style="color:black;"> Transaction Date </b></label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                        </div>
                                                                                        <input style="color:black;" name="payment_date" type="date" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group bmd-form-group">
                                                                                    <label for=""> <b style="color:black;"> Payment Type </b></label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                        </div>
                                                                                        <select style="color:black;" name="payment_type" class="form-control">
                                                                                            <option value="Pay Interest Amount">Pay Interest Amount</option>
                                                                                            <option value="Pay Principal Amount">Pay Principal Amount </option>
                                                                                            <option value="Pay Principal and Interest Amount">Pay Principal and Interest Amount</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="text" name="out_id" id="" value="<?php echo $row["id"]; ?>" hidden readonly>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-primary">Pay</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <!-- POP UP ENDS -->
                                                            <!-- /ends here -->
                                                        </div>
                                                    </td>
                                                </tr>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#l_check_<?php echo $row["id"] ?>').on("click", function() {
                                                            var id = $(this).data("loan-id");
                                                            var account = $("#account_no").val();
                                                            $.ajax({
                                                                url: "ajax_post/loan/loan_rec_check.php",
                                                                method: "POST",
                                                                data: {
                                                                    id: id,
                                                                    account: account
                                                                },
                                                                success: function(data) {
                                                                    $('#done_loan').html(data);
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
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