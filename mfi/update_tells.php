<?php
// this is Victor's personal testing page for tasks.....  BEWARE!!!!!!!!!!!!!!!!!!!!!!!

include("../functions/connect.php");


    
    
        $institutionId = 1;
        $branch = 1;
        $length = strlen($branch);
          if ($length == 2) {
            // if branch id is greater than one
            $digit = 7;
          } else if ($length == 3) {
            // greater than 2
            $digit = 6;
          } else if ($length == 4) {
            // greater than 3
            $digit = 5;
          } else {
            $digit = 8;
          }
    $randms = str_pad(rand(0, pow(10, $digit) - 1), $digit, '0', STR_PAD_LEFT);

    function account_no_generation($institutionId, $branch, $randms){
       $account_no = $institutionId . "" . $branch . "" . $randms;
        return $account_no;
    }
    $account_no = account_no_generation($institutionId, $branch, $randms);
    echo $account_no . "This is the main  ";

    $condition = [
            'int_id' => $institutionId,
        ];
    $fetch_account_info = selectAll('account', $condition);
    foreach($fetch_account_info as $account_info){
    $fetched_account_no = $account_info['account_no'];
        if ($account_no == $fetched_account_no){
          $account_no = account_no_generation();
        }
    }
//echo "Anther acct no was generated because it exists - new one here" . $another_account_number;
   $bambi = $account_no; 
   echo "Bambi is las las one variable-> ".$bambi;
?>