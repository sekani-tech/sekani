<?php
include('../connect.php');
session_start();
<<<<<<< HEAD
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['endofyear'])) {
    // Perform End of Month
   $closedDate = $_POST['closedDate'];
    
    endOfYear($closedDate,$connection);
} else {
    // Generate End Of Month Report
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $branch = $_POST['branch'];

    $startDate_timestamp = strtotime($startDate.' 00:00:00');
    $endDate_timestamp = strtotime($endDate.' 24:00:00');

    $result = selectAll('endofyear_tb',['branch_id'=>$branch]);
    $generatedData = [];

    
    foreach($result as $r) {
        $created_on = strtotime($r['created_on']);
        if($created_on >= $startDate_timestamp && $created_on <= $endDate_timestamp) {
            // Get staff name
            $staff = selectAll('staff', ['id'=>$r['staff_id']]);
            $r['staff_name'] = $staff[0]['display_name'];
            // push data
            array_push($generatedData, $r);
        }
    }

    echo json_encode($generatedData);
}
?>

=======
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
>>>>>>> Victor
