<?php
include("../../functions/connect.php");
session_start();
$output = '';

if(isset($_POST["id2"]))
{
    if($_POST["id2"] !='')
    {
      $sql1 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '".$_POST["id2"]."' && int_id = '".$_POST["int_id"]."'";
      $sql2 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '".$_POST["idx2"]."' && int_id = '".$_POST["int_id"]."'";
      $xs = '';
      $chg = '';
        $result = mysqli_query($connection, $sql1);
        $result2x = mysqli_query($connection, $sql2);
        $o = mysqli_fetch_array($result);
        $ox = mysqli_fetch_array($result2x);
        $int_id = $_POST["int_id"];
        $gl_code = $_POST["id2"];
        $gl_acct = $_POST["idx2"];
        $gl_name = $o["name"];
        $gl_name2 = $ox["name"];
        $id_trans = $_SESSION["product_temp"];
        $inload = mysqli_query($connection, "INSERT INTO `prod_acct_cache` (`gl_code`, `name`, `acct_gl_code`, `acct`, `prod_cache_id`, `type`) VALUES ('{$gl_code}', '{$gl_name}', '{$gl_acct}', '{$gl_name2}', '{$id_trans}', 'pen')");
    }
    // else
    // {
    //     $sql = "SELECT * FROM prod_acct_cache WHERE int_id = '$int_id' && prod_cache_id = '$id_trans'";
    // }
    $sqlx2 = "SELECT * FROM prod_acct_cache WHERE prod_cache_id = '$id_trans' && prod_acct_cache.type ='pen'";
    $rmes2 = mysqli_query($connection, $sqlx2);
    ?>
    <input type="text" id="idq3" value="<?php echo $gl_code; ?>" hidden>
    <input type="text" id="idqx3" value="<?php echo $gl_acct; ?>" hidden>
    <input type="text" id="int_idq3" value="<?php echo $int_id; ?>" hidden>
    <input type="text" id="main_pq3" value="<?php echo $id_trans; ?>" hidden>
    <script>
  $(document).ready(function() {
    // lock the table
    document.getElementById("acct_3").setAttribute("hidden", "");
    // making
        var id2 = $('#idq3').val();
        var idx2 = $('#idqx3').val();
        var int_id = $('#int_idq3').val();
        var main_p = $('#main_pq3').val();
      $.ajax({
        url:"ajax_post/sub_ajax/check_pen.php",
        method:"POST",
        data:{id2:id2, idx2:idx2, int_id:int_id, main_p: main_p},
        success:function(data) {
        $('#real_payment3').html(data);
      }
   });
});
</script>
<div class="table-responsive">
<table id="tabledat" class="table" cellspacing="0" style="width:100%">
         <thead>
           <th> <b> Fee </b></th>
           <th> <b>Income Account <b></th>
         </thead>
  <tbody>
    <?php if (mysqli_num_rows($rmes2) > 0) {
      while($roz2 = mysqli_fetch_array($rmes2, MYSQLI_ASSOC)) {?> 
      <tr>
        <th> <?php echo $roz2["name"] ?></th>
        <th><?php echo $roz2["acct"] ?></th>
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
