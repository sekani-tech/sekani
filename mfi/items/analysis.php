 <?php
  include("../../functions/connect.php");
  session_start();
  $out= '';
  $logo = $_SESSION["int_logo"];
  $name = $_SESSION['int_name'];
  $sessint_id = $_SESSION['int_id'];
  $rom = "do";

  if(!empty($_POST["start"]) && !empty($_POST["end"])) {
    $start = $_POST["start"];
    $end = $_POST["end"];
    $branch_id = $_POST["branch_id"];

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

    $ttlsector = $sector1 + $sector2 + $sector3 + $sector4 + $sector5 + $sector6 + $sector7 + $sector8 + $sector9 + $sector10 + $sector11;
    $ttunt = $amount1 + $amount2 + $amount3 + $amount4 + $amount5 + $amount6 + $amount7 + $amount8 + $amount9 + $amount10 + $amount11;

    $percentAmount1 = !empty($amount1) ? round(($amount1 / $ttunt * 100), 2) : '';
    $percentAmount2 = !empty($amount2) ? round(($amount2 / $ttunt * 100), 2) : '';
    $percentAmount3 = !empty($amount3) ? round(($amount3 / $ttunt * 100), 2) : '';
    $percentAmount4 = !empty($amount4) ? round(($amount4 / $ttunt * 100), 2) : '';
    $percentAmount5 = !empty($amount5) ? round(($amount5 / $ttunt * 100), 2) : '';
    $percentAmount6 = !empty($amount6) ? round(($amount6 / $ttunt * 100), 2) : '';
    $percentAmount7 = !empty($amount7) ? round(($amount7 / $ttunt * 100), 2) : '';
    $percentAmount8 = !empty($amount8) ? round(($amount8 / $ttunt * 100), 2) : '';
    $percentAmount9 = !empty($amount9) ? round(($amount9 / $ttunt * 100), 2) : '';
    $percentAmount10 = !empty($amount10) ? round(($amount10 / $ttunt * 100), 2) : '';
    $percentAmount11 = !empty($amount11) ? round(($amount11 / $ttunt * 100), 2) : '';

    $ttlamount = number_format($ttunt, 2);

    $out ='
    `<div class="card">
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
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount1.'</td>
                    </tr>
                    <tr>
                        <td>Manufacturing</td>
                        <td style="text-align: center;">'.$sector2.'</td>
                        <td style="text-align: center;">'.$amount2.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount2.'</td>
                    </tr>
                    <tr>
                        <td>Agricultural sector</td>
                        <td style="text-align: center;">'.$sector3.'</td>
                        <td style="text-align: center;">'.$amount3.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount3.'</td>
                    </tr>
                    <tr>
                        <td>Banking</td>
                        <td style="text-align: center;">'.$sector4.'</td>
                        <td style="text-align: center;">'.$amount4.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount4.'</td>
                    </tr>
                    <tr>
                        <td>Public Service</td>
                        <td style="text-align: center;">'.$sector5.'</td>
                        <td style="text-align: center;">'.$amount5.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount5.'</td>
                    </tr>
                    <tr>
                        <td>Health</td>
                        <td style="text-align: center;">'.$sector6.'</td>
                        <td style="text-align: center;">'.$amount6.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount6.'</td>
                    </tr>
                    <tr>
                        <td>Education</td>
                        <td style="text-align: center;">'.$sector7.'</td>
                        <td style="text-align: center;">'.$amount7.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount7.'</td>
                    </tr>
                    <tr>
                        <td>Tourism</td>
                        <td style="text-align: center;">'.$sector8.'</td>
                        <td style="text-align: center;">'.$amount8.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount8.'</td>
                    </tr>
                    <tr>
                        <td>Civil Service</td>
                        <td style="text-align: center;">'.$sector9.'</td>
                        <td style="text-align: center;">'.$amount9.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount9.'</td>
                    </tr>
                    <tr>
                        <td>Trade & Commerce</td>
                        <td style="text-align: center;">'.$sector10.'</td>
                        <td style="text-align: center;">'.$amount10.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount10.'</td>
                    </tr>
                    <tr>
                        <td>Others</td>
                        <td style="text-align: center;">'.$sector11.'</td>
                        <td style="text-align: center;">'.$amount11.'</td>
                        <td style="background-color:bisque; text-align: center;">'.$percentAmount11.'</td>
                    </tr>
                    <tr>
                        <td><b>TOTAL</b></td>
                        <th style="text-align: center; background-color:bisque;"><b>'.$ttlsector.'</b></th>
                        <th style="text-align: center; background-color:bisque;"><b>'.$ttlamount.'</b></th>
                        <th style="text-align: center; background-color:bisque;"><b></b></th>
                    </tr>
                </tbody>
            </table>

            <div class="form-group mt-4">
                <form method = "POST" action = "../composer/loan_analysis.php">
                    <input hidden name ="branch_id" type="text" value="'.$branch_id.'"/>
                    <input hidden name ="start" type="text" value="'.$start.'"/>
                    <input hidden name ="end" type="text" value="'.$end.'"/>
                    <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download PDF</button>
                </form>
            </div>
        </div>
    </div>`
    ';
    echo $out;
}
?>