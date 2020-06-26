<!-- create new item -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h4 class="modal-title" id="myModalLabel">Create Item</h4>
      </div>
      <div class="modal-body" style="text-align:center;">
         <form action="" method="post">
           <div class="row form-group">
              <div class="col-md-4">
                   <label for="">Name</label>
                   <input type="text" name="" class="form-control" id="" required>
               </div>
               <div class="col-md-4">
                   <label for="">Start Date</label>
                   <input type="date" name="" class="form-control" id="" required>
               </div>
               <div class="col-md-4">
                   <label for="">End Date</label>
                   <input type="date" name="" id="" class="form-control" required>
               </div>
               <div class="col-md-4">
                   <label for="">Interest Rate</label>
                   <input type="number" name="" class="form-control" id="">
               </div>
               <div class="col-md-4">
                   <label for="">Description</label>
                   <textarea name="" id="" class="form-control" cols="30" rows="10"></textarea>
               </div>
           </div>
           <button type="reset" class="btn btn-danger">Reset</button>
           <button type="submit" class="btn btn-success">Add</button>
         </form>
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
       </div>
     </div>
     <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- /.modal -->