<?php
include("../functions/connect.php");
session_start();
?>

<?php
if(isset($_GET["edit"])) {
  $location = $_GET["edit"];
  echo 'get is giving out this value '.$location;
  if($location == "1"){
    
  }
  else if($location == "2"){

  }
  else if($location == 3){
    echo 'how you doing';
    echo header("Location: client.php");
  }
  else if($location == "4"){

  }
  else if($location == "5"){

  }
  else if($location == "6"){

  }
  else if($location == "7"){

  }
  else if($location == "8"){

  }
  else if($location == "9"){

  }
  else if($location == "10"){

  }
  else if($location == "11"){

  }
  else if($location == "12"){

  }
  else if($location == "13"){

  }
  else if($location == "14"){

  }
  else if($location == "15"){

  }
  else if($location == "16"){

  }
  else if($location == "17"){

  }
  else if($location == "18"){

  }
  else if($location == "19"){

  }
  else if($location == "20"){

  }
  else if($location == "21"){

  }
  else if($location == "22"){

  }
  else if($location == "23"){

  }
  else if($location == "24"){

  }
  else if($location == "25"){

  }
  else if($location == "26"){

  }
  else if($location == "27"){

  }
  else if($location == "28"){

  }
  else if($location == "29"){

  }
  else if($location == "30"){

  }
  else if($location == "31"){

  }
  else if($location == "32"){

  }
  else if($location == "33"){
    echo header("Location: teller.php");
  }
  else if($location == "34"){
    echo header("Location: vault_report.php");
  }
}
?>