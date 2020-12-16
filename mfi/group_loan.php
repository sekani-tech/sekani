<?php

$page_title = "Group Loan";
$destination = "transaction.php";
include("header.php");
$groups = selectAll('groups');
$products = selectAll('product');

// Function for charges
function fill_charges($connection)
{
    $sint_id = $_SESSION["int_id"];
    return selectAll('charge', ['int_id' => $sint_id]);
}

$digit = 6;
try {
    $randomNumber = str_pad(random_int(0, (10 ** $digit) - 1), $digit, '0', STR_PAD_LEFT);
} catch (Exception $e) {
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

        #backg {
            display: none;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0px;
            left: 0px;
            background-color: black;
            opacity: 0.7;
            z-index: 9999;
        }

        #dlbox {
            /*initially dialog box is hidden*/
            display: none;
            position: fixed;
            width: 480px;
            z-index: 9999;
            border-radius: 10px;
            padding: 20px;
            background-color: #ffffff;
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

        #background {
            display: none;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0px;
            left: 0px;
            background-color: black;
            opacity: 0.7;
            z-index: 9999;
        }

        #diallbox {
            /*initially dialog box is hidden*/
            display: none;
            position: fixed;
            width: 480px;
            z-index: 9999;
            border-radius: 10px;
            padding: 20px;
            background-color: #ffffff;
        }
    </style>
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">

                    <!-- Disbure Loan Card Begins -->
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Disburse Group Loan</h4>
                            <p class="card-category">Fill in all important data</p>
                        </div>

                        <div class="card-body">
                            <form id="form" action="" method="post">
                                <div class="form-group">
                                    <!-- Loan term -->
                                    <script>
                                        // page scripts
                                        $(document).ready(function () {
                                            $('#charges').change(function () {
                                                var id = $(this).val();
                                                var group_id = $('#group_id').val();
                                                var sint_id = $('#sint_id').val();
                                                var rando = $('#random').val();
                                                $.ajax({
                                                    url: "load_data_lend.php",
                                                    method: "POST",
                                                    data: {id: id, group_id: group_id, sint_id: sint_id},
                                                    success: function (data) {
                                                        $('#show_product').html(data);
                                                    }
                                                })
                                                $.ajax({
                                                    url: "ajax_post/lend_charge.php",
                                                    method: "POST",
                                                    data: {id: id, rando: rando, group_id: group_id},
                                                    success: function (data) {
                                                        $('#lend_charge').html(data);
                                                    }
                                                })
                                            });
                                        })
                                    </script>
                                    <div class="tab">
                                        <h3>Term:</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="bmd-label-floating">Group Names *:</label>
                                                <select name="group_id" class="form-control" id="group_id">
                                                    <option value="">select an option</option>
                                                    <?php foreach ($groups as $group) { ?>
                                                        <option value="<?php echo $group['id'] ?>"><?php echo $group['g_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="bmd-label-floating">Product *:</label>
                                                <select name="product_id" class="form-control" id="charges">
                                                    <option value="">select an option</option>
                                                    <?php foreach ($products as $product) { ?>
                                                        <option value="<?php echo $product['id'] ?>"><?php echo $product['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <input hidden type="text" id="random"
                                                       value="<?php echo $randomNumber; ?>"/>
                                                <input hidden type="text" id="sint_id"
                                                       value="<?php echo $_SESSION['int_id']; ?>"/>
                                            </div>
                                            <div class="col-md-12" id="show_product"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Members of the group tab -->
                                <div class="tab">
                                    <h3>Group Members:</h3>
                                    <table class="table table-bordered">

                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Client Name</th>
                                            <th>Account Number</th>
                                            <th> Current Balance</th>
                                            <th>Total Amount Disbursed = <input type="text" readonly name="total"
                                                                                class="grand_total"/></th>
                                        </tr>
                                        </thead>
                                        <tbody id="showGroup">

                                        </tbody>
                                    </table>
                                </div>
                                <!-- members end here -->

                                <!-- Charges -->
                                <div class="tab">
                                    <h3>Charges:</h3>
                                    <div id="lend_charge"></div>
                                </div>

                                <!-- Collateral -->
                                <div class="tab">
                                    <h3> Collateral:</h3>
                                    <!-- Button trigger modal -->
                                    <button style="margin-bottom: 20px;" type="button" class="btn btn-primary"
                                            data-toggle="modal" data-target="#exampleModal">
                                        Add
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">Add Collateral</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h3></h3>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating" for=""> Name:</label>
                                                            <input type="text" name="col_name" id="colname"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating" for="">Value(₦):</label>
                                                            <input type="number" name="col_value" id="col_val"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating"
                                                                   for="">Description:</label>
                                                            <input type="text" name="col_description" id="col_descr"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    <button type="button" class="btn btn-primary">Add</button>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">

                                                <thead>
                                                <tr>
                                                    <th>Name/Type</th>
                                                    <th>Value</th>
                                                    <th>Description</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>


                                                    <td>Loan Application Foam</td>
                                                    <td><b>N3,000.00</b></td>
                                                    <td>SIGNED FIDELITY BANK CHEQUE</td>
                                                </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Collateral ends here -->

                                <!-- Guarantor begins -->
                                <div class="tab">
                                    <h3> Guarantors:</h3>
                                    <!-- Button trigger modal -->
                                    <button style="margin-bottom: 20px;" type="button" class="btn btn-primary"
                                            data-toggle="modal" data-target="#exampleModal1">
                                        Add
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">Add Guarantor</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="dlbox" style="display: block; left: 528px; top: 150px;">

                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating" for=""> First
                                                                        Name:</label>
                                                                    <input type="text" name="gau_first_name"
                                                                           id="gau_first_name" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating" for=""> Last
                                                                        Name:</label>
                                                                    <input type="text" name="gau_last_name"
                                                                           id="gau_last_name" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating"
                                                                           for="">Phone:</label>
                                                                    <input type="text" name="gau_phone" id="gau_phone"
                                                                           class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating" for="">Phone
                                                                        2:</label>
                                                                    <input type="text" name="gau_phone2" id="gau_phone2"
                                                                           class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating" for="">Home
                                                                        Address:</label>
                                                                    <input type="text" name="home_address"
                                                                           id="home_address" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating" for="">Office
                                                                        Address:</label>
                                                                    <input type="text" name="office_address"
                                                                           id="office_address" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating">Email:</label>
                                                                    <input type="text" name="gau_email" id="gau_email"
                                                                           class="form-control">
                                                                </div>
                                                            </div>
                                                            <!-- Who the Guarantor is guaranting  -->
                                                            <!-- should be a select option of all the members in the group -->
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="bmd-label-floating">Guarantee:</label>
                                                                    <input type="text" name="gau_pe" id="gau_pe"
                                                                           class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    <button type="button" class="btn btn-primary">Add</button>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">

                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Guarantor Phone Number</th>
                                                    <th>Email</th>
                                                    <th>Gaurantee</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>


                                                    <td>Godwin Edim</td>
                                                    <td>08135991031</td>
                                                    <td>godwin@gmail.com</td>
                                                    <td>Gaurantee</td>
                                                </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- guarantor ends here -->

                                <!-- Schedule Section -->
                                <div class="tab">
                                    <h3>Schedule:</h3>
                                    <div class="col-md-12">
                                        <table class="table table-bordered">

                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Months</th>
                                                <th>Paid By</th>
                                                <th>Disbursement</th>
                                                <th>Principal Due</th>
                                                <th>Principal Balance</th>
                                                <th>Interest Due</th>
                                                <th>Fees</th>
                                                <th>Penaties</th>
                                                <th>Total Due</th>
                                                <th>Total Paid</th>
                                                <th>Total Outstanding</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tfoot>
                                            <tr>
                                                <td><b></b></td>
                                                <td><b>Total</b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                                <td><b></b></td>
                                            </tr>
                                            </tfoot>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- ends here -->

                                <!-- overview -->
                                <div class="tab">
                                    <h3> Overview:</h3>
                                    <div class="row">
                                        <!-- <div class="my-3"> -->
                                        <!-- replace values with loan data -->
                                        <div class=" col-md-6 form-group">
                                            <label class="bmd-label-floating">Loan size:</label>
                                            <input type="number" readonly="" value="" name="principal_amount"
                                                   class="form-control" required="" id="ls">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="bmd-label-floating">Loan Term:</label>
                                            <input readonly="" type="number" id="lt" name="loan_term"
                                                   class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="bmd-label-floating">Interest Rate per:</label>
                                            <input readonly="" type="text" value="" name="repay_every"
                                                   class="form-control" id="irp">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="bmd-label-floating">Interest Rate:</label>
                                            <input readonly="" type="text" name="interest_rate" class="form-control"
                                                   id="ir">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="bmd-label-floating">Disbusrsement Date:</label>
                                            <input readonly="" type="date" name="disbursement_date" class="form-control"
                                                   id="db">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="bmd-label-floating">Loan Officer:</label>
                                            <input readonly="" type="text" name="loan_officer" class="form-control"
                                                   id="lo">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="bmd-label-floating">Loan Purpose:</label>
                                            <input readonly="" type="text" name="loan_purpose" class="form-control"
                                                   id="lp">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="bmd-label-floating">Linked Savings account:</label>
                                            <input readonly="" type="text" name="linked_savings_acct"
                                                   class="form-control" id="lsa">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="bmd-label-floating">Repayment Start Date:</label>
                                            <input readonly="" type="date" name="repay" class="form-control" id="rsd">
                                        </div>
                                    </div>
                                </div>
                                <!-- Overview ends here -->


                                <!-- Page Steppers -->
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
                                    <!-- <span class="step"></span> -->
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>
                                </div>
                        </div>
                        </form>
                    </div>

                </div>
                <!-- Disbure Loan Card Begins -->

            </div>
        </div>

    </div>
    </div>

    </div>
    </div>


    <!-- steppers script -->
    <script>
        // page scripts
        $(document).ready(function () {
            $('#charges').change(function () {
                var id = $(this).val();
                var group_id = $('#group_id').val();
                var sint_id = $('#sint_id').val();
                var rando = $('#random').val();
                $.ajax({
                    url: "load_data_lend.php",
                    method: "POST",
                    data: {id: id, group_id: group_id, sint_id: sint_id, rando: rando},
                    success: function (data) {
                        $('#show_product').html(data);
                    }
                })
                $.ajax({
                    url: "ajax_post/lend_charge.php",
                    method: "POST",
                    data: {id: id, rando: rando, group_id: group_id},
                    success: function (data) {
                        $('#lend_charge').html(data);
                    }
                })
            });
        })

        // Group list
        $(document).ready(function () {
            $('#group_id').on("change keyup paste", function () {
                var id = $(this).val();
                var groupDis = "groups";
                $.ajax({
                    url: "ajax_post/group_paylist.php",
                    method: "POST",
                    data: {id: id, groupDis: groupDis},
                    success: function (data) {
                        $('#showGroup').html(data);
                    }
                })
            });
        });


        //  this function totals the input field as it's been added
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