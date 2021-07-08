 <?php
  include("../../functions/connect.php");
  session_start();
  $out= '';
  $count = 1;

    if(!empty($_POST["start"]) && !empty($_POST["end"])) {
    $start = $_POST["start"];
    $end = $_POST["end"];
    $branch_id = $_POST["branch_id"];

    $getEOD = mysqli_query($connection, "SELECT * FROM `endofday_tb` WHERE transaction_date BETWEEN '$start' AND '$end' AND branch_id = $branch_id");
    
    
    
    if (mysqli_num_rows($getEOD) > 0) {
      while ($fetchEOD = mysqli_fetch_assoc($getEOD)) {

        $staff_id = $fetchEOD['staff_id'];
        $transaction_date = $fetchEOD['transaction_date'];

        $getStaffName = mysqli_query($connection, "SELECT display_name FROM `staff` WHERE id = $staff_id");
         while ($fetchStaffName = mysqli_fetch_array($getStaffName)) {
          $staff_name = $fetchStaffName['display_name']; 
        }
            echo'
            
              
                <tr>
                  <td>'.$count.'</td>
                  <td>'.$transaction_date.'</td>
                  <td>'.$staff_name.'</td>
                  <td><input type="checkbox" checked data-toggle="toggle" data-on="Open" data-off="Closed" data-onstyle="success" data-offstyle="danger"></td>
                </tr>';
              
              $count++;


      }
  }
       
}
?>