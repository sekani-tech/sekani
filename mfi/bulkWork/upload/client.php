<?php
include('../../../functions/connect.php');
session_start();

/** Include PHPExcel_IOFactory */
include('../../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submitClient'])) {
    //    check for excel file submitted
    if ($_FILES["clientData"]["name"] != '') {
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

//            Join data with content from the excel sheet
            foreach ($data as $key => $row) {
                $ourDataTables[] = array(
                    'int_id' => $row['1'],
                    'loan_officer_id' => $row['2'],
                    'loan_status' => $row['3'],
                    'branch_id' => $row['4'],
                    'client_type' => $row['5'],
                    'account_no' => $row['6'],
                    'account_type' => $row['7'],
                    'activation_date' => $row['8'],
                    'firstname' => $row['9'],
                    'middlename' => $row['10'],
                    'lastname' => $row['11'],
                    'display_name' => $row['12'],
                    'mobile_no' => $row['13'],
                    'occupation' => $row['14'],
                    'gender' => $row['15'],
                    'is_staff' => $row['16'],
                    'date_of_birth' => $row['17'],
                    'update_by' => $row['18'],
                    'image_id' => $row['19'],
                    'update_on' => $row['20'],
                    'submittedon_date' => $row['21'],
                    'email_address' => $row['22'],
                    'BVN' => $row['23'],
                    'address' => $row['24'],
                    'marital_status' => $row['25'],
                    'state_of_origin' => $row['26'],
                    'lga' => $row['27'],
                    'country' => $row['28'],
                    'sms_active' => $row['29'],
                    'email_active' => $row['30'],
                    'id_card' => $row['31'],
                    'id_img_url' => $row['32'],
                    'signature' => $row['33'],
                    'passport' => $row['34'],
                    'rc_number' => $row['35'],
                    'sig_one' => $row['36'],
                    'sig_two' => $row['37'],
                    'sig_three' => $row['38'],
                    'sig_address_one' => $row['39'],
                    'sig_address_two' => $row['40'],
                    'sig_address_three' => $row['41'],
                    'sig_phone_one' => $row['42'],
                    'sig_phone_two' => $row['43'],
                    'sig_phone_three' => $row['44'],
                    'sig_gender_one' => $row['45'],
                    'sig_gender_two' => $row['46'],
                    'sig_gender_three' => $row['47'],
                    'sig_state_one' => $row['48'],
                    'sig_state_two' => $row['49'],
                    'sig_lga_one' => $row['50'],
                    'sig_lga_two' => $row['51'],
                    'sig_lga_three' => $row['52'],
                    'sig_occu_one' => $row['53'],
                    'sig_occu_two' => $row['54'],
                    'sig_occu_three' => $row['55'],
                    'sig_bvn_one' => $row['56'],
                    'sig_bvn_two' => $row['57'],
                    'sig_bvn_three' => $row['58'],
                    'sms_active_one' => $row['59'],
                    'sms_active_two' => $row['60'],
                    'sms_active_three' => $row['61'],
                    'email_active_one' => $row['62'],
                    'email_active_two' => $row['63'],
                    'email_active_three' => $row['64'],
                    'sig_passport_one' => $row['65'],
                    'sig_passport_two' => $row['66'],
                    'sig_passport_three' => $row['67'],
                    'sig_signature_one' => $row['68'],
                    'sig_signature_two' => $row['69'],
                    'sig_signature_three' => $row['70'],
                    'sig_id_img_one' => $row['71'],
                    'sig_id_img_two' => $row['72'],
                    'sig_id_img_three' => $row['73'],
                    'sig_id_card_one' => $row['74'],
                    'sig_id_card_two' => $row['75'],
                    'sig_id_card_three' => $row['76'],
                    'status' => $row['77']
                );
            }

//            send information one by one
            foreach ($ourDataTables as $key => $ourDataTable) {
                $condition = [
                    'int_id' => $ourDataTable['int_id'],
                    'loan_officer_id' => $ourDataTable['loan_officer_id'],
                    'loan_status' => $ourDataTable['loan_status'],
                    'branch_id' => $ourDataTable['branch_id'],
                    'client_type' => $ourDataTable['client_type'],
                    'account_no' => $ourDataTable['account_no'],
                    'account_type' => $ourDataTable['account_type'],
                    'activation_date' => $ourDataTable['activation_date'],
                    'firstname' => $ourDataTable['firstname'],
                    'middlename' => $ourDataTable['middlename'],
                    'lastname' => $ourDataTable['lastname'],
                    'display_name' => $ourDataTable['display_name'],
                    'mobile_no' => $ourDataTable['mobile_no'],
                    'occupation' => $ourDataTable['occupation'],
                    'gender' => $ourDataTable['gender'],
                    'is_staff' => $ourDataTable['is_staff'],
                    'date_of_birth' => $ourDataTable['date_of_birth'],
                    'update_by' => $ourDataTable['update_by'],
                    'image_id' => $ourDataTable['image_id'],
                    'update_on' => $ourDataTable['update_on'],
                    'submittedon_date' => $ourDataTable['submittedon_date'],
                    'email_address' => $ourDataTable['email_address'],
                    'BVN' => $ourDataTable['BVN'],
                    'address' => $ourDataTable['address'],
                    'marital_status' => $ourDataTable['marital_status'],
                    'state_of_origin' => $ourDataTable['state_of_origin'],
                    'lga' => $ourDataTable['lga'],
                    'country' => $ourDataTable['country'],
                    'sms_active' => $ourDataTable['sms_active'],
                    'email_active' => $ourDataTable['email_active'],
                    'id_card' => $ourDataTable['id_card'],
                    'id_img_url' => $ourDataTable['id_img_url'],
                    'signature' => $ourDataTable['signature'],
                    'passport' => $ourDataTable['passport'],
                    'rc_number' => $ourDataTable['rc_number'],
                    'sig_one' => $ourDataTable['sig_one'],
                    'sig_two' => $ourDataTable['sig_two'],
                    'sig_three' => $ourDataTable['sig_three'],
                    'sig_address_one' => $ourDataTable['sig_address_one'],
                    'sig_address_two' => $ourDataTable['sig_address_two'],
                    'sig_address_three' => $ourDataTable['sig_address_three'],
                    'sig_phone_one' => $ourDataTable['sig_phone_one'],
                    'sig_phone_two' => $ourDataTable['sig_phone_two'],
                    'sig_phone_three' => $ourDataTable['sig_phone_three'],
                    'sig_gender_one' => $ourDataTable['sig_gender_one'],
                    'sig_gender_two' => $ourDataTable['sig_gender_two'],
                    'sig_gender_three' => $ourDataTable['sig_gender_three'],
                    'sig_state_one' => $ourDataTable['sig_state_one'],
                    'sig_state_two' => $ourDataTable['sig_state_two'],
                    'sig_lga_one' => $ourDataTable['sig_lga_one'],
                    'sig_lga_two' => $ourDataTable['sig_lga_two'],
                    'sig_lga_three' => $ourDataTable['sig_lga_three'],
                    'sig_occu_one' => $ourDataTable['sig_occu_one'],
                    'sig_occu_two' => $ourDataTable['sig_occu_two'],
                    'sig_occu_three' => $ourDataTable['sig_occu_three'],
                    'sig_bvn_one' => $ourDataTable['sig_bvn_one'],
                    'sig_bvn_two' => $ourDataTable['sig_bvn_two'],
                    'sig_bvn_three' => $ourDataTable['sig_bvn_three'],
                    'sms_active_one' => $ourDataTable['sms_active_one'],
                    'sms_active_two' => $ourDataTable['sms_active_two'],
                    'sms_active_three' => $ourDataTable['sms_active_three'],
                    'email_active_one' => $ourDataTable['email_active_one'],
                    'email_active_two' => $ourDataTable['email_active_two'],
                    'email_active_three' => $ourDataTable['email_active_three'],
                    'sig_passport_one' => $ourDataTable['sig_passport_one'],
                    'sig_passport_two' => $ourDataTable['sig_passport_two'],
                    'sig_passport_three' => $ourDataTable['sig_passport_three'],
                    'sig_signature_one' => $ourDataTable['sig_signature_one'],
                    'sig_signature_two' => $ourDataTable['sig_signature_two'],
                    'sig_signature_three' => $ourDataTable['sig_signature_three'],
                    'sig_id_img_one' => $ourDataTable['sig_id_img_one'],
                    'sig_id_img_two' => $ourDataTable['sig_id_img_two'],
                    'sig_id_img_three' => $ourDataTable['sig_id_img_three'],
                    'sig_id_card_one' => $ourDataTable['sig_id_card_one'],
                    'sig_id_card_two' => $ourDataTable['sig_id_card_two'],
                    'sig_id_card_three' => $ourDataTable['sig_id_card_three'],
                    'status' => $ourDataTable['status']
                ];
                $sendData = create('clients', $condition);
            }
            if ($sendData) {
                echo $message = '<div class="alert alert-success">Data Imported Successfully</div>';
            }
        }
    }
}