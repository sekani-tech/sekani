<?php

$page_title = "Rent Repayment";
$destination = "";
include("header.php");
// include("repay.php");

// include("../functions/connect.php");
$output = '';
?>
<?php
if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Rent Repayment succesfully added",
          text: "Rent Repayment succesfully added",
          showConfirmButton: false,
          timer: 60000
      })
  });
  </script>
  ';
    }
?>


<div class="content"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Rent Repayment</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">


                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalLong">
                                    Add
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Rent Repayment Form </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

<
                                            <div class="modal-body">
                                        
                                                <div class="row">
                                                    <div class="col-md-6">
                                             
                                                        <div class="form-group">
                                                        <form action="rentrepayment.php" method="POST">
                                                            <label>Select Year<span style="color: red;">*</span>:</label>
                                                            <select class="form-control" name="startyear">
                                                                <?php
                                                                for ($year = (int)date('Y'); 1900 <= $year; $year--) : ?>
                                                                    <option value="<?= $year; ?>"><?= $year; ?></option>
                                                                <?php endfor; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                              
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shortSharesName">Amount <span style="color: red;">*</span></label>
                                                            <input type="number" class="form-control" name="amount" value="" placeholder="Enter Amount..." required="">
                                                        </div>
                                                    </div>
                                                    
                                     <script>
                                            $(document).ready(function () {
                                                $('#code').on("change keyup paste", function () {
                                                    var id = $(this).val();
                                                    var ist = $('#int_id').val();
                                                    $.ajax({
                                                        url: "ajax_post/repayment/repay.php",
                                                        method: "POST",
                                                        data: {id: id, ist: ist},
                                                        success: function (data) {
                                                            $('#rent').html(data);
                                                        }
                                                    })
                                                });
                                            });
                                        </script>
                                                    <div class="col-md-6">
                                                        <div id="rent"></div>
                                                        <div class="form-group">
                                                            <label for="shortSharesName">GL code<span style="color: red;">*</span></label>
                                                  
                                                            <input type="number" class="form-control" name="glcode" id="code" value="" id="int_id"  placeholder="Enter GL Code..." required="">
                                                            <input type="text" class="form-control" hidden name=""
                                                   value="<?php echo $sessint_id; ?>" id="int_id">
                                                        </div>
                                                    </div>
                                                    <script>
                                            $(document).ready(function () {
                                                $('#code2').on("change keyup paste", function () {
                                                    var id = $(this).val();
                                                    var ist = $('#int_id2').val();
                                                    $.ajax({
                                                        url: "ajax_post/repayment/exp_gl.php",
                                                        method: "POST",
                                                        data: {id: id, ist: ist},
                                                        success: function (data) {
                                                            $('#expense').html(data);
                                                        }
                                                    })
                                                });
                                            });
                                        </script>
                                                    <div class="col-md-6">
                                                    <div id="expense"></div>
                                                        <div class="form-group">
                                                            <label for="shortSharesName">Expense GL Code <span style="color: red;">*</span></label>
                                                            <input type="number" class="form-control" name="expenseglcode" id="code2" value="" placeholder="Enter Expense GL Code..." required="">
                                                            <input type="text" class="form-control" hidden name=""
                                                   value="<?php echo $sessint_id; ?>" id="int_id2">
                                                         
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <input type="submit" name="submit" class="btn btn-primary">
                                                </form>
                                            </div>
 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php echo $output ?>
                        <div class="row">
                            <div class="col-md-4 ml-auto mr-auto">
                                <div class="card card-pricing bg-info">
                                    <div class="card-body ">
                                        <h3 class="card-title">2020</h3>
                                        <p class="card-description">

                                        </p>
                                        <a href="rent_repayment_view.php" class="btn btn-white btn-round">View</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 ml-auto mr-auto">
                                <div class="card card-pricing bg-info">
                                    <div class="card-body ">
                                        <h3 class="card-title">2021</h3>
                                        <p class="card-description">

                                        </p>
                                        <a href="rent_repayment_view.php" class="btn btn-white btn-round">View</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 ml-auto mr-auto">
                                <div class="card card-pricing bg-info">
                                    <div class="card-body ">
                                        <h3 class="card-title">2022</h3>
                                        <p class="card-description">

                                        </p>
                                        <a href="rent_repayment_view.php" class="btn btn-white btn-round">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include("footer.php");
?>