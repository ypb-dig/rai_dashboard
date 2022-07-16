<?php 
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "rai_db";

    $conn = new mysqli($host, $user, $pass, $dbname,);

    if($conn->error){
        die("Falha ao conectar com banco:" . $conn->error);
    }