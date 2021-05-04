<?php

$page_title = "Rent Repayment";
$destination = "";
include("header.php");

$exp_error = "";
$message = $_SESSION['feedback'];
?>
<input type="text" value="<?php echo $message?>" id="feedback" hidden>
<?php

// feedback messages 0 for success and 1 for errors

if (isset($_GET["message0"])) {
    $key = $_GET["message0"];
    $tt = 0;
  
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
      echo '<script type="text/javascript">
      $(document).ready(function(){
        let feedback =  document.getElementById("feedback").value;
          swal({
              type: "success",
              title: "Success",
              text: feedback,
              showConfirmButton: true,
              timer: 7000
          })
      });
      </script>
      ';
      $_SESSION["lack_of_intfund_$key"] = 0;
    }
  } else if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
      echo '<script type="text/javascript">
      $(document).ready(function(){
        let feedback =  document.getElementById("feedback").value;
          swal({
              type: "error",
              title: "Error",
              text: feedback,
              showConfirmButton: true,
              timer: 7000
          })
      });
      </script>
      ';
      $_SESSION["lack_of_intfund_$key"] = 0;
    }
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
                                <form action="../functions/administrative/rent_prepayment.php" method="post" autocomplete="off">
                                    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Rent Repayment Form </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Date<span style="color: red;">*</span>:</label>
                                                                <input type="date" min="<?php echo $minDate; ?>" max="<?php echo $today; ?>" name="transDate" class="form-control" required />
                                                                <!-- <select class="form-control" name="startyear">
                                                                    <?php
                                                                    // for ($year = (int)date('Y'); 1900 <= $year; $year--) : 
                                                                    ?>
                                                                        <option value="<?php //$year; 
                                                                                        ?>"><?php //$year; 
                                                                                            ?></option>
                                                                    <?php //endfor; 
                                                                    ?>
                                                                </select> -->
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="shortSharesName">Amount <span style="color: red;">*</span></label>
                                                                <input type="text" name="amount" id="amount1" value="" class="form-control" required>
                                                                <span class="help-block" style="color: red;"><?php echo $exp_error; ?></span>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#amount1').on("change blur", function() {
                                                                    var amount = $(this).val();
                                                                    $.ajax({
                                                                        url: "ajax_post/function/converter.php",
                                                                        method: "POST",
                                                                        data: {
                                                                            amount: amount
                                                                        },
                                                                        success: function(data) {
                                                                            $('#amount1').val(data);
                                                                        }
                                                                    })
                                                                });
                                                            });
                                                        </script>
                                                        <div class="col-md-6">
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#gl_income').on("change keyup paste", function() {
                                                                        var id = $(this).val();
                                                                        var ist = $('#int_id').val();
                                                                        $.ajax({
                                                                            url: "ajax_post/gl/find_income_gl.php",
                                                                            method: "POST",
                                                                            data: {
                                                                                id: id,
                                                                                ist: ist
                                                                            },
                                                                            success: function(data) {
                                                                                $('#income').html(data);
                                                                            }
                                                                        })
                                                                    });
                                                                });
                                                            </script>
                                                            <div class="form-group">
                                                                <label for="shortSharesName">Prepayment Journal<span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" name="prepay_gl" id="gl_income" required>
                                                                <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                                            </div>
                                                            <div id="income"></div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#gl_expense').on("change keyup paste", function() {
                                                                        var id = $(this).val();
                                                                        var ist = $('#int_id').val();
                                                                        $.ajax({
                                                                            url: "ajax_post/gl/acct_rep.php",
                                                                            method: "POST",
                                                                            data: {
                                                                                id: id,
                                                                                ist: ist
                                                                            },
                                                                            success: function(data) {
                                                                                $('#expense').html(data);
                                                                            }
                                                                        })
                                                                    });
                                                                });
                                                            </script>

                                                            <div class="form-group">
                                                                <label for="shortSharesName">Expense GL Code <span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" name="expense_gl" id="gl_expense" required>
                                                                <!-- <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id"> -->
                                                            </div>
                                                            <div id="expense"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="shortSharesName">Number of Years <span style="color: red;">*</span></label>
                                                                <input type="number" class="form-control" min="1" name="no_of_years" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
 
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        
                        <div class="row">
                        <?php
                        $yearSearchConditions = [
                            'int_id' => $sessint_id,
                            'branch_id' => $branch_id
                        ];
                        $findPrepayments = selectAllWithOrder('prepayment_account', $yearSearchConditions, "year", "ASC");
                        // $length = ;
                        // $i = 1;
                        foreach($findPrepayments as $keys => $rows){
                            
                        
                        ?>
                            <div class="col-md-4 ml-auto mr-auto">
                                <div class="card card-pricing bg-info">
                                    <div class="card-body ">
                                        <h3 class="card-title"><?php echo $rows['year'] ?></h3>
                                        <p class="card-description">

                                        </p>
                                        <a href="rent_repayment_view.php?view=<?php echo $rows['id'] ?>" class="btn btn-white btn-round">View</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            // $i++;
                            }
                            ?>
                            
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