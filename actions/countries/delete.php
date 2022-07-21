<?php 
    include '../../config.php';
    include '../../protect.php';

    if ( isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "DELETE FROM countries WHERE id=$id";
        $conn->query($sql);
    }

    header("Location: ../../countries.php?msg=success");

?>