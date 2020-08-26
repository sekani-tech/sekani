<?php
$dep = $_POST["dd"];
$min = $_POST["min"];
$max = $_POST["max"];


 if($dep < $min ) {
    echo '<label style="color: red;">Min Deposit Amount has not been met!</label';
}
else if($max>=$dep && $dep>=$min){
    echo '';
}
else if($dep > $max) {
    echo '<label style="color: red;">Max Deposit Amount has been exceeded!</label';
}
else{
    echo '<label style="color: red;">Bruhh</label';
}
?>