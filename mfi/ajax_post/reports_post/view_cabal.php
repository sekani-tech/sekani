<?php
include('../../../functions/connect.php');
session_start();

$sessint_id = $_SESSION['int_id'];
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
if(isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["branch"])) {
  $start = $_POST["start"];
  $end = $_POST["end"];
  $branch = $_POST["branch"];
  // $staff = $_POST["staff"];
//   $queryi = "SELECT staff.id FROM staff JOIN account ON staff.id = account.field_officer_id WHERE staff.int_id = '$sessint_id' AND staff.id = '$staff'";
  $queryi = "SELECT * FROM staff WHERE int_id = '$sessint_id'";
  $queryxexec = mysqli_query($connection, $queryi);
  // $z = mysqli_fetch_array($queryxexec);
  $rom = '
  <thead class=" text-primary">
  <tr>
    <th>
        Staff ID
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
';

echo $rom;
    while($z = mysqli_fetch_array($queryxexec, MYSQLI_ASSOC)){
      $emp_status =  $z['employee_status'];
      if($emp_status=='Employed'){
$staff =  $z['id'];

  $query = "SELECT * FROM staff WHERE id = '$staff'";
  $queryexec = mysqli_query($connection, $query);
  $a = mysqli_fetch_array($queryexec);
  $staff_name = $a['display_name'];

  $query1 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1'";
  $query1exec = mysqli_query($connection, $query1);
  $current = mysqli_num_rows($query1exec);

  $query2 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1'";
  $query2exec = mysqli_query($connection, $query2);
  $savings = mysqli_num_rows($query2exec);

  $query3 = "SELECT * FROM loan WHERE loan_officer = '$staff'";
  $query3exec = mysqli_query($connection, $query3);
  $loans = mysqli_num_rows($query3exec);

  $query4 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1'";
  $query4exec = mysqli_query($connection, $query4);
  $c = mysqli_fetch_array($query4exec);
  $currentamount = $c['account_balance_derived'];
  

  $query5 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1'";
  $query5exec = mysqli_query($connection, $query5);
   $s = mysqli_fetch_array($query5exec);
  $savingsamount = $s['account_balance_derived'];

  $query6 = "SELECT SUM(principal_amount)  AS principal_amount FROM loan WHERE loan_officer = '$staff'";
  $query6exec = mysqli_query($connection, $query6);
  $l = mysqli_fetch_array($query6exec);
  $loansamount = $l['principal_amount'];


  $out = '
    <tr>
    <th>'.$staff.'</th>
    <th>'.$staff_name.'</th>
    <th>'.$current.'</th>
    <th>'.number_format($currentamount).'</th>
    <th>'.$savings.'</th>
    <th>'.number_format($savingsamount).'</th>
    
    <th>'.$loans.'</th>
    <th>'.number_format($loansamount).'</th>
    </tr>
    ';
    echo $out;
    }
    else{
    echo 'no data';
    }
}          
}
}
else{
  if(isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["branch"])) {
    $start = $_POST["start"];
    $end = $_POST["end"];
    $branch = $_POST["branch"];
    // $staff = $_POST["staff"];
  //   $queryi = "SELECT staff.id FROM staff JOIN account ON staff.id = account.field_officer_id WHERE staff.int_id = '$sessint_id' AND staff.id = '$staff'";
  $quccy = "SELECT * FROM staff WHERE int_id = '$sessint_id' AND user_id = '$user_id'";
  $queryxexec = mysqli_query($connection, $quccy);
    $rom = '
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
  ';
  echo $rom;
  $z = mysqli_fetch_array($queryxexec);
  $staff =  $z['id'];
  
    $query = "SELECT * FROM staff WHERE id = '$staff'";
    $queryexec = mysqli_query($connection, $query);
    $a = mysqli_fetch_array($queryexec);
    $staff_name = $a['display_name'];
  
    $query1 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1'";
    $query1exec = mysqli_query($connection, $query1);
    $current = mysqli_num_rows($query1exec);
  
    $query2 = "SELECT client.id, client.account_type, account.product_id, client.account_no FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1'";
    $query2exec = mysqli_query($connection, $query2);
    $savings = mysqli_num_rows($query2exec);
  
    $query3 = "SELECT * FROM loan WHERE loan_officer = '$staff'";
    $query3exec = mysqli_query($connection, $query3);
    $loans = mysqli_num_rows($query3exec);
  
    $query4 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id = '1'";
    $query4exec = mysqli_query($connection, $query4);
    $c = mysqli_fetch_array($query4exec);
    $currentamount = $c['account_balance_derived'];
    
  
    $query5 = "SELECT SUM(account.account_balance_derived)  AS account_balance_derived FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND client.loan_officer_id = '$staff' AND account.product_id != '1'";
    $query5exec = mysqli_query($connection, $query5);
     $s = mysqli_fetch_array($query5exec);
    $savingsamount = $s['account_balance_derived'];
  
    $query6 = "SELECT SUM(principal_amount)  AS principal_amount FROM loan WHERE loan_officer = '$staff'";
    $query6exec = mysqli_query($connection, $query6);
    $l = mysqli_fetch_array($query6exec);
    $loansamount = $l['principal_amount'];
  
  
    $out = '
      <tr>
      <th>'.$staff.'</th>
      <th>'.$staff_name.'</th>
      <th>'.$current.'</th>
      <th>'.number_format($currentamount).'</th>
      <th>'.$savings.'</th>
      <th>'.number_format($savingsamount).'</th>
      
      <th>'.$loans.'</th>
      <th>'.number_format($loansamount).'</th>
      </tr>
      ';
      echo $out;

  }
}
?>