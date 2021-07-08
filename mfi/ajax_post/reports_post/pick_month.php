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
    $out .= " OR client.branch_id ='$do'";
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
        $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' AND (client.branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
         while($row = mysqli_fetch_array($result)) {
             $cid= $row["id"];
             $first = $row["firstname"];
             $last = $row["lastname"];
             $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
             $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
             if (count([$atype]) == 1) {
                 $yxx = mysqli_fetch_array($atype);
                 $actype = $yxx['product_id'];
                 $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
             if (count([$spn])) {
                 $d = mysqli_fetch_array($spn);
                 if (isset($d["name"])){
                 $savingp = $d["name"];
                 }
             }
             }
             $acc_no = $row["account_no"];
             $phone = $row["mobile_no"];
         $oru .= 
         '<tr>
             <th>'.$first.'</th>
             <th>'.$last.'</th>
             <th>'.$acc_off.'</th>
             <th>'.$savingp.'</th>
             <th>'.$acc_no.'</th>
             <th>'.$phone.'</th>
         </tr>
         ';
    }
    return $oru;
}
        $out = '
        <thead class=" text-primary">
        <tr>
        <th>
            First Name
        </th>
        <th>
            Last Name
        </th>
        <th>
            Account officer
        </th>
        <th>
            Account Type
        </th>
        <th>
            Account Number
        </th>
        <th>
            Phone
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
            $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
            $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
            $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
            $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
            $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
            $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
            $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
            $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
             $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
             $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
             $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
             $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
             $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
             $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
             $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
             $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
             $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
             $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
             $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
             $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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
             $query = "SELECT client.id, client.account_type, client.client_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' AND (client.branch_id ='$br_id' $branches)";
             $result = mysqli_query($connection, $query);
             while($row = mysqli_fetch_array($result)) {
                 $cid= $row["id"];
                 $first = $row["firstname"];
                 $last = $row["lastname"];
                 $acc_off = strtoupper($row["first_name"]." ".$row["last_name"]);
                 $atype = mysqli_query($connection, "SELECT * FROM account WHERE int_id ='$sessint_id' AND client_id = '$cid'");
                 if (count([$atype]) == 1) {
                     $yxx = mysqli_fetch_array($atype);
                     $actype = $yxx['product_id'];
                     $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                 if (count([$spn])) {
                     $d = mysqli_fetch_array($spn);
                     if (isset($d["name"])){
                     $savingp = $d["name"];
                     }
                 }
                 }
                 $acc_no = $row["account_no"];
                 $phone = $row["mobile_no"];
             $oru .= 
             '<tr>
                 <th>'.$first.'</th>
                 <th>'.$last.'</th>
                 <th>'.$acc_off.'</th>
                 <th>'.$savingp.'</th>
                 <th>'.$acc_no.'</th>
                 <th>'.$phone.'</th>
             </tr>
             ';
        }
        return $oru;
    }
         $out = '
         <thead class=" text-primary">
         <tr>
         <th>
             First Name
         </th>
         <th>
             Last Name
         </th>
         <th>
             Account officer
         </th>
         <th>
             Account Type
         </th>
         <th>
             Account Number
         </th>
         <th>
             Phone
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