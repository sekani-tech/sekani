<<<<<<< HEAD
<h2>Import Excel File into MySQL Database using PHP</h2>
    
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
        <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="submit"
                    class="btn-submit">Import</button>
            </div>
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
=======

>>>>>>> 8ce354db850074da047dddc5f2414718d2550009

<?php
include('../../functions/connect.php');
session_start();
$institutionId = $_SESSION['int_id'];
/** Include PHPExcel_IOFactory */
include('../../mfi/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

$digit = 4;
try {
    $randms = str_pad(random_int(0, (10 ** $digit) - 1), 7, '0', STR_PAD_LEFT);
} catch (Exception $e) {
}
<<<<<<< HEAD
if (isset($_POST['submit'])) {

    


//    check for excel file submitted
    if ($_FILES["file"]["name"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["file"]["name"]);
=======
if (isset($_POST['submitbranch'])) {
    //    check for excel file submitted
    if ($_FILES["file"]["branchData"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["file"]["branchData"]);
>>>>>>> 8ce354db850074da047dddc5f2414718d2550009
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
                'name' => $row['0'],
                'address' => $row['1'],
                'phone' => $row['2'],
                'opening_date' => $row['3'],
                'email' => $row['4'],
                'state' => $row['5'],
                'lga' => $row['6'],
                'balance' => $row['7'],
                'gl_code' => $row['8']

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
                    $branchData = [
                        'int_id' => $institutionId,
                        'name' => $data['name'],
                        'location' => $data['address'],
                        'phone' => $data['phone'],
                        'opening_date' => $data['opening_date'],
                        'email' => $data['email'],
                        'state' => $data['state'],
                        'lga' => $data['lga']
                    ];

                    $branchName = $data['name'];
                    $balance = $data['balance'];
                    $incomeGl = $data['gl_code'];
                }
                $insertBranch = insert('branch', $branchData);
                if ($insertBranch) {
                    $brna = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '{$institutionId}' AND name = '{$branchName}'");
                    $gom = mysqli_fetch_array($brna);
                    $branchId = $gom['id'];
                    $movableAmout = 10000000.00;
                    $submittedOn = date('Y-m-d h:i:sa');
                    $vaultDetails = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'movable_amount' => $movableAmout,
                        'balance' => $balance,
                        'date' => $submittedOn,
                        'last_withdrawal' => 0.00,
                        'last_deposit' => 0.00,
                        'gl_code' => $incomeGl
                    ];

                    $createBranchVault = insert('int_vault', $vaultDetails);
                    if ($createBranchVault) {
                        $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
                        echo header("Location: ../../mfi/migrate_branch.php?message1=$randms");
                    } else {
                        $_SESSION["Lack_of_intfund_$randms"] = "Branch creation successful. \n Failed to create Vault";
                        echo "error";
                        echo header("Location: ../../mfi/migrate_branch.php?message2=$randms");
                        // echo header("location: ../mfi/client.php");

                    }
                }
            }
        }
    }
<<<<<<< HEAD
<<<<<<< HEAD
=======
  
>>>>>>> 8ce354db850074da047dddc5f2414718d2550009
=======
>>>>>>> 8c99d785555b24b40a84ddd4203e26e53f771da8
}
