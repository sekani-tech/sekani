<?php
 include("../../../functions/connect.php");
 session_start();
 $out= '';
 $logo = $_SESSION['int_logo'];
$name = $_SESSION['int_full'];
$sessint_id = $_SESSION['int_id'];
$current = date('d/m/Y');
if(isset($_POST['start'])){
    $start = $_POST['start'];
    $end = $_POST['end'];
    $branch_id = $_POST['branch'];
    $starttime = strtotime($start);
    $endtime = strtotime($end);
    $curren = date("F d, Y", $endtime);
    $onemonth = date("F d, Y", strtotime("-31 days", $endtime));
    $onemonthly = date("Y-m-d", strtotime("-31 days", $endtime));
    $osdnd = strtotime($onemonthly);

    if($starttime > $osdnd){
      $onemontstart = date("Y-m-d", strtotime("-31 days", $starttime));
    }
    else{
      $onemontstart = $start;
    }

// Interest on loans data
$jfjf = mysqli_query($connection, "SELECT * FROM acct_rule WHERE int_id = '$sessint_id'");
  while($dsdsd = mysqli_fetch_array($jfjf)){
    $acct_rule_id =$dsdsd['id'];
    $interest_income = $dsdsd['inc_interest'];
    $fdof = mysqli_query($connection, "SELECT * FROM acct_rule WHERE int_id = '$sessint_id' AND inc_interest = '$interest_income'");
    $dfds = mysqli_num_rows($fdof);
    if($dfds > 1){
      // interest on loans current month
      $fdfi = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$interest_income' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
      $dov = mysqli_query($connection, $fdfi);
      $oof = mysqli_fetch_array($dov);
      $gl = $oof['credit'];
      $int_on_loans = $gl;
    
      // interest on loans previous month
      $fkdlf = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$interest_income' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
      $dff = mysqli_query($connection, $fkdlf);
      $df = mysqli_fetch_array($dff);
      $gfl = $df['credit'];
      $last_int_on_loans = $gfl;
    }
    else{
      while($er = mysqli_fetch_array($fdof)){
        // interest on loans current month
      $fdfi = "SELECT * FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$interest_income' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
      $dov = mysqli_query($connection, $fdfi);
      $oof = mysqli_fetch_array($dov);
      $gl = $oof['credit'];
      $int_on_loans += $gl;
    
      // interest on loans previous month
      $fkdlf = "SELECT * FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$interest_income' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
      $dff = mysqli_query($connection, $fkdlf);
      $df = mysqli_fetch_array($dff);
      $gfl = $df['credit'];
      $last_int_on_loans += $gfl;
      }
    }
    }

// Fines and Fees gl
function fill_charge($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly)
{
  $stateg = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND classification_enum = '4' AND gl_code !='80010000'";
  $state1 = mysqli_query($connection, $stateg);
  $outxx = '';
  while ($row = mysqli_fetch_array($state1))
  {
    $namde = $row['name'];

    $glcode = $row['gl_code'];

    $opbalance = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
    $fodf = mysqli_query($connection, $opbalance);
      $n = mysqli_fetch_array($fodf);
      if(isset($n['credit'])){
      $endbal = number_format($n['credit'], 2);
      }else{
        $endbal = "0.00";
      }
    
    $fdf = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
    $ss = mysqli_query($connection, $fdf);
      $u = mysqli_fetch_array($ss);
      if(isset($u['credit'])){
      $lastmon = number_format($u['credit'], 2);
      }
      else{
        $lastmon = "0.00";
      }
if($endbal == '0.00' && $lastmon == '0.00'){
  $outxx .= '';
}
else{
  $outxx .= '
  <tr>
  <td>'.$namde.'</td>
  <td style="text-align: center">'.$endbal.'</td>
  <td style="text-align: center">'.$lastmon.'</td>
</tr>
';
}

  }
return $outxx;
}
// total of fees
$oieio = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND classification_enum = '4'";
$sdreo = mysqli_query($connection, $oieio);
while ($op = mysqli_fetch_array($sdreo))
{
  $gldo = $op['gl_code'];

  $sldksp = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gldo' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
  $reprop = mysqli_query($connection, $sldksp);
    $i = mysqli_fetch_array($reprop);
    if(isset($i)){
    $ending = $i['credit'];
    }
    else{
      $ending = '0.00';
    }
  
    $opso = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gldo' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
  $sdpo = mysqli_query($connection, $opso);
    $q = mysqli_fetch_array($sdpo);
    if(isset($q)){
    $pdospo = $q['credit'];
    }
    else{
      $pdospo = '0.00';
    }
      $total_fees_current += $ending;
      $total_fees_last += $pdospo;

}
// Liabilities Report
$liab = "SELECT * FROM acc_gl_account WHERE int_id='$sessint_id' AND name LIKE 'INTEREST EXPENSE'";
$iod = mysqli_query($connection, $liab);
while($re = mysqli_fetch_array($iod)){
  $dofs = $re['gl_code'];
  $dops = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$dofs' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
$sklsd = mysqli_query($connection, $dops);
$ui = mysqli_fetch_array($sklsd);
if(isset($ui)){
$rer = $ui['credit'];
}else{
  $rer = "0.00";
}
$liabilities += $rer;

$kldfk = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id ='$sessint_id' AND gl_code = '$dofs' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
$odf = mysqli_query($connection, $kldfk);
$pdfo = mysqli_fetch_array($odf);
if(isset($pdfo)){
$pso = $pdfo['credit'];
}
else{
  $pso = "0.00";
}
$otgerliabi += $pso;
}
// NET INTEREST INCOME
$net_interest_income =$int_on_loans - $liabilities;
$net_interest_income_last = $last_int_on_loans - $otgerliabi;
// Total Revenue Income
$ttl_revenue_curren = $net_interest_income + $total_fees_current;
$ttl_revenue_last = $net_interest_income_last + $total_fees_last;
// Operating Expenses
function fill_operation($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly)
{
  $stateg = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id !='0' AND classification_enum ='5' AND gl_code !='90010000' ORDER BY name ASC";
  $state1 = mysqli_query($connection, $stateg);
  $outxx = '';
  while ($row = mysqli_fetch_array($state1))
  {
    $namde = $row['name'];

    $glcode = $row['gl_code'];

    $opbalance = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
    $fodf = mysqli_query($connection, $opbalance);
      $n = mysqli_fetch_array($fodf);
      if(isset($n)){
      $endbal = number_format($n['credit'], 2);
      }else{
        $endbal = "0.00";
      }
    
    $fdf = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
    $ss = mysqli_query($connection, $fdf);
      $u = mysqli_fetch_array($ss);
      if(isset($u)){
      $lastmon = number_format($u['credit'], 2);
      }
      else{
        $lastmon = "0.00";
      }
if($endbal == '0.00' && $lastmon == '0.00'){
  $outxx .= '';
}
else{
  $outxx .= '
  <tr>
  <td>'.$namde.'</td>
  <td style="text-align: center">'.$endbal.'</td>
  <td style="text-align: center">'.$lastmon.'</td>
</tr>';
}
  }
return $outxx;
}

// While loop for total operating expense
$xccfdg = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id !='0' AND classification_enum ='5' ORDER BY name ASC";
$fdff = mysqli_query($connection, $xccfdg);
while ($q = mysqli_fetch_array($fdff))
  {
    $gllcode = $q['gl_code'];
// current month
    $kutty = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gllcode' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
    $cxcxfd = mysqli_query($connection, $kutty);
    $j = mysqli_fetch_array($cxcxfd);
    if(isset($j)){
    $fdpfodp = $j['credit'];
    }else{
      $fdpfodp = "0.00";
    }
    // previous month
    $kuoo = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gllcode' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
    $po = mysqli_query($connection, $kuoo);
      $o = mysqli_fetch_array($po);
      if(isset($o)){
      $sweowee = $o['credit'];
      }
      else{
        $sweowee = "0.00";
      }
      $ttlcurrenmonth += $fdpfodp;
      $ttlastmonth += $sweowee;
  }
  // Depreciation Amount
  $fdkfm = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id !='0' AND classification_enum ='5' AND name LIKE '%depreciation%' ORDER BY name ASC";
$fdfs = mysqli_query($connection, $fdkfm);
while ($t = mysqli_fetch_array($fdfs))
  {
    $gllcode = $t['gl_code'];
// current month
    $dfdfso = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gllcode' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
    $erte = mysqli_query($connection, $dfdfso);
    $i = mysqli_fetch_array($erte);
    if(isset($i)){
    $ferd = $i['credit'];
    }else{
      $ferd = "0.00";
    }
    // previous month
    $uiyr = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$gllcode' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
    $ererw = mysqli_query($connection, $uiyr);
      $a = mysqli_fetch_array($ererw);
      if(isset($a)){
      $dsdada = $a['credit'];
      }
      else{
        $dsdada = "0.00";
      }
      $depreciation_current +=$ferd;
      $depreciation_last +=$dsdada;
  }

  // Depreciation and income tax hasnt been coded yet. Values = 0 for now

  $income_tax_current = 0.00;

  $income_tax_last = 0.00;
  $net_prof_from_op = $ttl_revenue_curren - $ttlcurrenmonth;
  $net_prof_last_op = $ttl_revenue_last - $ttlastmonth;
  $profit_for_year = $net_prof_from_op - ($depreciation_current + $income_tax_current);
  $profit_for_year_last = $net_prof_last_op - ($depreciation_last + $income_tax_last);

  // FINAL FORMAT FOR NEGATIVE VALUES
  // Net interest income
  if($net_interest_income < 0){
    $netint = "(".number_format(abs($net_interest_income), 2).")";
  }
  else{
    $netint = number_format($net_interest_income, 2);
  }
  if($net_interest_income_last < 0){
    $netint_last = "(".number_format(abs($net_interest_income_last), 2).")";
  }
  else{
    $netint_last = number_format($net_interest_income_last, 2);
  }

  // total fees
  if($total_fees_current < 0){
    $totalfeecurrent = "(".number_format(abs($total_fees_current), 2).")";
  }
  else{
    $totalfeecurrent = number_format($total_fees_current, 2);
  }
  if($total_fees_last < 0){
    $totalfeelast = "(".number_format(abs($total_fees_last), 2).")";
  }
  else{
    $totalfeelast = number_format($total_fees_last, 2);
  }
  
  // total current revenue
  if($ttl_revenue_curren < 0){
    $ttl_revenue = "(".number_format(abs($ttl_revenue_curren), 2).")";
  }
  else{
    $ttl_revenue = number_format($ttl_revenue_curren, 2);
  }
  if($ttl_revenue_last < 0){
    $ttl_revenuelast = "(".number_format(abs($ttl_revenue_last), 2).")";
  }
  else{
    $ttl_revenuelast = number_format($ttl_revenue_last, 2);
  }

  // subtotal expense
  if($ttlcurrenmonth < 0){
    $tlcurmont = "(".number_format(abs($ttlcurrenmonth), 2).")";
  }
  else{
    $tlcurmont = number_format($ttlcurrenmonth, 2);
  }
  if($ttlastmonth < 0){
    $tllasmont = "(".number_format(abs($ttlastmonth), 2).")";
  }
  else{
    $tllasmont = number_format($ttlastmonth, 2);
  }

  // Gross profit from operation
  if($net_prof_from_op < 0){
    $netprof = "(".number_format(abs($net_prof_from_op), 2).")";
  }
  else{
    $netprof = number_format($net_prof_from_op, 2);
  }
  if($net_prof_last_op < 0){
    $netprof_last = "(".number_format(abs($net_prof_last_op), 2).")";
  }
  else{
    $netprof_last = number_format($net_prof_last_op, 2);
  }

  // profit/loss for year
  if($profit_for_year < 0){
    $prof_year = "(".number_format(abs($profit_for_year), 2).")";
  }
  else{
    $prof_year = number_format($profit_for_year, 2);
  }
  if($profit_for_year_last < 0){
    $prof_year_last = "(".number_format(abs($profit_for_year_last), 2).")";
  }
  else{
    $prof_year_last = number_format($profit_for_year_last, 2);
  }

$out = '';
$out = '
<div class="card">
<div class="card-header card-header-primary">
  <h4 class="card-title">Operating Revenue</h4>
</div>
<div class="card-body">
  <table class="table">
    <thead>
      <th style="font-weight:bold;">GL Account</th>
      <th style="text-align: center; font-weight:bold;">'.$curren.'<br/>(NGN)</th>
      <th style="text-align: center; font-weight:bold;">'.$onemonth.'<br/>(NGN)</th>
    </thead>
    <tbody>
      <tr>
        <td>Interest Income:</td>
        <td style="text-align: center">'.number_format($int_on_loans).'</td>
        <td style="text-align: center">'.number_format($last_int_on_loans).'</td>
      </tr>
      <tr>
        <td>Less interest Expense:</td>
        <td style="text-align: center">'.number_format($liabilities).'</td>
        <td style="text-align: center">'.number_format($otgerliabi).'</td>
      </tr>
      <tr>
        <td style="font-weight:bold;"><b>NET INTEREST INCOME</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.$netint.'</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.$netint_last.'</b></td>
      </tr>

      '.fill_charge($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly).'
      <tr>
      <td style="font-weight:bold;"><b>SUB TOTAL INCOME</b></td>
      <td style="text-align: center"><b>'.$totalfeecurrent.'</b></td>
      <td style="text-align: center"><b>'.$totalfeelast.'</b></td>
    </tr>
      <tr>
        <td>Other services and other income</td>
        <td style="text-align: center">'.number_format($other).'</td>
        <td style="text-align: center">0.00</td>
      </tr>
      <tr>
        <td style="font-weight:bold;"><b>GROSS OPERATING INCOME</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.$ttl_revenue.'</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.$ttl_revenuelast.'</b></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<div class="card">
<div class="card-header card-header-primary">
  <h4 class="card-title">Operating Expenses</h4>
</div>
<div class="card-body">
  <table class="table">
    <thead>
      <th style="font-weight:bold;">GL Account</th>
      <th style="text-align: center; font-weight:bold;">'.$curren.' <br/>(NGN)</th>
      <th style="text-align: center; font-weight:bold;">'.$onemonth.' <br/>(NGN)</th>
    </thead>
    <tbody>
    '.fill_operation($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly).'
      <tr>
        <td style="font-weight:bold;">SUB TOTAL EXPENSE</td>
        <td style="text-align: center; font-weight:bold;"><b>'.$tlcurmont.'</b></td>
        <td style="text-align: center; font-weight:bold;"><b>'.$tllasmont.'</b></td>
      </tr>
      <tr>
        <td style="font-weight:bold;">GROSS PROFIT/(LOSS) FROM OPERATIONS</td>
        <td style="font-weight:bold; text-align: center">'.$netprof.'</td>
        <td style="font-weight:bold; text-align: center">'.$netprof_last.'</td>
      </tr>
      <tr>
        <td>Depreciation</td>
        <td style="text-align: center">'.number_format($depreciation_current).'</td>
        <td style="text-align: center">'.number_format($depreciation_last).'</td>
      </tr>
      <tr>
        <td>Income Tax</td>
        <td style="text-align: center">0.00</td> 
        <td style="text-align: center">0.00</td>
      </tr>
      <tr>
        <td style="font-weight:bold;">NET PROFIT/(LOSS) FOR THE YEAR</td>
        <td style="font-weight:bold; text-align: center">'.$prof_year.'</td>
        <td style="font-weight:bold; text-align: center">'.$prof_year_last.'</td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<!--//report ends here -->
<div class="card">
 <div class="card-body">
 <form method="POST" action="../composer/stmt_income.php">
 <input hidden type="text" name="start_date" value="'.$start.'"/>
 <input hidden type="text" name="end_date" value="'.$end.'"/>
 <input hidden type="text" name="branch_id" value="'.$branch_id.'"/>
 <input hidden type="text" name="int_id" value="'.$sessint_id.'"/>
 <input hidden type="text" name="previous_month_date" value="'.$onemonthly.'"/>
 <input hidden type="text" name="current_interest_on_loans" value="'.$int_on_loans.'"/>
 <input hidden type="text" name="previous_interest_on_loans" value="'.$last_int_on_loans.'"/>
 <input hidden type="text" name="total_current_fees" value="'.$total_fees_current.'"/>
 <input hidden type="text" name="total_previous_fees" value="'.$total_fees_last.'"/>
 <input hidden type="text" name="current_liabilities" value="'.$liabilities.'"/>
 <input hidden type="text" name="previous_liabilities" value="'.$otgerliabi.'"/>
 <input hidden type="text" name="current_net_interest_on_income" value="'.$net_interest_income.'"/>
 <input hidden type="text" name="previous_net_interest_on_income" value="'.$net_interest_income_last.'"/>
 <input hidden type="text" name="current_charge_income" value="'.$curren_charge.'"/>
 <input hidden type="text" name="previous_charge_income" value="'.$last_mon_charge.'"/>
 <input hidden type="text" name="current_total_revenue" value="'.$ttl_revenue_curren.'"/>
 <input hidden type="text" name="previous_total_revenue" value="'.$ttl_revenue_last.'"/>
 <input hidden type="text" name="current_total_operating_expense" value="'.$ttlcurrenmonth.'"/>
 <input hidden type="text" name="previous_total_operating_expense" value="'.$ttlastmonth.'"/>
 <input hidden type="text" name="current_net_profit_from_operation" value="'.$net_prof_from_op.'"/>
 <input hidden type="text" name="previous_net_profit_from_operation" value="'.$net_prof_last_op.'"/>
 <input hidden type="text" name="profit_current_year" value="'.$profit_for_year.'"/>
 <input hidden type="text" name="profit_previous_year" value="'.$profit_for_year_last.'"/>
 <input hidden type="text" name="prev_month_start" value="'.$onemontstart.'"/>
  <button class="btn btn-primary">Print</button>
  </form>
 </div>
</div>
</div>';
echo $out;
}
?>