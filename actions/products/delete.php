<?php 
    include '../../config.php';
    include '../../protect.php';

    if ( isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "DELETE FROM listings WHERE id=$id";
        $result_insert = $conn->query($sql);
    }
    if(!$result_insert){
        header("Location: ../../products.php?msg=error");
    }else{
        header("Location: ../../products.php?msg=success");
    }
    
?>