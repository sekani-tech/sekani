
<?php
header("Access-Control-Allow-Origin=> *");
header("Content-Type=> application/json; charset=UTF-8");

include_once '../config/database.php';
include_once 'client.php';

$database = new Database();
$db = $database->getConnection();

$items = new Client($db);

$stmt = $items->getClient();
$item_count = $stmt->rowCount();


echo json_encode($item_count);

if($item_count > 0){
	
	$client_arr = [];
	$client_arr["data"] = [];
	$client_arr["item_count"] = $item_count;

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$get_data = [
			"id" => $id,
			"int_id" => $int_id,
			"loan_officer_id" => $loan_officer_id,
			"loan_status" => $loan_status,
			"branch_id" => $branch_id,
			"client_type" => $client_type,
			"account_no"=> $account_no,
			"account_type"=> $account_type,
			"activation_date"=> $activation_date,
			"firstname"=> $firstname,
			"middlename"=> $middlename,
			"lastname"=> $lastname,
			"display_name"=> $display_name,
			"mobile_no"=> $mobile_no,
			"occupation"=> $occupation,
			"gender"=> $gender,
			"is_staff"=> $is_staff,
			"date_of_birth"=> $date_of_birth,
			"image_id"=> $image_id,
			"updated_by"=> $updated_by,
			"updated_on"=> $updated_on,
			"submittedon_date"=> $submittedon_date,
			"email_address"=> $email_address,
			"mobile_no_2"=> "",
			"BVN"=> $BVN,
			"ADDRESS"=> $ADDRESS,
			"STATE_OF_ORIGIN"=> $STATE_OF_ORIGIN,
			"COUNTRY"=> $COUNTRY,
			"SMS_ACTIVE"=> $SMS_ACTIVE,
			"EMAIL_ACTIVE"=> $EMAIL_ACTIVE,
			"id_card"=> $id_card,
			"id_img_url"=> $id_img_url,
			"LGA"=> $LGA,
			"signature"=> $signature,
			"passport"=> $passport,
			"rc_number"=> $rc_number,
			"sig_one"=> $sig_one,
			"sig_two"=> $sig_two,
			"sig_three"=> $sig_three,
			"sig_address_one"=> $sig_address_one,
			"sig_address_two"=> $sig_address_two,
			"sig_address_three"=> $sig_address_three,
			"sig_phone_one"=> $sig_phone_one,
			"sig_phone_two"=> $sig_phone_two,
			"sig_phone_three"=> $sig_address_three,
			"sig_gender_one"=> $sig_gender_one,
			"sig_gender_two"=> $sig_gender_two,
			"sig_gender_three"=> $sig_gender_three,
			"sig_state_one"=> $sig_state_one,
			"sig_state_two"=> $sig_state_two,
			"sig_state_three"=> $sig_state_three,
			"sig_lga_one"=> $sig_lga_one,
			"sig_lga_two"=> $sig_lga_two,
			"sig_lga_three"=> $sig_lga_three,
			"sig_occu_one"=> $sig_occu_one,
			"sig_occu_two"=> $sig_occu_two,
			"sig_occu_three"=> $sig_occu_three,
			"sig_bvn_one"=> $sig_bvn_one,
			"sig_bvn_two"=> $sig_bvn_two,
			"sig_bvn_three"=> $sig_bvn_three,
			"sms_active_one"=> $sms_active_one,
			"sms_active_two"=> $sms_active_two,
			"sms_active_three"=> $sms_active_three,
			"email_active_one"=> $email_active_one,
			"email_active_two"=> $email_active_two,
			"email_active_three"=> $email_active_three,
			"sig_passport_one"=> $sig_passport_one,
			"sig_passport_two"=> $sig_signature_two,
			"sig_passport_three"=> $sig_passport_three,
			"sig_signature_one"=> $sig_signature_one,
			"sig_signature_two"=> $sig_signature_two,
			"sig_signature_three"=> $sig_signature_three,
			"sig_id_img_one"=> $sig_id_img_one,
			"sig_id_img_two"=> $sig_id_img_two,
			"sig_id_img_three"=> $sig_id_img_three,
			"sig_id_card_one"=> $sig_id_card_one,
			"sig_id_card_two"=> $sig_id_card_two,
			"sig_id_card_three"=> $sig_id_card_three,
			"status"=> $status,
			"parent_id"=> $parent_id,
			"hierarchy"=> $hierarchy,
			"opening_date"=> $opening_date,
			"branch_name"=> $name,
			"email"=> $email,
			"state"=> $state,
			"lga"=> $lga,
			"phone"=> $phone,
			"location"=> $location
		];

		array_push($client_arr["data"], $get_data);
	}
	echo json_encode($client_arr);
}

else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}
?>


























