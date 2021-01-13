<?php
include('../../functions/connect.php');
session_start();

/** Include PHPExcel_IOFactory */
include('../vendor/autoload.php');

// select table for file creation
$dataTables = selectAll('transact_cache', ['status'=>'Pending']);

//export.php

include 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST["file_content"])) {
//    set temporary file
    $temporary_html_file = 'file.html';

//    pass post content into temporary file
    file_put_contents($temporary_html_file, $_POST["file_content"]);

//    read html tables
    $reader = IOFactory::createReader('Html');

//    load the temporary file into spreadSheet
    $spreadsheet = $reader->load($temporary_html_file);

//    create the file
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

//    set the file name
    $filename = time() .'_transactionCache'. '.xlsx';


    $writer->save($filename);

//    download instruction
    header('Content-Type: application/x-www-form-urlencoded');

    header('Content-Transfer-Encoding: Binary');

    header("Content-disposition: attachment; filename=\"" . $filename . "\"");

    readfile($filename);

    unlink($temporary_html_file);

    unlink($filename);

    exit;
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <title>Convert HTML Table to Excel using PHPSpreadsheet</title>
</head>
<body>
<div class="container">
    <br/>
    <h3 align="center">Convert HTML Table to Excel using PHPSpreadsheet</h3>
    <br/>
    <div class="table-responsive">
        <form method="POST" id="convert_form" action="export.php">
            <table class="table table-striped table-bordered" id="table_content">
                <tr>
                    <th>int_id</th>
                    <th>branch_id</th>
                    <th>branch_id</th>
                    <th>description</th>
                    <th>account_no</th>
                    <th>client_id</th>
                    <th>client_name</th>
                    <th>staff_id</th>
                    <th>account_off_name</th>
                    <th>amount</th>
                    <th>pay_type</th>
                    <th>transact_type</th>
                    <th>product_type</th>
                    <th>status</th>
                </tr>
                <?php
                foreach ($dataTables as $dataTable) {
                    ?>
                <tr>
                  <td><?php echo $dataTable["first_name"] ?></td>
                  <td><?php echo  $dataTable["account_no"] ?></td>
                  <td><?php echo $dataTable["amount"] ?></td>
                </tr>
                <?php
                }
                ?>
            </table>
            <input type="hidden" name="file_content" id="file_content"/>
            <button type="button" name="convert" id="convert" class="btn btn-primary">Convert</button>
        </form>
        <br/>
        <br/>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#convert').click(function () {
            var table_content = '<table>';
            table_content += $('#table_content').html();
            table_content += '</table>';
            $('#file_content').val(table_content);
            $('#convert_form').submit();
        });
    });
</script>
</body>
</html>



