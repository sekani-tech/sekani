<?php

include("../functions/connect.php");

$statement = mysqli_query($connection, "SELECT client_id, id, account_no FROM account WHERE product_id = '76'");
 while($row = mysqli_fetch_array($statement)){
     $client = $row['client_id'];
     $id = $row['id'];
     $accountNo = $row['account_no'];

     $updateScript = mysqli_query($connection, "UPDATE account_transaction p INNER JOIN (
        SELECT 
            s.id, s.account_no, s.transaction_date, s.running_balance_derived, s.amount, s.debit, s.credit, 
            @b := @b - s.debit + s.credit AS balance
        FROM
            (SELECT @b := 0.0) AS dummy 
          CROSS JOIN
            account_transaction AS s WHERE client_id = '$client' AND account_no = '$accountNo' AND id = '$id'
        ORDER BY
            transaction_date) s on p.id = s.id AND p.client_id = '$client' SET p.running_balance_derived = s.balance
        ");

        if(!$updateScript) {
                    printf('Error: %s\n', mysqli_error($connection));//checking for errors
                    exit();
                }else{
                    //output
                    echo 'Success'; 
                }
 }