<?php
include('../connect.php');
session_start();
//Convert date to month here

if (isset($_POST['endofyear'])) {
     $data = [
        'transaction_date' => $_POST['dateclosed'],
        'staff_id' => $_SESSION['staff_id'],
        'int_id' => $_SESSION['int_id'],
        'branch_id' => $_SESSION['branch_id'],
        'year' => getYear($_POST['dateclosed']),
        'manual_posted' => 1,
    ];
    
    //Insert into the endofyear table if it is set
    $endofyear = insert('endofyear_tb', $data);
      //Send report header on succesful closing of the month
      header("Location: ../../mfi/end_of_year.php?message1=$randms");
        }
     ?> 