<?php 
    include '../../config.php';
    include '../../protect.php';

    if ( isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "DELETE FROM listings WHERE id=$id";
        $conn->query($sql);
    }

    header("Location: ../../products.php?msg=success");

?>