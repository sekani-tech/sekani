<?php

// the message
$msg = "test was successful\nYaay";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("olochesamuel2@gmail.com","My subject",$msg);

?>