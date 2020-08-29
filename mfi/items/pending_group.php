
                  
                   <div class="table-responsive">
                   <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && (branch_id ='$br_id' $branches) && status = 'Pending'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Group
                        </th>
                        <th>
                          Branch
                        </th>
                        <th width="20px">Edit</th>
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