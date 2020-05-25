<?php
include("../../functions/connect.php");
$output = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
      $sql1 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '".$_POST["id"]."' && int_id = '".$_POST["int_id"]."'";
      $sql2 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '".$_POST["idx"]."' && int_id = '".$_POST["int_id"]."'";
      $xs = '';
      $chg = '';
        $result = mysqli_query($connection, $sql1);
        $result2x = mysqli_query($connection, $sql2);
        $o = mysqli_fetch_array($result);
        $ox = mysqli_fetch_array($result2x);
        $int_id = $_POST["int_id"];
        $gl_code = $_POST["id"];
        $gl_acct = $_POST["idx"];
        $gl_name = $o["name"];
        $gl_name2 = $ox["name"];
        $id_trans = $_POST["main_p"];
        $inload = mysqli_query($connection, "INSERT INTO `prod_acct_cache` (`gl_code`, `name`, `acct_gl_code`, `acct`, `prod_cache_id`, `type`) VALUES ('{$gl_code}', '{$gl_name}', '{$gl_acct}', '{$gl_name2}', '{$id_trans}', 'pay')");
       
        // $sql = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
    }
    else
    {
        $sql = "SELECT * FROM prod_acct_cache WHERE int_id = '$int_id' && prod_cache_id = '$id_trans'";
    }
    $sqlx = "SELECT * FROM prod_acct_cache WHERE prod_cache_id = '$id_trans' && type ='pay'";
    $rmes = mysqli_query($connection, $sqlx);
    ?>
    <input type="text" id="idq" value="<?php echo $gl_code; ?>" hidden>
    <input type="text" id="idqx" value="<?php echo $gl_acct; ?>" hidden>
    <input type="text" id="int_idq" value="<?php echo $int_id; ?>" hidden>
    <input type="text" id="main_pq" value="<?php echo $id_trans; ?>" hidden>
    <script>
  $(document).ready(function() {
    // lock the table
    document.getElementById("acct_int").setAttribute("hidden", "");
    // making
        var id = $('#idq').val();
        var idx = $('#idqx').val();
        var int_id = $('#int_idq').val();
        var main_p = $('#main_pq').val();
      $.ajax({
        url:"ajax_post/sub_ajax/check_pay.php",
        method:"POST",
        data:{id:id, idx:idx, int_id:int_id, main_p: main_p},
        success:function(data) {
        $('#real_payment').html(data);
      }
   });
});
</script>
<div class="table-responsive">
<table id="tabledat" class="table" cellspacing="0" style="width:100%">
         <thead>
           <th> <b> Payment Type </b></th>
           <th> <b>Assets Account <b></th>
         </thead>
  <tbody>
    <?php if (mysqli_num_rows($rmes) > 0) {
      while($roz = mysqli_fetch_array($rmes, MYSQLI_ASSOC)) {?> 
      <tr>
        <th> <?php echo $roz["name"] ?></th>
        <th><?php echo $roz["acct"] ?></th>
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
