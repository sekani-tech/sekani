<?php
include("../functions/connect.php");
session_start();
?>

<?php
if(isset($_GET["edit"])) {
  $location = $_GET["edit"];
  echo 'Page not yet functional, Please go back to previous page ';
  if($location == "1"){
    echo header("Location: report_client_view.php?view1");
  }
  else if($location == "2"){
    echo header("Location: report_client_view.php?view2");
  }
  else if($location == 3){
    echo header("Location: report_client_view.php?view3");
  }
  else if($location == "4"){
    echo header("Location: report_client_view.php?view4");
  }
  else if($location == "5"){
    echo header("Location: report_client_view.php?view5");
  }
  else if($location == "6"){
    echo header("Location: report_group_view.php?view6");
  }
  else if($location == "8"){
    echo header("Location: report_group_view.php?view8");
  }
  else if($location == "9"){
    echo header("Location: report_group_view.php?view9");
  }
  else if($location == "10"){
    echo header("Location: report_savings_view.php?view10");
  }
  else if($location == "11"){
    echo header("Location: report_savings_view.php?view11");
  }
  else if($location == "12"){
    echo header("Location: report_current_view.php?view12");
  }
  else if($location == "13"){

  }
  else if($location == "14"){
    echo header("Location: report_current_view.php?view14");
  }
  else if($location == "15"){
    echo header("Location: report_loan_view.php?view15");
  }
  else if($location == "16"){
    echo header("Location: report_loan_view.php?view16");
  }
  else if($location == "17"){
    echo header("Location: report_loan_view.php?view17");
  }
  else if($location == "18"){
    echo header("Location: report_loan_view.php?view18");
  }
  else if($location == "19"){
    echo header("Location: report_loan_view.php?view19");
  }
  else if($location == "20"){
    echo header("Location: report_loan_view.php?view20");
  }
  else if($location == "21"){
    echo header("Location: report_loan_view.php?view21");
  }
  else if($location == "22"){

  }
  else if($location == "23"){
    echo header("Location: report_loan_view.php?view23");
  }
  else if($location == "24"){

  }
  else if($location == "25"){
    echo header("Location: report_financial_view.php?view25");
  }
  else if($location == "26"){
    echo header("Location: report_financial_view.php?view26");
  }
  else if($location == "27"){
    echo header("Location: statement_of_fp.php");

  }
  else if($location == "28"){
    echo header("Location: statement_of_income.php");

  }
  else if($location == "29"){
    echo header("Location: report_financial_view.php?view29");
  }
  else if($location == "30"){

  }
  else if($location == "31"){
    echo header("Location: report_fixed_deposit_view.php?view31");
  }
  else if($location == "32"){

  }
  else if($location == "33"){
    echo header("Location: teller.php");
  }
  else if($location == "34"){
    echo header("Location: vault_report.php");
  }
  else if($location == "35"){
    echo header("Location: report_institution_view.php?view35");
  }
  else if($location == "36"){
    echo header("Location: report_institution_view.php?view36");
  }
  else if($location == "39"){
    echo header("Location: report_loan_view.php?view39");
  }
  else if($location == "40"){
    echo header("Location: report_loan_view.php?view40");
  }
  else if($location == "41"){
    echo header("Location: report_savings_view.php?view41");
  }
  else if($location == "42"){
    echo header("Location: report_current_view.php?view42");
  }
  else if($location == "43"){
    echo header("Location: report_financial_view.php?view43");
  }
  else if($location == "44"){
    echo header("Location: report_institution_view.php?view44");
  }
  else if($location == "45"){
    echo header("Location: report_loan_view.php?view45");
  }
  else if($location == "46"){
    echo header("Location: report_group_view.php?view46");
  }
  else if($location == "47"){
    echo header("Location: report_financial_view.php?view47");
  }
  else if($location == "48"){
    echo header("Location: report_loan_view.php?view41");
  }
}
?>