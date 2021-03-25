<form action="">

  <div class="form-group">
    <label for="">Campaign Name</label>
    <input type="text" name="" id="" class="form-control">
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label class="bmd-label-floating">Gender Group</label><br />
        <select name="gender" class="form-control" id="gender">
          <option value="">select an option</option>
        </select>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label class="bmd-label-floating">Religion Group</label><br />
        <select name="religion" class="form-control" id="religion">
          <option value="">select an option</option>
        </select>
      </div>

    </div>

  </div>


  <div class="form-group">
    <label for="">Email Subject</label>
    <input type="text" name="" id="subject" class="form-control">
  </div>
  <div class="form-group">
    <label for="textArea">Email Body</label>
    <textarea></textarea>
  </div>




  <!-- button to preview email -->
  <button type="button" id="preview" class="btn btn-primary">Preview</button>
</form>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="message">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    $("#preview").click(function () {

      $('#exampleModalLabel').text($('#subject').val())
      console.log($('#subject').val(), $('#exampleModalLabel').val())
      $('#exampleModal').modal('show')
    });
  })
</script>
<script>
  tinymce.init({
    selector: '#textArea'
  });
</script>