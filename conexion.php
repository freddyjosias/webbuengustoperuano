<?php

    try {
        $conexion = new PDO(

            // 'mysql:host=localhost;dbname=buengustoperuano;charset=UTF8',
            // 'root',
            // ''

            'mysql:host=35.238.102.2;dbname=buengustoperuano;charset=UTF8',
            'user',
            'tuprima'
            
        );
    } catch (Exception $e) {
        echo $e -> getMessage();
    }

?>