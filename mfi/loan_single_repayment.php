<?php
    $page_title = "Loan Single Repayment";
    $destination = "configuration.php";
    include("header.php");
?>
<!-- Frontend Begin -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_prin = $_POST["principal"];
    $update_int = $_POST["interest"];
    $rep_id = $_POST["rep_id"];
    $update_rep = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET principal_amount = '$update_prin', interest_amount = '$update_int' WHERE id = '$rep_id' AND int_id = '$sessint_id'");
    
    $get_loan_id = mysqli_query($connection, "SELECT loan_id FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND id = '$rep_id'");
    $loan_id = mysqli_fetch_array($get_loan_id)['loan_id'];

    if ($update_rep) {
      $_SESSION['repayment_updated'] = 1;
      header('Location: loan_report_view.php?edit='. $loan_id);
    } else {
      $_SESSION['repayment_not_updated'] = 1;
      header('Location: loan_report_view.php?edit='. $loan_id);
    }
}

if (isset($_GET["id"]) AND $_GET["id"] != "") {
  // move
  $rep_id = $_GET["id"];
  $query_rep = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND id = '$rep_id'");
  if (mysqli_num_rows($query_rep) > 0){
    $row = mysqli_fetch_array($query_rep);
?>
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Single Loan Repayment</h4>
                  <!-- <p class="card-category">Modify user profile</p> -->
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Transaction Id</label>
                          <input type="text" value="<?php 
                          $harsh = $_GET["id"];
                          $display_hash = hash('fnv1a64', $harsh);
                          echo $display_hash;
                           ?>" class="form-control" readonly>
                           <input type="text" hidden value="<?php echo $rep_id; ?>" name="rep_id" id="">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Disbursement Date</label>
                          <input type="text" class="form-control" value="<?php echo $row["fromdate"]; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Due Date</label>
                          <input type="text" class="form-control" value="<?php echo $row["duedate"] ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Principal Amount</label>
                          <input type="decimal" name="principal" value="<?php echo $row["principal_amount"] ?>" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Interest Amount</label>
                          <input type="decimal" name="interest" value="<?php echo $row["interest_amount"] ?>" class="form-control">
                        </div>
                      </div>
                    </div>
                     
                   
                    <button type="submit" class="btn btn-primary pull-left">Update Repayment</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                <?php
                $client_id = $row["client_id"];
                $query_client = mysqli_query($connection, "SELECT * FROM client WHERE id ='$client_id' AND int_id = '$sessint_id'");
                $cm = mysqli_fetch_array($query_client);
                $firstname = strtoupper($cm["firstname"]." ".$cm["lastname"]);
                $loan_id = $row["loan_id"];
                $query_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE int_id = '$sessint_id' AND id = '$loan_id'");
                $x = mysqli_fetch_array($query_loan);
                $account_no = $x["account_no"];
                $outstanding = number_format($x["total_outstanding_derived"], 2);
                ?>
                  <h6 class="card-category text-gray"><?php echo $firstname; ?></h6>
                  <h4 class="card-title">Account Number: <?php echo $account_no; ?> </h4>
                  <p class="card-description">
                    Loan Balance: <?php echo "NGN ".$outstanding; ?>
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
            </div>
          </div>
          <!-- /content -->
        </div>
      </div>
      <?php
      } else {
        // run script
        echo '<script type="text/javascript">
        $(document).ready(function(){
         swal({
          type: "error",
          title: "Sorry Repayment is Empty",
          text: "Check the Repayment Table",
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
} else {
    // run script
    echo '<script type="text/javascript">
    $(document).ready(function(){
     swal({
      type: "error",
      title: "Sorry No User Repayment Found",
      text: "Check the Repayment Table",
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
<!-- Frontend End -->
<?php 
include("footer.php");
?>