<?php 
    include '../../config.php';
    include '../../protect.php';

    if ( isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "DELETE FROM categories WHERE id=$id";
        $conn->query($sql);
    }

    header("Location: ../../categories.php?msg=success");

?>