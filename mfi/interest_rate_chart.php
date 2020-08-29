<?php
    include("../functions/connect.php");
    session_start();
    $display = '';
    $col_id = $_POST['id'];
    $name = $_POST['name'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $intrate = $_POST['intrate'];
    if(isset($_POST['term'])){
        $term = $_POST['term'];
    }
    else{
        $term = 0; 
    }

    if(isset($_POST['amount'])){
        $amount = $_POST['amount'];
    }
    else{
        $amount = 0;
    }

    $desc = $_POST['desc'];
    $coldate = date('Y-m-d');
    $int_id = $_SESSION['int_id'];
    $branch_id = $_SESSION["branch_id"];
    $cache_id = $_SESSION["savings_temp"];

    $coll = mysqli_query($connection, "INSERT INTO interest_rate_chart (int_id, branch_id, name, start_date,
     end_date, interest_rate, term, amount, description, prod_cache_id) VALUES ('{$int_id}', '{$branch_id}', '{$name}', '{$start}', '{$end}', '{$intrate}', '{$term}','{$amount}','{$desc}', '{$cache_id}')");
    if ($coll) {
        $donc = mysqli_query($connection, "SELECT * FROM interest_rate_chart WHERE int_id ='$int_id' AND prod_cache_id = '$cache_id' ORDER BY id DESC");
?>
             <table class="rtable display nowrap" style="width:100%">
             <thead>
             <tr>
               <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Interest Rate</th>
                <th>Description</th>
                </tr>
             </thead>
             <tbody>
                 <?php if (mysqli_num_rows($donc) > 0) { 
                     while($pox = mysqli_fetch_array($donc, MYSQLI_ASSOC))
                     {
                     ?>
             <tr>
            <th><?php echo $pox["name"]; ?></th>
            <th><?php echo $pox["start_date"]; ?></th>
            <th><?php echo $pox["end_date"]; ?></th>
            <th><?php echo $pox["interest_rate"]; ?></th>
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