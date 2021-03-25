<?php

$page_title = "Shares Booking";
$destination = "";
include("header.php");
?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Shares Booking</h4>
                        <p class="category">Fill in all important data</p>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div style="margin-bottom: 30px;" class="row">
                                    <div class="col-md-4">
                                        <label class="bmd-label-floating">Shares Product:</label>
                                        <select name="s_product" id="sav_prod_id" class="form-control">
                                            <option value="">select an option</option>
                                           
                                            <option value="39">DG Executive FTD</option>
                                            <option value="40">DG Executive FTD</option>
                                            <option value="0"></option>
                                            <option value="0">Sekani</option>
                                            <option value="0">Sekani</option>
                                            <option value="0">Sekani</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="bmd-label-floating">Client Account No*:</label>
                                        <select name="client" class="form-control" id="collat">
                                            <option value="">select an option</option>
                                           
                                            <option value="1725">FAVOUR UMOGBAI</option>
                                            <option value="1724">OLUFUNKE TEMITOPE ADETUNJI</option>
                                        </select>
                                    </div>
                                </div>

                               
                                <div class="row" id="ddjf"><br>
                                   

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Deposit Amount (min: 100,000 | max: 1,000,000)</label>
                                            <div id="verrify"></div>
                                            <input type="number" id="dep" value="100000" class="form-control" name="amount">
                                            <input type="number" id="min" hidden="" value="100000" class="form-control" name="">
                                            <input type="number" id="max" hidden="" value="1000000" class="form-control" name="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Shares Number</label>
                                            <input type="text" readonly="" value="FTD/TEST/001/02022021" class="form-control" name="ftd_no">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Value Date</label>
                                            <input type="date" id="repay" class="form-control" name="date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Linked Savings account:</label>
                                            <select name="linked_savings_acct" class="form-control" id="lsaa">
                                                <option value="986">0200004085 - SAVINGS ACCOUNT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Account Officer:</label>
                                            <select name="acc_off" class="form-control" id="lsaa">
                                                <option value="105">FUNKE</option>
                                                <option value="104">Jamogha</option>
                                                <option value="106">PHILIP</option>
                                            </select>
                                        </div>
                                    </div>                                  
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Book Share</button>
                            </form>
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