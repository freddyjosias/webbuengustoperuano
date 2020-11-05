<?php 

    require '../../conexion.php';

    session_start();

    if (!isset($_SESSION['sucursal'])) {
        header('Location: ../../index.php');
    }

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 2) {
            header('Location: ../../index.php');
        }
    } else {
        header('Location: ../../index.php');
    }

    if (isset($_GET['id'])) {

        $resultados = $conexion -> prepare(
            'UPDATE categoriaproductos SET estado = 0 WHERE idcategoriaproducto = ?'
        );
        $resultados -> execute(array($_GET['id']));

        if ($resultados) {
            header('Location: listar.php');
        }
    }

?>