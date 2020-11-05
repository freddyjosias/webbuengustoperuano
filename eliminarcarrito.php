<?php 

    require 'conexion.php';

    session_start();


    if (isset($_GET['id'])) {

        $resultados = $conexion -> prepare(
            'DELETE FROM shop_car WHERE idproducto = ?'
        );
        $resultados -> execute(array($_GET['id']));

        if ($resultados) {
            header('Location: carrito.php?view='.$_GET['view']);
        }
    }


?>