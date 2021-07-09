<?php
include('../connect.php');
<<<<<<< HEAD
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['endofmonth'])) {
    // Perform End of Month
   $closedDate = $_POST['closedDate'];
    
   endOfMonth($closedDate,$connection, function($r,$check){
        $digits = 7;
        $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

       if($check==0) {
            $_SESSION['feedback'] = $r;
            header("Location: ../../mfi/end_of_month.php?message=$randms");
       } else {
            $_SESSION['feedback'] = $r.'! ';
            header("Location: ../../mfi/end_of_month.php?message1=$randms");
       }

     
   });

} else {
    // Generate End Of Month Report
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $branch = $_POST['branch'];

    $startDate_timestamp = strtotime($startDate.' 00:00:00');
    $endDate_timestamp = strtotime($endDate.' 24:00:00');

    $result = selectAll('endofmonth_tb',['branch_id'=>$branch]);
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
// include('')
session_start();
//Convert date to month here
//check if month is set 
if (isset($_POST['endofmonth'])) {
     $data = [
        'dateclosed' => $_POST['dateclosed'],
        'closed_by' => $_SESSION['staff_id'],
        'int_id' => $_SESSION['int_id'],
        'branch_id' => $_SESSION['branch_id'],
         'monthend' => getPieceOfDate($_POST['dateclosed'], "F"),
         'yearclosed' => getPieceOfDate($_POST['yearclosed'], "Y"),
        'status' =>"",
    ];
    //Insert into the endofmonth table if it is set
    $endofthemonth = insert('endofmonth_tb',$data);
    //Send report header on succesful closing of the month
    header("Location: ../../mfi/end_of_month.php?message1=$randms");

    $year = getPieceOfDate($_POST['dateclosed'],'Y'); 
    $nowYear = date('Y');
  
    if($year==$nowyear){
        $month = getPieceOfDate($_POST['dateclosed'],'M');
        $nowmonth = date('m');
        if($month == $nowmonth){
            $day =  getPieceOfDate($_POST['dateclosed'],"n");
            $nowDay = date('n');
            if($day== $nowDay){
       
             
            }

         
        }
    }

  

        }
        ?>
>>>>>>> Victor
