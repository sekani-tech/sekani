<?php
include("../functions/connect.php");

$output = '';

if (isset($_POST["id"])) {

    if ($_POST["id"] != '') {
        $sql = "SELECT * FROM product WHERE id = '" . $_POST["id"] . "'";
    } else {
        $sql = "SELECT * FROM product";
    }

    $result = mysqli_query($connection, $sql);
    // $client = $_POST['client_id'];
    $client = isset($_POST['client_id']) ? $_POST['client_id'] : '';

    function fill_account($connection)
    {
        $id = $_POST["id"];
        $org = mysqli_query($connection, "SELECT * FROM product WHERE id = '$id'");
        if (count([$org]) == 1) {
            $a = mysqli_fetch_array($org);
            $int_id = $a['int_id'];
        }
        // $client_id = $_POST['client_id'];
        $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : '';
        $pen = "SELECT * FROM account WHERE client_id = '$client_id'";
        $res = mysqli_query($connection, $pen);
        $out = '';
        while ($row = mysqli_fetch_array($res)) {
            $product_type = $row["product_id"];
            $get_product = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$product_type' AND int_id = '$int_id'");
            while ($mer = mysqli_fetch_array($get_product)) {
                $p_n = $mer["name"];
                $out .= '<option value="' . $row["account_no"] . '">' . $row["account_no"] . ' - ' . $p_n . '</option>';
            }
        }
        return $out;
    }

    function getCurrentDate() {
        return date('Y-m-d');
    }

    function fill_payment($connection)
    {
        $id = $_POST["id"];
        $org = mysqli_query($connection, "SELECT * FROM product WHERE id = '$id'");
        if (count([$org]) == 1) {
            $a = mysqli_fetch_array($org);
            $sint_id = $a['int_id'];
        }
        $org = "SELECT * FROM payment_type WHERE int_id = '$sint_id'";
        $res = mysqli_query($connection, $org);
        $out = '';
        while ($row = mysqli_fetch_array($res)) {
            $out .= '<option value="' . $row["id"] . '">' . $row["value"] . '</option>';
        }
        return $out;
    }

    function fill_loanofficer($connection)
    {
        $id = $_POST["id"];
        $org = mysqli_query($connection, "SELECT * FROM product WHERE id = '$id'");
        if (count([$org]) == 1) {
            $a = mysqli_fetch_array($org);
            $int_id = $a['int_id'];
        }
        $pen = "SELECT * FROM staff WHERE int_id = '$int_id' AND employee_status = 'Employed'";
        $res = mysqli_query($connection, $pen);
        $out = '';
        while ($row = mysqli_fetch_array($res)) {
            $out .= '<option value="' . $row["id"] . '">' . $row["first_name"] . ' ' . $row["last_name"] . '</option>';
        }
        return $out;
    }

    while ($row = mysqli_fetch_array($result)) {
        if($row["repayment_frequency"] != 1) {
            // ex. instead of having "30 day" it will be "30 days"
            $repayment_every_x = $row["repayment_every"] . "s";
        } else {
            $repayment_every_x = $row["repayment_every"];
        }

        $output = '
        <div class="form-group">

            <div class="row">

                <style>
                    label{
                        color: dimgrey;
                    }
                </style>

                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Loan Size *:</label>
                            </div>
                            <div class="col-md-8">
                                <label>(Min Loan Amt *: N' . $row["min_principal_amount"] . ')</label>
                                <label>(Max Loan Amt *: N' . $row["max_principal_amount"] . ')</label>
                                <input type="number" hidden readonly value="' . $row["max_principal_amount"] . '" name="max_principal_amount" class="form-control" required id="maximum_Lamount">
                                <input type="number" hidden readonly value="' . $row["min_principal_amount"] . '" name="min_principal_amount" class="form-control" required id="minimum_Lamount">
                            </div>
                        </div>
                        <div id="verifyl"></div>
                        <input type="number" value="" step=".01" name="principal_amount" class="form-control" required id="principal_amount">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label>Loan Term *:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" step=".01" value="' . $row["loan_term"] . '" name="loan_term" class="form-control" id="loan_term" />
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value ="' . ucfirst($repayment_every_x) . '" id="repay" name="repay_eve" readonly />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Interest rate *:</label>
                            </div>
                            <div class="col-md-8">
                                <label>Min Interest Allowed *: ' . $row["min_interest_rate"] . '%</label>
                                <label>Max Interest Allowed *: ' . $row["max_interest_rate"] . '%</label>
                                <input type="number" hidden readonly value="' . $row["max_interest_rate"] . '" name="max_interest_rate" class="form-control" required id="maximum_intrate">
                                <input type="number" hidden readonly value="' . $row["min_interest_rate"] . '" name="min_interest_rate" class="form-control" required id="minimum_intrate">
                            </div>
                        </div>
                        <div id="verifyi"></div>
                        <input type="number" step= "1" value="' . $row["interest_rate"] . '" name="interest_rate" class="form-control" id="interest_rate">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label>Repayment Every:</label>
                                <input type="text" value="' . $row["repayment_frequency"] . ' '.  ucfirst($repayment_every_x) .'" name="repay_every_no" class="form-control" id="rapno" readonly/>
                                <input type="hidden" value="' . $row["repayment_frequency"] . '" name="repay_frequency" />
                            </div>
                        </div>
                    </div>
                </div>
      
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Disbursement Date *:</label>
                        <input type="date" name="disbursement_date" class="form-control" id="disb_date" value="'.getCurrentDate().'">
                    </div>
                </div>

                <div id="rep_start"class="col-md-4">
                    <div class="form-group">
                        <label>Repayment Start Date:</label>
                        <input type="date" name="repay_start" class="form-control" id="repay_start" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Account Officer:</label>
                        <select type="text" value="" name="loan_officer" class="form-control" id="lof">
                        ' . fill_loanofficer($connection) . '
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Loan Purpose:</label>
                        <input type="text" value="" name="loan_purpose" class="form-control" id="lop">
                    </div>
                </div>
      
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Loan Sector:</label>
                        <select name="loan_sector" class="form-control">
                            <option value="0">Select loan sector</option>
                            <option value="1">Agriculture, Mining & Quarry</option>
                            <option value="2">Manufacturing</option>
                            <option value="3">Agricultural sector</option>
                            <option value="4">Banking</option>
                            <option value="5">Public Service</option>
                            <option value="6">Health</option>
                            <option value="7">Education</option>
                            <option value="8">Tourism</option>
                            <option value="9">Civil Service</option>
                            <option value="10">Trade & Commerce</option>
                            <option value="11">Others</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4" hidden>
                    <div class="form-group">
                        <label>Fund Source:</label>
                        <select name="fund_source" class="form-control">
                        ' . fill_payment($connection) . '
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div id="sekat" class="form-group">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Grace on Payment:</label>
                        <input type="text" value="' . $row["grace_on_principal_amount"] . '" name="grace_on_principal" readonly class="form-control" id="lop">
                    </div>
                </div>
            </div>
        </div>
        ';
    }

    echo $output;
}

