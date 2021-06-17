<?php

$page_title = "GL Transactions";
$destination = "transaction.php";
include("header.php");
// include("ajaxcall.php");
$exp_error = "";
$message = $_SESSION['feedback'];
if ($message != "") {
?>
    <input type="text" value="<?php echo $message ?>" id="feedback" hidden>
<?php
}
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

if ($trans_post == 1 || $trans_post == "1") {
?>
    <?php
    $digits = 12;
    $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
    $randms1 = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
    $randms2 = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
    $transid = $randms;
    $transid1 = $randms1;
    $transid2 = $randms2;
    ?>

    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Income and Liabilities</h4>
                            <p class="card-category">Make deductions from clients accounts and fund your Gl (<i>Applies to loan recovery, charges and other similar transactions</i>) </p>
                        </div>
                        <div class="card-body">
                            <form action="../functions/gl_transactions/income_liability_credit.php" method="post" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-4">
                                        <script>
                                            $(document).ready(function() {
                                                $('#act').on("change keyup paste", function() {
                                                    var id = $(this).val();
                                                    var ist = $('#int_id').val();
                                                    $.ajax({
                                                        url: "acct_name.php",
                                                        method: "POST",
                                                        data: {
                                                            id: id,
                                                            ist: ist
                                                        },
                                                        success: function(data) {
                                                            $('#accname').html(data);
                                                        }
                                                    })
                                                });
                                            });
                                        </script>

                                        <div class="form-group">
                                            <label class="bmd-label-floating">Amount</label>
                                            <input type="text" class="form-control" id="amount3" name="amount" value="" required>
                                        </div>

                                        <div id="acct_name"></div>
                                        <script>
                                            $(document).ready(function() {
                                                $('#amount3').on("change blur", function() {
                                                    var amount = $(this).val();
                                                    $.ajax({
                                                        url: "ajax_post/function/converter.php",
                                                        method: "POST",
                                                        data: {
                                                            amount: amount
                                                        },
                                                        success: function(data) {
                                                            $('#amount3').val(data);
                                                        }
                                                    })
                                                });
                                            });
                                        </script>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Account Number</label>
                                            <input type="text" class="form-control" name="account_no" id="act" required>
                                            <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                        </div>
                                        <div id="accname"></div>
                                    </div>

                                    <div class="col-md-4">
                                        <script>
                                            $(document).ready(function() {
                                                $('#gl_account').on("change keyup paste", function() {
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
                                                            $('#accrex').html(data);
                                                        }
                                                    })
                                                });
                                            });
                                        </script>
                                        <div class="form-group">
                                            <label for="">GL Number</label>
                                            <input type="text" class="form-control" name="acct_gl" id="gl_account" required>
                                            <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                        </div>
                                        <div id="accrex"></div>
                                    </div>
                                    <!-- <div id="rd"></div> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Transaction ID:</label>
                                            <input type="text" value="<?php echo "INCOME_" . $transid1; ?>" name="transid" class="form-control" id="transid" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <input type="text" value="" name="description" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Transaction Date</label>
                                            <input type="date" min="<?php echo $minDate; ?>" max="<?php echo $today; ?>" name="transDate" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <script>
                                            $(document).ready(function() {
                                                $('#recovery').on("change", function() {
                                                    var recover = $(this).val();
                                                    $.ajax({
                                                        url: "ajax_post/function/recovery_id.php",
                                                        method: "POST",
                                                        data: {
                                                            recover: recover
                                                        },
                                                        success: function(data) {
                                                            $('#transid').val(data);
                                                        }
                                                    })
                                                });
                                                $('input[type="checkbox"]').click(function() {
                                                    if ($(this).is(":checked")) {
                                                        var value = 1;
                                                        $('#recovery').val(value);
                                                        console.log("Checkbox is checked.");
                                                    } else if ($(this).is(":not(:checked)")) {
                                                        var value = 0;
                                                        $('#recovery').val(value);
                                                        console.log("Checkbox is unchecked.");
                                                    }
                                                });
                                            });
                                        </script>
                                        <!-- <div class="form-group"> -->
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="1" id="recovery">
                                                Mark as Loan Recovery
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <!-- </div> -->
                                        <script>
                                            $(document).ready(function() {
                                                $('#charge').on("change", function() {
                                                    var charge = $(this).val();
                                                    $.ajax({
                                                        url: "ajax_post/function/charge_id.php",
                                                        method: "POST",
                                                        data: {
                                                            charge: charge
                                                        },
                                                        success: function(data) {
                                                            $('#transid').val(data);
                                                        }
                                                    })
                                                });
                                                $('input[type="checkbox"]').click(function() {
                                                    if ($(this).is(":checked")) {
                                                        var value = 1;
                                                        $('#charge').val(value);
                                                        console.log("Checkbox is checked.");
                                                    } else if ($(this).is(":not(:checked)")) {
                                                        var value = 0;
                                                        $('#charge').val(value);
                                                        console.log("Checkbox is unchecked.");
                                                    }
                                                });
                                            });
                                        </script>
                                        <!-- <div class="form-group"> -->
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="1" id="charge">
                                                Mark as Charge
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                    <div class="col-md-6">
                                        
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /income posting ends here -->
                <!-- gl to client -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Expense Income</h4>
                            <p class="card-category">Make deductions from GL accounts and fund a Client (<i>Applies to all expense income scenarios</i>) </p>
                        </div>
                        <div class="card-body">
                            <form action="../functions/gl_transactions/gl_to_client.php" method="post" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-4">
                                        <script>
                                            $(document).ready(function() {
                                                $('#accc').on("change keyup paste", function() {
                                                    var id = $(this).val();
                                                    var ist = $('#int_id').val();
                                                    $.ajax({
                                                        url: "acct_name.php",
                                                        method: "POST",
                                                        data: {
                                                            id: id,
                                                            ist: ist
                                                        },
                                                        success: function(data) {
                                                            $('#acountName').html(data);
                                                        }
                                                    })
                                                });
                                            });
                                        </script>

                                        <div class="form-group">
                                            <label class="bmd-label-floating">Amount</label>
                                            <input type="text" class="form-control" id="amount4" name="amount" value="" required>
                                        </div>

                                        <div id="acct_name"></div>
                                        <script>
                                            $(document).ready(function() {
                                                $('#amount4').on("change blur", function() {
                                                    var amount = $(this).val();
                                                    $.ajax({
                                                        url: "ajax_post/function/converter.php",
                                                        method: "POST",
                                                        data: {
                                                            amount: amount
                                                        },
                                                        success: function(data) {
                                                            $('#amount4').val(data);
                                                        }
                                                    })
                                                });
                                            });
                                        </script>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Account Number</label>
                                            <input type="text" class="form-control" name="account_no" id="accc" required>
                                            <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                        </div>
                                        <div id="acountName"></div>
                                    </div>

                                    <div class="col-md-4">
                                        <script>
                                            $(document).ready(function() {
                                                $('#gl_accounts').on("change keyup paste", function() {
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
                                                            $('#accrexs').html(data);
                                                        }
                                                    })
                                                });
                                            });
                                        </script>
                                        <div class="form-group">
                                            <label for="">GL Number</label>
                                            <input type="text" class="form-control" name="acct_gl" id="gl_accounts" required>
                                            <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                        </div>
                                        <div id="accrexs"></div>
                                    </div>
                                    <!-- <div id="rd"></div> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Transaction ID:</label>
                                            <input type="text" value="<?php echo "INCOME_" . $transid1; ?>" name="transid" class="form-control" id="transid" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <input type="text" value="" name="description" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Transaction Date</label>
                                            <input type="date" min="<?php echo $minDate; ?>" max="<?php echo $today; ?>" name="transDate" class="form-control" required />
                                        </div>
                                    </div>
                                    
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- gl to client ends here -->
                <!-- Income To Liabilities/Expense -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">GL TO GL Posting</h4>
                            <!-- <p class="card-category">Fill in all important data</p> -->
                        </div>
                        <div class="card-body">
                            <form action="../functions/gl_transactions/gl_to_gl.php" method="post" autocomplete="off">
                                <div class="row">
                                    <!-- Pick the income GL you want to post to -->
                                    <div class="col-md-4">
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
                                            <label for="">DEBIT:</label>
                                            <input type="text" class="form-control" name="income_gl" id="gl_income" required>
                                            <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                        </div>
                                        <div id="income"></div>
                                    </div>
                                    <!-- Expense GL comes here -->
                                    <div class="col-md-4">
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
                                            <label for="">CREDIT:</label>
                                            <input type="text" class="form-control" name="expense_gl" id="gl_expense" required>
                                            <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                        </div>
                                        <div id="expense"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Amount:</label>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Transaction ID:</label>
                                            <input type="text" readonly value="<?php echo "GL_TO_GL_" . $transid; ?>" name="transid" class="form-control" id="tit">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Description:</label>
                                            <input type="text" value="" name="description" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Transaction Date</label>
                                            <input type="date" min="<?php echo $minDate; ?>" max="<?php echo $today; ?>" name="transDate" class="form-control" required />
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- / Income To Liabilities/Expense ends here -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Other Incomes</h4>
                            <p class="card-category">Post income which are not part of your Institution primary process</p>
                        </div>
                        <div class="card-body">
                            <form action="../functions/gl_transactions/other_income.php" method="post" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-4">
                                        <script>
                                            $(document).ready(function() {
                                                $('#acct').on("change keyup paste", function() {
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
                                                            $('#accrep').html(data);
                                                        }
                                                    })
                                                });
                                            });
                                        </script>
                                        <div class="form-group">
                                            <label for="">GL Number</label>
                                            <input type="text" class="form-control" name="acct_gl" id="acct">
                                            <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                        </div>
                                        <div id="accrep"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Amount:</label>
                                            <input type="text" name="amount" id="amount" value="" class="form-control">
                                            <span class="help-block" style="color: red;"><?php echo $exp_error; ?></span>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#amount').on("blur change", function() {
                                                var amount = $(this).val();
                                                $.ajax({
                                                    url: "ajax_post/function/converter.php",
                                                    method: "POST",
                                                    data: {
                                                        amount: amount
                                                    },
                                                    success: function(data) {
                                                        $('#amount').val(data);
                                                    }
                                                })
                                            });
                                        });
                                    </script>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Transaction ID:</label>
                                            <input type="text" readonly value="<?php echo "OTHER_INCOME_" . $transid; ?>" name="transid" class="form-control" id="tit">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <input type="text" value="" name="descrip" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Transaction Date</label>
                                            <input type="date" min="<?php echo $minDate; ?>" max="<?php echo $today; ?>" name="transDate" class="form-control" required />
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php
    include("footer.php");
    ?>
<?php
} else {
    echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Transaction Authorization",
    text: "You Dont Have permission to Make Transactions",
   showConfirmButton: false,
    timer: 2000
    }).then(
    function (result) {
      history.go(-1);
    }
    )
    });
   </script>
  ';
    // $URL="transact.php";
    // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

?>