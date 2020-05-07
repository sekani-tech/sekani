<?php

$page_title = "STATEMENT OF FINANCIAL POSITION";
$destination = "client.php";
include('header.php');

?>

<!-- Content added here -->
<!-- print content -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">Reports - Trial Balance</h4>
            </div>
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">Head Office</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Hide Zero Balances</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Run report</button>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div style="margin:auto; text-align:center;">
                  <img src="op.jpg" alt="sf">
                  <h2>Institution name</h2>
                  <p>Address</p>
                  <h4>Trial Balance</h4>
                  <h4>Branch</h4>
                  <P>From: 24/05/2020  ||  To: 24/05/2020</P>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Trial Balance Report</h4>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                    <thead>
                      <th style="font-weight:bold;">GL Codes</th>
                      <th style="font-weight:bold;">Name</th>
                      <th style="font-weight:bold;">Office</th>
                      <th style="text-align: center; font-weight:bold;">Opening Balance <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">Debit <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">Credit <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">Closing Balance <br> &#x20A6</th>
                    </thead>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td><b>Cash Balances</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Main Vault</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Teller Funds</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Petty Cash/Deposit</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Loan Disbursement</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Teller Diffrencies</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Due from Banks</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Wema Bank</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>UBA</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Heritage Bank</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>ECO Bank</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>First Bank</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Prepayment</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Rent-(Prepaid)</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Risk Premium</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Short term Investment</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Total Loan Portfolio</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr><tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Non-Current Asset</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Current Liability</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Non-Current Liability</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Accumulated Deprecation</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Equity</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Operating Income</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Other Non-Operating Income</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">0</td>
                        <td style="font-weight:bold; text-align: center">0</td>
                        <td style="font-weight:bold; text-align: center">0</td>
                        <td style="font-weight:bold; text-align: center">0</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><b>Operating Expense</b></td>
                        <td><b>Head Office</b></td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                        <td style="font-weight:bold; text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Software Prepaid</td>
                        <td></td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                        <td style="text-align: center">4,436,527</td>
                      </tr>
                      <tr>
                        <td><b>Total Asset</b></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center"><b>70.456,088</b></td>
                        <td style="text-align: center"><b>70.456,088</b></td>
                        <td style="text-align: center"><b>70.456,088</b></td>
                        <td style="text-align: center"><b>70.456,088</b></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--//report ends here -->
              <div class="card">
                 <div class="card-body">
                  <a href="" class="btn btn-primary">Back</a>
                  <a href="" class="btn btn-success btn-left">Print</a>
                 </div>
               </div> 
            </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>