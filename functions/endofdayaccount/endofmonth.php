<?php
include('../connect.php');
// include('')
session_start();
//Convert date to month here
//check if month is set 
if (isset($_POST['endofmonth'])) {
     $data = [
        'dateclosed' => $_POST['dateclosed'],
        'closed_by' => $_SESSION['staff_id'],
        'int_id' => $_SESSION['int_id'],
         'monthend' => getPieceOfDate($_POST['dateclosed'], "F"),
         'yearclosed' => getPieceOfDate($_POST['yearclosed'], "Y"),
        'status' =>"",
    ];
    //Insert into the endofmonth table if it is set
    $endofthemonth = create('endofmonth_tb',$data);
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
