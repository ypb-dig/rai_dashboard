<?php 
    // $host = "localhost";
    // $user = "root";
    // $pass = "";
    // $dbname = "rai_db";

    $host = "localhost";
    $user = "realestate_rai_db";
    $pass = "*nLMwFb)gO6o";
    $dbname = "realestate_rai_db";

    $conn = new mysqli($host, $user, $pass, $dbname,);

    if($conn->error){
        die("Falha ao conectar com banco:" . $conn->error);
    }
