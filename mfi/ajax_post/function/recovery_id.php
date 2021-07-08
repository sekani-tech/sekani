<?php
$digits = 12;
$rando = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
if($_POST['recover'] == 1){
    $digits = 12;
    $rando = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
    echo "RECOVERY_INCOME_". $rando;
}else{
    echo "INCOME_" . $rando;
}