<?php
session_start();
$page_title = "Client Statement";
$destination = "client.php";
include('../../functions/connect.php');
?>
<?php
if(isset($_POST["id"])) {
    $id = $_POST["id"];
    $query1 = mysqli_query($connection, "SELECT * FROM client WHERE id='$id'");
    if (count([$query1]) == 1) {
        $a = mysqli_fetch_array($query1);
        $fname = $a['firstname'];
        $lname = $a['lastname'];
        $int_id = $a['int_id'];
        $actype = $a['account_type'];
        $acc_no = $a['account_no'];
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
        }
        $totald = mysqli_query($connection,"SELECT SUM(debit)  AS debit FROM account_transaction WHERE client_id = '$client_id'");
        $deb = mysqli_fetch_array($totald);
        $tdp = $deb['debit'];
        $totaldb = number_format($tdp, 2);
  
        $totalc = mysqli_query($connection, "SELECT SUM(credit)  AS credit FROM account_transaction WHERE client_id = '$client_id'");
        $cred = mysqli_fetch_array($totalc);
        $tcp = $cred['credit'];
        $totalcd = number_format($tcp, 2);
        function fill_data($connection){
        $id = $_POST["id"];
      // import
      $accountquery = "SELECT * FROM account_transaction WHERE client_id ='$id'";
      $resul = mysqli_query($connection, $accountquery);
      $out = '';

      while ($q = mysqli_fetch_array($resul))
      {
        $transaction_date = $q["transaction_date"];
        $value_date = $q["created_date"]; 
        $transact_id = $q["transaction_id"];
        $amt2 = $q["debit"];
        $amt = $q["credit"];
        $balance = $q["running_balance_derived"]; 
        $out .= '
        <tr>
            <td class="column1"> '.$transaction_date.'</td>
            <td class="column2">'.$value_date.'</td>
            <td class="column3">'.$transact_id .'</td>
            <td class="column4">'.$amt2.'</td>
            <td class="column5">'.$amt.'</td>
            <td class="column6">'.$balance.'</td>
        </tr>
      ';
      }
      return $out;
    }
    }

    $output = '
    <html>

        <link rel="stylesheet" media="print"  href="../composer/pdf/util.css">
        <link rel="stylesheet" href="../composer/pdf/main.css">    
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
            <td><div class="tail"><span>Total credit: '.$totalcd.'</span></div></td>
            
        </tr>
        <tr>
            <td><div class="tail"><span>Account number: </span>'.$acc_no.'</div></td>
            <td></td>
            <td><div class="tail"><span>Total debit: '.$totaldb.'</span></div></td> 
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
                    "'.fill_data($connection).'"
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </html>
    ';
  }
  echo $output;
?>