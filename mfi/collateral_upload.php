<?php
    include("../functions/connect.php");
    $display = '';
    $col_id = $_POST['id'];
    $clientid = $_POST['client_id'];
    $colval = $_POST['colval'];
    $colname = $_POST['colname'];
    $coldes = $_POST['coldes']; 
    $coldate = date('Y-m-d');

    $org = mysqli_query($connection, "SELECT * FROM client WHERE id = '$clientid'");
    if (count([$org]) == 1) {
      $a = mysqli_fetch_array($org);
      $int_id = $a['int_id'];
     }

    $coll = mysqli_query($connection, "INSERT INTO collateral (int_id, client_id, date, type, value, description) VALUES ('{$int_id}',
    '{$clientid}', '{$coldate}', '{$colval}', '{$colname}', '{$coldes}')");
    if ($coll) {
        $donc = mysqli_query($connection, "SELECT * FROM collateral WHERE client_id = '$clientid' ORDER BY id DESC");
?>
             <table id="tabled" class="table table-bordered" cellspacing="0" style="width:100%;">
             <thead>
             <tr>
               <th>Name/Type</th>
                <th>Value</th>
                <th>Description</th>
                </tr>
             </thead>
             <tbody>
                 <?php if (mysqli_num_rows($donc) > 0) { 
                     while($pox = mysqli_fetch_array($donc, MYSQLI_ASSOC))
                     {
                     ?>
             <tr>
            <th><?php echo $pox["value"]; ?></th>
            <th>&#x20a6; <?php echo number_format($pox["type"], 2); ?></th>
            <th><?php echo $pox["description"]; ?></th>
            </tr>
            <?php
             }
            } else {
                echo "0 Collateral";
            }
            ?>
             </tbody>
            </table>
<?php
    }    
?>