<?php

    try {
        $conexion = new PDO(

            'mysql:host=34.72.102.16;dbname=buengustoperuano;charset=UTF8',
            'user',
            'tuprima'
            
        );
    } catch (Exception $e) {
        echo $e -> getMessage();
    }

?>