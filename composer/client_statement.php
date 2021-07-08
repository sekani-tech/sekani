<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once('../functions/connect.php');
?>
<?php
$sessint_id = $_SESSION['int_id'];
if(isset($_POST["id"])) {
    $id = $_POST["id"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $acc_no = $_POST["account_no"];

    $query1 = mysqli_query($connection, "SELECT * FROM client WHERE id='$id'");
    if (count([$query1]) == 1) {
        $a = mysqli_fetch_array($query1);
        $fname = $a['firstname'];
        $lname = $a['lastname'];
        $int_id = $a['int_id'];
        $actype = $a['account_type'];
        $branch = $a['branch_id'];
        $query2 = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$int_id'");
        if (count([$query2]) == 1) {
            $b = mysqli_fetch_array($query2);
            $intname = $b['int_name'];
            $logo = $b['int_name'];
            $full = $b['int_full'];
            $web = $b['website'];
        }
        $branchid = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch'");
        if (count([$branchid]) == 1) {
         $c = mysqli_fetch_array($branchid);
         $branch_name = strtoupper($c['name']);
        $branch_address = $c['location'];
        }
        $acount = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acc_no'");
        if (count([$acount]) == 1) {
        $d = mysqli_fetch_array($acount);
        $currtype = $d['currency_code'];
        $client_id = $d['client_id'];
        $acc_id = $d['id'];
        }
        $totald = mysqli_query($connection,"SELECT SUM(debit)  AS debit FROM account_transaction WHERE (account_no = '$acc_no' && int_id = '$sessint_id' && branch_id = '$branch') && (transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC");
        $deb = mysqli_fetch_array($totald);
        $tdp = $deb['debit'];
        $totaldb = number_format($tdp, 2);
  
        $totalc = mysqli_query($connection, "SELECT SUM(credit)  AS credit FROM account_transaction WHERE (account_no = '$acc_no' && int_id = '$sessint_id' && branch_id = '$branch') && (transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC");
        $cred = mysqli_fetch_array($totalc);
        $tcp = $cred['credit'];
        $totalcd = number_format($tcp, 2);

              // Closing Balance
      $result = mysqli_query($connection, "SELECT * FROM account_transaction WHERE (account_no = '$acc_no' && int_id = '$sessint_id' && branch_id = '$branch') && (transaction_date BETWEEN '$start' AND '$end') ORDER BY id DESC");
      $rerc = mysqli_fetch_array($result);
      $closing_bal = $rerc['running_balance_derived'];


        function fill_data($connection, $acc_no, $sessint_id, $start, $end, $branch){
        $id = $_GET["edit"];
      // import
      $accountquery = "SELECT * FROM account_transaction WHERE (account_no = '$acc_no' && int_id = '$sessint_id' && branch_id = '$branch') && (transaction_date BETWEEN '$start' AND '$end') ORDER BY transaction_date ASC";
      $resul = mysqli_query($connection, $accountquery);
      $out = '';

      while ($q = mysqli_fetch_array($resul))
      { 
        if ($q["transaction_type"] == "") {
          $desc = "Deposit";
        } else if ($q["transaction_type"] == "") {
          $desc = "Withdrawal";
        } else if ($q["transaction_type"] == "loan_disbursement") {
          $desc = "Loan Disbursment";
        } else if ($q["transaction_type"] == "percentage_charge") {
          $desc = $q["description"];
        } else if ($q["transaction_type"] == "flat_charge") {
          $desc = $q["description"];
        } else {
          $desc = $q["description"];
        }
        $transaction_date = $q["transaction_date"];
        $value_date = $q["created_date"]; 
        $description = $desc;
        $amt2 = $q["debit"];
        $amt = $q["credit"];
        $balance = $q["running_balance_derived"]; 
        $out .= '
        <tr>
            <td class="column1"> '.$transaction_date.'</td>
            <td class="column2">'.$value_date.'</td>
            <td class="column3">'.$description .'</td>
            <td class="column4">'.$amt2.'</td>
            <td class="column5">'.$amt.'</td>
            <td class="column6">'.number_format($balance).'</td>
        </tr>
      ';
      }
      return $out;
    }
    }

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML('
    <html>

        <link rel="stylesheet" media="print"  href="pdf/util.css">
        <link rel="stylesheet" href="pdf/main.css">    
        <header class="clearfix">
        <div id="logo">
          <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
        </div>
        <h1>'.$full.'<br/> Client Statement</h1>
        <div id="project" class="clearfix">
        <table cellpadding="4" cellpacing="15" class="tbl">
        <tr>
            <th style="color:white;">CELL SPACING AREA</th>
            <th style="color:white;">CELL SPACING AREA</th>
            <th style="color:white;">CELL SPACING AREA</th>
        </tr>
        <tr>
            <td><div class="head"><span>Branch Name: </span>'.$branch_name.'</div></td>
            <td></td>
            <td><div class="head"><span>Client name: </span>'.$fname.' '.$lname.'</div></td>
        </tr>
        <tr>
            <td><div class="head"><span>Currency: </span>'.$currtype.'</div></td> 
            <td></td>
            <td><div class="tail"><span>Total credit: &#8358;'.$totalcd.'</span></div></td>
            
        </tr>
        <tr>
            <td><div class="tail"><span>Account number: </span>'.$acc_no.'</div></td>
            <td></td>
            <td><div class="tail"><span>Total debit: &#8358;'.$totaldb.'</span></div></td> 
        </tr>
        <tr>
            <td><div class="tail"><span>Statement Period: </span>'.$start.' - '.$end.'</div></td>
            <td></td>
            <td><div class="tail"><span>Closing Balance: </span> &#8358;'.number_format($closing_bal, 2).'</div></td>
        </tr>
         </table>
        </div>
        </header>

    <div class="limiter">
        <div class="wrap-table100">
            <div class="table100">
                <table>
                    <thead>
                        <tr class="table100-head">
                            <th class="column1">Transaction-Date</th>
                            <th class="column2">Value Date</th>
                            <th class="column3">Reference</th>
                            <th class="column4">Debits(&#8358;)</th>
                            <th class="column5">Credits(&#8358;)</th>
                            <th class="column6">Balance(&#8358;)</th>
                        </tr>
                    </thead>
                    <tbody>
                    "'.fill_data($connection, $acc_no, $sessint_id, $start, $end, $branch).'"
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </html>
    ');
    $mpdf->SetWatermarkImage('../instimg/DGMFB.jpg');
    $mpdf->showWatermarkImage = true;
    // $stylesheet = file_get_contents('style.css');
    
    // $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    $file_name = 'Client Statement '.$lname.' '.$fname.'.pdf';
    $mpdf->Output($file_name, 'D');

}
else{
    echo 'Data not found';
}

?>