<?php
$digits = 12;
$rando = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
if ($_POST['charge'] == 1){
    echo "CHARGE_". $rando;
}
else{
    echo "INCOME_" . $rando;
}