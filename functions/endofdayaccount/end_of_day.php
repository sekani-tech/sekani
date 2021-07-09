<?php
include('../connect.php');
session_start();
<<<<<<< HEAD
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
=======

    if (isset($_POST['endofday'])) {
        $_SESSION['transact_date'] = $_POST['dateclosed'];
        $transact_date = $_POST['dateclosed'];
        $newDate = date("Y-m-d", strtotime($transact_date));

$int_id = $_SESSION['int_id'];
$stmt = $connection->prepare("SELECT account_balance_derived FROM institution_account WHERE int_id = '$int_id' ");
$stmt->execute();
$data_array = [];
foreach ($stmt->get_result() as $row)
{
    $data_array[] = $row['account_balance_derived'];
}
sort($data_array);
if (min($data_array) < 0){
    header("Location: ../../mfi/end_of_day.php?response=manual_vault");
}else if (min($data_array) > 0){
    header("Location: ../../mfi/update_tellers.php");
    }else{
        $data = [
        'transaction_date' => $newDate,
        'branch_id' => $_SESSION['branch_id'],
        'staff_id' => $_SESSION['staff_id'],
        'int_id' => $_SESSION['int_id'],
        'manual_posted' => 1,
    ];
    $insertendofday = insert('endofday_tb', $data);
    header("Location: ../../mfi/end_of_day.php?response=success");
    }
    }


>>>>>>> Victor
     ?>