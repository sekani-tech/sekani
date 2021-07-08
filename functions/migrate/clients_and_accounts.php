<?php
include('../../functions/connect.php');
session_start();

/** Include PHPExcel_IOFactory */
include('../../mfi/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

$digit = 4;
try {
    $randms = str_pad(random_int(0, (10 ** $digit) - 1), 7, '0', STR_PAD_LEFT);
} catch (Exception $e) {
}
if (isset($_POST['submitClient'])) {

    


//    check for excel file submitted
    if ($_FILES["clientData"]["name"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["file"]["name"]);
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
        $password = "password1";
        $hash = password_hash($password, PASSWORD_DEFAULT);
//            Join data with content from the excel sheet For Account Table
        foreach ($data as $key => $row) {
            $ourDataTables[] = array(
                'account_no' => $row['0'],
                'product_id' => $row['1'],
                'account_balance_derived' => $row['2'],
                'last_withdrawal' => $row['3'],
                'last_deposit' => $row['4']
                
                
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
                    $clientData = [
                        'account_no' => $data['account_no'],
                        'product_id' => $data['product_id'],
                        'account_balance_derived' => $data['account_balance_derived'],
                        'last_withdrawer' => $data['last_withdrawal'],
                        'last_deposit' => $data['last_deposit']

                    ];
                }
                $insertClient = insert('client', $clientData);
                $insertaccount = insert('account', $accountdata);
                $insertaccount_transaction = insert('account_transaction', $account_transaction_data);
                //dd($clientData);
            }
        }
        $uptclient = mysqli_query($connection, "UPDATE account , client SET account.client_id = client.id WHERE account.account.no = client.account_no");
        if (!$uptclient) {
            printf("Error: %s\n", mysqli_error($connection));//checking for errors
            exit();
        }
        else{
            echo "SUCCESS";
        }
    }
}    