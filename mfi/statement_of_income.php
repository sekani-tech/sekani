<?php

$page_title = "STATEMENT OF INCOME";
$destination = "client.php";
include('header.php');

?>

<!-- Content added here -->
<!-- print content -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Statement of Income</h4>
                </div>
                <div class="card-body">
                <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">Head Office</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Hide Zero Balances</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="input" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
              </div>
              <!-- <div class="card">
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="">Initial Year</label>
                        <select name="" id="" class="form-control">
                          <option value="">2018</option>
                          <option value="">2019</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Comparing Year</label>
                        <select name="" id="" class="form-control">
                          <option value="">2018</option>
                          <option value="">2019</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
              </div> -->
              <script>
                    $(document).ready(function () {
                      $('#input').on("click", function () {
                        var cid = $(this).val();
                        var intid = $('#intt').val();
                        $.ajax({
                          url: "ajax_post/reports_post/stmt_of_income.php", 
                          method: "POST",
                          data:{cid:cid, intid:intid},
                          success: function (data) {
                            $('#outjournal').html(data);
                          }
                        })
                      });
                    });
                  </script>
              <div id="outjournal" class="card">

              </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>