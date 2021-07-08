<?php
include("../functions/connect.php");
session_start();

require_once __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if(isset($_POST["downloadPDF"])) {

    if (!empty($_POST["date"]) && !empty($_POST["branch_id"])) {

        $sessint_id = $_SESSION['int_id'];
        $branch_id = $_POST["branch_id"];
        $date = $_POST["date"];

        $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '$sessint_id' AND id = '$branch_id'");
        if (count([$branchquery]) == 1) {
            $ans = mysqli_fetch_array($branchquery);
            $branch = $ans['name'];
            $branch_email = $ans['email'];
            $branch_location = $ans['location'];
            $branch_phone = $ans['phone'];
        }

        function fill_assets($connection, $sessint_id, $branch_id, $date) {

            $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
            while ($result = mysqli_fetch_array($getParentID)) {
                $parent_id = $result['parent_id'];
            }

            if ($parent_id == 0) {
                $current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current asset')");
                $non_current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non current asset' || 'non-current asset')");
            } else {
                $current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current asset')");
                $non_current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non current asset' || 'non-current asset')");
            }
            
            // Current Assets
            $total_ca_value = 0;

            $gl_acc_assets = '
            <tr>
                <td><b>Current Assets</b></td>
                <td></td>
            </tr>
            ';

            while($ca_type = mysqli_fetch_array($current_assets_list)) {
                $ca = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$ca_type['gl_code']} AND transaction_date <= '$date'");
                $ca = mysqli_fetch_array($ca);
                $ca_credit = $ca['credit'];
                $ca_debit = $ca['debit'];
            
                $ca_value = $ca_credit - $ca_debit;
            
                $GLOBALS['total_ca_value'] += $ca_credit - $ca_debit;
            
                $gl_acc_assets .= '
                <tr>
                    <td>'.ucfirst(strtolower($ca_type['name'])).'</td>
                    <td style="text-align: center">₦ '.number_format($ca_value, 2).'</td>
                </tr>
                ';
            }

            $gl_acc_assets .= '
            <tr style="background-color: #eeeeee">
                <td><b>Total Current Assets</b></td>
                <td style="text-align: center"><b>₦ '.number_format($total_ca_value, 2).'</b></td>
            </tr>
            <tr>
                <td><b>Non-Current Assets</b></td>
                <td></td>
            </tr>
            ';

            // Non-Current Assets
            $total_nca_value = 0;

            while($nca_type = mysqli_fetch_array($non_current_assets_list)) {
                $nca = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$nca_type['gl_code']} AND transaction_date <= '$date'");
                $nca = mysqli_fetch_array($nca);
                $nca_credit = $nca['credit'];
                $nca_debit = $nca['debit'];

                $nca_value = $nca_credit - $nca_debit;

                $total_nca_value += $nca_credit - $nca_debit;

                $gl_acc_assets .= '
                <tr>
                    <td>'.ucfirst(strtolower($nca_type['name'])).'</td>
                    <td style="text-align: center">₦ '.number_format($nca_value, 2).'</td>
                </tr>
                ';
            }

            $total_asset_value = $total_ca_value + $total_nca_value;

            $gl_acc_assets .= '
            <tr style="background-color: #eeeeee">
                <td><b>Total Non-Current Assets</b></td>
                <td style="text-align: center"><b>₦ '.number_format($total_nca_value, 2).'</b></td>
            </tr>

            <tr>
                <td><b>Less: Accumulated Depreciation</b></td>
                <td style="text-align: center"><b></b></td>
            </tr>

            <tr>
                <td><b>NPV</b></td>
                <td style="text-align: center"><b></b></td>
            </tr>

            <tr style="background-color: #aaaaaa">
                <td><b>Total Asset</b></td>
                <td style="text-align: center"><b>₦ '.number_format($total_asset_value, 2).'</b></td>
            </tr>
            ';

            return $gl_acc_assets;
        }

        function fill_liabilities_equity($connection, $sessint_id, $branch_id, $date) {

            $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
            while ($result = mysqli_fetch_array($getParentID)) {
                $parent_id = $result['parent_id'];
            }

            if ($parent_id == 0) {
                $current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current liability')");
                $non_current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non-current liability' || 'non current liability')");
                $equity_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id <> '0' AND classification_enum = '3'");
            } else {
                $current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current liability')");
                $non_current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non-current liability' || 'non current liability')");
                $equity_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND parent_id <> '0' AND classification_enum = '3'");
            }
            
            $total_cl_value = 0;

            $gl_acc_liabilities_equity = '
            <tr>
                <td><b>Current Liabilities</b></td>
                <td></td>
            </tr>
            ';

            while($cl_type = mysqli_fetch_array($current_liabilities_list)) {
                $cl = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$cl_type['gl_code']} AND transaction_date <= '$date'");
                $cl = mysqli_fetch_array($cl);
                $cl_credit = $cl['credit'];
                $cl_debit = $cl['debit'];
            
                $cl_value = $cl_credit - $cl_debit;
            
                $total_cl_value += $cl_credit - $cl_debit;
            
                $gl_acc_liabilities_equity .= '
                <tr>
                    <td>'.ucfirst(strtolower($cl_type['name'])).'</td>
                    <td style="text-align: center">₦ '.number_format($cl_value, 2).'</td>
                </tr>
                ';
            }

            $gl_acc_liabilities_equity .= '
            <tr style="background-color: #eeeeee">
                <td><b>Total Current Liabilities</b></td>
                <td style="text-align: center"><b>₦ '.number_format($total_cl_value, 2).'</b></td>
            </tr>

            <tr>
                <td><b>Non-Current Liabilities</b></td>
                <td></td>
            </tr>
            ';

            $total_ncl_value = 0;

            while($ncl_type = mysqli_fetch_array($non_current_liabilities_list)) {
                $ncl = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$ncl_type['gl_code']} AND transaction_date <= '$date'");
                $ncl = mysqli_fetch_array($ncl);
                $ncl_credit = $ncl['credit'];
                $ncl_debit = $ncl['debit'];

                $ncl_value = $ncl_credit - $ncl_debit;

                $total_ncl_value += $ncl_credit - $ncl_debit;

                $gl_acc_liabilities_equity .= '
                <tr>
                    <td>'.ucfirst(strtolower($ncl_type['name'])).'</td>
                    <td style="text-align: center">₦ '.number_format($ncl_value, 2).'</td>
                </tr>
                ';
            }

            $total_cl_ncl_value = $total_cl_value + $total_ncl_value;

            $gl_acc_liabilities_equity .= '
            <tr style="background-color: #eeeeee">
                <td><b>Total Non-Current Liabilities</b></td>
                <td style="text-align: center"><b>₦ '.number_format($total_ncl_value, 2).'</b></td>
            </tr>

            <tr style="background-color: #cecece">
                <td><b>Total Liabilities</b></td>
                <td style="text-align: center"><b>₦ '.number_format($total_cl_ncl_value, 2).'</b></td>
            </tr>

            <tr>
                <td><b>Shareholders Equity</b></td>
                <td></td>
            </tr>
            ';

            $total_equity_value = 0;

            while($equity_type = mysqli_fetch_array($equity_list)) {
                $equity = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$equity_type['gl_code']} AND transaction_date <= '$date'");
                $equity = mysqli_fetch_array($equity);
                $equity_credit = $equity['credit'];
                $equity_debit = $equity['debit'];

                $equity_value = $equity_credit - $equity_debit;

                $total_equity_value += $equity_credit - $equity_debit;

                $gl_acc_liabilities_equity .= '
                <tr>
                    <td>'.ucfirst(strtolower($equity_type['name'])).'</td>
                    <td style="text-align: center">₦ '.number_format($equity_value, 2).'</td>
                </tr>
                ';
            }

            $total_cl_ncl_equity_value = $total_cl_value + $total_ncl_value + $total_equity_value;

            $gl_acc_liabilities_equity .= '
            <tr style="background-color: #eeeeee">
                <td><b>Total Shareholders Equity</b></td>
                <td style="text-align: center"><b>₦ '.number_format($total_equity_value, 2).'</b></td>
            </tr>

            <tr style="background-color: #aaaaaa">
                <td><b>Total Liabilities and Shareholders Equity</b></td>
                <td style="text-align: center"><b>₦ '.number_format($total_cl_ncl_equity_value, 2).'</b></td>
            </tr>
            ';

            return $gl_acc_liabilities_equity;
        }

        $assets = fill_assets($connection, $sessint_id, $branch_id, $date);
        $liabilities_equity = fill_liabilities_equity($connection, $sessint_id, $branch_id, $date);


        require_once __DIR__ . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
        <header class="clearfix">
        <div id="logo">
            <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
        </div>
        <h1>'.$_SESSION["int_full"].' <br/>Statement of Financial Position Report</h1>
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
        <h1>Assets</h1>
        <table>
            <thead>
            <tr class="table100-head">
                <th style="font-size:20px;">GL Account</th>
                <th style="font-size:20px;"></th>
            </tr>
            </thead>
            <tbody>
            "'.$assets.'"
            </tbody>
        </table>

        <h1 style="margin-top: 50px;">Liabilities & Equity</h1>
        <table>
            <thead>
            <tr class="table100-head">
                <th style="font-size:20px;">GL Account</th>
                <th style="font-size:20px;"></th>
            </tr>
            </thead>
            <tbody>
            "'.$liabilities_equity.'"
            </tbody>
        </table>
        </main>
        ');

        $file_name = 'statement-of-financial-position-' . date('d-m-Y', time()) . '.pdf';
        $mpdf->Output($file_name, 'D');

    } else {
        echo 'Not Seeing Data';
    }
}



