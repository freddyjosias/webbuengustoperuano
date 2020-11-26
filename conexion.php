<?php

    try {
        $conexion = new PDO(

            'mysql:host=34.123.150.176;dbname=buengustoperuano;charset=UTF8',
            'user',
            'tuprima'
            
        );
    } catch (Exception $e) {
        echo $e -> getMessage();
    }

?>