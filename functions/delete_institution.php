<?php
include("connect.php");
?>
<?php
if(isset($_GET['edit']) && $_GET['edit'] !== '') {
    $int_id = $_GET['edit'];
    $sql = "DELETE FROM institutions WHERE int_id='$int_id'";
    $stmt = mysqli_prepare($connection, $sql);
    if(mysqli_stmt_execute($stmt)) {
        header("Location: ../institution.php");
    } else {
        echo "nop";
    }
    // close statement
    mysqli_stmt_close($stmt);
} else {
    echo "BAD";
}

mysqli_close($connection);
?>