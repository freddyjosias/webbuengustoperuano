<?php

    session_start();

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 3) {
            header('Location: ../../index.php');
        }
    } else {
        header('Location: ../../index.php');
    }

    require '../../conexion.php';

    if (isset($_GET['id']) && isset($_GET['email'])) {

        $resultadosUser = $conexion -> prepare('SELECT idusuario FROM usuario WHERE emailusuario = ?');
        $resultadosUser -> execute(array($_GET['email']));
        $resultadosUser = $resultadosUser -> fetchAll(PDO::FETCH_ASSOC);

        $deleteEncargado = $conexion -> prepare('DELETE FROM access WHERE idusuario = ?');
        $deleteEncargado -> execute(array($_GET['id']));

        $updateProfile = $conexion -> prepare('UPDATE usuario SET id_profile = 1 WHERE idusuario = ?');
        $updateProfile -> execute(array($resultadosUser[0]['idusuario']));

        header('Location: listar.php');
    }

?>
