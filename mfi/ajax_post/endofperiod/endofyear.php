<?php
include '../../../functions/connect.php';
session_start();
if (!empty($_POST['start']) && !empty($_POST['end'])) {

    $start = $_POST['start'];
    $end = $_POST['end'];
    $branch_id = $_SESSION['branch_id'];

    if (isset($_POST['status']) && isset($_POST['id'])) {
        $status = $_POST['status'];
        $id = $_POST['id'];
        $query = mysqli_query($connection, "UPDATE endofyear_tb SET status=$status WHERE id=$id" );
    }
    
    ?>
<table id="endofyear" class="table table-striped table-bordered" style="width:100%">
<thead class="">
<?php
  $result = mysqli_query($connection, 'SELECT * FROM endofyear_tb'); 
?>
  <th> ID</th>
  <th>DATE CLOSED</th>
  <th>CLOSED BY</th>
  <th>YEAR CLOSED</th>
  <th>ACTION</th>
</thead>
<tbody>
<?php
while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
   <?php $row["id"]; 
  $idd = $row["id"];?>
   <input type="hidden" id="toggleID" value="<?php echo $row[ 'id']; ?>">
    <th><?php echo $row['id'];?></th>
     <th><?php echo $row['dateclosed']; ?></th> 
    <th> <?php echo $row['closed_by']; ?></th>
    <th> <?php echo $row['yearend']; ?></th>
    <th><input type="checkbox" id="status" checked data-toggle="toggle" data-on="Open" data-off="Closed" data-onstyle="success" data-offstyle="danger">
    <input type="text" hidden id="id_store"></th>
    <?php
      ?>
  </tr>
  <?php
   }
    ?>
</tbody>
</table>
 <div class="form-group mt-4">
              <form method="POST" action="../composer/endofyear.php">
                <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                <input hidden name="end" type="text" value="<?php echo $end; ?>" />
            <input hidden name="branch_id" type="text" value="<?php echo $branch_id; ?>" />
        <button type="submit" name="downloadPDF" class="btn btn-primary">DOWNLOAD PDF</button>
     </form>
    </div>  
<script>
$('#endofyear').DataTable(); 
</script>
<?php  }?> 