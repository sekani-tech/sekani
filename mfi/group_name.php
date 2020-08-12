<?php
include("../functions/connect.php");
session_start();
$output = '';
$output2 = '';

if(isset($_POST["id"]))
{
?>
<div class="row">
<div class="col-md-12">
        <p></p>
        <p></p>
        <p></p>
    </div>
    <div class="col-md-6">
    <div class="custom-radio custom-control">
        <input type="radio" id="fetcpostloanoff"  name="fech_post" class="custom-control-input">
        <label class="custom-control-label" for="fetcpostloanoff">Fetch Posting by loan officer</label>
    </div>
    </div>
    <div class="col-md-6">
        <div class="custom-radio custom-control">
            <input type="radio" id="fetcpostgroup" name="fech_post" class="custom-control-input">
            <label class="custom-control-label" for="fetcpostgroup">Fetch posting by group</label>
        </div>
    </div>
    <div class="col-md-12">
        <p></p>
    </div>
    <div class="col-md-4">
            <div class="form-group">
              <?php
                  function fill_group($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM groups WHERE int_id = '$sint_id' ORDER BY g_name ASC";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["g_name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
              <label>Select Group</label>
               <select class="form-control" name="pay_type" id="group">
                  <?php echo fill_group($connection)?>
               </select>
            </div>
        </div>
        <div class="col-md-12">
        <p><h3>Group Posting Setup:</h3></p>
    </div>
    <div class="col-md-4">
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
               <input type="text" name="" class="form-control"/>
            </div>
        </div>
</div>
<script>
    $(document).ready(function() {
    $('#group').on("change keyup paste click", function(){
        var id = $(this).val();
        $.ajax({
        url:"group_paylist.php",
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
?>