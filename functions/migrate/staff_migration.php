<<<<<<< HEAD
<h2>Import Excel File into MySQL Database using PHP</h2>
    
    <div class="outer-container">
        <form action="" method="post"

            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
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
/** Include PHPExcel_IOFactory */
include('../../mfi/vendor/autoload.php');


use PhpOffice\PhpSpreadsheet\IOFactory;

$digit = 4;
try {
    $randms = str_pad(random_int(0, (10 ** $digit) - 1), 7, '0', STR_PAD_LEFT);
} catch (Exception $e) {
}
<<<<<<< HEAD
if (isset($_POST['import'])) {

    


//    check for excel file submitted
    if ($_FILES["file"]["name"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["file"]["name"]);
=======
if (isset($_POST['submitstaff'])) {


//    check for excel file submitted
    if ($_FILES["file"]["staff
    ata"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["file"]["staffData"]);
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

        $password = "password1";
        $hash = password_hash($password, PASSWORD_DEFAULT);
//            Join data with content from the excel sheet For Staff Table
        foreach ($data as $key => $row) {
            $ourDataTables[] = array(
                'first_name' => $row['0'],
                'last_name' => $row['1'],
                'email' => $row['2'],
                'description' => $row['3'],
                'address' => $row['4'],
                'phone' => $row['5'],
                'employee_status' => $row['6'],
                'password'=> $hash
                
            
            
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
                    $staffData = [
                        'firstname' => $data['first_name'],
                        'lastname' => $data['last_name'],
                        'email' => $data['email'],
                        'description' => $data['description'],
                        'address' => $data['address'],
                        'phone' => $data['phone'],
                        'employee_status' => $data['employee_status']
                        
                    ];
                    $firstName = $data['first_name'];
                    $lastName = $data['last_name'];
                    $fullName = $firstName ." ". $lastName;
                    $userdata = [
                    
                        'fullname' => $fullName,
                        'password' => $hash
                    ];   
                }
                $insertstaff = insert('staff', $staffData);
                $insertuser = insert('users', $userdata);       
                //dd($staffData);
            }
        }
   
         $uptstaff = mysqli_query($connection, "UPDATE staff , users SET staff.user_id = users.id WHERE staff. username = users. username");
         // $iupres = mysqli_query($connection, $iupq);
         // if($iupres) 
         if (!$uptstaff) {
            printf("Error: %s\n", mysqli_error($connection));//checking for errors
            exit();
        }else{
            echo "SUCCESS";
        }
    }
}



