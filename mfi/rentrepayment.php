<?php
include("../functions/connect.php");
 session_start();
// initializing the needed session variable
 $institutionId = $_SESSION['int_id'];
 $branchId  = $_SESSION['branch_id'];
 $staffId = $_SESSION['staff_id'];
 
if (isset($_POST['submit'])) {
    // initializing post values
    $year = $_POST['year'];
    $prepaymentGl = $_POST['glcode'];
    $expenseGl = $_POST['expenseglcode'];
    $amount =  $_POST['amount'];

    if (isset($_POST['prepayment_made']) && isset($_POST['id'])) {
        $prepayment_made = $_POST['prepayment_made'];
        $id = $_POST['id'];
        $query = mysqli_query($connection, "UPDATE prepayment_account SET prepayment_made=$prepayment_made WHERE id=$id");
    }
    
    


    // insert data into prepayment account table
    // start by finding start and end date of prepayment
    // record data after generating it.
    # function starts here
    $query_date = $year;
     // start Date.
    $startdate = date('Y-m-now', strtotime($query_date));
     // End Date.
   $enddate = date('Y-m-today', strtotime($query_date));
    # first find 12months  from the given date
    $prepaymentData = [
        'int_id' => $institutionId,
        'branch_id' => $branchId,
        'gl_code' => $prepaymentGl,
        'expense_gl_code' => $expenseGl,
        'prepayment_made' => 0,
        'start_date' =>   $startdate,
        'end_date' =>   $enddate,
        'created_by' => $staffId,
        'amount' => $amount
    ];
    // insert into prepayment table 
    $insertprepayment = insert('prepayment_account',$prepaymentData);
    //dd( $insertprepayment);
    # conditional statement

     if($insertprepayment){
        $query = mysqli_query($connection, "SELECT id FROM prepayment_account");
        $rows = mysqli_fetch_all($query );
       // echo implode(',',array_column($rows, 'id' ));
    //dd($rows);
   $installmentAmount = $amount / 12; 
   $loanexpenseData = [
    'int_id' => $institutionId,
    'branch_id' => $branchId,
    'prepayment_account_id' => $rows,
    'expended' => 0,
    'expense_amount' => $installmentAmount,
    'expense_date' => $enddate,
    
];
$insertprepayment = insert('prepayment_schedule', $loanexpenseData);
    }
    # if insert is successful
    # collect id of inserted row so as to insert on the prepayment_account_id 
    // find installment amounts
    //$installmentAmount = $amount / 12;
    # generate schedule - loop from start date to end date to generate 
    # data for each installment
    # data to be generated are;
    // expense amount - is already generated as $installmentAmount
    // expense date 
    # insert each installment
    # once done provide success message.
     
    header("Location:rent_repayment.php?message1=$randms");  
    }


     ?>