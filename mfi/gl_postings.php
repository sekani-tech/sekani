<?php

$page_title = "GL Transactions";
$destination = "transaction.php";
include("header.php");
include("ajaxcall.php");
?>
<?php
$exp_error = "";
if (isset($_GET["message"])) {
    $key = $_GET["message"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Transaction Successful",
            showConfirmButton: True,
            timer: 7000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Transaction Successful - Error storing record for expense GL! Contact Support",
          showConfirmButton: true,
          timer: 7000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message2"])) {
    $key = $_GET["message2"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error",
            text: "Transaction Successful - Error storing record for Income GL! Contact Support",
            showConfirmButton: True,
            timer: 7000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message3"])) {
    $key = $_GET["messag3"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "Error",
          title: "Expense Error",
          text: "Insufficient Fund in chossen Income GL",
          showConfirmButton: true,
          timer: 7000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message4"])) {
    $key = $_GET["message4"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "NOT AUTHURIZED",
          text: "Kindly provide all Neccessary Information",
          showConfirmButton: true,
          timer: 7000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message3p"])) {
    $key = $_GET["message3p"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Withdrawal",
            text: "Transaction Successful, Awaiting Approval",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message4"])) {
    $key = $_GET["message4"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Withdrawal Error",
            text: "Transaction Error",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message5"])) {
    $key = $_GET["message5"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Fund Error",
            text: "Insufficient Fund in the Till",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message7"])) {
    $key = $_GET["message7"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Account Number Error",
            text: "Account Not Found",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messagex5"])) {
    $key = $_GET["messagex5"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Insufficient Fund",
          text: "Client Has Insufficient Fund",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message8"])) {
    $key = $_GET["message8"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Pick",
          text: "Select Transaction Type",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["loan1"])) {
    $key = $_GET["loan1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "EXPENSE POSTING",
          text: "Expense Posting Successful",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["income1"])) {
    $key = $_GET["income1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "INCOME POSTING",
          text: "Income Transaction Successful",
          showConfirmButton: true,
          timer: 7000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["income2"])) {
    $key = $_GET["income2"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "INCOME RECORD ERROR",
          text: "Transaction successful but GL record not saved",
          showConfirmButton: true,
          timer: 5000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["income3"])) {
    $key = $_GET["income3"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Loan",
          text: "Sorry could not Find Chosen GL",
          showConfirmButton: true,
          timer: 7000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["income4"])) {
    $key = $_GET["income4"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Error",
                text: "There was an error Storing Transaction on behalf of customer Kindly contact Support",
                showConfirmButton: true,
                timer: 7000
            })
        });
    </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["income5"])) {
    $key = $_GET["income5"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Error",
                text: "Could not deduct money from customer",
                showConfirmButton: true,
                timer: 7000
            })
        });
    </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["income6"])) {
    $key = $_GET["income6"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Error",
                text: "Insufficient Balance in Customers Account",
                showConfirmButton: true,
                timer: 7000
            })
        });
    </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["income7"])) {
    $key = $_GET["income7"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Error",
                text: "Provide the Necessary Information!",
                showConfirmButton: true,
                timer: 7000
            })
        });
    </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["other_income"])) {
    $key = $_GET["other_income"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Transaction Successul",
                text: "Income Posted Successfilly",
                showConfirmButton: true,
                timer: 7000
            })
        });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["other_income2"])) {
    $key = $_GET["other_income2"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Account Funded Transaction Error",
          text: "Error storing Transaction record income GL",
          showConfirmButton: true,
          timer: 7000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["other_income3"])) {
    $key = $_GET["other_income3"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Transaction Error",
          text: "Error Funding GL!",
          showConfirmButton: true,
          timer: 7000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["other_income4"])) {
    $key = $_GET["other_income4"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "GL Error",
          text: "GL not Found or GL does not exist!",
          showConfirmButton: false,
          timer: 3000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else {
    echo "";
}
?>
<?php

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