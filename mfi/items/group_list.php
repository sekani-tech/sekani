<script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <?php
                  $sessint_id = $_SESSION['int_id'];
                  ?>
                   <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Group
                        </th>
                        <th>
                          Branch
                        </th>
                        <th width="20px">Edit</th>
                        <th width="20px">Close</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["g_name"]; ?></th>
                          <?php
                          $ds= $row["branch_id"];
                           $query = "SELECT * FROM branch WHERE int_id = '$sessint_id' && id = '$ds'";
                           $erre = mysqli_query($connection, $query);
                           $ds = mysqli_fetch_array($erre);
                           $dfd = $ds['name'];
                          ?>
                          <th><?php echo $dfd; ?></th>
                          <td><a href="update_group.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                          <td><a href="../functions/updategroup.php?close=<?php echo $row["id"];?>" class="btn btn-info">Close</a></td>
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