<?php 
    $host = "localhost";
    $user = "realestate_rai_db";
    $pass = "6K2R4?yGiF]p";
    $dbname = "realestate_rai_db";

    $conn = new mysqli($host, $user, $pass, $dbname,);

    if($conn->error){
        die("Falha ao conectar com banco:" . $conn->error);
    }