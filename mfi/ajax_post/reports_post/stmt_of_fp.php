<?php
 include("../../../functions/connect.php");
 session_start();
 $out= '';
 $logo = $_SESSION['int_logo'];
$name = $_SESSION['int_full'];
$sessint_id = $_SESSION['int_id'];
$current = date('d/m/Y');

// Start date
$start = $_POST['start'];
$starttime = strtotime($start);
$startd = date("F d, Y", $starttime);

// End date
$end = $_POST['end'];
$endtime = strtotime($end);
$current = date("F d, Y", $endtime);

// Year Before
$start = $_POST['start'];
$strto = strtotime($start);
$yearbefore = date("Y-m-d", strtotime("-1 day", $strto));
$yeardisplay = date("F d, Y", strtotime("-1 day", $strto));

////////////////////// CURRENT YEAR DATA begins //////////////////////
// Current Assets
// CASH
$ivoc = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND name LIKE '%cash%' AND classification_enum = '1' AND parent_id = '0'");
$cas = mysqli_fetch_array($ivoc);
$name = $cas['name'];
$cp_id = $cas['id'];
if($cp_id != 0){
$fdsp = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND parent_id = '$cp_id'");
$fop = mysqli_fetch_array($fdsp);
$cash_credit = $fop['credit'];
$cash_debit = $fop['debit'];
$cash = $cash_credit - $cash_debit;
}
// BANKS
$sdoi = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND name LIKE '%bank%' AND classification_enum = '1' AND parent_id = '0'");
$ska = mysqli_fetch_array($sdoi);
$bname = $ska['name'];
$bp_id = $ska['id'];
if($bp_id != 0){
$dsodi = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND parent_id = '$bp_id'");
$dsp = mysqli_fetch_array($dsodi);
$bank_credit = $dsp['credit'];
$bank_debit = $dsp['debit'];
$bank = $bank_credit - $bank_debit;
}
// CASH AND BANK
$cash_and_bank = $bank + $cash;

// Loans AND recievables
$dsdj = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND name LIKE '%LOANS%' AND classification_enum = '1' AND parent_id = '0'");
$fido = mysqli_fetch_array($dsdj);
$ln_id = $fido['id'];
$lname = $fido['name'];
if($ln_id != 0){
$oep = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND parent_id = '$ln_id'");
$fop = mysqli_fetch_array($oep);
$loan_credit = $fop['credit'];
$loan_debit = $fop['debit'];
$loan = $loan_credit - $loan_debit;
}
// prepayment
$sdpo = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND name LIKE '%prepayment%' AND classification_enum = '1' AND parent_id = '0'");
$apa = mysqli_fetch_array($sdpo);
$pname = $apa['name'];
$pp_id = $apa['id'];
if($pp_id != 0){
$opd = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND parent_id = '$pp_id'");
$sse = mysqli_fetch_array($opd);
$prepay_credit = $sse['credit'];
$prepay_debit = $sse['debit'];
$prepayment = $prepay_credit - $prepay_debit;
}

// total current asset
$total_current = $prepayment + $loan + $cash_and_bank;


// NON CURRENT ASSETS
function fill_gl($connection, $sessint_id){
$diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND name LIKE '%NON CURRENT ASSET%' AND classification_enum = '1' AND parent_id = '0'");
$pdi = mysqli_fetch_array($diis);
$no_curr_id = $pdi['id'];

$dops = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE parent_id = '$no_curr_id' AND int_id = '$sessint_id'");
$out ='';

while($op = mysqli_fetch_array($dops)){
  $gll = $op['gl_code'];
  $glname = $op['name'];
  $iopf = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM gl_account_transaction WHERE parent_id = '$no_curr_id' AND int_id = '$sessint_id' AND gl_code = '$gll'");
  $dpd = mysqli_fetch_array($iopf);
  $gl_credit = $dpd['credit'];
  $gl_debit = $dpd['debit'];

  $gl_am = $gl_credit - $gl_debit;
  $out .= '
  <tr>
  <td></td>
  <td>'.$glname.'</td>
  <td style="text-align: center">'.number_format($gl_am, 2).'</td>
  <td style="text-align: center"></td>
</tr>';
}
return $out;
}

