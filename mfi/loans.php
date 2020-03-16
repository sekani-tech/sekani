<?php

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
                  <h4 class="card-title ">Loans</h4>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT client.id, principal_amount_proposed, client.display_name, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='$sessint_id' && client.loan_status = 'Active'";
                   $resultx = mysqli_query($connection, $query);
                   if ($resultx) {
                     $inr = mysqli_num_rows($resultx);
                     echo $inr;
                   }?> Active loans || <a href="lend.php">Lend Client</a></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
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