<?php
include("../../functions/connect.php");
$output = '';
session_start();

if(isset($_POST["id"]))
{
    $sessint_id = $_SESSION["int_id"];
    $branch_id = $_SESSION["branch_id"];
    $gid = $_POST["id"];

    $query = "DELETE FROM `group_clients` WHERE id = '{$gid}')";
     $queryexec = mysqli_query($connection, $query);
}
?>
                    <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM group_clients WHERE group_id = '$gid' AND int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                         Members
                        </th>
                        <th>
                          Branch
                        </th>
                        <th width="20px">Delete</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["client_name"]; ?></th>
                          <?php
                          $ds= $row["branch_id"];
                           $query = "SELECT * FROM branch WHERE int_id = '$sessint_id' && id = '$ds'";
                           $erre = mysqli_query($connection, $query);
                           $ds = mysqli_fetch_array($erre);
                           $dfd = $ds['name'];
                          ?>
                          <th><?php echo $dfd; ?></th>
                          <td><a href="delete_group_client.php?edit=<?php echo $row["id"];?>" class="btn btn-danger">Delete</a></td>
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