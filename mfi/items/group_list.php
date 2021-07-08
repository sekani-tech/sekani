<script>
  $(document).ready(function() {
    $('#tabledat').DataTable();
  });
</script>
<?php
$sessint_id = $_SESSION['int_id'];
?>
<div class="table-responsive">
  <table class="rtable display nowrap" style="width:100%">
    <thead class=" text-primary">
      <?php
      $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && (branch_id ='$br_id' $branches) && status = 'Approved'";
      $result = mysqli_query($connection, $query);
      ?>
      <th>
        Group
      </th>
      <th>
        Branch
      </th>
      <th>Account Officer</th>

      <th width="20px">Edit</th>
      <th width="20px">Close</th>
      <!-- <th>Phone</th> -->
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
          <tr>
            <?php $row["id"]; ?>
            <th><?php echo $row["g_name"]; ?></th>
            <?php
            $ds = $row["branch_id"];
            $query = "SELECT * FROM branch WHERE int_id = '$sessint_id' && id = '$ds'";
            $erre = mysqli_query($connection, $query);
            $ds = mysqli_fetch_array($erre);
            $dfd = $ds['name'];
            ?>
            <th><?php echo $dfd; ?></th>
            <th><?php 
              $loanOfficer = $row['loan_officer'];
              // Find loan officers name from staff table
              $query_staff = mysqli_query($connection, "SELECT * FROM `staff` WHERE id = '$loanOfficer' AND int_id = '$sessint_id'");
              if (mysqli_num_rows($query_staff) > 0) {
                  $ms = mysqli_fetch_array($query_staff);
                  $staff_fullname = strtoupper($ms["display_name"]);
              }
              echo $staff_fullname;
            ?></th>
            <td><a href="group_view.php?edit=<?php echo $row["id"]; ?>" class="btn btn-info">View</a></td>
            <td><a href="../functions/updategroup.php?close=<?php echo $row["id"]; ?>" class="btn btn-info">Close</a></td>
          </tr>
      <?php }
      } else {
        // echo "0 Document";
      }
      ?>
    </tbody>
  </table>
</div>