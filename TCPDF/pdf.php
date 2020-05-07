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
            $web = $b['website'];
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
		$this->SetFillColor(194, 100, 201);
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
		$this->SetFillColor(212, 188, 209);
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
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);
// $pdf->SetHeaderData($logo, '13', PDF_HEADER_TITLE.$intname, PDF_HEADER_STRING.$web);

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
<!DOCTYPE html>
<html>
    <head>
        <style>
            .head {
                color: black;
                font-family: helvetica;
                background-color: #eaeaea;
                width: 100%;
                display:inline-flex ;
                padding: 10px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            .grid {
                display: grid;
                grid-column-gap: 10px;
                grid-template-columns: 50px 50px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            .cname{
                margin-left: 70%;
                text-align:left;
                padding:10px;
                font-size: 20px;
                font-weight: bolder;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            .customer-info {
                display:inline-flex ;
                padding: 10px;
                width: 100%;
                border: 1px solid black;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            .right{
                text-align:right;
            }
            .left{
                text-align:left;
                padding-left:10px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            .tablea{
                width:100%;
            }
            th{
                color: white;
                background-color:#c264c9;
                border: 1px solid #c0c0c0;
                text-align:center;
            }
            td{
                border: 1px solid #c0c0c0;
            }
            .table{
                width:100%;
            }
            </style>
    </head>
    <body>
            <div class="cname">Customer Name: $lname $fname</div> 
        <div class="customer-info-box">
            <div class="customer-info">
                <span class="left">
                <br/><span>Branch name:        <b>$branch_name</b></span><br/> 
                <span>Branch address: <b>$branch_address</b></span><br/>
                <span>Client name: <b>$lname $fname</b></span><br/> 
                <span>Currency: <b>$currtype</b></span><br/>
                <span>Account number:<b> $acc_no</b></span><br/> 
                <span>Total debit <b></span></b><br/>
                <span>Total credit <b></span></b><br/> 
                <span>Statement period: <b> 04/04/2020 - 05/05/2020</b></span><br/> 
            </span>
            </div>
        </div>
        <div class="table">
            <table class="tablea">
                <thead>
                    <tr>
                        <th>Opening Balance</th>
                        <th>Closing Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2,000,000</td>
                        <td>2,600,000</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            
        </div>
    </body>
</html>
EOD;

// print a block of text using Write()
$pdf->writeHTML($html, true, false, true, false, '');

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