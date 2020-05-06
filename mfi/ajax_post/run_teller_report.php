<?php
include("../../functions/connect.php");
$output = '';
?>
<?php
if (isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["branch"]) && isset($_POST["till"]))
{
    $int_id = $_POST["int_id"];
    if($_POST["start"] != '' && $_POST["till"] != '')
    {
        $start = $_POST["start"];
       $end = $_POST["end"];
       $branch = $_POST["branch"];
       $teller = $_POST["teller"];
   $query = mysqli_query($connection, "SELECT * FROM tellers WHERE name ='$teller' && int_id='$sessint_id'");
  if (count([$query]) == 1) {
    $ans = mysqli_fetch_array($query);
    $id = $ans['id'];
    $int_id = $ans['int_id'];
    $tell_name = $ans['name'];
    $postlimit = $ans['post_limit'];
    $tellerno = $ans['till_no'];
    $tillno = $ans['till'];
    $startdate = $ans['valid_from'];
    $endate = $ans['valid_to'];
    $branch_id = $ans['branch_id'];
    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
    }
  }

       $querytoget = "SELECT * FROM institution_account_transaction WHERE teller_id = ''";
    }
}
?>