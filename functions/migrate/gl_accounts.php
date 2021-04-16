

<?php
include('../../functions/connect.php');
session_start();
$randms = str_pad(rand(0, pow(10, $digit) - 1), $digit, '0', STR_PAD_LEFT);
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

        //            Join data with content from the excel sheet
        foreach ($data as $key => $row) {
            $ourDataTables[] = array(
                'branch_id' => $row['0'],
                'name' => $row['1'],
                'gl_code' => $row['2'],
                'description' => $row['3'],
                'organisation_running_balance_derived' => $row['4'],


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
                    $gl_code = $data['gl_code'];
                    $gl_accountData = [
                        'organisation_running_balance_derived' => $data['organisation_running_balance_derived']

                    ];
                }
                $gl_account = update('acc_gl_account', $gl_code, 'gl_code', $gl_accountData);
                // dd($insert_gl_account);

                if (!$gl_account) {
                    printf('Error: %s\n', mysqli_error($connection)); //checking for errors
                    exit();
                } else {
                    // Sucess feedback
                    $_SESSION["Lack_of_intfund_$randms"] = "General Ledger Sucessfully Updated!";
                    echo header("Location: ../../mfi/migrate_gl_accounts_data.php?glaccount1=$randms");
                }
            }
        }
    }
}
