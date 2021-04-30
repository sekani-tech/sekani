<?php
include('../connect.php');
session_start();
// initializing the needed session variable
$institutionId = $_SESSION['int_id'];
$branchId  = $_SESSION['branch_id'];
$staffId = $_SESSION['staff_id'];

if (isset($_POST['endofyear'])) {
     $data = [
        'dateclosed' => $_POST['dateclosed'],
        'closed_by' => $staffId,
        'int_id' => $institutionId,
        'branch_id' => $branchId,
        'yearend' => getPieceOfDate($_POST['dateclosed'], "Y"),
        'status' =>"",
    ];
    
    //Insert into the endofyear table if it is set
    $endofyear = insert('endofyear_tb', $data);
      //Send report header on succesful closing of the month
      header("Location: ../../mfi/end_of_year.php?message1=$randms");
        }
     ?>   
