<?php

    try {
        $conexion = new PDO(
            'mysql:host=bm12bwjh2ogki5nep1dq-mysql.services.clever-cloud.com;dbname=bm12bwjh2ogki5nep1dq',
            'udq5trupmgax8sb2',
            '2zEPbb8IUZ93mDSBLxwx'
        );
    } catch (Exception $e) {
        echo $e -> getMessage();
    }

?>