?>
<input type="hidden" id="client" value="<?php echo $client ?>">
<!-- uphere restric back date -->
<script>
    $(document).ready(function () {
        $('#principal_amount').on("change keyup paste click", function () {
            var id = $('#charges').val();
            var client_id = $('#client').val();
            var prin = $(this).val();
            $.ajax({
                url: "ajax_post/lend_charge.php",
                method: "POST",
                data: {id: id, prin: prin, client_id: client_id},
                success: function (data) {
                    $('#lend_charge').html(data);
                }
            });
        });

        $('#nextBtn').on("click", function () {
            var prina = $('#principal_amount').val();
            var loant = $('#loan_term').val();
            var intr = $('#interest_rate').val();
            var repay = $('#repay').val();
            var repay_start = $('#repay_start').val();
            var disbd = $('#disb_date').val();
            var total_charge_amount = $('#total_charge_amount').val();

            $.ajax({
                url: "loan_calculation_table.php",
                method: "POST",
                data: {
                    prina: prina,
                    loant: loant,
                    intr: intr,
                    repay: repay,
                    repay_start: repay_start,
                    disbd: disbd,
                    total_charge_amount: total_charge_amount
                },
                success: function (data) {
                    $('#accname').html(data);
                }
            })
        });

        // Date calculation
        $('#principal_amount').on("change keyup paste click", function () {
            var id = $(this).val();
            var ist = $('#int_id').val();
            var prina = $('#principal_amount').val();
            var loant = $('#loan_term').val();
            var intr = $('#interest_rate').val();
            var repay = $('#repay').val();
            var repay_start = $('#repay_start').val();
            var disbd = $('#disb_date').val();
            var max_Lamount = $('#maximum_Lamount').val();
            var min_Lamount = $('#minimum_Lamount').val();
            var max_intrate = $('#maximum_intrate').val();
            var min_intrate = $('#minimum_intrate').val();
            $.ajax({
                url: "loan_verify.php",
                method: "POST",
                data: {
                    id: id,
                    ist: ist,
                    prina: prina,
                    loant: loant,
                    intr: intr,
                    repay: repay,
                    repay_start: repay_start,
                    disbd: disbd,
                    max_Lamount: max_Lamount,
                    min_Lamount: min_Lamount,
                    max_intrate: max_intrate,
                    min_intrate: min_intrate
                },
                success: function (data) {
                    $('#verifyl').html(data);
                }
            })
        });
    
        $('#interest_rate').on("change keyup paste click", function () {
            var id = $(this).val();
            var ist = $('#int_id').val();
            var prina = $('#principal_amount').val();
            var loant = $('#loan_term').val();
            var intr = $('#interest_rate').val();
            var repay = $('#repay').val();
            var repay_start = $('#repay_start').val();
            var disbd = $('#disb_date').val();
            var max_Lamount = $('#maximum_Lamount').val();
            var min_Lamount = $('#minimum_Lamount').val();
            var max_intrate = $('#maximum_intrate').val();
            var min_intrate = $('#minimum_intrate').val();
            $.ajax({
                url: "loan_verify2.php",
                method: "POST",
                data: {
                    id: id,
                    ist: ist,
                    prina: prina,
                    loant: loant,
                    intr: intr,
                    repay: repay,
                    repay_start: repay_start,
                    disbd: disbd,
                    max_Lamount: max_Lamount,
                    min_Lamount: min_Lamount,
                    max_intrate: max_intrate,
                    min_intrate: min_intrate
                },
                success: function (data) {
                    $('#verifyi').html(data);
                }
            })
        });
    
        $('#loan_term').on("change keyup paste click", function () {
            var id = $(this).val();
            var ist = $('#int_id').val();
            var loant = $('#loan_term').val();
            var repay = $('#repay').val();
            var repay_start = $('#repay_start').val();
            var disbd = $('#disb_date').val();
            $.ajax({
                url: "date_calculation.php",
                method: "POST",
                data: {id: id, ist: ist, loant: loant, repay: repay, repay_start: repay_start, disbd: disbd},
                success: function (data) {
                    $('#sekat').html(data);
                }
            });
        });
    });
    setInterval(function () {
        var id = $('#loan_term').val();
        var ist = $('#int_id').val();
        var loant = $('#loan_term').val();
        var repay = $('#repay').val();
        var repay_start = $('#repay_start').val();
        var disbd = $('#disb_date').val();
        if (id != "" && ist != "" && loant != "" && repay != "" && repay_start != "" && disbd != "") {
            $.ajax({
                url: "date_calculation.php",
                method: "POST",
                data: {id: id, ist: ist, loant: loant, repay: repay, repay_start: repay_start, disbd: disbd},
                success: function (data) {
                    $('#sekat').html(data);
                }
            });
        }
    }, 1000);

    $(document).ready(function () {

        $('#repay').on("change keyup paste click", function () {
            var id = $(this).val();
            var ist = $('#int_id').val();
            var loant = $('#loan_term').val();
            var repay = $('#repay').val();
            var repay_start = $('#repay_start').val();
            var disbd = $('#disb_date').val();
            $.ajax({
                url: "date_calculation.php",
                method: "POST",
                data: {id: id, ist: ist, loant: loant, repay: repay, repay_start: repay_start, disbd: disbd},
                success: function (data) {
                    $('#sekat').html(data);
                }
            });
        });

        //     $('#repay_start').on("change keyup paste click", function () {
        //         var id = $(this).val();
        //         var ist = $('#int_id').val();
        //         var loant = $('#loan_term').val();
        //         var repay = $('#repay').val();
        //         var repay_start = $('#repay_start').val();
        //         var disbd = $('#disb_date').val();
        //         $.ajax({
        //             url: "date_calculation.php",
        //             method: "POST",
        //             data: {id: id, ist: ist, loant: loant, repay: repay, repay_start: repay_start, disbd: disbd},
        //             success: function (data) {
        //                 $('#sekat').html(data);
        //             }
        //         })
        //     });

        $('#disb_date').on("change keyup paste click", function () {
            var id = $(this).val();
            var ist = $('#int_id').val();
            var loant = $('#loan_term').val();
            var repay = $('#repay').val();
            var repay_start = $('#repay_start').val();
            var disbd = $('#disb_date').val();
            $.ajax({
                url: "date_calculation.php",
                method: "POST",
                data: {id: id, ist: ist, loant: loant, repay: repay, repay_start: repay_start, disbd: disbd},
                success: function (data) {
                    $('#sekat').html(data);
                }
            })
        });
    });



    $(document).ready(function () {
        var disb = $('#disb_date').val();
        var loant = $('#loan_term').val();
        var repay = $('#repay').val();
        var repayno = $('#rapno').val();
        
        $.ajax({
            url: "ajax_post/repayment_calc.php",
            method: "POST",
            data: {loant: loant, disb: disb, repay: repay, repayno: repayno},
            success: function (data) {
                $('#rep_start').html(data);
            }
        })
        
        $('#loan_term').on("change keyup paste click", function () {
            var disb = $('#disb_date').val();
            var loant = $(this).val();
            var repay = $('#repay').val();
            var repayno = $('#rapno').val();
            
            $.ajax({
                url: "ajax_post/repayment_calc.php",
                method: "POST",
                data: {loant: loant, disb: disb, repay: repay, repayno: repayno},
                success: function (data) {
                    $('#rep_start').html(data);
                }
            })
        });

        $('#disb_date').on("change keyup paste click", function () {
            var disb = $(this).val();
            var loant = $('#loan_term').val();
            var repay = $('#repay').val();
            var repayno = $('#rapno').val();
            
            $.ajax({
                url: "ajax_post/repayment_calc.php",
                method: "POST",
                data: {loant: loant, disb: disb, repay: repay, repayno: repayno},
                success: function (data) {
                    $('#rep_start').html(data);
                }
            })
        });

        $('#repay').on("change keyup paste click", function () {
            var disb = $('#disb_date').val();
            var loant = $('#loan_term').val();
            var repay = $(this).val();
            var repayno = $('#rapno').val();
            
            $.ajax({
                url: "ajax_post/repayment_calc.php",
                method: "POST",
                data: {loant: loant, disb: disb, repay: repay, repayno: repayno},
                success: function (data) {
                    $('#rep_start').html(data);
                }
            })
        });
    });
