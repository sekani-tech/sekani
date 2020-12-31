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
	$searchQuery = " and (principal_amount like '%".$searchValue."%' or 
    loan_term like '%".$searchValue."%' or disbursement_date like '%".$searchValue."%' or 
    maturedon_date like'%".$searchValue."%' or interest_rate like'%".$searchValue."%'  ) ";
}

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from loan WHERE int_id = '$sessint_id'");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from loan WHERE int_id = '$sessint_id'  ".$searchQuery."");
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "SELECT * FROM loan WHERE int_id = '$sessint_id' ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    // client namw
    $lo_id = $row["id"];
    $name = $row['client_id'];
    $anam = mysqli_query($con, "SELECT firstname, lastname FROM client WHERE id = '$name'");
    $f = mysqli_fetch_array($anam);
    $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
    // loan offucer
    $loan_off = $row['loan_officer'];
    $fido = mysqli_query($con, "SELECT * FROM staff WHERE id = '$loan_off'");
    $fd = mysqli_fetch_array($fido);
    $account = $fd['display_name'];
// DONT KNOW
$int_rate = $row["interest_rate"];
                          $prina = $row["principal_amount"];
                          $intr = $int_rate/100;
                          $final = $intr * $prina;
                            $loant = $row["loan_term"];
                            $total = $loant * $final;
                            @$totalint +=$total;
                          $fee = $row["fee_charges_charged_derived"];
                          $income = $fee + $total;
                          @$ttlinc += $income;
// END
// repaymeny
$dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$lo_id'";
$sdoi = mysqli_query($con, $dd);
$e = mysqli_fetch_array($sdoi);
$interest = $e['interest_amount'];

$dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$lo_id'";
$sdswe = mysqli_query($con, $dfdf);
$u = mysqli_fetch_array($sdswe);
$prin = $u['principal_amount'];

$outstanding = $prin + $interest;
// Arrears
$ldfkl = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$lo_id'";
$fosdi = mysqli_query($con, $ldfkl);
$l = mysqli_fetch_array($fosdi);
$interesttwo = $l['interest_amount'];

$sdospd = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$lo_id'";
$sodi = mysqli_query($con, $sdospd);
$s = mysqli_fetch_array($sodi);
$printwo = $s['principal_amount'];

$outstandingtwo = $printwo + $interesttwo;
$bal = $row["total_outstanding_derived"];
                          $df = $bal;
                          $ttloutbalance = 0;
                          $ttloustanding = $outstanding + $outstandingtwo;
    $data[] = array(
    	"id"=>$row["id"],
    	"ClientName"=>$nae,
    	"principal_amount"=>number_format($row["principal_amount"]),
    	"loan_term"=>$row['loan_term'],
    	"DisbursementDate"=>$row['disbursement_date'],
    	"DateofMaturity"=>$row['maturedon_date'],
    	"InterestRate"=>$row["interest_rate"]."%",
    	"OutstandingLoanBalance"=>number_format($ttloustanding),
    	"LoanOfficer"=>$account,
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
