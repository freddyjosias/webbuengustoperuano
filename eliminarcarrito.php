<?php 

    require 'conexion.php';

    session_start();


    if (isset($_GET['id'])) {

        $producto = $conexion -> prepare('SELECT quantity FROM shop_car WHERE idproducto = ?');
        $producto -> execute(array($_GET['id']));
        $producto = $producto -> fetch(PDO::FETCH_ASSOC);

        $insercion = $conexion -> prepare('UPDATE productos SET stock = stock + ? WHERE idproducto = ?');
        $insercion -> execute(array($producto['quantity'],$_GET['id']));

        $resultados = $conexion -> prepare(
            'DELETE FROM shop_car WHERE idproducto = ?'
        );
        $resultados -> execute(array($_GET['id']));
   
        if ($resultados) {
            header('Location: carrito.php?view='.$_GET['view']);
        }
    }


?>