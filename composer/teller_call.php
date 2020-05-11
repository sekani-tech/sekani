<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
<header class="clearfix">
<div id="logo">
  <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
</div>
<h1>'.$_SESSION["int_name"].' - Call Over Report</h1>
<div id="company" class="clearfix">
  <div>Company Name</div>
  <div>455 Foggy Heights,<br /> AZ 85004, US</div>
  <div>(602) 519-0450</div>
  <div><a href="mailto:c@example.com">company@example.com</a></div>
</div>
<div id="project">
  <div><span>TELLER NAME</span> Teller 1</div>
  <div><span>BRANCH</span> Head Office Branch</div>
  <div><span>FROM</span> August 17, 2015</div>
  <div><span>AS AT</span> September 17, 2015</div>
</div>
</header>
<main>
<table>
<thead>
  <tr>
    <th class="service">Account Name</th>
    <th class="desc">Deposit</th>
    <th>Withdrawal</th>
    <th>Balance</th>
    <th>TOTAL</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="service">Design</td>
    <td class="desc">Creating a recognizable design solution based on the companys existing visual identity</td>
    <td class="unit">$40.00</td>
    <td class="qty">26</td>
    <td class="total">$1,040.00</td>
  </tr>
  <tr>
    <td class="service">Development</td>
    <td class="desc">Developing a Content Management System-based Website</td>
    <td class="unit">$40.00</td>
    <td class="qty">80</td>
    <td class="total">$3,200.00</td>
  </tr>
  <tr>
    <td class="service">SEO</td>
    <td class="desc">Optimize the site for search engines (SEO)</td>
    <td class="unit">$40.00</td>
    <td class="qty">20</td>
    <td class="total">$800.00</td>
  </tr>
  <tr>
    <td class="service">Training</td>
    <td class="desc">Initial training sessions for staff responsible for uploading web content</td>
    <td class="unit">$40.00</td>
    <td class="qty">4</td>
    <td class="total">$160.00</td>
  </tr>
  <tr>
    <td colspan="4">SUBTOTAL</td>
    <td class="total">$5,200.00</td>
  </tr>
  <tr>
    <td colspan="4">TAX 25%</td>
    <td class="total">$1,300.00</td>
  </tr>
  <tr>
    <td colspan="4" class="grand total">GRAND TOTAL</td>
    <td class="grand total">$6,500.00</td>
  </tr>
</tbody>
</table>
<div id="notices">
<div>Opening Balance: </div>
<div>Total Deposit: </div>
<div>Total Withdrawal: </div>
<div>Closing Balance: </div>
<br/>
<div>Teller Sign:</div>
<div id="company" class="clearfix">
Date:
</div>
<div>Checked by:</div>
<div id="company" class="clearfix">
Date and Sign:
</div>
</div>
</main>
');
$mpdf->Output();
?>