// total non current asset
  $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND name LIKE '%NON CURRENT ASSET%' AND classification_enum = '1' AND parent_id = '0'");
  $pdi = mysqli_fetch_array($diis);
  $no_curr_id = $pdi['id'];

  $ofe = mysqli_query($connection, "SELECT SUM(credit) AS credit, SUM(debit) AS debit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND parent_id='$no_curr_id'");
  $iof = mysqli_fetch_array($ofe);
  $sum_gl_credit = $iof['credit'];
  $sum_gl_debit = $iof['debit'];

  $sum_gl = $sum_gl_credit - $sum_gl_debit;

  // less accumulated depreciation
$out = '
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title">Assets</h4>
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <th style="font-weight:bold;"></th>
        <th style="font-weight:bold;"></th>
        <th style="text-align: center; font-weight:bold;">'.$current.' <br/>(NGN)</th>
        <th style="text-align: center; font-weight:bold;">'.$yeardisplay.' <br/>(NGN)</th>
      </thead>
      <tbody>
      <tr>
          <td></td>
          <td><b>ASSETS</b></td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
          <tr>
              <td></td>
              <td><b>Current Assets</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td></td>
          <td>Cash and Bank</td>
          <td style="text-align: center">'.number_format($cash_and_bank, 2).'</td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td></td>
          <td>Loans and Recievables</td>
          <td style="text-align: center">'.number_format($loan, 2).'</td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td></td>
          <td>Prepayments</td>
          <td style="text-align: center">'.number_format($prepayment, 2).'</td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td></td>
          <td><b>Total Current Assets</b></td>
          <td style="text-align: center"><b>'.number_format($total_current, 2).'</b></td>
          <td style="text-align: center"><b></b></td>
        </tr>
        <tr>
              <td></td>
              <td><b>Non-Current Assets</b></td>
              <td></td>
              <td></td>
          </tr>
          '.fill_gl($connection, $sessint_id).'
        <tr>
          <td></td>
          <td><b>Total Non-Current Assets</b></td>
          <td style="text-align: center"><b>'.number_format($sum_gl, 2).'</b></td>
          <td style="text-align: center"><b></b></td>
        </tr>
        <tr>
          <td></td>
          <td><b>Less: Accumulated Description</b></td>
          <td style="text-align: center"><b></b></td>
          <td style="text-align: center"><b></b></td>
        </tr>
        <tr>
          <td></td>
          <td><b>NPV</b></td>
          <td style="text-align: center"><b></b></td>
          <td style="text-align: center"><b></b></td>
        </tr>
        <tr>
          <td></td>
          <td><b>Total Asset</b></td>
          <td style="text-align: center"><b></b></td>
          <td style="text-align: center"><b></b></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title">Liablities</h4>
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <th style="font-weight:bold;">GL Account</th>
        <th style="text-align: center; font-weight:bold;">'.$start.' <br/>(NGN)</th>
        <th style="text-align: center; font-weight:bold;">'.$end.' <br/>(NGN)</th>
      </thead>
      <tbody>
      <tr>
              <td><b>LIABILITIES & EQUITY</b></td>
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td><b>Current Liabilities</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td>Deposit Liablities</td>
          <td style="text-align: center">4,436,527</td>
          <td style="text-align: center">4,436,527</td>
        </tr>
        <tr>
          <td>Trade and Other Payables</td>
          <td style="text-align: center">66,109,561</td>
          <td style="text-align: center">66,109,561</td>
        </tr>
        <tr>
          <td><b>Total Current Liabilities</b></td>
          <td style="text-align: center"><b></b></td>
          <td style="text-align: center"><b></b></td>
        </tr>
        <tr>
              <td><b>Non-Current Liabilities</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td>Unearned Income</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td><b>Total Non-Current Liabilities</b></td>
          <td style="text-align: center"><b></b></td>
          <td style="text-align: center"><b></b></td>
        </tr>
        <tr>
          <td><b>Total Liabilities</b></td>
          <td style="text-align: center"><b></b></td>
          <td style="text-align: center"><b></b></td>
        </tr>
        <tr>
            <td><b>Shareholders Equity</b></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
          <td> Authorised Share Capital</td>
          <td style="text-align: center">0</td>
          <td style="text-align: center">0</td>
        </tr>
        <tr>
          <td> Current Retained Earning</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td><b>Total Shareholders Equity</b></td>
          <td style="text-align: center"><b></b></td>
          <td style="text-align: center"><b></b></td>
        </tr>
        <tr>
          <td><b>Total Liabilities and Shareholders Equity</b></td>
          <td style="text-align: center"><b></b></td>
          <td style="text-align: center"><b></b></td>
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
 </div> ';
 echo $out;
?>