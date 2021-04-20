<?php

include('../connect.php');
session_start();
$institutionId = $_SESSION['int_id'];
$today = date("Y-m-d");
$user = $_SESSION['user_id'];
/** Include PHPExcel_IOFactory */
include('../../mfi/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submitClient'])) {
    //    check for excel file submitted
    if ($_FILES["clientData"]["name"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["clientData"]["name"]);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            try {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['clientData']['tmp_name'], $file_name);
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
        }

        //            Join data with content from the excel sheet
        foreach ($data as $key => $row) {
            $ourDataTables[] = array(
                'first_name' => $row['0'],
                'middle_name' => $row['1'],
                'last_name' => $row['2'],
                'display_name' => $row['3'],
                'bvn' => $row['4'],
                'account_officer' => $row['5'],
                'branch' => $row['6'],
                'mobile_no' => $row['7'],
                'gender' => $row['8'],
                'email' => $row['9'],
                'account_balance' => $row['10'],
                'product_id' => $row['11']
            );

            if (count($ourDataTables)) {
                $keys = array_keys($ourDataTables);
                $values = '';
                $x = 1;

                foreach ($ourDataTables as $field) {
                    $values .= '?';
                    if ($x < count($ourDataTables)) {
                        $values .= ', ';
                    }
                    $x++;
                }

                foreach ($ourDataTables as $values => $data) {
                    $branch = $data['branch'];
                    $length = strlen($branch);
                    if($length == 2){
                        // if branch id is greater than one
                        $digit = 7;
                    }else if($length == 3){
                        // greater than 2
                        $digit = 6;
                    }else if($length == 4){
                        // greater than 3
                        $digit = 5;
                    }else{
                        $digit = 8;
                    }
                    
                    $randms = str_pad(rand(0, pow(10, $digit) - 1), $digit, '0', STR_PAD_LEFT);
                    $account_no = $institutionId . "" .$branch. "" . $randms;
                    
                    $clientData = [
                        'int_id' => $institutionId,
                        'branch_id' => $branch,
                        'firstname' => $data['first_name'],
                        'middlename' => $data['middle_name'],
                        'lastname' => $data['last_name'],
                        'bvn' => $data['bvn'],
                        'email_address' => $data['email'],
                        'gender' => $data['gender'],
                        'mobile_no' => $data['mobile_no'],
                        'loan_officer_id' => $data['account_officer'],
                        'client_type' => "INDIVIDUAL",
                        'account_no' => $account_no,
                        'status' => "Not Approved",
                        'account_type' => $data['product_id'],
                        'submittedon_date' => $today
                    ];

                    $accountData = [
                        'int_id' => $institutionId,
                        'branch_id' => $branch,
                        'account_no' => $account_no,
                        'account_type' => $data['product_id'],
                        'product_id' => $data['product_id'],
                        'submittedon_userid' => $user,
                        'submittedon_date' => $today,
                        'currency_code' => "NGN",
                        'field_officer_id' => $data['account_officer'],
                        'account_balance_derived' => $data['account_balance'],
                    ];

                    
                }
                $clientInsert = insert('client', $clientData);
                if($clientInsert){
                    $accountInsert = insert('account', $accountData);
                    if($accountInsert){
                        $updateAccount = mysqli_query($connection, "UPDATE account, client SET account.client_id = client.id WHERE account.account_no = client.account_no");
                        if(!$updateAccount) {
                           printf('Error: %s\n', mysqli_error($connection));//checking for errors
                           exit();
                        }else{
                            // Sucess feedback
                            $_SESSION["Lack_of_intfund_$randms"] = "Accounts created Successful!";
                            echo header("Location: ../../mfi/migrate_client_data.php?account1=$randms");
                        }
                    }
                }
            }
        }
    }
}else{
    $_SESSION["Lack_of_intfund_$randms"] = "No file Uploaded!";
    echo header("Location: ../../mfi/migrate_client_data.php?account2=$randms");
}