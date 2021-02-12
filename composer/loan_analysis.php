<?php
$output = '';
include("../functions/connect.php");
session_start();

if(isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["branch_id"])) {
    $intname = $_SESSION['int_name'];
    $date = date('d/m/Y');
    $sessint_id =  $_SESSION['int_id'];
    $branch_id = $_POST["branch_id"];
    $start = $_POST['start'];
    $end = $_POST['end'];
    // $staff = $_POST["staff"];
    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");

    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
      $branch_email = $ans['email'];
      $branch_location = $ans['location'];
      $branch_phone = $ans['phone'];
    }

    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
    while ($result = mysqli_fetch_array($getParentID)) {
        $parent_id = $result['parent_id'];
    }

    if ($parent_id == 0) {
        $don1 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '1' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se1 = mysqli_fetch_array($don1);
        $amount1 = $se1['principal_amount'];
        $dona = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '1' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector1 = mysqli_num_rows($dona);
        
        $don2 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '2' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don2);
        $amount2 = $se['principal_amount'];
        $donb = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '2' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector2 = mysqli_num_rows($donb);

        $don3 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '3' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don3);
        $amount3 = $se['principal_amount'];
        $donc = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '3' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector3 = mysqli_num_rows($donc);

        $don4 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '4' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don4);
        $amount4 = $se['principal_amount'];
        $dond = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '4' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector4 = mysqli_num_rows($dond);

        $don5 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '5' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don5);
        $amount5 = $se['principal_amount'];
        $done = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '5' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector5 = mysqli_num_rows($done);

        $don6 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '6' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don6);
        $amount6 = $se['principal_amount'];
        $donf = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '6' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector6 = mysqli_num_rows($donf);

        $don7 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '7' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don7);
        $amount7 = $se['principal_amount'];
        $dong = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '7' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector7 = mysqli_num_rows($dong);

        $don8 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '8' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don8);
        $amount8 = $se['principal_amount'];
        $donh = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '8' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector8 = mysqli_num_rows($donh);

        $don9 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '9' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don9);
        $amount9 = $se['principal_amount'];
        $doni = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '9' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector9 = mysqli_num_rows($doni);

        $don10 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '10' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don10);
        $amount10 = $se['principal_amount'];
        $donj = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '10' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector10 = mysqli_num_rows($donj);

        $don11 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '11' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se = mysqli_fetch_array($don11);
        $amount11 = $se['principal_amount'];
        $donk = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '11' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector11 = mysqli_num_rows($donk);

    } else {
        $don1 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '1' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se1 = mysqli_fetch_array($don1);
        $amount1 = $se1['principal_amount'];
        $dona = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '1' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector1 = mysqli_num_rows($dona);

        $don2 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '2' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se2 = mysqli_fetch_array($don2);
        $amount2 = $se2['principal_amount'];
        $donb = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '2' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector2 = mysqli_num_rows($donb);

        $don3 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '3' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se3 = mysqli_fetch_array($don3);
        $amount3 = $se3['principal_amount'];
        $donc = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '3' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector3 = mysqli_num_rows($donc);

        $don4 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '4' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se4 = mysqli_fetch_array($don4);
        $amount4 = $se4['principal_amount'];
        $dond = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '4' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector4 = mysqli_num_rows($dond);

        $don5 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '5' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se5 = mysqli_fetch_array($don5);
        $amount5 = $se5['principal_amount'];
        $done = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '5' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector5 = mysqli_num_rows($done);
        
        $don6 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '6' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se6 = mysqli_fetch_array($don6);
        $amount6 = $se6['principal_amount'];
        $donf = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '6' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector6 = mysqli_num_rows($donf);

        $don7 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '7' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se7 = mysqli_fetch_array($don7);
        $amount7 = $se7['principal_amount'];
        $dong = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '7' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector7 = mysqli_num_rows($dong);
        
        $don8 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '8' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se8 = mysqli_fetch_array($don8);
        $amount8 = $se8['principal_amount'];
        $donh = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '8' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector8 = mysqli_num_rows($donh);

        $don9 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '9' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se9 = mysqli_fetch_array($don9);
        $amount9 = $se9['principal_amount'];
        $doni = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '9' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector9 = mysqli_num_rows($doni);

        $don10 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '10' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se10 = mysqli_fetch_array($don10);
        $amount10 = $se10['principal_amount'];
        $donj = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '10' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector10 = mysqli_num_rows($donj);

        $don11 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '11' AND submittedon_date BETWEEN '$start' AND '$end'");
        $se11 = mysqli_fetch_array($don11);
        $amount11 = $se11['principal_amount'];
        $donk = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND loan_sub_status_id = '11' AND submittedon_date BETWEEN '$start' AND '$end'");
        $sector11 = mysqli_num_rows($donk);
    }

    $ttunt = $amount1 + $amount2 + $amount3 + $amount4 + $amount5 + $amount6 + $amount7 + $amount8 + $amount9 + $amount10 + $amount11;
    $ttlsector = $sector1 + $sector2 + $sector3 + $sector4 + $sector5 + $sector6 + $sector7 + $sector8 + $sector9 + $sector10 + $sector11;
    $ttlamount = number_format($ttunt, 2);

    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
    $mpdf->showWatermarkImage = true;
    $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
    <header class="clearfix">
      <div id="logo">
        <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
      </div>
      <h1>'.$_SESSION["int_full"].' <br/> Loan Analysis Schedule</h1>
      <div id="company" class="clearfix">
        <div>'.$branch.'</div>
        <div>'.$branch_location.'</div>
        <div>(+234) '.$branch_phone.'</div>
        <div><a href="mailto:'.$branch_email.'">'.$branch_email.'</a></div>
      </div>
      <div id="project">
        <div><span>BRANCH</span> '.$branch.' </div>
      </div>
    </header>
    <main>
      <table class="table">
        <thead class=" text-primary">
          <tr>
            <th style="font-size: 30px;" class="column1">
              SECTOR
            </th>
            <th style="font-size: 30px;" class="column1">
              NUMBER OF LOANS
            </th>
            <th style="font-size: 30px;" class="column1">
              AMOUNT &#x20A6
            </th>
            <th style="font-size: 30px;" class="column1">
              %
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <th style="font-size: 30px;" class="column1">Agriculture, Mining & Quarry</th>
              <th style="font-size: 30px;" class="column1">'.$sector1.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount1.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Manufacturing</th>
              <th style="font-size: 30px;" class="column1">'.$sector2.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount2.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Agricultural sector</th>
              <th style="font-size: 30px;" class="column1">'.$sector3.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount3.'</th>>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Banking</th>
              <th style="font-size: 30px;" class="column1">'.$sector4.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount4.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Public Service</th>
              <th style="font-size: 30px;" class="column1">'.$sector5.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount5.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Health</th>
              <th style="font-size: 30px;" class="column1">'.$sector6.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount6.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Education</th>
              <th style="font-size: 30px;" class="column1">'.$sector7.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount7.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Tourism</th>
              <th style="font-size: 30px;" class="column1">'.$sector8.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount8.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Civil Service</th>
              <th style="font-size: 30px;" class="column1">'.$sector9.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount9.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Trade & Commerce</th>
              <th style="font-size: 30px;" class="column1">'.$sector10.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount10.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1">Others</th>
              <th style="font-size: 30px;" class="column1">'.$sector11.'</th>
              <th style="font-size: 30px;" class="column1">'.$amount11.'</th>
              <th  class="column1" style="background-color:bisque;"></th>
          </tr>
          <tr>
              <th style="font-size: 30px;" class="column1"><b>TOTAL</b></th>
              <th style="font-size: 30px;" class="column1"><b>'.$ttlsector.'</b></th>
              <th style="font-size: 30px;" class="column1"><b>'.$ttlamount.'</b></th>
              <th style="font-size: 30px;" class="column1"><b></b></th>
          </tr>
        </tbody>
      </table>
    </main>
  ');
  $file_name = 'Loan Analysis Report for '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
}

?>
