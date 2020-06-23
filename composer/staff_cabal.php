<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
$sessint_id = $_SESSION['int_id'];
$int_name = $_SESSION['int_name'];
$user_id = $_SESSION["user_id"];
$quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' AND user_id = '$user_id'";
$rult = mysqli_query($connection, $quy);

  $rccw = mysqli_fetch_array($rult);
        $roleid = $rccw['org_role'];
        $quyd = "SELECT * FROM permission WHERE  int_id = '$sessint_id' AND role_id = '$roleid'";
        $rlot = mysqli_query($connection, $quyd);
        $tolm = mysqli_fetch_array($rlot);
        $report = $tolm['staff_cabal'];
if($report == 1 || $report == '1'){
if(isset($_POST["start"]) && isset($_POST["end"])){
  $start = $_POST["start"];
  $end = $_POST["end"];
  $branch_id = $_POST["branch"];
  // $staff = $_POST["staff"];
  $int_id = $_SESSION['int_id'];
  function fill_stafff($connection, $int_id, $start, $end, $branch_id)
        {
          // import
                    // $q = mysqli_fetch_array($querytoget);
          $out = '';
          $sessint_id = $_SESSION['int_id'];
          $querytoget = mysqli_query($connection, "SELECT * FROM staff WHERE ((branch_id = '$branch_id') AND (int_id ='$int_id' AND employee_status = 'Employed'))");
          $q = mysqli_fetch_array($querytoget);
          while ($q = mysqli_fetch_array($querytoget))
          {
            $staff = $q["id"];
          $name = $q["display_name"];

          $query1 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query1exec = mysqli_query($connection, $query1);
          $current = mysqli_num_rows($query1exec);

          $query4 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query4exec = mysqli_query($connection, $query4);
          $c = mysqli_fetch_array($query4exec);
          $currentamount = $c['account_balance_derived'];

          $query2 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query2exec = mysqli_query($connection, $query2);
          $savings = mysqli_num_rows($query2exec);

          $query5 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query5exec = mysqli_query($connection, $query5);
          $s = mysqli_fetch_array($query5exec);
          $savingsamount = $s['account_balance_derived'];

          $query3 = "SELECT * FROM loan WHERE loan_officer = '$staff' AND submittedon_date BETWEEN '$start' AND '$end'";
          $query3exec = mysqli_query($connection, $query3);
          $loans = mysqli_num_rows($query3exec);

          $query6 = "SELECT SUM(principal_amount)  AS principal_amount FROM loan WHERE loan_officer = '$staff'AND submittedon_date BETWEEN '$start' AND '$end'";
          $query6exec = mysqli_query($connection, $query6);
          $l = mysqli_fetch_array($query6exec);
          $loansamount = $l['principal_amount'];

            $out .= '
            <tr>
            <th>'.$staff.'</th>
            <th>'.$name.'</th>
            <th>'.$current.'</th>
            <th>'.$currentamount.'</th>
            <th>'.$savings.'</th>
            <th>'.$savingsamount.'</th>
            <th>'.$loans.'</th>
            <th>'.$loansamount.'</th>
            </tr>
          ';
        }
          return $out;
        }
  require_once __DIR__ . '/vendor/autoload.php';
  $mpdf = new \Mpdf\Mpdf();
  $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
  $mpdf->showWatermarkImage = true;
  $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
  <header class="clearfix">
  <div id="logo">
    <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
  </div>
  <h1>Staff Cabal Report For '.$end.'</h1>
  </header>
  <main>
  <table>
  <thead class=" text-primary">
  <tr>
    <th>
        Staff No
      </th>
      <th>
        Accounts Officer
      </th>
      <th colspan="2">
        Current Accounts
      </th>
      <th colspan="2">
        Savings Accounts
      </th>
      <th colspan="2">
        Loans Disbursement
      </th>
      </tr>
      <tr>
      <th>
      </th>
      <th>
      </th>
      <th>
        No of Client
      </th>
      <th>
        Value of Accounts
      </th>
      <th>
        No of Client
      </th>
      <th>
        Value of Accounts
      </th>
      <th>
        No of Client
      </th>
      <th>
        Value of Accounts
      </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_stafff($connection, $int_id, $start, $end, $branch_id).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Staff Cabal Report For '.$end.'.pdf';
  $mpdf->Output($file_name, 'D');
    }
    else {
      echo 'Not Seeing Data';
    }
  }
  else{
    if(isset($_POST["start"]) && isset($_POST["end"])){
      $start = $_POST["start"];
      $end = $_POST["end"];
      $branch_id = $_POST["branch"];
      // $staff = $_POST["staff"];
      $int_id = $_SESSION['int_id'];
      $queryto = mysqli_query($connection, "SELECT * FROM staff WHERE `user_id` = '$user_id'");
          $s = mysqli_fetch_array($queryto);
          $nacme = $s["display_name"];
      function fill_stafff($connection, $int_id, $start, $end, $branch_id)
        {
          // import
                    // $q = mysqli_fetch_array($querytoget);
          $out = '';
          $sessint_id = $_SESSION['int_id'];
          $user_id = $_SESSION['user_id'];
          $querytoget = mysqli_query($connection, "SELECT * FROM staff WHERE `user_id` = '$user_id'");
          $q = mysqli_fetch_array($querytoget);
            $staff = $q["id"];
          $name = $q["display_name"];

          $query1 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query1exec = mysqli_query($connection, $query1);
          $current = mysqli_num_rows($query1exec);

          $query4 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query4exec = mysqli_query($connection, $query4);
          $c = mysqli_fetch_array($query4exec);
          $currentamount = $c['account_balance_derived'];

          $query2 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query2exec = mysqli_query($connection, $query2);
          $savings = mysqli_num_rows($query2exec);

          $query5 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1' AND account.branch_id = '$branch_id' AND account.submittedon_date BETWEEN '$start' AND '$end'";
          $query5exec = mysqli_query($connection, $query5);
          $s = mysqli_fetch_array($query5exec);
          $savingsamount = $s['account_balance_derived'];

          $query3 = "SELECT * FROM loan WHERE loan_officer = '$staff' AND submittedon_date BETWEEN '$start' AND '$end'";
          $query3exec = mysqli_query($connection, $query3);
          $loans = mysqli_num_rows($query3exec);

          $query6 = "SELECT SUM(principal_amount)  AS principal_amount FROM loan WHERE loan_officer = '$staff'AND submittedon_date BETWEEN '$start' AND '$end'";
          $query6exec = mysqli_query($connection, $query6);
          $l = mysqli_fetch_array($query6exec);
          $loansamount = $l['principal_amount'];
            $out .= '
            <tr>
            <th>'.$staff.'</th>
            <th>'.$name.'</th>
            <th>'.$current.'</th>
            <th>'.$currentamount.'</th>
            <th>'.$savings.'</th>
            <th>'.$savingsamount.'</th>
            <th>'.$loans.'</th>
            <th>'.$loansamount.'</th>
            </tr>
          ';
          return $out;
        }
      require_once __DIR__ . '/vendor/autoload.php';
      $mpdf = new \Mpdf\Mpdf();
      $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
      $mpdf->showWatermarkImage = true;
      $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
      <header class="clearfix">
      <div id="logo">
        <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
      </div>
      <h1>Staff Cabal Report For '.$end.'</h1>
      </header>
      <main>
      <table>
      <thead class=" text-primary">
      <tr>
        <th>
            Staff No
          </th>
          <th>
            Accounts Officer
          </th>
          <th colspan="2">
            Current Accounts
          </th>
          <th colspan="2">
            Savings Accounts
          </th>
          <th colspan="2">
            Loans Disbursement
          </th>
          </tr>
          <tr>
          <th>
          </th>
          <th>
          </th>
          <th>
            No of Client
          </th>
          <th>
            Value of Accounts
          </th>
          <th>
            No of Client
          </th>
          <th>
            Value of Accounts
          </th>
          <th>
            No of Client
          </th>
          <th>
            Value of Accounts
          </th>
          </tr>
        </thead>
      <tbody>
      "'.fill_stafff($connection, $int_id, $start, $end, $branch_id).'"
      </tbody>
      </table>
      </main>
      ');
      $file_name = 'Staff Cabal Report For '.$nacme.'-'.$end.'.pdf';
      $mpdf->Output($file_name, 'D');
        }
        else {
          echo 'Not Seeing Data';
        }
  }
?>