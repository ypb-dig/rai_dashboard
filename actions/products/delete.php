<?php 
    include '../../config.php';
    include '../../protect.php';

    if ( isset($_GET['id'])){
        $id = $_GET['id'];

        $conn->begin_transaction();

        $sql = "DELETE FROM cadastro_listing_categories
        WHERE cadastro_listing_categories.idlistings = $id";

        $result_delete = $conn->query($sql);

        $conn->commit();
    }
    if(!$result_delete){
        header("Location: ../../products.php?msg=error");
    }else{
        header("Location: ../../products.php?msg=success");
    }
    
?>