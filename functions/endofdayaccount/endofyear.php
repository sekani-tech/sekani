<?php
include('../connect.php');
session_start();
//Convert date to month here

if (isset($_POST['endofyear'])) {
     $data = [
        'dateclosed' => $_POST['dateclosed'],
        'closed_by' => $_SESSION['staff_id'],
        'int_id' => $_SESSION['int_id'],
        'yearend' => getPieceOfDate($_POST['dateclosed'], "Y"),
        'status' =>"",
    ];
    
    //Insert into the endofyear table if it is set
    $endofyear = insert('endofyear_tb', $data);
      //Send report header on succesful closing of the month
      header("Location: ../../mfi/end_of_year.php?message1=$randms");
        }
     ?>   
