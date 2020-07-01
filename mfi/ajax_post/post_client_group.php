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

    $opv = "SELECT * FROM client WHERE int_id = '$int_id' AND id= '$client_id'";
    $fof = mysqli_query($connection, $opv);
    $cid = mysqli_fetch_array($fof);
    $client_name = $cid['firstname']." ".$cid['lastname'];

    $query = "INSERT INTO `group_client_cache` (`int_id`, `branch_id`, `client_id`, `client_name`, `date`, `group_cache_id`)
     VALUES ('{$int_id}', '{$branch_id}', '{$client_id}', '{$client_name}', '{$date}', '{$cache_id}')";
     $queryexec = mysqli_query($connection, $query);

     $dsd = "UPDATE client SET client_type='GROUP' WHERE id = '$client_id'";
     $dsdds = mysqli_query($connection, $dsd);
}
?>
<table width="70px" class="table">
    <?php
        $sds = "SELECT * FROM group_client_cache WHERE int_id = '$int_id' AND group_cache_id = '$cache_id' ORDER BY id ASC";
        $result = mysqli_query($connection, $sds);
    ?>
    <thead class="text-primary">
        <th style="width: 60px;">Client</th>
    </thead>
    <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <?php
                        $clid = $row["client_id"];
                            $hhty = "SELECT * FROM client WHERE int_id = '$int_id' AND id= '$clid'";
                            $gffd = mysqli_query($connection, $hhty);
                            $re = mysqli_fetch_array($gffd);
                            $client_name = $re['firstname']." ".$re['lastname'];
                        ?>
                          <th style="width: 60px;"><?php echo $client_name; ?></th>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                          <!-- <th></th> -->
                      </tbody>
</table>