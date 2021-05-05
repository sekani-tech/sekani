<?php

$page_title = "New Product";
$destination = "index.php";
include("header.php");

function fill_charges()
{
    $sint_id = $_SESSION["int_id"];
    $main_p = $_SESSION["product_temp"];

    return selectAll('charge', ['int_id' => $sint_id, 'charge_applies_to_enum' => '5', 'is_active' => '1']);
}

// show charge missing information
if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $key) {
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Missing Information",
        text: "Charges Information Not Found!",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}


$sint_id = $_SESSION['int_id'];
//$ftdChargesDelete = delete('charges_cache', $sint_id, 'int_id');
//$ftdProductCache = delete('prod_acct_cache', $sint_id, 'int_id');

?>
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Create new Product</h4>
                            <p class="card-category">Fill in all important data</p>
                        </div>
                        <form id="form" action="../functions/int_ftd_upload.php" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!-- Each tab equals a stepper page -->
                                            <!-- First Tab -->
                                            <div class="tab">
                                                <h3> New Fixed Deposit Term Product:</h3>
                                                <p><i>All fields with (<span style="color: red;">*</span>) are required</i>
                                                </p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Name <span style="color: red;">*</span></label>
                                                            <input type="text" name="longName" class="form-control"
                                                                   id="longName"
                                                                   placeholder="Fixed Deposit full name..." required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shortLoanName">Short Product Name <span
                                                                        style="color: red;">*</span> </label>
                                                            <input type="text" class="form-control" name="shortName"
                                                                   value="" id="shortName" placeholder="Short Name..."
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="loanDescription">Description <span
                                                                        style="color: red;">*</span></label>
                                                            <input type="text" class="form-control" name="description"
                                                                   value="" id="description"
                                                                   placeholder="Description...." required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="installmentAmount">Currency</label>
                                                            <select class="form-control" name="currency" id="currency">
                                                                <option value="NGN">Nigerian Naira(NGN)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="interestRate">Deposit Amount <span
                                                                        style="color: red">*</span></label>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control"
                                                                           name="depositDefault" value=""
                                                                           id="depositDefault"
                                                                           placeholder="Default" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control"
                                                                           name="depositMin" value="" id="depositMin"
                                                                           placeholder="Min" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control"
                                                                           name="depositMax" value="" id="depositMax"
                                                                           placeholder="Max" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="interestRate">Interest Rate <span
                                                                        style="color: red">*</span></label>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control"
                                                                           name="interestRateDefault" value=""
                                                                           id="interestRateDefault"
                                                                           placeholder="Default" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control"
                                                                           name="interestRateMin" value=""
                                                                           id="interestRateMin"
                                                                           placeholder="Min" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" class="form-control"
                                                                           name="interestRateMax" value=""
                                                                           id="interestRateMax"
                                                                           placeholder="Max" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="interestRateApplied">Interest Posting period
                                                                Type</label>
                                                            <select class="form-control" name="interestPostType"
                                                                    id="interestPostType">
                                                                <option value="30">Monthly</option>
                                                                <option value="90">Quarterly</option>
                                                                <option value="180">Bi-Annually</option>
                                                                <option value="365">Annually</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="installmentAmount">Interest Compounding
                                                                Period</label>
                                                            <select class="form-control" name="compoundPeriod"
                                                                    id="compoundPeriod"
                                                                    required>
                                                                <option value="">Select Option</option>
                                                                <option value="2">Monthly</option>
                                                                <option value="3">Quarterly</option>
                                                                <option value="4">Bi-Annually</option>
                                                                <option value="5">Annually</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" hidden>
                                                        <div class="form-group">
                                                            <label for="interestMethodology">Interest Calculation
                                                                Type</label>
                                                            <select class="form-control" name="intCalType"
                                                                    id="intCalType">
                                                                <option value="1">Daily Balance</option>
                                                                <option value="2">Average Daily Balance</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="amortizatioMethody">Interest Calculation Days in
                                                                Year type</label>
                                                            <select class="form-control" name="intCalDays"
                                                                    id="intCalDays" required>
                                                                <option value="30">30 days</option>
                                                                <option value="60">60 days</option>
                                                                <option value="90">90 days</option>
                                                                <option value="180">180 days</option>
                                                                <option value="365">365 days</option>
                                                                <option value="366">366 days</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" hidden>
                                                        <div class="form-group">
                                                            <label for="principal">Lock-in Period Frequency</label>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="number" class="form-control"
                                                                           name="lockPerFreq" id="lockPerFreq" value="1"
                                                                           placeholder="Default" required>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control"
                                                                            name="lockPerFreqTime" id="lockPerFreqTime">
                                                                        <option value="1">Days</option>
                                                                        <option value="3">Months</option>
                                                                        <option value="4">Years</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="principal">Minimum Deposit Term <span
                                                                        style="color: red">*</span></label>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="number" class="form-control"
                                                                           name="minimumDepTerm" id="minimumDepTerm"
                                                                           value=""
                                                                           placeholder="Min" required>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control"
                                                                            name="minimumDepTermTime">
                                                                        <option value="1">Days</option>
                                                                        <option value="3">Months</option>
                                                                        <option value="4">Years</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="additionalCharges">Auto Renew on
                                                                maturity</label>
                                                            <select class="form-control" name="autoRenew" id="autoRenew"
                                                                    required>
                                                                <option value="2">No</option>
                                                                <option value="1">Yes</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="principal">Maximum Deposit Term <span
                                                                        style="color: red">*</span></label>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="number" class="form-control"
                                                                           name="maximumDepTerm" id="maximumDepTerm"
                                                                           value=""
                                                                           placeholder="Max" required>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control"
                                                                            name="maximumDepTermTime">
                                                                        <option value="1">Days</option>
                                                                        <option value="3">Months</option>
                                                                        <option value="4">Years</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="additionalCharges">Allow Premature Closing
                                                                Penalty</label>
                                                            <select class="form-control" name="prematureClosingPenalty"
                                                                    required>
                                                                <option value="2">No</option>
                                                                <option value="1">Yes</option>
                                                            </select>
                                                        </div>
                                                    </div>

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
                                                                <label for="shortSharesName">FTD Journal<span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" name="glCode" id="gl_income" required>
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
                                                                <label for="shortSharesName">Income Expense Journal <span style="color: red;">*</span></label>
                                                                <input type="text" class="form-control" name="expense_gl" id="gl_expense" required>
                                                                <!-- <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id"> -->
                                                            </div>
                                                            <div id="expense"></div>
                                                        </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="principal">In Multiples of Deposit Term <span
                                                                        style="color: red">*</span></label>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="number" class="form-control"
                                                                           name="inMultiplesDepTerm"
                                                                           id="inMultiplesDepTerm" value=""
                                                                           placeholder="Default" required>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select class="form-control"
                                                                            name="inMultiplesDepTermTime">
                                                                        <option value="1">Days</option>
                                                                        <option value="3">Months</option>
                                                                        <option value="4">Years</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- First Tab -->

                                            <!-- Second Tab -->
                                            <div class="tab">
                                                <h3>Charges</h3>
                                                <input type="text" hidden readonly id="int_id"
                                                       value="<?php echo $sessint_id; ?>">
                                                <input type="text" hidden readonly id="branch_id"
                                                       value="<?php echo $branch_id; ?>">
                                                <script>
                                                    $(document).ready(function () {
                                                        $('#charges').change(function () {
                                                            var id = $(this).val();
                                                            var int_id = $('#int_id').val();
                                                            var branch_id = $('#branch_id').val();
                                                            var main_p = $('#main_p').val();
                                                            let longName = $('#longName').val();
                                                            let shortName = $('#shortName').val();
                                                            $.ajax({
                                                                url: "ftd_charges.php",
                                                                method: "POST",
                                                                data: {
                                                                    id: id,
                                                                    int_id: int_id,
                                                                    branch_id: branch_id,
                                                                    main_p: main_p,
                                                                    longName: longName,
                                                                    shortName: shortName
                                                                },
                                                                success: function (data) {
                                                                    $('#show_charges').html(data);
                                                                }
                                                            })
                                                        });
                                                    })
                                                </script>
                                                <div class="form-group">
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Charges:</label>
                                                            <div id="takeme">
                                                                <input type="text" hidden value="<?php echo $main_p; ?>"
                                                                       id="main_p">
                                                                <select name="charge_id" class="form-control"
                                                                        id="charges">
                                                                    <option value="">select an option</option>
                                                                    <?php $results = fill_charges();
                                                                    foreach ($results as $charge) {
                                                                        ?>
                                                                        <option value="<?= $charge["id"] ?>"><?= $charge["name"] ?>
                                                                        </option>;
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top: 50px;">
                                                        <div class="col-md-12">
                                                            <div id="show_charges">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- Second Tab -->

                                            <!-- third Tab -->
                                            <!--                                            <div class="tab">-->
                                            <!--                                                <div class="col-md-6">-->
                                            <!--                                                    <button class="btn btn-primary" id="preview">Preview</button>-->
                                            <!--                                                </div>-->
                                            <!--                                                <script>-->
                                            <!--                                                    $(document).ready(function () {-->
                                            <!--                                                        $('#preview').click(function () {-->
                                            <!--                                                            let longName = $('#longName').val();-->
                                            <!--                                                            let shortName = $('#shortName').val();-->
                                            <!--                                                            let description = $('#description').val();-->
                                            <!--                                                            let currency = $('#currency').val();-->
                                            <!--                                                            let depositDefault = $('#depositDefault').val();-->
                                            <!--                                                            let depositMin = $('#depositMin').val();-->
                                            <!--                                                            let depositMax = $('#depositMax').val();-->
                                            <!--                                                            let interestRateDefault = $('#interestRateDefault').val();-->
                                            <!--                                                            let interestRateMin = $('#interestRateMin').val();-->
                                            <!--                                                            let interestRateMax = $('#interestRateMax').val();-->
                                            <!--                                                            let compoundPeriod = $('#compoundPeriod').val();-->
                                            <!--                                                            let intCalType = $('#intCalType').val();-->
                                            <!--                                                            let intCalDays = $('#intCalDays').val();-->
                                            <!--                                                            let lockPerFreq = $('#lockPerFreq').val();-->
                                            <!--                                                            let lockPerFreqTime = $('#lockPerFreqTime').val();-->
                                            <!--                                                            let minimumDepTerm = $('#minimumDepTerm').val();-->
                                            <!--                                                            let minimumDepTermTime = $('#minimumDepTermTime').val();-->
                                            <!--                                                            let autoRenew = $('#autoRenew').val();-->
                                            <!--                                                            let maximumDepTerm = $('#maximumDepTerm').val();-->
                                            <!--                                                            let maximumDepTermTime = $('#maximumDepTermTime').val();-->
                                            <!--                                                            let prematureClosingPenalty = $('#prematureClosingPenalty').val();-->
                                            <!--                                                            let glCode = $('#glCode').val();-->
                                            <!--                                                            let inMultiplesDepTerm = $('#inMultiplesDepTerm').val();-->
                                            <!--                                                            let inMultiplesDepTermTime = $('#inMultiplesDepTermTime').val();-->
                                            <!--                                                            $.ajax({-->
                                            <!--                                                                url: "ajax_post/ftdPreview.php",-->
                                            <!--                                                                method: "POST",-->
                                            <!--                                                                data: {-->
                                            <!--                                                                    longName: longName,-->
                                            <!--                                                                    shortName: shortName,-->
                                            <!--                                                                    description: description,-->
                                            <!--                                                                    currency: currency,-->
                                            <!--                                                                    depositDefault: depositDefault,-->
                                            <!--                                                                    depositMin: depositMin,-->
                                            <!--                                                                    depositMax: depositMax,-->
                                            <!--                                                                    interestRateDefault: interestRateDefault,-->
                                            <!--                                                                    interestRateMin: interestRateMin,-->
                                            <!--                                                                    interestRateMax: interestRateMax,-->
                                            <!--                                                                    compoundPeriod: compoundPeriod,-->
                                            <!--                                                                    intCalType: intCalType,-->
                                            <!--                                                                    intCalDays: intCalDays,-->
                                            <!--                                                                    lockPerFreq: lockPerFreq,-->
                                            <!--                                                                    lockPerFreqTime: lockPerFreqTime,-->
                                            <!--                                                                    minimumDepTerm: minimumDepTerm,-->
                                            <!--                                                                    minimumDepTermTime: minimumDepTermTime,-->
                                            <!--                                                                    autoRenew: autoRenew,-->
                                            <!--                                                                    maximumDepTerm: maximumDepTerm,-->
                                            <!--                                                                    maximumDepTermTime: maximumDepTermTime,-->
                                            <!--                                                                    prematureClosingPenalty: prematureClosingPenalty,-->
                                            <!--                                                                    glCode: glCode,-->
                                            <!--                                                                    inMultiplesDepTerm: inMultiplesDepTerm,-->
                                            <!--                                                                    inMultiplesDepTermTime: inMultiplesDepTermTime-->
                                            <!--                                                                },-->
                                            <!--                                                                success: function (data) {-->
                                            <!--                                                                    $('#showPreview').html(data);-->
                                            <!--                                                                }-->
                                            <!--                                                            })-->
                                            <!--                                                        });-->
                                            <!--                                                    })-->
                                            <!--                                                </script>-->
                                            <!--                                                <div id="showPreview">-->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->
                                            <!-- third Tab -->

                                        </div>
                                        <!-- Buttons -->
                                        <div style="overflow:auto;">
                                            <div style="float:right;">
                                                <button class="btn btn-primary pull-right" type="button" id="nextBtn"
                                                        onclick="nextPrev(1)">Next
                                                </button>
                                                <button class="btn btn-primary pull-right" type="button" id="prevBtn"
                                                        onclick="nextPrev(-1)">Previous
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Steppers -->
                                        <!-- Circles which indicates the steps of the form: -->
                                        <div style="text-align:center;margin-top:40px;">
                                            <span class="step"></span>
                                            <span class="step"></span>
                                            <!--                                            <span class="step"></span>-->
                                            <!--                    <span class="step"></span>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /col-12 -->
        </div>
        <!-- /content -->
    </div>
    </div>
    <!-- make something cool here -->
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f1f1f1;
        }

        /* #regForm {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 70%;
        min-width: 300px;
      } */

        h1 {
            text-align: center;
        }

        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        button {
            background-color: #a13cb6;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #9e38b5;
        }
    </style>
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Create";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("form").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = true; // This was change to true to disable the validation function. Should be reverted to FALSE after testing is complete
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
<?php

include("footer.php");

?>