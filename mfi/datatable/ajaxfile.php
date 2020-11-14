<?php
include 'config.php';
session_start();
$sessint_id = $_SESSION["int_id"];
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (client.firstname like '%".$searchValue."%' or 
    client.lastname like '%".$searchValue."%' or client.account_no like '%".$searchValue."%' or 
    client.display_name like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from client WHERE int_id = '$sessint_id'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from client WHERE int_id = '$sessint_id'  ".$searchQuery."");
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT *
FROM client 
WHERE client.int_id = '$sessint_id' AND status = 'Approved' ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    // get account
    $cid = $row["id"];
    $get_one_account = mysqli_query($con, "SELECT * FROM `account` WHERE client_id = '$cid' AND int_id = '$sessint_id' ORDER BY id ASC LIMIT 1");
    if (mysqli_num_rows($get_one_account) == 1) {
                            $rowa = mysqli_fetch_array($get_one_account);
                            $soc = $rowa["account_no"];
                            $actype = $rowa["product_id"];
                            // acccount id
                            $spn = mysqli_query($con, "SELECT * FROM savings_product WHERE id = '$actype' AND int_id = '$sessint_id'");
                           if (count([$spn])) {
                             $d = mysqli_fetch_array($spn);
                             if(isset($d["name"])){
                             $savingp = $d["name"];
                            }
                        }
                          } else {
                            $soc = "No Account";
                          }
    $data[] = array(
    		"firstname"=>$row['firstname'],
    		"lastname"=>$row['lastname'],
    		"account_officer"=>$row['loan_officer_id'],
    		"account_type"=>"$savingp",
    		"account_no"=>"$soc",
    		"view"=>"<a href='client_view.php?edit=".$row["id"]."' class='btn btn-info'>View</a>",
    		"close"=>"<a href='../functions/close_client.php?edit=".$row["id"]."' class='btn btn-info'>Close</a>"
    	);
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
