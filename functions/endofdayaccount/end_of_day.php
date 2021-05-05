<?php
include('../connect.php');
session_start();
if (isset($_POST['endofday'])) {
     $data = [
        'dateclosed' => $_POST['dateclosed'],
        'branch_id' => $_SESSION['branch_id'],
        'closedby' => $_SESSION['staff_id'],
        'int_id' => $_SESSION['int_id'],
        'status' =>"",
    ];
    $insertendofday = insert('endofday_tb', $data);
    header("Location: ../../mfi/end_of_day.php?message1=$randms");
   

      
    }
     ?>