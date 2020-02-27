<?php

    include("header.php");
    // start session
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Institutions</h4>
                  <!-- Insert number of exsisting institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM institutions";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> Registered institutions here</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM institutions";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>
                          Name
                        </th>
                        <th>
                          RCN
                        </th>
                        <th>
                          State
                        </th>
                        <th>
                          Local government
                        </th>
                        <th>P. Contact</th>
                        <th>Phone</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <?php $row["int_id"]; ?>
                          <th><?php echo $row["int_name"]; ?></th>
                          <th><?php echo $row["rcn"]; ?></th>
                          <th><?php echo $row["int_state"]; ?></th>
                          <th><?php echo $row["lga"]; ?></th>
                          <th><?php echo $row["pc_surname"]; ?></th>
                          <th><?php echo $row["pc_phone"]; ?></th>
                          <td><a href="manage_institution.php?edit=<?php echo $row["int_id"];?>" class="btn btn-info">Edit</a></td>
                          <td><a href="functions/delete_institution.php?edit=<?php echo $row["int_id"]; ?>" class="btn btn-danger">Delete</a></td>
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