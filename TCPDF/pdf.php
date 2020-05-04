<?php
require_once('tcpdf.php');
include('../functions/connect.php');
// Include the main TCPDF library (search for installation path).
require_once('config/tcpdf_config.php');

if(isset($_GET["edit"])) {
    $id = $_GET["edit"];
    $query1 = mysqli_query($connection, "SELECT * FROM client WHERE id='$id'");
    if (count([$query1]) == 1) {
        $a = mysqli_fetch_array($query1);
        $fname = $a['firstname'];
        $lname = $a['lastname'];
        $int_id = $a['int_id'];
        $actype = $a['account_type'];
        $acc_no = $a['account_no'];
        $branch = $a['branch_id'];
        $query2 = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$int_id'");
        if (count([$query2]) == 1) {
            $b = mysqli_fetch_array($query2);
            $intname = $b['int_name'];
            $logo = $b['img'];
        }
        $branchid = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch'");
        if (count([$branchid]) == 1) {
         $c = mysqli_fetch_array($branchid);
         $branch_name = strtoupper($c['name']);
        $branch_address = $c['location'];
        }
        $acount = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acc_no'");
        if (count([$acount]) == 1) {
        $d = mysqli_fetch_array($acount);
        $currtype = $d['currency_code'];
        }
        $trans = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acc_no'");
        if (count([$trans]) == 1) {
        $e = mysqli_fetch_array($trans);
        $client_id = $e['client_id'];
        }
    }
}
// extend TCPF with custom functions
class MYPDF extends TCPDF {

	// Load table data from file
	public function LoadData() {
        require_once('dbtable.php');
        $objbook = new book;
        $books = $objbook -> gettransaction();
		return $books;
	}

	// Colored table
	public function ColoredTable($header,$data) {
		// Colors, line width and bold font
		$this->SetFillColor(000, 000, 000);
		$this->SetTextColor(255);
		$this->SetDrawColor(211, 211, 211);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		$w = array(40, 25, 45, 30, 30, 30);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		foreach($data as $row) {
			$this->Cell($w[0], 6, $row['transaction_date'], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row['created_date'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['amount'], 'LR', 0, 'L', $fill);
			$this->Cell($w[3], 6, number_format($row['debit'], 2), 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, number_format($row['credit'], 2), 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, number_format($row['cumulative_balance_derived'], 2), 'LR', 0, 'R', $fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($intname);
$pdf->SetTitle('Client_statement');
$pdf->SetSubject('Client statement for '.$fname, $lname.'');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Client Statment by '.$intname, PDF_HEADER_STRING);
// $pdf->SetHeaderData('../instimg/'.$logo, '30', 'Client Statment by '.$intname, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// $pdf->setPrintHeader(false);
// $pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);
$pdf->setCellHeightRatio(1.25);
// add a page
$pdf->AddPage();

// column titles
$header = array('Transaction-Date','Value Date', 'Reference','Debits','Credits','Balance');

$html = <<<EOD
<style>
th {
    font-size: 13px;
}
.firstbox {
    color: black;
    height: auto;
    font-family: helvetica;
    background-color: #eaeaea;
}
.tag {
    padding: 10px;
}
.grid {
    display: grid;
    grid-column-gap: 10px;
    grid-template-columns: 50px 50px;
}
.row{
    height: 10px;
    width:50%;
    border: 1px solid black;
}
</style>
<div class="tag">
<div class="firstbox">
<div class="grid">
       <div class="row">Branch name: $branch_name</div>
       <div class="row">Branch address: $branch_address</div>
       <div class="row">Client name: $fname $lname</div>
       <div class="row">Currency: $currtype</div> 
       <div class="row">Account number: $acc_no</div>
       <div class="row">Total debit: $actype</div>     
       <div class="row">Opening balance: $actype</div>
       <div class="row">Total credit: $actype</div>    
       <div class="row">Closing balance: $actype</div>
       <div class="row">Statement period:  01/01/2020 - 01/04/2020</div> 
        </div>
    </div>
    </div>
EOD;

// print a block of text using Write()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// data loading
$data = $pdf->LoadData();
// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('client_statement.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+

?>