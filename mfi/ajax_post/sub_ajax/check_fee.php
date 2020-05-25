<?php
include("../../../functions/connect.php");
session_start();
$output = '';

if(isset($_POST["id2"]))
{
    if($_POST["id2"] !='')
    {
        $main_p = $_SESSION["product_temp"];
        $sint_id = $_POST["int_id"];
?>
<?php
     function fill_inc2($connection, $sint_id)
     {
        $getacct = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE name LIKE '%FEE%' && parent_id = '0' && int_id = '$sint_id'");
        $cx = mysqli_fetch_array($getacct);
        $dfb = $cx["id"];
     $org = "SELECT acc_gl_account.gl_code, acc_gl_account.name FROM acc_gl_account LEFT JOIN prod_acct_cache ON prod_acct_cache.gl_code = acc_gl_account.gl_code WHERE prod_acct_cache.gl_code IS NULL && acc_gl_account.int_id = '$sint_id' && classification_enum = '4' && parent_id = '$dfb' ORDER BY name ASC";
     $res = mysqli_query($connection, $org);
     $output = '';
     while ($row = mysqli_fetch_array($res))
     {
       $output .= '<option value="'.$row["gl_code"].'">'.$row["name"].'</option>';
     }
     return $output;
     }
     ?>
     <script>
         $(document).ready(function () {
            document.getElementById("run_pay3").setAttribute("hidden", "");
            document.getElementById("run_pay4").removeAttribute("hidden");
     $('#run_pay4').bind('click', function(){
      $(this).unbind('click');
                          var id2 = $('#meez2').val();
                          var int_id = $('#int_id').val();
                          var main_p = $('#main_p').val();
                          var idx2 = $('#payment_id_x2').val();
            if (idx2 != '' && id2 !=  '') {
                $.ajax({
                 url: "ajax_post/payment_fee.php",
                 method: "POST",
                 data:{id2:id2, int_id:int_id, main_p:main_p, idx2:idx2},
                 success: function (data) {
                   $('#show_payment2').html(data);
                   document.getElementById("ipayment_id2").setAttribute("hidden", "");
                   document.getElementById("real_payment2").removeAttribute("hidden");
                 }
               })
               }
            });
         });
    </script>
     <select name="pay2" class="form-control" id="meez2">
     <?php echo fill_inc2($connection, $sint_id); ?>
     </select>
<?php
    }
}
?>