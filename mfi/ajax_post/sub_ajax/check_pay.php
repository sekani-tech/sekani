<?php
include("../../../functions/connect.php");
$output = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $main_p = $_POST["main_p"];
        $sint_id = $_POST["int_id"];
?>
<?php
     function fill_paym($connection, $sint_id)
     {
        $getacct = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE name LIKE '%due from bank%' && int_id = '$sint_id'");
        $cx = mysqli_fetch_array($getacct);
        $dfb = $cx["id"];
     $org = "SELECT acc_gl_account.gl_code, acc_gl_account.name FROM acc_gl_account LEFT JOIN prod_acct_cache ON prod_acct_cache.gl_code = acc_gl_account.gl_code WHERE prod_acct_cache.gl_code IS NULL && acc_gl_account.int_id = '$sint_id' && classification_enum = '1' && parent_id = '$dfb' ORDER BY name ASC";
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
            document.getElementById("run_pay").setAttribute("hidden", "");
            document.getElementById("run_pay2").removeAttribute("hidden");
     $('#run_pay2').bind('click', function(){
      $(this).unbind('click');
                          var id = $('#meez').val();
                          var int_id = $('#int_id').val();
                          var main_p = $('#main_p').val();
                          var idx = $('#payment_id_x').val();
            if (idx != '' && id !=  '') {
                $.ajax({
                 url: "ajax_post/payment_product.php",
                 method: "POST",
                 data:{id:id, int_id:int_id, main_p:main_p, idx:idx},
                 success: function (data) {
                   $('#show_payment').html(data);
                   document.getElementById("ipayment_id").setAttribute("hidden", "");
                   document.getElementById("real_payment").removeAttribute("hidden");
                 }
               })
               } else {
                //  poor the internet
                alert('SELECT SOMETHING');
               }
            });
         });
    </script>
     <select name="pay2" class="form-control" id="meez">
     <option value="">select an option</option>
     <?php echo fill_paym($connection, $sint_id); ?>
     </select>
<?php
    }
}
?>