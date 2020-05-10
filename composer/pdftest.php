<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
<header class="clearfix">
<div id="logo">
  <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
</div>
<h1>'.$_SESSION["int_name"].'</h1>
<div id="company" class="clearfix">
  <div>Company Name</div>
  <div>455 Foggy Heights,<br /> AZ 85004, US</div>
  <div>(602) 519-0450</div>
  <div><a href="mailto:company@example.com">company@example.com</a></div>
</div>
<div id="project">
  <div><span>CLIENT</span> John Doe</div>
  <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
  <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
  <div><span>DATE</span> August 17, 2015</div>
  <div><span>DUE DATE</span> September 17, 2015</div>
</div>
</header>
');
$mpdf->Output();
?>