<style type="text/css">
  #oche{
    color: #000;background: white;width: 100%;border: 1px solid gray;text-decoration: none;list-style: none;padding: 6px;margin: 0px;cursor: hand
  }
</style>
<?php
include("../../../functions/connect.php");
session_start();

if(isset($_POST['search'])){
  $searchVal=$_POST['search'];
  $int_id = $_SESSION["int_id"];
  $branch_id = $_SESSION['branch_id'];

  $query=searchClient('client', $int_id, $branch_id, $searchVal);

  if($query) {

    echo "<ul class='list-unstyled'>";
    foreach ($query as $key => $Result) {
      ?>
      <li id="oche"><?php echo  $Result['firstname']." ".$Result['lastname']; ?></li> 
      <input type="hidden" name="" id="client_id" value="<?=$Result['id'];?>">

      <?php
    }
  }else{

    ?>
    <li id="oche">No record found</li>

    <?php
  }
  echo "</ul>";
}

?>