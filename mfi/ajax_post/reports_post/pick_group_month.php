<?php
include("../../../functions/connect.php");
session_start();

function branch_opt($connection)
{  
    $br_id = $_SESSION["branch_id"];
    $sint_id = $_SESSION["int_id"];
    $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
    $dof = mysqli_query($connection, $dff);
    $out = '';
    while ($row = mysqli_fetch_array($dof))
    {
      $do = $row['id'];
    $out .= " OR branch_id ='$do'";
    }
    return $out;
}
$br_id = $_SESSION["branch_id"];
$sessint_id = $_SESSION['int_id'];
$branches = branch_opt($connection);

if(isset($_POST['month'])){
    $mont = $_POST['month'];
    if($mont == 1){
       $mog = date('Y');
       $ns = "-01-01";
       $ms ="-01-31";
       $curren = $mog.$ns;
       $std = $mog.$ms;

       function fill_month($connection, $curren, $std, $br_id, $branches){
        $out = '';
        $oru = '';
        $sessint_id = $_SESSION['int_id'];
        $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '2'){
        $mog = date('Y');
        $ns = "-02-01";
        $ms ="-02-28";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_month($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '3'){
        $mog = date('Y');
        $ns = "-03-01";
        $ms ="-03-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_month($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '4'){
        $mog = date('Y');
        $ns = "-04-01";
        $ms ="-04-30";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_month($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '5'){
        $mog = date('Y');
        $ns = "-05-01";
        $ms ="-05-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_month($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '6'){
        $mog = date('Y');
        $ns = "-06-01";
        $ms ="-06-30";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_month($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '7'){
        $mog = date('Y');
        $ns = "-07-01";
        $ms ="-07-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_month($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '8'){
        $mog = date('Y');
        $ns = "-08-01";
        $ms ="-08-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_month($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '9'){
        $mog = date('Y');
        $ns = "-09-01";
        $ms ="-09-30";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_month($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '10'){
        $mog = date('Y');
        $ns = "-10-01";
        $ms ="-10-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_month($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $gname = $row["g_name"];
             $reg_type = $row["reg_type"];
             $meeting_day = $row["meeting_day"];
             $meeting_frequency = $row["meeting_frequency"];
             $meeting_time = $row["meeting_time"];
             $meeting_location = $row["meeting_location"];
         $oru .= 
         '<tr>
             <th>'.$gname.'</th>
             <th>'.$reg_type.'</th>
             <th>'.$meeting_day.'</th>
             <th>'.$meeting_frequency.'</th>
             <th>'.$meeting_time.'</th>
             <th>'.$meeting_location.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
        Group Name
      </th>
      <th>
        Reg Type
      </th>
      <th>
        Meeting Day
      </th>
      <th>
        Meeting Frequency
      </th>
      <th>
        Meeting Time
      </th>
      <th>
        Meeting Location
      </th>
        </tr>
        </thead>
        <tbody>
        '.fill_month($connection, $curren, $std, $br_id, $branches).'
        </tbody>';

        echo $out;
    }
    else if($mont == '11'){
        $mog = date('Y');
        $ns = "-11-01";
        $ms ="-11-30";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_monthd($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
             $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
            $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $gname = $row["g_name"];
                 $reg_type = $row["reg_type"];
                 $meeting_day = $row["meeting_day"];
                 $meeting_frequency = $row["meeting_frequency"];
                 $meeting_time = $row["meeting_time"];
                 $meeting_location = $row["meeting_location"];
             $oru .= 
             '<tr>
                 <th>'.$gname.'</th>
                 <th>'.$reg_type.'</th>
                 <th>'.$meeting_day.'</th>
                 <th>'.$meeting_frequency.'</th>
                 <th>'.$meeting_time.'</th>
                 <th>'.$meeting_location.'</th>
             </tr>
             ';
        }
        return $oru;
    }
            $out = '
            <thead class=" text-primary">
            <tr>
            <th>
            Group Name
          </th>
          <th>
            Reg Type
          </th>
          <th>
            Meeting Day
          </th>
          <th>
            Meeting Frequency
          </th>
          <th>
            Meeting Time
          </th>
          <th>
            Meeting Location
          </th>
            </tr>
            </thead>
            <tbody>
            '.fill_monthd($connection, $curren, $std, $br_id, $branches).'
            </tbody>';
    
            echo $out;
    }
    else if($mont == '12'){
        $mog = date('Y');
        $ns = "-12-01";
        $ms ="-12-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        function fill_montha($connection, $curren, $std, $br_id, $branches){
            $out = '';
            $oru = '';
            $sessint_id = $_SESSION['int_id'];
            $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
            $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $gname = $row["g_name"];
                 $reg_type = $row["reg_type"];
                 $meeting_day = $row["meeting_day"];
                 $meeting_frequency = $row["meeting_frequency"];
                 $meeting_time = $row["meeting_time"];
                 $meeting_location = $row["meeting_location"];
             $oru .= 
             '<tr>
                 <th>'.$gname.'</th>
                 <th>'.$reg_type.'</th>
                 <th>'.$meeting_day.'</th>
                 <th>'.$meeting_frequency.'</th>
                 <th>'.$meeting_time.'</th>
                 <th>'.$meeting_location.'</th>
             </tr>
             ';
        }
        return $oru;
    }
            $out = '
            <thead class=" text-primary">
            <tr>
            <th>
            Group Name
          </th>
          <th>
            Reg Type
          </th>
          <th>
            Meeting Day
          </th>
          <th>
            Meeting Frequency
          </th>
          <th>
            Meeting Time
          </th>
          <th>
            Meeting Location
          </th>
            </tr>
            </thead>
            <tbody>
            '.fill_montha($connection, $curren, $std, $br_id, $branches).'
            </tbody>';
    
            echo $out;
    }
    }
    else {
        echo 'No Data';
    }
?>