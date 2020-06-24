<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
  $intname = $_SESSION['int_name'];
  $branch_id = $_SESSION["branch_id"];
  $date = date('d/m/Y');
  // $staff = $_POST["staff"];
  $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
      $branch_email = $ans['email'];
      $branch_location = $ans['location'];
      $branch_phone = $ans['phone'];
    }
    if(isset($_POST["start"]) && isset($_POST["end"])) {
        $start = $_POST["start"];
        $end = $_POST["end"];
        $branch = $_POST["branch"];
      
      $don1 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '1' AND submittedon_date BETWEEN '$start' AND '$end'");
      $dona = mysqli_query($connection, "SELECT loan_sub_status_id FROM loan WHERE int_id = '$sessint_id' AND loan_sub_status_id = '1' AND submittedon_date BETWEEN '$start' AND '$end'");
      $sector1 = mysqli_num_rows($dona);
      $se1 = mysqli_fetch_array($don1);
      $amount1 = $se1['principal_amount'];
      
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
      
      $ttunt = $amount1 + $amount2 + $amount3 + $amount4 + $amount5 + $amount6 + $amount7 + $amount8 + $amount9 + $amount10 + $amount11;
      $ttlsector = $sector1 + $sector2 + $sector3 + $sector4 + $sector5 + $sector6 + $sector7 + $sector8 + $sector9 + $sector10 + $sector11;
      $ttlamount =number_format($ttunt);
      
  require_once __DIR__ . '/vendor/autoload.php';
  $mpdf = new \Mpdf\Mpdf();
  $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
  $mpdf->showWatermarkImage = true;
  $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
  <header class="clearfix">
<div id="logo">
  <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
</div>
<h1>'.$_SESSION["int_full"].' <br/> Client List Report</h1>
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
  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title">Sectoral Analysis of Loans and Advances</h4>
    </div>
    <div class="card-body">
      <table class="table">
        <thead>
          <th style="font-weight:bold;">SECTOR</th>
          <th style="font-weight:bold; text-align: center;">NUMBER OF LOANS</th>
          <th style="font-weight:bold; text-align: center;">AMOUNT <br> &#x20A6</th>
          <th style="font-weight:bold; text-align: center;">%</th>
        </thead>
        <tbody>
            <tr>
                <td>Agriculture, Mining & Quarry</td>
                <td style="text-align: center;">'.$sector1.'</td>
                <td style="text-align: center;">'.$amount1.'</td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Manufacturing</td>
                <td style="text-align: center;">'.$sector2.'</td>
                <td style="text-align: center;">'.$amount2.'</td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Agricultural sector</td>
                <td style="text-align: center;">'.$sector3.'</td>
                <td style="text-align: center;">'.$amount3.'</td>>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Banking</td>
                <td style="text-align: center;">'.$sector4.'</td>
                <td style="text-align: center;">'.$amount4.'</td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Public Service</td>
                <td style="text-align: center;">'.$sector5.'</td>
                <td style="text-align: center;">'.$amount5.'</td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Health</td>
                <td style="text-align: center;">'.$sector6.'</td>
                <td style="text-align: center;">'.$amount6.'</td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Education</td>
                <td style="text-align: center;">'.$sector7.'</td>
                <td style="text-align: center;">'.$amount7.'</td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Tourism</td>
                <td style="text-align: center;">'.$sector8.'</td>
                <td style="text-align: center;">'.$amount8.'</td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Civil Service</td>
                <td style="text-align: center;">'.$sector9.'</td>
                <td style="text-align: center;">'.$amount9.'</td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Trade & Commerce</td>
                <td style="text-align: center;">'.$sector10.'</td>
                <td style="text-align: center;">'.$amount10.'</td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
            <td>Others</td>
            <td style="text-align: center;">'.$sector11.'</td>
            <td style="text-align: center;">'.$amount11.'</td>
            <td style="background-color:bisque;"></td>
        </tr>
            <tr>
                <td><b>TOTAL</b></td>
                <th style=" text-align: center; background-color:bisque;"><b>'.$ttlsector.'</b></th>
                <th style="text-align: center; background-color:bisque;"><b>'.$ttlamount.'</b></th>
                <th style="text-align: center; background-color:bisque;"><b></b></th>
            </tr>
        </tbody>
      </table>
    </div>
  </main>
  ');
  $file_name = 'Loan Analysis Report for '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
    }
?>