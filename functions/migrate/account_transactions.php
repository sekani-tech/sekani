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
if (isset($_POST['SubmitAccountTransaction'])) {

    


//    check for excel file submitted
    if ($_FILES["AccountTransactionData"]["name"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            try {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['file']['tmp_name'], $file_name);
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

        //          $password = "password1";
       //            $hash = password_hash($password, PASSWORD_DEFAULT);
//            Join data with content from the excel sheet For Staff Table
        foreach ($data as $key => $row) {
            $ourDataTables[] = array(
                'account_no' => $row['0'],
                'amount' => $row['1'],
                'transaction_type' => $row['2'],
                'description' => $row['3'],
                'transaction_id' => $row['4'],
                'debit' => $row['5'],
                'credit' => $row['6'],
                
                
            
            
            );
            
            if(count($ourDataTables)) {
                $keys = array_keys($ourDataTables);
                $values = '';
                $x = 1;
        


                foreach($ourDataTables as $field) {
                    $values .= '?';
                    if($x < count($ourDataTables)) {
                        $values .= ', ';
                    }
                    $x++;
                }
                 
                foreach($ourDataTables as $values => $data){
                    $account_transactionData = [
                        'account_no' => $data['account_no'],
                        'amount' => $data['amount'],
                        'transaction_type' => $data['transaction_type'],
                        'description' => $data['description'],
                        'transaction_id' => $data['transaction_id'],
                        'debit' => $data['debit'],
                        'credit' => $data['credit']
                        
                    ];
                    
                }
                $insertaccount_transaction = insert('account_transaction', $account_transactionData);
                 
                //dd($account_transactionData);
            }
        }
   
        
    }
}