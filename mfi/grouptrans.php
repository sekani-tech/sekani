<?php

$page_title = "Group Posting";
$destination = "index.php";
include("header.php");
$b_id = $_SESSION['branch_id'];

function branch_option($connection)
{
    $br_id = $_SESSION["branch_id"];
    $sint_id = $_SESSION["int_id"];
    $fod = "SELECT * FROM branch WHERE int_id = '$sint_id' AND parent_id='$br_id' || id = '$br_id'";
    $dof = mysqli_query($connection, $fod);
    $out = '';
    while ($row = mysqli_fetch_array($dof)) {
        $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
    }
    return $out;
}

?>
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
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Group transactions</h4>
                            <p class="card-category">Fill in all important data</p>
                        </div>
                        <div class="card-body">
                            <form id="form" action="../functions/group_tran.php" method="POST" autocomplete="off">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!-- Group info _ Tab1 -->
                                            <div class="tab"><h3>Choose Type of Group Posting:</h3>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5 class="card-title">Accounting Rules</h5>
                                                        <div class="position-relative form-group ">
                                                            <div>
                                                                <div class="custom-radio custom-control">
                                                                    <input type="radio" id="collct" name="acc" value="deposit"
                                                                           class="custom-control-input">
                                                                    <label class="custom-control-label" for="collct">Collect
                                                                        Payment</label>
                                                                </div>
<!--                                                                <div class="custom-radio custom-control">-->
<!--                                                                    <input type="radio" id="perfwith" name="acc"-->
<!--                                                                           value="withdraw" class="custom-control-input">-->
<!--                                                                    <label class="custom-control-label" for="perfwith">Perform-->
<!--                                                                        Withdrawal</label>-->
<!--                                                                </div>-->
                                                                <input type="hidden"
                                                                       value="<?php echo $_SESSION["int_id"]; ?>"
                                                                       name="intID">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-12">
                                                        <label for="">Select Group</label>
                                                        <div id="acWrapXXX" class="acWrap">
                                                            <input type="text" name="pay_type" class="form-control groups" id="groups">
                                                            <div id="acBoxXXX" class="acBox">
                                                                <div>Option A</div>
                                                                <div>Option B</div>
                                                                <div>Option C</div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <script>
                                                        $(document).ready(function () {
                                                            $('#collct').on("change keyup paste", function () {
                                                                var id = $(this).val();
                                                                var perf = $('#perfwith').val();
                                                                var fetchoff = $('#fetcpostloanoff').val();
                                                                var fetchgroup = $('#fetcpostgroup').val();
                                                                $.ajax({
                                                                    url: "group_name.php",
                                                                    method: "POST",
                                                                    data: {
                                                                        id: id,
                                                                        perf: perf,
                                                                        fetchoff: fetchoff,
                                                                        fetchgroup: fetchgroup
                                                                    },
                                                                    success: function (data) {
                                                                        $('#post').html(data);
                                                                    }
                                                                })
                                                            });
                                                        });

                                                        $(document).ready(function () {
                                                            $('#perfwith').on("change keyup paste", function () {
                                                                var perf = $('#collct').val();
                                                                var id = $(this).val();
                                                                var fetchoff = $('#fetcpostloanoff').val();
                                                                var fetchgroup = $('#fetcpostgroup').val();
                                                                $.ajax({
                                                                    url: "group_name.php",
                                                                    method: "POST",
                                                                    data: {
                                                                        id: id,
                                                                        perf: perf,
                                                                        fetchoff: fetchoff,
                                                                        fetchgroup: fetchgroup
                                                                    },
                                                                    success: function (data) {
                                                                        $('#post').html(data);
                                                                    }
                                                                })
                                                            });
                                                        });


                                                    </script>
                                                    <div class="col-md-12">
                                                        <p></p>
                                                        <p></p>
                                                        <p></p>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <p></p>
                                                    </div>
<!--                                                    <div class="col-md-6">-->
<!--                                                        <div class="custom-radio custom-control">-->
<!--                                                            <input type="radio" id="fetcpostloanoff" name="fech_post"-->
<!--                                                                   class="custom-control-input">-->
<!--                                                            <label class="custom-control-label" for="fetcpostloanoff">Fetch-->
<!--                                                                Posting by loan officer</label>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <div class="col-md-6">-->
<!--                                                        <div class="custom-radio custom-control">-->
<!--                                                            <input type="radio" id="fetcpostgroup" name="fech_post"-->
<!--                                                                   class="custom-control-input">-->
<!--                                                            <label class="custom-control-label" for="fetcpostgroup">Fetch-->
<!--                                                                posting by group</label>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
                                                    <div id="post" class="col-md-12">

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- group payment -->
                                            <div class="tab">
                                                <h3> Collect Payments:</h3>
                                                <div>
                                                    <table class="table table-bordered hover">
                                                        <thead>
                                                        <tr>
                                                            <td colspan="5">Total</td>
                                                            <td><input type="number" readonly name="total"
                                                                       class="grand_total"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Client Name</th>
                                                            <th>Choose Account</th>
                                                            <th>Balance Derived</th>
                                                            <th>Total Expected Repayment</th>
                                                            <th>Total Deposit</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="grlist">
                                                        <!-- insert td in list -->
                                                        </tbody>
                                                        <script>
//                                                            this function totals the input field as it's been added
                                                            $(document).ready(function () {
                                                                $("body").on("keyup", "input", function (event) {
                                                                    $(this).closest(".line").find(".total_price").val($(this).closest(".line").val() * 1 - $(this).closest(".line").val());
                                                                    var sum = 0;
                                                                    $('.total_price').each(function () {
                                                                        sum += Number($(this).val());
                                                                    });
                                                                    $(".grand_total").val(sum);
                                                                });
                                                            });
                                                        </script>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Buttons -->
                                            <div style="overflow:auto;">
                                                <div style="float:right;">
                                                    <button class="btn btn-primary pull-right" type="button"
                                                            id="prevBtn" onclick="nextPrev(-1)">Previous
                                                    </button>
                                                    <button class="btn btn-primary pull-right" type="button"
                                                            id="nextBtn" onclick="nextPrev(1)">Next
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Steppers -->
                                            <!-- Circles which indicates the steps of the form: -->
                                            <div style="text-align:center;margin-top:40px;">
                                                <span class="step"></span>
                                                <span class="step"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <!-- /stepper  -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /content -->
    </div>
    </div>

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
                document.getElementById("nextBtn").innerHTML = "Submit";
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
                    valid = true;
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