</script>

<script>
    $(document).ready(function () {

        $('#principal_amount').change(function () {
            $('#ls').val($('#principal_amount').val());
            $('#lt').val($('#loan_term').val());
            $('#irp').val($('#repay').val());
            $('#ir').val($('#interest_rate').val());
            $('#db').val($('#disb_date').val());
            $('#lo').val($('#lof').val());
            $('#lp').val($('#lop').val());
            $('#lsa').val($('#act_no').val());
            $('#rsd').val($('#repay_start').val());
        });

        $('#loan_term').change(function () {
            $('#ls').val($('#principal_amount').val());
            $('#lt').val($('#loan_term').val());
            $('#irp').val($('#repay').val());
            $('#ir').val($('#interest_rate').val());
            $('#db').val($('#disb_date').val());
            $('#lo').val($('#lof').val());
            $('#lp').val($('#lop').val());
            $('#lsa').val($('#act_no').val());
            $('#rsd').val($('#repay_start').val());
            $('#end').val($('#ed').val());
        });

        $('#repay').change(function () {
            $('#ls').val($('#principal_amount').val());
            $('#lt').val($('#loan_term').val());
            $('#irp').val($('#repay').val());
            $('#ir').val($('#interest_rate').val());
            $('#db').val($('#disb_date').val());
            $('#lo').val($('#lof').val());
            $('#lp').val($('#lop').val());
            $('#lsa').val($('#act_no').val());
            $('#rsd').val($('#repay_start').val());
        });

        $('#interest_rate').change(function () {
            $('#ls').val($('#principal_amount').val());
            $('#lt').val($('#loan_term').val());
            $('#irp').val($('#repay').val());
            $('#ir').val($('#interest_rate').val());
            $('#db').val($('#disb_date').val());
            $('#lo').val($('#lof').val());
            $('#lp').val($('#lop').val());
            $('#lsa').val($('#act_no').val());
            $('#rsd').val($('#repay_start').val());
        });

        $('#disb_date').change(function () {
            $('#ls').val($('#principal_amount').val());
            $('#lt').val($('#loan_term').val());
            $('#irp').val($('#repay').val());
            $('#ir').val($('#interest_rate').val());
            $('#db').val($('#disb_date').val());
            $('#lo').val($('#lof').val());
            $('#lp').val($('#lop').val());
            $('#lsa').val($('#act_no').val());
            $('#rsd').val($('#repay_start').val());
        });

        $('#lof').change(function () {
            $('#ls').val($('#principal_amount').val());
            $('#lt').val($('#loan_term').val());
            $('#irp').val($('#repay').val());
            $('#ir').val($('#interest_rate').val());
            $('#db').val($('#disb_date').val());
            $('#lo').val($('#lof').val());
            $('#lp').val($('#lop').val());
            $('#lsa').val($('#act_no').val());
            $('#rsd').val($('#repay_start').val());
        });

        $('#lop').change(function () {
            $('#ls').val($('#principal_amount').val());
            $('#lt').val($('#loan_term').val());
            $('#irp').val($('#repay').val());
            $('#ir').val($('#interest_rate').val());
            $('#db').val($('#disb_date').val());
            $('#lo').val($('#lof').val());
            $('#lp').val($('#lop').val());
            $('#lsa').val($('#act_no').val());
            $('#rsd').val($('#repay_start').val());
        });

        $('#act_no').change(function () {
            $('#ls').val($('#principal_amount').val());
            $('#lt').val($('#loan_term').val());
            $('#irp').val($('#repay').val());
            $('#ir').val($('#interest_rate').val());
            $('#db').val($('#disb_date').val());
            $('#lo').val($('#lof').val());
            $('#lp').val($('#lop').val());
            $('#lsa').val($('#act_no').val());
            $('#rsd').val($('#repay_start').val());
        });

        $('#repay_start').change(function () {
            $('#ls').val($('#principal_amount').val());
            $('#lt').val($('#loan_term').val());
            $('#irp').val($('#repay').val());
            $('#ir').val($('#interest_rate').val());
            $('#db').val($('#disb_date').val());
            $('#lo').val($('#lof').val());
            $('#lp').val($('#lop').val());
            $('#lsa').val($('#act_no').val());
            $('#rsd').val($('#repay_start').val());
        });

        $('#repay_start').change(function () {
            console.log('it changed');
            var prina = document.getElementById("principal_amount").value;
            var loant = document.getElementById("loan_term").value;
            var intr = document.getElementById("interest_rate").value;
            var repay = document.getElementById("repay").value;
            var repay_start = document.getElementById("repay_start").value;
            var disbd = document.getElementById("disb_date").value;
            $.ajax({
                url: "loan_calculation_table.php",
                method: "POST",
                data: {prina: prina, loant: loant, intr: intr, repay: repay, disbd: disbd, repay_start: repay_start},
                success: function (data) {
                    $('#result').html(data);
                }
            })
        });

        $('#loan_term').change(function () {
            console.log('changed');
            var prina = document.getElementById("principal_amount").value;
            var loant = document.getElementById("loan_term").value;
            var intr = document.getElementById("interest_rate").value;
            var repay = document.getElementById("repay").value;
            var repay_start = document.getElementById("repay_start").value;
            var disbd = document.getElementById("disb_date").value;
            $.ajax({
                url: "loan_calculation_table.php",
                method: "POST",
                data: {prina: prina, loant: loant, intr: intr, repay: repay, disbd: disbd, repay_start: repay_start},
                success: function (data) {
                    $('#result').html(data);
                }
            })
        });

        $('#principal_amount').change(function () {
            console.log('changed');
            var prina = document.getElementById("principal_amount").value;
            var loant = document.getElementById("loan_term").value;
            var intr = document.getElementById("interest_rate").value;
            var repay = document.getElementById("repay").value;
            var repay_start = document.getElementById("repay_start").value;
            var disbd = document.getElementById("disb_date").value;
            $.ajax({
                url: "loan_calculation_table.php",
                method: "POST",
                data: {prina: prina, loant: loant, intr: intr, repay: repay, disbd: disbd, repay_start: repay_start},
                success: function (data) {
                    $('#result').html(data);
                }
            })
        });

        $('#interest_rate').change(function () {
            console.log('changed');
            var prina = document.getElementById("principal_amount").value;
            var loant = document.getElementById("loan_term").value;
            var intr = document.getElementById("interest_rate").value;
            var repay = document.getElementById("repay").value;
            var repay_start = document.getElementById("repay_start").value;
            var disbd = document.getElementById("disb_date").value;
            $.ajax({
                url: "loan_calculation_table.php",
                method: "POST",
                data: {prina: prina, loant: loant, intr: intr, repay: repay, disbd: disbd, repay_start: repay_start},
                success: function (data) {
                    $('#result').html(data);
                }
            })
        });
    })
</script>