if(isset($_POST["downloadExcel"])) {

  if (!empty($_POST["date"]) && !empty($_POST["branch_id"])) {

    $sessint_id = $_SESSION['int_id'];
    $branch_id = $_POST["branch_id"];
    $date = $_POST["date"];

    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
    while ($result = mysqli_fetch_array($getParentID)) {
      $parent_id = $result['parent_id'];
    }

    if ($parent_id == 0) {
        $current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current asset')");
        $non_current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non current asset' || 'non-current asset')");
    } else {
        $current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current asset')");
        $non_current_assets_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '1' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non current asset' || 'non-current asset')");
    }

    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();
    $active_sheet->setCellValue('A1', 'ASSETS');
    $active_sheet->setCellValue('A2', 'Gl Account');
    $active_sheet->setCellValue('A4', 'Current Assets');

    $count = 5;

    $total_ca_value = 0;

    while($ca_type = mysqli_fetch_array($current_assets_list)) {
        $ca = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$ca_type['gl_code']} AND transaction_date <= '$date'");
        $ca = mysqli_fetch_array($ca);
        $ca_credit = $ca['credit'];
        $ca_debit = $ca['debit'];
    
        $ca_value = $ca_credit - $ca_debit;
    
        $total_ca_value += $ca_credit - $ca_debit;

        $active_sheet->setCellValue('A' . $count, ucfirst(strtolower($ca_type['name'])));
        $active_sheet->setCellValue('B' . $count, $ca_value);

        $count++;
    }

    $active_sheet->setCellValue('A' . $count, 'Total Current Assets');
    $active_sheet->setCellValue('B' . $count, $total_ca_value);

    $count = $count + 2;

    $active_sheet->setCellValue('A' . $count, 'Non-Current Assets');

    $count++;

    $total_nca_value = 0;

    while($nca_type = mysqli_fetch_array($non_current_assets_list)) {
        $nca = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$nca_type['gl_code']} AND transaction_date <= '$date'");
        $nca = mysqli_fetch_array($nca);
        $nca_credit = $nca['credit'];
        $nca_debit = $nca['debit'];

        $nca_value = $nca_credit - $nca_debit;

        $total_nca_value += $nca_credit - $nca_debit;

        $active_sheet->setCellValue('A' . $count, ucfirst(strtolower($nca_type['name'])));
        $active_sheet->setCellValue('B' . $count, $nca_value);

        $count++;
    }

    $active_sheet->setCellValue('A' . $count, 'Total Non-Current Assets');
    $active_sheet->setCellValue('B' . $count, $total_nca_value);

    $count = $count + 2;

    $active_sheet->setCellValue('A' . $count, 'Less: Accumulated Depreciation');
    $active_sheet->setCellValue('B' . $count, '');

    $count++;

    $active_sheet->setCellValue('A' . $count, 'NPV');
    $active_sheet->setCellValue('B' . $count, '');

    $count = $count + 2;

    $total_asset_value = $total_ca_value + $total_nca_value;

    $active_sheet->setCellValue('A' . $count, 'Total Asset');
    $active_sheet->setCellValue('B' . $count, $total_asset_value);
    

    if ($parent_id == 0) {
        $current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current liability')");
        $non_current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non-current liability' || 'non current liability')");
        $equity_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND parent_id <> '0' AND classification_enum = '3'");
    } else {
        $current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'current liability')");
        $non_current_liabilities_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND classification_enum = '2' AND parent_id IN (SELECT id FROM `acc_gl_account` WHERE name = 'non-current liability' || 'non current liability')");
        $equity_list = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND branch_id = '$branch_id' AND parent_id <> '0' AND classification_enum = '3'");
    }

    $active_sheet->setCellValue('D1', 'LIABILITIES & EQUITY');
    $active_sheet->setCellValue('D2', 'Gl Account');
    $active_sheet->setCellValue('D4', 'Current Liabilities');

    $count2 = 5;

    $total_cl_value = 0;

    while($cl_type = mysqli_fetch_array($current_liabilities_list)) {
        $cl = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$cl_type['gl_code']} AND transaction_date <= '$date'");
        $cl = mysqli_fetch_array($cl);
        $cl_credit = $cl['credit'];
        $cl_debit = $cl['debit'];

        $cl_value = $cl_credit - $cl_debit;

        $total_cl_value += $cl_credit - $cl_debit;

        $active_sheet->setCellValue('D' . $count2, ucfirst(strtolower($cl_type['name'])));
        $active_sheet->setCellValue('E' . $count2, $cl_value);

        $count2++;
    }
    
    $active_sheet->setCellValue('D' . $count2, 'Total Current Liabilities');
    $active_sheet->setCellValue('E' . $count2, $total_cl_value);

    $count2 = $count2 + 2;

    $active_sheet->setCellValue('D' . $count2, 'Non-Current Liabilities');

    $count2++;

    $total_ncl_value = 0;

    while($ncl_type = mysqli_fetch_array($non_current_liabilities_list)) {
        $ncl = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$ncl_type['gl_code']} AND transaction_date <= '$date'");
        $ncl = mysqli_fetch_array($ncl);
        $ncl_credit = $ncl['credit'];
        $ncl_debit = $ncl['debit'];

        $ncl_value = $ncl_credit - $ncl_debit;

        $total_ncl_value += $ncl_credit - $ncl_debit;

        $active_sheet->setCellValue('D' . $count2, ucfirst(strtolower($ncl_type['name'])));
        $active_sheet->setCellValue('E' . $count2, $ncl_value);

        $count2++;
    }

    $active_sheet->setCellValue('D' . $count2, 'Total Non-Current Liabilities');
    $active_sheet->setCellValue('E' . $count2, $total_ncl_value);

    $count2 = $count2 + 2;

    $total_cl_ncl_value = $total_cl_value + $total_ncl_value;

    $active_sheet->setCellValue('D' . $count2, 'Total Liabilities');
    $active_sheet->setCellValue('E' . $count2, $total_cl_ncl_value);

    $count2 = $count2 + 2;

    $active_sheet->setCellValue('D' . $count2, 'Shareholders Equity');

    $count2++;

    $total_equity_value = 0;

    while($equity_type = mysqli_fetch_array($equity_list)) {
        $equity = mysqli_query($connection, "SELECT SUM(credit) as credit, SUM(debit) as debit FROM `gl_account_transaction` WHERE int_id = '$sessint_id' AND gl_code = {$equity_type['gl_code']} AND transaction_date <= '$date'");
        $equity = mysqli_fetch_array($equity);
        $equity_credit = $equity['credit'];
        $equity_debit = $equity['debit'];

        $equity_value = $equity_credit - $equity_debit;

        $total_equity_value += $equity_credit - $equity_debit;

        $active_sheet->setCellValue('D' . $count2, ucfirst(strtolower($equity_type['name'])));
        $active_sheet->setCellValue('E' . $count2, $equity_value);

        $count2++;
    }

    $active_sheet->setCellValue('D' . $count2, 'Total Shareholders Equity');
    $active_sheet->setCellValue('E' . $count2, $total_equity_value);

    $count2 = $count2 + 2;

    $total_cl_ncl_equity_value = $total_cl_value + $total_ncl_value + $total_equity_value;

    $active_sheet->setCellValue('D' . $count2, 'Total Liabilities and Shareholders Equity');
    $active_sheet->setCellValue('E' . $count2, $total_cl_ncl_equity_value);
    

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');

    $file_name = 'statement-of-financial-position-' . date('d-m-Y', time()) . '.xlsx';

    $writer->save($file_name);

    header('Content-Type: application/x-www-form-urlencoded');

    header('Content-Transfer-Encoding: Binary');

    header("Content-disposition: attachment; filename=\"".$file_name."\"");

    readfile($file_name);

    unlink($file_name);

    exit;

  }

}
?>