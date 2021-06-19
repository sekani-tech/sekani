<?php
include("../../../functions/connect.php");
session_start();
$insitutionId = $_SESSION['int_id'];

$cacheChargeConditions = [
    'int_id' => $insitutionId,
    'cache_prod_id' => $_POST['tempId']
];
$cacheCharged = selectAll("charges_cache", $cacheChargeConditions);
foreach ($cacheCharged as $keys => $rows) {
?>
    <tr>
        <td><?php echo $rows['name'] ?></td>
        <td><?php echo $rows['charge'] ?></td>
        <td><?php echo $rows['collected_on'] ?></td>
        <td>
            <div class="test" data-id="<?php echo $rows['id'] ?>"><span class="btn btn-danger">Delete</span></div>
        </td>
    </tr>
<?php
}
?>

<script>
    $(document).ready(function() {
        $('#eodr').DataTable();
    });
    $('.test').click(function() {
        var el = this;

        // Delete id
        var id = $(this).data('id');

        var confirmalert = confirm("Delete this Charge?");
        if (confirmalert == true) {
            // AJAX Request
            $.ajax({
                url: 'ajax_post/ajax_delete/delete_cache.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(response) {

                    if (response == 1) {
                        // Remove row from HTML Table
                        $(el).closest('tr').css('background', 'tomato');
                        $(el).closest('tr').fadeOut(700, function() {
                            $(this).remove();
                        });
                    } else {
                        alert('Invalid ID.');
                    }
                }
            });
        }
    });
</script>