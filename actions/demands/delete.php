<?php 
    include '../../config.php';
    include '../../protect.php';

    if ( isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "DELETE FROM demands WHERE id=$id";
        $result_insert = $conn->query($sql);
    }
    if(!$result_insert){
        header("Location: ../../demands.php?msg=error");
    }else{
        header("Location: ../../demands.php?msg=success");
    }

?>