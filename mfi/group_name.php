<?php
include("../functions/connect.php");
session_start();
$output = '';
$output2 = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] == "payment"){
        $fkd = $_POST["id"];
        echo  $fkd.' was selected';
    }
    else if($_POST["id"] == "withdrawal"){
        $fkd = $_POST["id"];
        echo $fkd.' was selected';
    }
    
?>
<div class="row">
<div class="col-md-12">
        <p></p>
        <p></p>
        <p></p>
    </div>
   
    <div class="col-md-12">
        <p></p>
    </div>
            <div class="form-group">
            <div class="form-group">
              <?php
                  function fill_payment($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM payment_type WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["value"].'</option>';
                  }
                  return $out;
                  }
                  ?>
              <label>Payment Method</label>
               <select class="form-control" name="pay_type" id="opo">
                  <?php echo fill_payment($connection)?>
               </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <label>Repayment Date</label>
               <input type="date" name="" class="form-control"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <label>Total Payment Amount</label>
               <input type="number" name="" class="form-control"/>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
              <label>description</label>
               <input type="text" name="description" class="form-control"/>
            </div>
        </div>
</div>
<script>
    $(document).ready(function() {
    $('#group').on("change keyup paste", function(){
        var id = $(this).val();
        $.ajax({
        url:"ajax_post/group_paylist.php",
        method:"POST",
        data:{id:id},
        success:function(data){
        $('#grlist').html(data);
        }
        })
    });
    });
</script>
<?php
}
else if(isset($_POST["perf"])){
    echo 'withdrawal was selected';
}
?>