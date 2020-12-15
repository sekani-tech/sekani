<?php
include("../functions/connect.php");
function fill_groups()
{
    $group_id = $_POST['group_id'];
    return selectOne('groups', ['id' => $group_id]);
}

function fill_account($connection)
{
    $id = $_POST["sint_id"];
    $data = [];
    $client_id = $_POST['client_id'];
    $pen = selectOne('account', ['client_id' => $client_id]);
    $product_type = $pen["product_id"];
    $product_name = selectOne('savings_product', ['id' => $product_type, 'int_id' => $id]);
    $data['account_no'] = $pen['account_no'];
    $data['id'] = $pen['id'];
    $data['name'] = $product_name['name'];
    return $data;
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
    $id = $_POST["sint_id"];
    return selectAll('staff', ['int_id' => $id, 'employee_status' => 'Employed']);
}

$output = '';
if (isset($_POST["id"]) and (isset($_POST['client_id']) xor isset($_POST['group_id']))) {
//    dd($_POST["sint_id"]);
    if (!empty($_POST["id"])) {
        $result = selectOne('product', ['id' => $_POST['id']]);
    }
    if ($result) {
        ?>

        <div class="form-group">
            <div class="row">
                <style>
                    label {
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
                                <label>(Min Loan Amt *: N <?php echo $result["min_principal_amount"] ?>)</label>
                                <label>(Max Loan Amt *: N' <?php echo $result["max_principal_amount"] ?>)</label>
                                <input type="number" hidden readonly
                                       value="<?php echo $result["max_principal_amount"] ?>"
                                       name="max_principal_amount" class="form-control" required id="maximum_Lamount">
                                <input type="number" hidden readonly
                                       value="<?php echo $result["min_principal_amount"] ?>"
                                       name="min_principal_amount" class="form-control" required id="minimum_Lamount">
                            </div>
                        </div>
                        <div id="verifyl"></div>
                        <input type="number" value="" step=".01" name="principal_amount" class="form-control" required
                               id="principal_amount">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Loan Term *:</label>
                                <input type="number" step=".01" value="<?php echo $result["loan_term"] ?>"
                                       name="loan_term"
                                       class="form-control" id="loan_term"/>
                                <input type="text" hidden value="<?php echo $result["grace_on_principal_amount"] ?>"
                                       id="grace_prin"/>
                            </div>
                            <div class="col-md-5">
                                <label> </label>
                                <select id="repay" name="repay_eve" class="form-control">
                                    <option hidden
                                            value="<?php echo $result["repayment_every"] ?>"><?php echo $result["repayment_every"] ?></option>
                                    <option value="day">Days</option>
                                    <option value="week">Weeks</option>
                                    <option value="month">Months</option>
                                    <option value="year">Years</option>
                                </select>
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
                                <label>Min Interest Allowed *: <?php echo $result["min_interest_rate"] ?>%</label>
                                <label>Max Interest Allowed *: <?php echo $result["max_interest_rate"] ?>%</label>
                                <input type="number" hidden readonly value="<?php echo $result["max_interest_rate"] ?>"
                                       name="max_interest_rate" class="form-control" required id="maximum_intrate">
                                <input type="number" hidden readonly value="<?php echo $result["min_interest_rate"] ?>"
                                       name="min_interest_rate" class="form-control" required id="minimum_intrate">
                            </div>
                        </div>
                        <div id="verifyi"></div>
                        <input type="number" step="1" value="<?php echo $result["interest_rate"] ?>"
                               name="interest_rate"
                               class="form-control" id="interest_rate">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <label>Repayment Every:</label>
                                <input type="number" value="<?php echo $result["repayment_frequency"] ?>"
                                       name="repay_every_no"
                                       class="form-control id=" rapno"/>
                            </div>
                            <div class="col-md-5">
                                <label> </label></br>
                                <label> </label></br>
                                <div id="change_term">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Disbursement Date *:</label>
                        <input type="date" name="disbursement_date" class="form-control" id="disb_date">
                    </div>
                </div>
                <div id="rep_start" class="col-md-4">
                    <div class="form-group">
                        <label>Repayment Start Date:</label>
                        <input type="date" name="repay_start" class="form-control" id="repay_start">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Account Officer:</label>
                        <select type="text" value="" name="loan_officer" class="form-control" id="lof">
                            <?php $officerDetails = fill_loanofficer($connection);
                            foreach ($officerDetails as $officerDetail) { ?>
                                <option value="<?php echo $officerDetail['id'] ?>"><?php echo $officerDetail['display_name'] ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Loan Purpose:</label>
                        <input type="text" value="" name="loan_purpose" class="form-control" id="loan_purpose">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Linked Savings account:</label>
                        <select name="linked_savings_acct" class="form-control" id="lsaa">
                            <?php if (isset($_POST['group_id'])) {
                                $groupResult = fill_groups();
                                if ($groupResult) { ?>
                                    <option value="<?php echo $groupResult["id"] ?>"><?php echo $groupResult['account_no'] ?></option>
                                    <?php
                                } else { ?>
                                    <option><?php echo "No Account Number" ?></option> <?php
                                }
                            } else {
                                $resultClient = fill_account($connection);
                                if ($resultClient) { ?>
                                    <option value="<?php echo $resultClient['id'] ?>"><?php echo $resultClient['account_no'] ?>
                                        - <?php echo $resultClient['name'] ?></option>
                                    <?php
                                } else { ?>
                                    <option><?php echo "No Account Number" ?></option> <?php
                                }
                            } ?>

                        </select>
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
                            <?php echo fill_payment($connection) ?>
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
                        <input type="text" value="<?php echo $result["grace_on_principal_amount"] ?>" name="" readonly
                               class="form-control" id="lop">
                    </div>
                </div>
            </div>
        </div>

        <?php

//}
// session_start();
//    $_SESSION['load_term'] = "batman";
//    $_SESSION['interest_rate'] = "batman";
//    $_SESSION['disbursment_date'] = "batman";
        ?>

        <!-- uphere restric back date -->
        <script>
            $(document).ready(function () {
                $('#principal_amount').on("change keyup paste click", function () {
                    var id = $('#charges').val();
                    var prin = $(this).val();
                    $.ajax({
                        url: "ajax_post/lend_charge.php",
                        method: "POST",
                        data: {id: id, prin: prin},
                        success: function (data) {
                            $('#lend_charge').html(data);
                        }
                    });
                });
                $('#act').on("change keyup paste click", function () {
                    var id = $(this).val();
                    var ist = $('#int_id').val();
                    var prina = $('#principal_amount').val();
                    var loant = $('#loan_term').val();
                    var intr = $('#interest_rate').val();
                    var repay = $('#repay').val();
                    var repay_start = $('#repay_start').val();
                    var disbd = $('#disb_date').val();
                    $.ajax({
                        url: "loan_calculation_table.php",
                        method: "POST",
                        data: {
                            id: id,
                            ist: ist,
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            repay_start: repay_start,
                            disbd: disbd
                        },
                        success: function (data) {
                            $('#accname').html(data);
                        }
                    })
                });
            });
            $(document).ready(function () {
                $('#loan_term').on("change keyup paste click", function () {
                    var id = $(this).val();
                    var ist = $('#int_id').val();
                    var prina = $('#principal_amount').val();
                    var loant = $('#loan_term').val();
                    var intr = $('#interest_rate').val();
                    var repay = $('#repay').val();
                    var repay_start = $('#repay_start').val();
                    var disbd = $('#disb_date').val();
                    $.ajax({
                        url: "loan_calculation_table.php",
                        method: "POST",
                        data: {
                            id: id,
                            ist: ist,
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            repay_start: repay_start,
                            disbd: disbd
                        },
                        success: function (data) {
                            $('#accname').html(data);
                        }
                    })
                });
            });
            $(document).ready(function () {
                $('#interest_rate').on("change keyup paste click", function () {
                    var id = $(this).val();
                    var ist = $('#int_id').val();
                    var prina = $('#principal_amount').val();
                    var loant = $('#loan_term').val();
                    var intr = $('#interest_rate').val();
                    var repay = $('#repay').val();
                    var repay_start = $('#repay_start').val();
                    var disbd = $('#disb_date').val();
                    $.ajax({
                        url: "loan_calculation_table.php",
                        method: "POST",
                        data: {
                            id: id,
                            ist: ist,
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            repay_start: repay_start,
                            disbd: disbd
                        },
                        success: function (data) {
                            $('#accname').html(data);
                        }
                    })
                });
            });
            $(document).ready(function () {
                $('#repay').on("change keyup paste click", function () {
                    var id = $(this).val();
                    var ist = $('#int_id').val();
                    var prina = $('#principal_amount').val();
                    var loant = $('#loan_term').val();
                    var intr = $('#interest_rate').val();
                    var repay = $('#repay').val();
                    var repay_start = $('#repay_start').val();
                    var disbd = $('#disb_date').val();
                    $.ajax({
                        url: "loan_calculation_table.php",
                        method: "POST",
                        data: {
                            id: id,
                            ist: ist,
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            repay_start: repay_start,
                            disbd: disbd
                        },
                        success: function (data) {
                            $('#accname').html(data);
                        }
                    })
                });
            });
            $(document).ready(function () {
                $('#repay_start').on("change keyup paste click", function () {
                    var id = $(this).val();
                    var ist = $('#int_id').val();
                    var prina = $('#principal_amount').val();
                    var loant = $('#loan_term').val();
                    var intr = $('#interest_rate').val();
                    var repay = $('#repay').val();
                    var repay_start = $('#repay_start').val();
                    var disbd = $('#disb_date').val();
                    $.ajax({
                        url: "loan_calculation_table.php",
                        method: "POST",
                        data: {
                            id: id,
                            ist: ist,
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            repay_start: repay_start,
                            disbd: disbd
                        },
                        success: function (data) {
                            $('#accname').html(data);
                        }
                    })
                });
            });
            $(document).ready(function () {
                $('#disb_date').on("change keyup paste click", function () {
                    var id = $(this).val();
                    var ist = $('#int_id').val();
                    var prina = $('#principal_amount').val();
                    var loant = $('#loan_term').val();
                    var intr = $('#interest_rate').val();
                    var repay = $('#repay').val();
                    var repay_start = $('#repay_start').val();
                    var disbd = $('#disb_date').val();
                    $.ajax({
                        url: "loan_calculation_table.php",
                        method: "POST",
                        data: {
                            id: id,
                            ist: ist,
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            repay_start: repay_start,
                            disbd: disbd
                        },
                        success: function (data) {
                            $('#accname').html(data);
                        }
                    })
                });
            });

            // Date calculation
            $(document).ready(function () {
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
            });
            $(document).ready(function () {
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
            });
            $(document).ready(function () {
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
                var id = $('#repay').val();
                $.ajax({
                    url: "ajax_post/change_term.php",
                    method: "POST",
                    data: {id: id},
                    success: function (data) {
                        $('#change_term').html(data);
                    }
                });
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
                    $.ajax({
                        url: "ajax_post/change_term.php",
                        method: "POST",
                        data: {id: id},
                        success: function (data) {
                            $('#change_term').html(data);
                        }
                    });
                });
            });
            $(document).ready(function () {
                $('#repay_start').on("change keyup paste click", function () {
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
                $('#disb_date').on("change keyup paste click", function () {
                    var disb = $(this).val();
                    var repay = $('#repay').val();
                    var repayno = $('#rapno').val();
                    var grace_prin = $('#grace_prin').val();
                    $.ajax({
                        url: "ajax_post/repayment_calc.php",
                        method: "POST",
                        data: {disb: disb, repay: repay, repayno: repayno, grace_prin: grace_prin},
                        success: function (data) {
                            $('#rep_start').html(data);
                        }
                    })
                });
            });

            $(document).ready(function () {
                $('#repay').on("change keyup paste click", function () {
                    var disb = $('#disb_date').val();
                    var repay = $(this).val();
                    var repayno = $('#rapno').val();
                    var grace_prin = $('#grace_prin').val();
                    $.ajax({
                        url: "ajax_post/repayment_calc.php",
                        method: "POST",
                        data: {disb: disb, repay: repay, repayno: repayno, grace_prin: grace_prin},
                        success: function (data) {
                            $('#rep_start').html(data);
                        }
                    })
                });
            });

            $(document).ready(function () {
                $('#rapno').on("change keyup paste click", function () {
                    var disb = $('#disb_date').val();
                    var repay = $('#repay').val();
                    var repayno = $(this).val();
                    var grace_prin = $('#grace_prin').val();
                    $.ajax({
                        url: "ajax_post/repayment_calc.php",
                        method: "POST",
                        data: {disb: disb, repay: repay, repayno: repayno, grace_prin: grace_prin},
                        success: function (data) {
                            $('#rep_start').html(data);
                        }
                    })
                });
            });

            $(document).ready(function () {
                $('#principal_amount').change(function () {
                    $('#ls').val($('#principal_amount').val());
                    $('#lt').val($('#loan_term').val());
                    $('#irp').val($('#repay').val());
                    $('#ir').val($('#interest_rate').val());
                    $('#db').val($('#disb_date').val());
                    $('#lo').val($('#lof').val());
                    $('#lp').val($('#lop').val());
                    $('#lsa').val($('#lsaa').val());
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
                    $('#lsa').val($('#lsaa').val());
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
                    $('#lsa').val($('#lsaa').val());
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
                    $('#lsa').val($('#lsaa').val());
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
                    $('#lsa').val($('#lsaa').val());
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
                    $('#lsa').val($('#lsaa').val());
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
                    $('#lsa').val($('#lsaa').val());
                    $('#rsd').val($('#repay_start').val());
                });
                $('#lsaa').change(function () {
                    $('#ls').val($('#principal_amount').val());
                    $('#lt').val($('#loan_term').val());
                    $('#irp').val($('#repay').val());
                    $('#ir').val($('#interest_rate').val());
                    $('#db').val($('#disb_date').val());
                    $('#lo').val($('#lof').val());
                    $('#lp').val($('#lop').val());
                    $('#lsa').val($('#lsaa').val());
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
                    $('#lsa').val($('#lsaa').val());
                    $('#rsd').val($('#repay_start').val());
                });
            });
            $(document).ready(function () {
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
                        data: {
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            disbd: disbd,
                            repay_start: repay_start
                        },
                        success: function (data) {
                            $('#result').html(data);
                        }
                    })
                });
            })
            $(document).ready(function () {
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
                        data: {
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            disbd: disbd,
                            repay_start: repay_start
                        },
                        success: function (data) {
                            $('#result').html(data);
                        }
                    })
                });
            })
            $(document).ready(function () {
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
                        data: {
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            disbd: disbd,
                            repay_start: repay_start
                        },
                        success: function (data) {
                            $('#result').html(data);
                        }
                    })
                });
            })
            $(document).ready(function () {
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
                        data: {
                            prina: prina,
                            loant: loant,
                            intr: intr,
                            repay: repay,
                            disbd: disbd,
                            repay_start: repay_start
                        },
                        success: function (data) {
                            $('#result').html(data);
                        }
                    })
                });
            })
        </script>
    <?php }
} ?>