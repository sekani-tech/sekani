<?php
include("../../functions/connect.php");
$output = '';
session_start();


if(isset($_POST["client_id"]))
{
  $int_id = $_SESSION["int_id"];
  $branch_id = $_SESSION["branch_id"];
  $client_id = $_POST["client_id"];
  $cache_id = $_POST["cache_id"];
  $date = date('Y-m-d h:i:s');
  ?>

  <!-- This will be passed into ajax for removing of client on group_client_cache table-->
  <input type="text" value="<?php echo $cache_id?>" hidden id="cache_id_res">

  <?php
//Fetch all data from group cache 
  $cacheData= [
    'int_id' => $int_id,
    'client_id' => $client_id,
    'group_cache_id' => $cache_id
  ];
  $findUser = selectOne('group_client_cache',  $cacheData);

  if($findUser){
    echo 'Group member already exists';
  }else{

//Fetch Client details based on institution
    $clientData =[
      'int_id' => $int_id,
      'id' => $client_id
    ];
    $clientResult = selectOne('client',  $clientData);
    $client_name = $clientResult['firstname']." ".$clientResult['lastname'];

//Add data to cache
    $cacheAdd=[
      'int_id' => $int_id,
      'branch_id' => $branch_id,
      'client_id' => $client_id,
      'client_name' => $client_name,
      'date' => $date,
      'group_cache_id' => $cache_id

    ];
    $addTocache= create('group_client_cache', $cacheAdd);
    if ($addTocache) {
      echo 'Group member successfully added';
    } 

  }

}
?>

<?php 
$cache_id=$_POST["cache_id"]; //This value is retrieved from delete_group_cache.php,it will enable reloading without refreshing the page
$int_id = $_SESSION["int_id"];
?>

<table width="70px" class="table">
  <?php
  //Fetch all client in group_client_cache having same institution id and group_cache_id
  $result = selectAllWithOrder('group_client_cache', ['int_id'=>$int_id,'group_cache_id'=>$cache_id], 'id', 'desc');
  ?>

  <thead class="text-primary">
    <th style="width: 100px;">Client</th>
  </thead>
  <tbody>
    <?php if ($result) {
     foreach ($result as $key => $row) { ?>
      <tr>

        <?php
        $client_id= $row["client_id"];
        
    //Fetch Client details based on institution
        $clientData =[
          'int_id' => $int_id,
          'id' => $client_id
        ];
        $clientResult = selectOne('client',  $clientData);
        $client_name = $clientResult['firstname']." ".$clientResult['lastname'];
        ?>

        <th style="width: 60px;"><?php echo $client_name; ?> 
        <a style="margin-right: 100px;" class="btn btn-primary btn-fab btn-fab-mini btn-round" id="del_num_<?php echo $row["id"]?>" data-cache-id="<?php echo $row["id"]?>">
          <i class="material-icons" style="color: #fff;text-decoration: none;">close</i>
        </a>

      </th>
    </tr>
    <!-- script -->
    <script type="text/javascript">
      $('#del_num_<?php echo $row["id"]?>').on("click", function () {

        var id = $(this).data("cache-id");
        var reload_cache = $('#cache_id_res').val();;
                            // alert(id + "i am here")
                            $.ajax({
                              url: "ajax_post/ajax_delete/delete_group_cache.php", 
                              method: "POST",
                              data:{id:id,redca: reload_cache},
                              success: function(data) {
                                $('#delshow').html(data);
                              }
                            });
                          });
                        </script>
                      <?php }
                    }
                    else {
       echo "no record found";                     // echo "0 Document";
     }
     ?>
     <!-- <th></th> -->
   </tbody>

 </table>
