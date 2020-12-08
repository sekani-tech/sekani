<?php

$page_title = "Group Loan";
$destination = "transaction.php";
include("header.php");
?>
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

                        <div class="row">
                            <div class="col-md-6">
                                <label class="bmd-label-floating">Group Names *:</label>
                                <select name="client_id" class="form-control" id="">
                                    <option value="">select an option</option>

                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="bmd-label-floating">Product *:</label>
                                <select name="product_id" class="form-control" id="">
                                    <option value="">select an option</option>

                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">

                                <div style="float:right;">
                                    <button class="btn btn-primary pull-right" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                </div>

                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="javascript:;" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="javascript:;">1</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:;">2 </a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:;">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:;">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>



                    </div>

                </div>
                <!-- Disbure Loan Card Begins -->

            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <!-- LOAN REQUEST FORM CARD BEGINS -->
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-primary">Loan Request Form</h4>
                    <div class="card-body">

                        <div class="col-md-12" id="show_product">
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
                                                    <label>(Min Loan Amt *: N500000.00)</label>
                                                    <label>(Max Loan Amt *: N10000000.00)</label>
                                                    <input type="number" hidden="" readonly="" value="10000000.00" name="max_principal_amount" class="form-control" required="" id="maximum_Lamount">
                                                    <input type="number" hidden="" readonly="" value="500000.00" name="min_principal_amount" class="form-control" required="" id="minimum_Lamount">
                                                </div>
                                            </div>
                                            <div id="verifyl"></div>
                                            <input type="number" value="" step=".01" name="principal_amount" class="form-control invalid" required="" id="principal_amount">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Loan Term *:</label>
                                                    <input type="number" step=".01" value="1" name="loan_term" class="form-control" id="loan_term">
                                                    <input type="text" hidden="" value="0" id="grace_prin">
                                                </div>
                                                <div class="col-md-5">
                                                    <label> </label>
                                                    <select id="repay" name="repay_eve" class="form-control">
                                                        <option hidden="" value="month">month</option>
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
                                                    <label>Min Interest Allowed *: 5.00%</label>
                                                    <label>Max Interest Allowed *: 10.00%</label>
                                                    <input type="number" hidden="" readonly="" value="10.00" name="max_interest_rate" class="form-control" required="" id="maximum_intrate">
                                                    <input type="number" hidden="" readonly="" value="5.00" name="min_interest_rate" class="form-control" required="" id="minimum_intrate">
                                                </div>
                                            </div>
                                            <div id="verifyi"></div>
                                            <input type="number" step="1" value="5.00" name="interest_rate" class="form-control" id="interest_rate">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label>Repayment Every:</label>
                                                    <input type="number" value="1" name="repay_every_no" class="form-control id=" rapno"="">
                                                </div>
                                                <div class="col-md-5">
                                                    <label> </label><br>
                                                    <label> </label><br>
                                                    <div id="change_term"><label>Time(s) Per Month</label></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Disbursement Date *:</label>
                                            <input type="date" name="disbursement_date" class="form-control invalid" id="disb_date">
                                        </div>
                                    </div>
                                    <div id="rep_start" class="col-md-4">
                                        <div class="form-group">
                                            <label>Repayment Start Date:</label>
                                            <input type="date" name="repay_start" class="form-control invalid" id="repay_start">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Account Officer:</label>
                                            <select type="text" value="" name="loan_officer" class="form-control" id="lof">
                                                <option value="2">Mosi Akande</option>
                                                <option value="5">Favour Umogbai</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Loan Purpose:</label>
                                            <input type="text" value="" name="loan_purpose" class="form-control invalid" id="lop">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Linked Savings account:</label>
                                            <select name="linked_savings_acct" class="form-control" id="lsaa">
                                                <option value="954">0010004976 - Current Account</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Loan Sector:</label>
                                            <select name="loan_sector" class="form-control">
                                                <option value="0">Select loan sector</option>
                                                <option value="1">Agriculture, Mining &amp; Quarry</option>
                                                <option value="2">Manufacturing</option>
                                                <option value="3">Agricultural sector</option>
                                                <option value="4">Banking</option>
                                                <option value="5">Public Service</option>
                                                <option value="6">Health</option>
                                                <option value="7">Education</option>
                                                <option value="8">Tourism</option>
                                                <option value="9">Civil Service</option>
                                                <option value="10">Trade &amp; Commerce</option>
                                                <option value="11">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" hidden="">
                                        <div class="form-group">
                                            <label>Fund Source:</label>
                                            <select name="fund_source" class="form-control">
                                                <option value="1">Cash</option>
                                                <option value="2">First Bank</option>
                                                <option value="3">UBA</option>
                                                <option value="4">Access Bank</option>
                                                <option value="5">Fidelity Bank</option>
                                                <option value="6">FCMB</option>
                                                <option value="17">DG Wallet</option>
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
                                            <input type="text" value="0" name="" readonly="" class="form-control" id="lop">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- LOAN REQUEST FORM CARD ENDS -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <!-- GROUP MEMBERS CARD BEGINS -->
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-primary">Group Members Section</h4>
                    <div class="card-body">

                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Account Number</th>
                                    <th>Account Officer</th>
                                    <th>Total Amount Disbursed = <b>N300, 000</b> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>


                                    <td>MICHEAL OLALERE </td>
                                    <td>0012345678</td>
                                    <td>FATIMA BINTA</td>
                                    <td><input type="number" class="form-control" placeholder="Enter Amount"></td>
                                </tr>


                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- GROUP MEMBERS CARD ENDS -->

            </div>

        </div>

        <div class="row">
            <div class="col-md-12">

                <!-- CHARGES CARD BEGINS  -->
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-primary">Charges Section</h4>
                    <div class="card-body">

                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Charge</th>
                                    <th>Amount</th>
                                    <th>Collected On</th>
                                    <th>Delete</th>
                                    <!-- <th>Date</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>


                                    <td>Credit Reference Search</td>
                                    <td><b>N1,000.00 Flat</b></td>
                                    <td><b>N1,000.00</b></td>
                                    <td>Disbursement</td>
                                    <td>
                                        <div class="test" data-id="12076">
                                            <span class="btn btn-danger">Delete</span>
                                        </div>
                                    </td>
                                </tr>


                                <td>Loan Application Foam </td>
                                <td><b>3,000.00 Flat</b></td>
                                <td><b>3,000.00 Flat</b></td>
                                <td>Disbursement</td>
                                <td>
                                    <div class="test" data-id="12242">
                                        <span class="btn btn-danger">Delete</span>
                                    </div>
                                </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- CHARGES CARD ENDS  -->

            </div>

        </div>


        <div class="row">
            <div class="col-md-12">

                <!-- COLLATERAL CARD BEGINS -->
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-primary">Collateral Section</h4>
                    <div class="card-body">

                        <h3> Collateral:</h3>
                        <!-- Button trigger modal -->
                        <button style="margin-bottom: 20px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Add
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel">Add Collateral</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h3></h3>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating" for=""> Name:</label>
                                                <input type="text" name="col_name" id="colname" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating" for="">Value(₦):</label>
                                                <input type="number" name="col_value" id="col_val" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="bmd-label-floating" for="">Description:</label>
                                                <input type="text" name="col_description" id="col_descr" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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


                                            <td>Loan Application Foam </td>
                                            <td><b>N3,000.00</b></td>
                                            <td>SIGNED FIDELITY BANK CHEQUE</td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>

                </div>
                <!-- COLLATERAL CARD ENDS -->


            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <!-- GUARANTORS CARD BEGINS -->
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-primary">Guarantors Section</h4>
                    <div class="card-body">

                        <h3> Guarantors:</h3>
                        <!-- Button trigger modal -->
                        <button style="margin-bottom: 20px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">
                            Add
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel">Add Guarantor</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                        <input type="text" name="gau_first_name" id="gau_first_name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating" for=""> Last
                                                            Name:</label>
                                                        <input type="text" name="gau_last_name" id="gau_last_name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating" for="">Phone:</label>
                                                        <input type="text" name="gau_phone" id="gau_phone" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating" for="">Phone
                                                            2:</label>
                                                        <input type="text" name="gau_phone2" id="gau_phone2" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating" for="">Home
                                                            Address:</label>
                                                        <input type="text" name="home_address" id="home_address" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating" for="">Office
                                                            Address:</label>
                                                        <input type="text" name="office_address" id="office_address" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="bmd-label-floating">Email:</label>
                                                        <input type="text" name="gau_email" id="gau_email" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>


                                            <td>Godwin Edim </td>
                                            <td>08135991031</td>
                                            <td>godwin@gmail.com</td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- GUARANTORS CARD BEGINS -->

            </div>
        </div>


        <div class="row">

            <div class="col-md-12">

                <!-- KYC CARD BEGINS -->
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-primary">KYC Section</h4>
                    <div class="card-body">

                        <div class="tab" style="display: block;">
                            <h3>KYC:</h3>
                            <p>Personal Information</p>
                            <br>
                            <div class="row">
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Marital Status:</label>
                                    <select class="form-control" name="marital_status">
                                        <option value="1">Single</option>
                                        <option value="2">Married</option>
                                    </select>
                                </div>
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Number of
                                        Dependants/Children:</label>
                                    <select class="form-control" name="no_of_dep">
                                        <option value="0">Non</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7 or More</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <p>Education and Employment</p>
                            <br>
                            <div class="row">
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Level of Education</label>
                                    <select class="form-control" name="ed_level">
                                        <option value="Unknown">Non/ Unknown</option>
                                        <option value="Secondary School">Secondary School</option>
                                        <option value="College">College</option>
                                        <option value="BSc">Bachelors (Bsc)</option>
                                        <option value="Masters">Masters (Msc)</option>
                                        <option value="PhD">Phd</option>
                                    </select>
                                </div>
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Employment Status</label>
                                    <select class="form-control" name="emp_stat">
                                        <option value="1">Self-Employed</option>
                                        <option value="2">Employed</option>
                                        <option value="3">Not Working</option>
                                    </select>
                                </div>
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Employment
                                        Category/Instiution</label>
                                    <select class="form-control" name="emp_category">
                                        <option value="FEDERAL">FEDERAL</option>
                                        <option value="STATE">STATE</option>
                                        <option value="FINANCIAL INSTITUTION/INSURANCE">FINANCIAL
                                            INSTITUTION/INSURANCE
                                        </option>
                                        <option value="GENERAL">GENERAL</option>
                                        <option value="MANUFACTURING">MANUFACTURING</option>
                                        <option value="INFORMATION AND COMMUNICATION">INFORMATION AND
                                            COMMUNICATION
                                        </option>
                                        <option value="OIL AND GAS">OIL AND GAS</option>
                                        <option value="OTHER">OTHER</option>
                                    </select>
                                </div>
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Employer/Business name</label>
                                    <input type="text" value="" name="emp_bus_name" class="form-control invalid">
                                </div>
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Monthly Income(₦):</label>
                                    <input type="number" value="" name="income" class="form-control invalid" required="">
                                </div>
                                <!-- new -->
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Years in current
                                        Job/Business:</label>
                                    <!-- <input type="number" value="" name="" class="form-control" required> -->
                                    <select class="form-control" name="years_in_job">
                                        <option value="1">1 - 2 years</option>
                                        <option value="3">3 - 4 years</option>
                                        <option value="5">4 - 5 years</option>
                                        <option value="6">5 - 6 years</option>
                                        <option value="7">6 - 7 years</option>
                                        <option value="8">7 - 8 years</option>
                                        <option value="9">8 - 9 years</option>
                                        <option value="10">9 - 10 years</option>
                                        <option value="12">11 - 12 years</option>
                                        <option value="14">13 - 14 years</option>
                                        <option value="15">14 - 15 years</option>
                                        <option value="17">16 - 17 years</option>
                                        <option value="19">18 - 19 years</option>
                                        <option value="9">20 OR MORE</option>
                                    </select>
                                </div>
                                <!-- new for years -->
                            </div>
                            <br>
                            <p>Address Details</p>
                            <br>
                            <div class="row">
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Residence Type:</label>
                                    <!-- <input type="number" readonly value="" name="res_type" class="form-control" required> -->
                                    <select class="form-control" name="res_type">
                                        <option value="1">Rented</option>
                                        <option value="2">Owner</option>
                                    </select>
                                </div>
                                <!-- damn -->
                                <!-- <div id="rent"> -->
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Rent per Year (if rented):</label>
                                    <input type="number" value="" name="rent_per_year" class="form-control invalid">
                                </div>
                                <!-- </div> -->
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">How long have you lived
                                        there?:</label>
                                    <!-- <input type="number" readonly value="" name="principal_amount" class="form-control" required> -->
                                    <select class="form-control" name="years_in_res">
                                        <option value="1">1 - 3 years</option>
                                        <option value="2">3 - 5 years</option>
                                        <option value="3">5 - 10 years</option>
                                        <option value="4">10 - 20 years</option>
                                        <option value="5">More than 20 years</option>
                                    </select>
                                </div>
                                <!-- THE BANK -->
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Other Bank</label>
                                    <!-- <input type="number" readonly value="" name="principal_amount" class="form-control" required> -->
                                    <select class="form-control" name="other_banks">
                                        <option value="GUARANTY TRUST BANK">GUARANTY TRUST BANK</option>
                                        <option value="FIRST CITY MONUMENT BANK">FIRST CITY MONUMENT
                                            BANK
                                        </option>
                                        <option value="FIRST BANK">FIRST BANK</option>
                                        <option value="UNION BANK">UNION BANK</option>
                                        <option value="UNITED BANK FOR AFRICA">UNITED BANK FOR AFRICA
                                        </option>
                                        <option value="SKYE BANK">SKYE BANK</option>
                                        <option value="STANBIC IBTC">STANBIC IBTC</option>
                                        <option value="ACCESS BANK">ACCESS BANK</option>
                                        <option value="ECOBANK">ECOBANK</option>
                                        <option value="Other">OTHERs</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <!-- KYC CARD BEGINS -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- REPAYMENT CARD BEGINS -->
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-primary">Repayment Schedule Section</h4>
                    <div class="card-body">

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
                </div>
                <!-- REPAYMENT CARD ENDS -->
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">

                <!-- LOAN OVERVIEW CARD BEGINS -->
                <div class="card card-nav-tabs">
                    <h4 class="card-header card-header-primary">Loan Overview Section</h4>
                    <div class="card-body">
                        <div class="tab" style="display: block;">
                            <h3> Overview:</h3>
                            <div class="row">
                                <!-- <div class="my-3"> -->
                                <!-- replace values with loan data -->
                                <div class=" col-md-6 form-group">
                                    <label class="bmd-label-floating">Loan size:</label>
                                    <input type="number" readonly="" value="" name="principal_amount" class="form-control" required="" id="ls">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="bmd-label-floating">Loan Term:</label>
                                    <input readonly="" type="number" id="lt" name="loan_term" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="bmd-label-floating">Interest Rate per:</label>
                                    <input readonly="" type="text" value="" name="repay_every" class="form-control" id="irp">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="bmd-label-floating">Interest Rate:</label>
                                    <input readonly="" type="text" name="interest_rate" class="form-control" id="ir">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="bmd-label-floating">Disbusrsement Date:</label>
                                    <input readonly="" type="date" name="disbursement_date" class="form-control" id="db">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="bmd-label-floating">Loan Officer:</label>
                                    <input readonly="" type="text" name="loan_officer" class="form-control" id="lo">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="bmd-label-floating">Loan Purpose:</label>
                                    <input readonly="" type="text" name="loan_purpose" class="form-control" id="lp">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="bmd-label-floating">Linked Savings account:</label>
                                    <input readonly="" type="text" name="linked_savings_acct" class="form-control" id="lsa">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="bmd-label-floating">Repayment Start Date:</label>
                                    <input readonly="" type="date" name="repay" class="form-control" id="rsd">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- LOAN OVERVIEW CARD BEGINS -->
            </div>
        </div>

    </div>
</div>

</div>
</div>
<?php

include("footer.php");

?>