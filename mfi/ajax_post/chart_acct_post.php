<?php
include("../../functions/connect.php");
$output2 = '';
session_start();
if (isset($_POST["gl"]) && isset($_POST["ch"]))
{
  if($_POST["gl"] == '1'){
    $int_id = $_POST["id"];
    if($_POST["gl"] != '' && $_POST["ch"] != '')
    {
        
        function fill_gl($connection) {
          $acct_use = $_POST["ch"];
          $sint_id = $_SESSION["int_id"];
          $org = "SELECT * FROM acc_gl_account WHERE classification_enum = '$acct_use' AND (int_id = '$sint_id' AND (parent_id = '' OR parent_id = '0'))";
          $res = mysqli_query($connection, $org);
          $out = '';
          while ($row = mysqli_fetch_array($res))
          {
            $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
          }
          return $out;
        }
        $output2 = '
            <option value="0">choose account</option>
            "'.fill_gl($connection).'"
            ';
    echo $output2;
    }
  }
  else{

  }
}
?>