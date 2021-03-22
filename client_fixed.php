
<html>

<head>
  <title> Client Form</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>

<body>

  <?php

  include("functions/connect.php");

if(isset($_POST['submit'])) { //Only run when form is submitted calibrace open

  $account_no = $_POST["account_no"];
  $account_balance = $_POST["account_balance"];
  $client_id = $_POST["client_id"];


  if( $account_balance == 0 ) { // if statement calibrace open

    $update_account_transaction = mysqli_query($connection, "UPDATE account_transaction p INNER JOIN (
      SELECT 
      s.id, s.account_no, s.transaction_date, s.running_balance_derived, s.amount, s.debit, s.credit, s.cumulative_balance_derived
      @b := @b - s.debit + s.credit AS balance
      FROM
      (SELECT @b := 0.0) AS dummy 
      CROSS JOIN
      account_transaction AS s WHERE client_id = '$client_id' && account_no = '$account_no'
      ORDER BY
      transaction_date) s on p.id = s.id AND p.client_id = '$client_id' SET `p.running_balance_derived` = s.balance, `p.cumulative_balance_derived` =s.balance ");


    $get_last_row_account = mysqli_query($connection, "SELECT 
      s.account_no, s.transaction_date, s.running_balance_derived, s.amount, s.debit, s.credit, s.id,
      @b := @b - s.debit + s.credit AS balance
      FROM
      (SELECT @b := 0.0) AS dummy 
      CROSS JOIN
      account_transaction AS s WHERE client_id = '$client_id' && account_no = '$account_no'
      ORDER BY
      transaction_date desc LIMIT 1");

  // $result = $connection->query($get_all_account);

    $row = mysqli_fetch_array($get_last_row_account);
    $balance = $row["balance"];

    $update_account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$balance' WHERE account_no = '$account_no' ");

    } // if statement calibrace close


    else if ( $account_balance > 0 ) {

    $get_last_row_account = mysqli_query($connection, "SELECT 
      s.account_no, s.transaction_date, s.running_balance_derived, s.amount, s.debit, s.credit, s.account_id,
      @b := @b - s.debit + s.credit AS balance
      FROM
      (SELECT @b := 0.0) AS dummy 
      CROSS JOIN
      account_transaction AS s WHERE client_id = '$client_id' && account_no = '$account_no'
      ORDER BY
      transaction_date desc LIMIT 1");

  // $result = $connection->query($get_all_account);

    $row = mysqli_fetch_array($get_last_row_account);

    $balance = $row["balance"];
    $day_before = date( 'Y-m-d', strtotime($row["transaction_date"]. ' -1 day') );
    $account_id = $row['account_id'];
    echo $account_id;

    $transactionDat = [
      'account_no' => $account_no,
      'account_id' => $account_id,
      'amount' => $account_balance,
      'running_balance_derived' => $balance,
      'cumulative_balance_derived' => $balance,
      'transaction_date' => $day_before,
      'transaction_type' => 'credit',
      'credit' => $balance,
      'description' => 'migration balance',
    ];

    $insert_into_account_transacton = insert('account_transaction', $transactionDat);
    $save = mysqli_query($connection, $insert_into_account_transacton);

/*      $insert_into_account_transacton = "INSERT INTO account_transaction (account_no, account_id, amount, running_balance_derived, cumulative_balance_derived, credit, transaction_date, transaction_type, 'description')
        VALUES ('{$account_no}', '{$client_id}', '{$account_balance}', '{$balance}', '{$balance}', '{$balance}', '{$day_before}', '{'credit'}, '{'Migration Balance'}' )";*/


    $update_account_transaction = mysqli_query($connection, "UPDATE account_transaction p INNER JOIN (
      SELECT 
      s.id, s.account_no, s.transaction_date, s.running_balance_derived, s.amount, s.debit, s.credit, s.cumulative_balance_derived
      @b := @b - s.debit + s.credit AS balance
      FROM
      (SELECT @b := 0.0) AS dummy 
      CROSS JOIN
      account_transaction AS s WHERE client_id = '$client_id' && account_no = '$account_no'
      ORDER BY
      transaction_date) s on p.id = s.id AND p.client_id = '$client_id' SET `p.running_balance_derived` = s.balance, `p.cumulative_balance_derived` =s.balance ");


    $get_last_row_account = mysqli_query($connection, "SELECT 
      s.account_no, s.transaction_date, s.running_balance_derived, s.amount, s.debit, s.credit, s.id,
      @b := @b - s.debit + s.credit AS balance
      FROM
      (SELECT @b := 0.0) AS dummy 
      CROSS JOIN
      account_transaction AS s WHERE client_id = '$client_id' && account_no = '$account_no'
      ORDER BY
      transaction_date desc LIMIT 1");

  // $result = $connection->query($get_all_account);

    $row = mysqli_fetch_array($get_last_row_account);
    $balance = $row["balance"];

    $update_account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$balance' WHERE account_no = '$account_no' ");

    echo "Task succesfull";

    }

    

  }//Only run when form is submitted calibrace close

  ?>

  <form action = "<?php $_PHP_SELF ?>" method = "POST">
    Account No: <input type ="text" name="account_no" value="0180007668" />
    Client ID: <input type ="text" name="client_id" value="1716" />

    Account Balance: <input type="number" name="account_balance"/>

    <input type = "submit" name="submit" value="submit" />
  </form>

</body>
</html>