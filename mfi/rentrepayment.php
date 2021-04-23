<?php
//include('../connect.php');
include("../functions/connect.php");
 session_start();
if (isset($_POST['submit'])) {
     $data = [
        'year' => $_POST['startyear'],
        'int_id' => $_SESSION['int_id'],
        'branch_id' => $_SESSION['branch_id'],
        'amount' => $_POST['amount'],
        'gl_code' => $_POST['glcode'],
        'expense_gl_code' => $_POST['expenseglcode'],
        
        'prepayment_account_id' => $_POST['prepayment_account_id'],
        'expense_amount' => $_POST['expense_amount'],
        'expense_date' => $_POST['expense_date'],
        'expended' => $_POST['expended'],
        

    ];
    $insertprepaymentacct = insert('prepayment_account', $data);
    $insertprepaymentacct = insert('prepayment_account', $data);
    header("Location:rent_repayment.php?message1=$randms");
   

      
    }
     ?>