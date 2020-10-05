<?php

$page_title = "Loans";
$destination = "index.php";
    include("header.php");

?>
<?php
//  Sweet alert Function

// If it is successfull, It will show this message
  if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Success",
            text: "Amount Less then the Expected amount",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = null;
}
// If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Error",
          text: "Error during Registration",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = null;
}?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Loans</h4>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT client.id, principal_amount_proposed, client.display_name, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='$sessint_id' && client.loan_status = 'Active'";
                  //  this query, Na fight?
                   $resultx = mysqli_query($connection, $query);
                   if ($resultx) {
                     $inr = mysqli_num_rows($resultx);
                     echo $inr;
                   }?> Active loans || <a href="lend.php">Lend Client</a></p>
                </div>
                <div class="card-body">
                <script>
                  $(document).ready(function() {
                  $('#tabledat3').DataTable();
                  });
                  </script>
                  <div class="table-responsive">
                    <table id="tabledat3" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                        <!-- <th>
                          ID
                        </th> -->
                        <?php
                        $query = "SELECT client.id, principal_amount, client.display_name, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='$sessint_id' && client.loan_status = 'Active'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>Name</th>
                        <th>
                          Principal
                        </th>
                        <th>
                          Interest Value
                        </th>
                        <th>
                          Collect Loan
                        </th>
                        <th></th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["display_name"]; ?></th>
                          <th><?php echo $row["principal_amount"]; ?></th>
                          <th><?php echo $row["interest_rate"]; ?></th>
                          <td><a href="loan_collection.php?loancoll=<?php echo $row["id"];?>" class="btn btn-info">Collect</a></td>
                          <td><a href="loan_summary.php?loancoll=<?php echo $row["id"];?>" class="btn btn-success">View</a></td>
                          </tr>
                          <?php }
                          }
                          else {
                            // echo "0 Document";
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

<?php

    include("footer.php");

?>