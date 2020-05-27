<?php
include("../../../functions/connect.php");
$output = '';
session_start();
if(isset($_POST["id2"]))
{
    if($_POST["id2"] !='')
    {
        $main_p = $_SESSION["product_temp"];
        $sint_id = $_POST["int_id"];
?>
<?php
     function fill_pen2($connection, $sint_id)
     {
     $org = "SELECT acc_gl_account.gl_code, acc_gl_account.name FROM acc_gl_account LEFT JOIN prod_acct_cache ON prod_acct_cache.gl_code = acc_gl_account.gl_code WHERE prod_acct_cache.gl_code IS NULL && acc_gl_account.int_id = '$sint_id' && acc_gl_account.name LIKE '%penalty%' ORDER BY name ASC";
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
            document.getElementById("run_pay5").setAttribute("hidden", "");
            document.getElementById("run_pay6").removeAttribute("hidden");
     $('#run_pay6').bind('click', function(){
      $(this).unbind('click');
                          var id2 = $('#meez3').val();
                          var int_id = $('#int_id').val();
                          var main_p = $('#main_p').val();
                          var idx2 = $('#payment_id_x3').val();
            if (idx2 != '' && id2 !=  '') {
                $.ajax({
                 url: "ajax_post/payment_pen.php",
                 method: "POST",
                 data:{id2:id2, int_id:int_id, main_p:main_p, idx2:idx2},
                 success: function (data) {
                   $('#show_payment3').html(data);
                   document.getElementById("ipayment_id3").setAttribute("hidden", "");
                   document.getElementById("real_payment3").removeAttribute("hidden");
                 }
               })
               }
            });
         });
    </script>
     <select name="pay2" class="form-control" id="meez3">
     <?php echo fill_pen2($connection, $sint_id); ?>
     </select>
<?php
    }
}
?>