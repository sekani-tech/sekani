<?php
include("../../functions/connect.php");

if (isset($_POST['id'])) {
    $tellersCondition = ['branch_id' => $_POST['id']];
    $tellers = selectAll("tellers", $tellersCondition);
    foreach ($tellers as $teller) {
        ?>
        <tr>
            <td><?php echo $teller['description'] ?></td>
            <td><?php echo $teller['id'] ?></td>
        </tr>
        <?php

    }
}
