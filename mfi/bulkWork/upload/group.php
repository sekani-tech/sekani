<?php
include('../../../functions/connect.php');
session_start();

/** Include PHPExcel_IOFactory */
include('../../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submitGroupClient'])) {
    //    check for excel file submitted
    if ($_FILES["groupClientData"]["name"] != '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["groupClientData"]["name"]);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            try {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['groupClientData']['tmp_name'], $file_name);
                $file_type = IOFactory::identify($file_name);
                $reader = IOFactory::createReader($file_type);
                $spreadsheet = $reader->load($file_name);

                unlink($file_name);

//            Data from excel Sheet
                $data = $spreadsheet->getActiveSheet()->toArray();
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            }

//            our data table for insertion
            $ourDataTables = [];
            //            Join data with content from the excel sheet
            foreach ($data as $key => $row) {
                $ourDataTables[] = array(
                    'branch_name' => $row['1'],
                    'int_id' => $row['2'],
                    'branch_id' => $row['3'],
                    'account_no' => $row['4'],
                    'account_type' => $row['5'],
                    'g_name' => $row['6'],
                    'loan_officer' => $row['7'],
                    'reg_date' => $row['8'],
                    'reg_type' => $row['9'],
                    'meeting_day' => $row['10'],
                    're' => $row['11'],
                    'meeting_time' => $row['12'],
                    'meeting_location' => $row['13'],
                    'submittedon_date' => $row['14'],
                    'approvedon_date' => $row['15']
                );
            }

            //            send information one by one
            foreach ($ourDataTables as $key => $ourDataTable) {
                $condition = [
                    'branch_name' => $ourDataTable['branch_name'],
                    'int_id' => $ourDataTable['int_id'],
                    'branch_id' => $ourDataTable['branch_id'],
                    'account_no' => $ourDataTable['account_no'],
                    'account_type' => $ourDataTable['account_type'],
                    'g_name' => $ourDataTable['g_name'],
                    'loan_officer' => $ourDataTable['loan_officer'],
                    'reg_date' => $ourDataTable['reg_date'],
                    'reg_type' => $ourDataTable['reg_type'],
                    'meeting_day' => $ourDataTable['meeting_day'],
                    're' => $ourDataTable['re'],
                    'meeting_time' => $ourDataTable['meeting_time'],
                    'meeting_location' => $ourDataTable['meeting_location'],
                    'submittedon_date' => $ourDataTable['submittedon_date'],
                    'approvedon_date' => $ourDataTable['approvedon_date']
                ];
                $sendData = create('group_client', $condition);
            }
            if ($sendData) {
                echo $message = '<div class="alert alert-success">Data Imported Successfully</div>';
            }
            dd($ourDataTables);
        }
    }
}
