<?php

    try {
        $conexion = new PDO(
            'mysql:host=93.189.89.98;dbname=buengustoperuano;charset=UTF8',
            'root',
            'root'
        );
    } catch (Exception $e) {
        echo $e -> getMessage();
    }

?>