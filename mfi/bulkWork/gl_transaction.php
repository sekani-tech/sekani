<?php
include('../../functions/connect.php');
/** Include PHPExcel_IOFactory */
include('../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
//    check for excel file submitted
    if ($_FILES["fileName"]["name"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["fileName"]["name"]);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            try {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['fileName']['tmp_name'], $file_name);
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
            foreach ($data as $key => $row) {
                $ourDataTables[] = array(
                    'int_id' => $row['0'],
                    'branch_id' => $row['1'],
                    'gl_code' => $row['2'],
                    'parent_id' => $row['3'],
                    'transaction_id' => $row['4'],
                    'description' => $row['5'],
                    'transaction_type' => $row['6'],
                    'teller_id' => $row['7'],
                    'transaction_date' => $row['8'],
                    'amount' => $row['9'],
                    'gl_account_balance_derived' => $row['10'],
                    'branch_balance_derived' => $row['11'],
                    'cumulative_balance_derived' => $row['12'],
                    'created_date' => $row['13'],
                    'credit' => $row['14'],
                    'debit' => $row['15']
                );
            }
            //    Send data to database
            foreach ($ourDataTables as $ourDataTable) {
                $convertDate = strtotime($ourDataTable['transaction_date']);
                $date = date('Y-m-d', $convertDate);
                $fullDate = $date . ' ' . date('H:i:s');
                $gl_accountCon = [
                    'int_id' => $ourDataTable['int_id'],
                    'branch_id' => $ourDataTable['branch_id'],
                    'gl_code' => $ourDataTable['gl_code'],
                    'parent_id' => $ourDataTable['parent_id'],
                    'transaction_id' => $ourDataTable['transaction_id'],
                    'description' => $ourDataTable['description'],
                    'transaction_type' => $ourDataTable['transaction_type'],
                    'teller_id' => $ourDataTable['teller_id'],
                    'transaction_date' => $date,
                    'amount' => $ourDataTable['amount'],
                    'gl_account_balance_derived' => $ourDataTable['gl_account_balance_derived'],
                    'branch_balance_derived' => $ourDataTable['branch_balance_derived'],
                    'cumulative_balance_derived' => $ourDataTable['cumulative_balance_derived'],
                    'created_date' => $fullDate,
                    'credit' => $ourDataTable['credit'],
                    'debit' => $ourDataTable['debit']
                ];
                $gl_accountDetails = create('gl_account_transaction', $gl_accountCon);
            }
            if ($gl_accountDetails) {
                echo "Done";
            }
        }
    }
}

?>

<!doctype html>
<html>
<head>
    <title>Gl transaction</title>
</head>
<body>
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <!-- Begining of Charge Row !-->

        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upload Excel File</h4>
                        <p class="category"></p>
                    </div>
                    <form action="deposit.php" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">

                                <div class="input-group">
                                    <input type="file" name="fileName"
                                           class="form-control inputFileVisible"
                                           placeholder="Single File" required>
                                    <span class="input-group-btn">
                                    <button type="submit" name="submitGl"
                                            class="btn btn-fab btn-round btn-primary">
                                        <i class="material-icons">send</i>
                                    </button>
                                    </span>
                                </div>

                            </div>
                            <!-- UPLOAD SECTION ENDS -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
