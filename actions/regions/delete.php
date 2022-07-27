<?php 
    include '../../config.php';
    include '../../protect.php';

    if ( isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "DELETE FROM regions WHERE id=$id";
        $conn->query($sql);
    }

    header("Location: ../../regions.php?msg=success");

?>