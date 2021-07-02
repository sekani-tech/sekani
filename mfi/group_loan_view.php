<?php
$page_title = "Group Loan View";
include('header.php');
?>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Group Loan Approval - Summary</h4>
                        <p class="card-category">Make sure everything is in order</p>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Group Name:</label>
                                        <input type="text" class="form-control" name="name" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Group Account Number</label>
                                        <input type="text" class="form-control" name="phone" value="" readonly="">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Account Officer</label>
                                        <input type="text" class="form-control" name="phone" value="" readonly="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <h4 style="text-align: center; margin-top: 10px; margin-bottom: 10px ">Group Members</h4>
                                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <th>Account Type</th>
                                                    <th>Account Number</th>
                                                    <th>Allocated Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>Saving Account</td>
                                                    <td>0012376345</td>
                                                    <td><input type="text" class="form-control" name="" value="" readonly=""></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Posted By</label>
                                        <input type="text" class="form-control" name="email" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Branch</label>
                                        <input type="text" class="form-control" name="branch" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Loan Product</label>
                                        <input type="text" class="form-control" name="phone" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Loan Sector</label>
                                        <input type="text" class="form-control" name="phone" value="" readonly="">
                                    </div>
                                </div>


                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Principal Amount</label>
                                        <input type="text" class="form-control" name="location" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Interest (%)</label>
                                        <input type="text" class="form-control" name="phone" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Loan Term</label>
                                        <input type="text" class="form-control" name="transidddd" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Disbursement Date</label>
                                        <input type="text" class="form-control" name="transidddd" value="" readonly="">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Total Interest </label>
                                        <input type="text" class="form-control" name="phone" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Total Repayment Due </label>
                                        <input type="text" class="form-control" name="location" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Repayment Every</label>
                                        <input type="text" class="form-control" name="transidddd" value="" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">1st Repayment Date</label>
                                        <input type="text" class="form-control" name="transidddd" value="" readonly="">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <p>Run Credit Check - Statistic Scoring</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-nav-tabs" style="width: 30rem;">
                                        <div class="card-header card-header-success">
                                            Delinquency Counter
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Healthy Repayment: 0 <div class="progress-container progress-success">
                                                    <span class="progress-badge">Good</span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                                            Good
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">UnHealthy Repayment: 0 <div class="progress-container progress-success">
                                                    <span class="progress-badge">Warning</span>
                                                    <div class="progress">
                                                        <div class="progress-bar  bg-warning" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                            Warning
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">Late Repayment: 0</li>
                                            <li class="list-group-item">

                                                <div class="progress-container progress-success">
                                                    <span class="progress-badge">Bad</span>
                                                    <div class="progress">
                                                        <div class="progress-bar  bg-danger" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                            Bad
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Next -->
                                <div class="col-md-6">
                                    <div class="card card-nav-tabs" style="width: 30rem;">
                                        <div class="card-header card-header-warning">
                                            Loan Behaviour
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Active Loan: 0</li>
                                            <li class="list-group-item">Bad Loan: 0</li>
                                            <li class="list-group-item">Written Off Loan: 0</li>
                                            <li class="list-group-item">Same Product Outstanding: 1</li>
                                            <li class="list-group-item">
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                                        Danger
                                                    </div>
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                        Warning
                                                    </div>
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                                                        Good
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Next -->
                            <div class="row">
                                <!-- new -->
                                <div class="col-md-6">
                                    <div class="card card-nav-tabs" style="width: 30rem;">
                                        <div class="card-header card-header-warning">
                                            Clients KYC
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Age: 23</li>
                                            <li class="list-group-item">Income: 70,000.00</li>
                                            <li class="list-group-item">Years in current Job/Business: 1 years</li>
                                            <li class="list-group-item">Marital Status: Single</li>
                                            <li class="list-group-item">Level of Education: 0</li>
                                            <li class="list-group-item">Number of Dependents: 0</li>
                                            <li class="list-group-item">Collateral Value: 0.00% of principal amount</li>
                                            <li class="list-group-item">
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                                        Danger
                                                    </div>
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                        Warning
                                                    </div>
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                                                        Good
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- new -->
                                <div class="col-md-6">
                                    <div class="card card-nav-tabs" style="width: 30rem;">
                                        <div class="card-header card-header-success">
                                            Savings Behaviour
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Average Savings Balance: 43,997.71</li>
                                            <li class="list-group-item">Maximum Savings Balance: 73,996.00</li>
                                            <li class="list-group-item">Number of Deposit: 1</li>
                                            <li class="list-group-item">Number of Withdrawals: 1</li>
                                            <li class="list-group-item">Average Deposit Amount: 4,000.00</li>
                                            <li class="list-group-item">Average Withdrawal Amount: 4.00</li>
                                            <li class="list-group-item">
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 55%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                                        Danger
                                                    </div>
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                                                        Warning
                                                    </div>
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 175%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                        Success
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- hyped -->
                                <br>
                                <!-- never be -->
                                <!-- saving -->

                                <!-- saving -->
                                <div class="col-md-6">
                                    <div class="card card-pricing bg-warning">
                                        <div class="card-body ">
                                            <div class="card-icon">
                                                <i class="material-icons">money</i>
                                            </div>
                                            <h3 class="card-title">₦ 10,000.00 </h3>
                                            <p class="card-description">
                                                100% of the principal amount.
                                            </p>
                                            <button type="submit" value="submit_b" name="submit" class="btn btn-white btn-round">Approve Plan</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <div>
                                        <a href="#" class="btn btn-success btn-round pull-right">Print Credit Score</a>
                                        <button type="submit" value="reject" name="submit" class="btn btn-danger btn-round pull-right">Reject Loan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<?php
include("footer.php");
?>