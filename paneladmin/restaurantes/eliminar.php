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

    if (isset($_GET['id'])) {

        $accessRest = $conexion -> prepare('SELECT * FROM access WHERE idsucursal = ?');
        $accessRest -> execute(array($_GET['id']));
        $accessRest = $accessRest -> fetchAll(PDO::FETCH_ASSOC);

        if (isset($accessRest[0])) {
            
            $deleteEncargado = $conexion -> prepare('DELETE FROM access WHERE idsucursal = ?');
            $deleteEncargado -> execute(array($_GET['id']));

            $auxAccess = count($accessRest);

            for ($i = 0; $i < $auxAccess; $i++) {

                $updateProfile = $conexion -> prepare('UPDATE usuario SET id_profile = 1 WHERE idusuario = ?');
                $updateProfile -> execute(array($accessRest[$i]['idusuario']));

            }
                
        }

        $updateProfile = $conexion -> prepare('UPDATE sucursal SET estado = 0 WHERE idsucursal = ?');
        $updateProfile -> execute(array($_GET['id']));
        
        header('Location: listar.php');
    }

?>
