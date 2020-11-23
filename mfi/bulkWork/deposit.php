<?php
include('../../functions/connect.php');
session_start();

/** Include PHPExcel_IOFactory */
include('../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
//    chosen branch upon upload
    $chosenBranch = $_POST['branch'];
    if ($_FILES["excelFile"]["name"] != '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["excelFile"]["name"]);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            $file_name = time() . '.' . $file_extension;
            move_uploaded_file($_FILES['excelFile']['tmp_name'], $file_name);
            $file_type = IOFactory::identify($file_name);
            $reader = IOFactory::createReader($file_type);

            $spreadsheet = $reader->load($file_name);

            unlink($file_name);

//            Data from excel Sheet
            $data = $spreadsheet->getActiveSheet()->toArray();

//            our data table for insertion
            $ourDataTables = [];

//            dd($data);
//            Join data with content from the excel sheet
            foreach ($data as $key => $row) {
                $ourDataTables[] = array(
                    'Branch_Name' => $row['0'],
                    'Account_Name' => $row['1'],
                    'Account_Number' => $row['2'],
                    'Phone_Number' => $row['3'],
                    'date' => $row['4'],
                    'amount' => $row['5'],
                    'deposit_slip_number' => $row['6'],
                    'teller_id' => $row['7'],

                );
            }

//            dd($ourDataTables);
//            send information one by one
            foreach ($ourDataTables as $key => $ourDataTable) {
//                getting tellers info to check for post limit
                $tellersCondition = ['id'=>$ourDataTable['teller_id']];
                dd($tellerDetails);
                $tellerDetails = selectOne('tellers', $tellersCondition);
//                branch and teller id for check
                $tellerBranch = $tellerDetails['branch_id'];
                $tellerPostLimit = $tellerDetails['post_limit'];
                if($tellerBranch == $chosenBranch){
                    if($ourDataTable['amount'] < $tellerPostLimit){
                        dd($ourDataTable);
                    } else{
                        echo $message = '<div class="alert alert-danger">Transaction gone for Approval</div>';
                        exit();
                    }
                } else {
                    echo $message = '<div class="alert alert-danger">Sorry this Teller Can not Preform this Action</div>';
                    exit();
                }

            }
//            if ($sendData) {
//                echo $message = '<div class="alert alert-success">Data Imported Successfully</div>';
//            }


        }

    } else {
        echo $message = '<div class="alert alert-danger">Only .xls .csv or .xlsx file allowed</div>';
    }

}
