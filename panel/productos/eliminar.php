<?php 

    require '../../conexion.php';
    header('Cache-Control: no cache');
    session_cache_limiter('private_no_expire');
    session_start();

    if (!isset($_SESSION['sucursal'])) {
        header('Location: index.php');
    }

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 2) {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }

    if (isset($_GET['categoria']) && isset($_GET['id'])) {

        $resultados = $conexion -> prepare(
            'UPDATE productos SET estado = 0 WHERE idcategoriaproducto = ? AND idproducto = ?'
        );
        $resultados -> execute(array($_GET['categoria'],$_GET['id']));

        if ($resultados) {
            header('Location: listar.php');
        }
    }


?>
