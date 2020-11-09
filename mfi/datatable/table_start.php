<div class="row" style="margin-bottom: 20px;">
                   <div class="col-md-6">
                   <!-- display button -->
<script>
 $(document).ready(function() {
    $('#get_f').on("change", function(){
        var counter = $(this).val();
        $.ajax({
           url:"datatable/table_count.php",
           method:"POST",
           data:{counter:counter},
           success:function(data){
             $('#display_count').html(data);
           }
      });
    });
 });
</script>
                   <div class="col-md-3">
                   <div class="form-group">
    <select class="form-control" id="get_f">
      <option value="25">Display: 25</option>
      <option value="50">Display: 50</option>
      <option value="100">Display: 100</option>
      <option value="250">Display: 250</option>
    </select>
  </div>
                   </div>
                   <!-- one page -->
                   </div>
                   <div class="col-md-6">
                   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">
        <i class="fa fa-group"></i>
      </span>
    </div>
    <input type="search" id="general_search" class="form-control" placeholder="Search - Name and Account No.">
  </div>
                   </div>
                   </div>