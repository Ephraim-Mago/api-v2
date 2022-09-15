<?php
    //mysql:host=localhost;dbname=id18146799_api_store
    //username:id18146799_root;password:qWK1C!yi3-Iq{F%m

    $dsn = 'mysql:host=localhost;dbname=api-v1'; //mysql:host=$host;dbname=$db;charset=utf8mb4
    $user = 'root';
    $password = "";
    
    try {
        $conn = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET UTF8'
        ]);
    } catch (\Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }  
?>