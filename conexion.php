<?php

    try {
        $conexion = new PDO(

            'mysql:host=localhost;dbname=buengustoperuano;charset=UTF8',
            'root',
            ''
            
        );
    } catch (Exception $e) {
        echo $e -> getMessage();
    }

?>