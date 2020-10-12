<?php

    try {
        $conexion = new PDO(
            'mysql:host=localhost;dbname=buengustoperuano',
            'root',
            ''
        );
    } catch (Exception $e) {
        echo $e -> getMessage();
    }

?>