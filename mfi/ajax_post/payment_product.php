<?php
include("../../functions/connect.php");
$output = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
      
      $sql1 = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
      $xs = '';
      $chg = '';
        $result = mysqli_query($connection, $sql1);
        $o = mysqli_fetch_array($result);
        $int_id = $_POST["int_id"];
        $inload = mysqli_query($connection, "");
        $sql = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
    }
    else
    {
        $sql = "SELECT * FROM charges_cache WHERE int_id = '$int_id' && cache_prod_id = '$main_p' ";
    }
    $sql = "SELECT * FROM charges_cache WHERE int_id = '$int_id' && cache_prod_id = '$main_p' ";
    $result = mysqli_query($connection, $sql);
    ?>
    <input type="text" id="idq" value="<?php echo $charge_id; ?>" hidden>
    <input type="text" id="int_idq" value="<?php echo $int_id; ?>" hidden>
    <input type="text" id="main_pq" value="<?php echo $main_p; ?>" hidden>
    <script>
  $(document).ready(function() {
        var id = $('#idq').val();
        var int_id = $('#int_idq').val();
          var branch_id = $('#branch_idq').val();
          var main_p = $('#main_pq').val();
          $.ajax({
          url:"ajax_post/check_up.php",
          method:"POST",
          data:{id:id, int_id:int_id, branch_id:branch_id, main_p: main_p},
          success:function(data){
          $('#damn_men').html(data);
       }
   })
})
</script>

    <div class="table-responsive">
  <table id="tabledat" class="table" cellspacing="0" style="width:100%">
  <thead class=" text-primary">
    <th>Name</th>
    <th>Charge</th>
    <th>Collected On</th>
  </thead>
  <tbody>
    <?php if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?> 
      <tr>
        <th> <?php echo $row["name"] ?></th>
        <th><?php echo $row["charge"] ?></th>
        <th> <?php echo $row["collected_on"] ?></th>
      </tr>
      <?php
      }
    } else {
      // echo something
    }?>
  </tbody>
</table>
</div>
  <?php
    echo $output;
}
?>
<!-- posting now -->
