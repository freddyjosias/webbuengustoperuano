<?php

    require '../../conexion.php';
    header('Cache-Control: no cache');
    session_cache_limiter('private_no_expire');
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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     
        if (isset($_POST['forma1'])) {
            $resultados1 = $conexion -> prepare('UPDATE detalleformaspago SET disponibilidadformaspago = ? WHERE idformaspago = 1 AND idsucursal = ?');
            $resultados1 -> execute(array($_POST['forma1'], $_SESSION['sucursal']));
        }

        if (isset($_POST['forma2'])) {
            $resultados2 = $conexion -> prepare('UPDATE detalleformaspago SET disponibilidadformaspago = ? WHERE idformaspago = 2 AND idsucursal = ?');
            $resultados2 -> execute(array($_POST['forma2'], $_SESSION['sucursal']));
        }

        if (isset($_POST['forma3'])) {
            $resultados3 = $conexion -> prepare('UPDATE detalleformaspago SET disponibilidadformaspago = ? WHERE idformaspago = 3 AND idsucursal = ?');
            $resultados3 -> execute(array($_POST['forma3'], $_SESSION['sucursal']));
        }
    }

    $resultado1 = $conexion -> prepare('SELECT disponibilidadformaspago FROM detalleformaspago WHERE idformaspago = 1 AND idsucursal = ?');
    $resultado1 -> execute(array($_SESSION['sucursal']));

    $resultado2 = $conexion -> prepare('SELECT disponibilidadformaspago FROM detalleformaspago WHERE idformaspago = 2 AND idsucursal = ?');
    $resultado2 -> execute(array($_SESSION['sucursal']));

    $resultado3 = $conexion -> prepare('SELECT disponibilidadformaspago FROM detalleformaspago WHERE idformaspago = 3 AND idsucursal = ?');
    $resultado3 -> execute(array($_SESSION['sucursal']));

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Actualizar Formas de Pago</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/responpanel.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">

</head>
<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">

            <?php require '../../menu/menupanel.php'; ?>

            <div class='formulario-panel container p-0 main-panel m-0 mw-85 w-85'>

            <h1 class='h3 text-center mt-5 font-weight-bold w-100'>Actualizar Formas de Pago</h1>

                <form action="" class='form-panel' method="post">
                <?php foreach($resultado1 as $row) { ?>
                    <?php
                        if($row['disponibilidadformaspago'] == 1 ){?>
                            <p class='h3 mt-5 font-weight-bold w-100'>Efectivo</p>
                            <p><input type="radio" id="" name="forma1" value="1"checked> Habilitar</p>
                            <p><input type="radio" id="" name="forma1" value="0"> Desabilitar</p><?php
                        }else{?>
                            <p class='h3 mt-5 font-weight-bold w-100'>Efectivo</p>
                            <p><input type="radio" id="" name="forma1" value="1"> Habilitar</p>
                            <p><input type="radio" id="" name="forma1" value="0"checked> Desabilitar</p><?php
                        }?>
                <?php } ?>
                <?php foreach($resultado2 as $row) { ?>
                    <?php
                        if($row['disponibilidadformaspago'] == 1 ){?>
                            <p class='h3 mt-5 font-weight-bold w-100'>Online</p>
                            <p><input type="radio" id="" name="forma2" value="1"checked> Habilitar</p>
                            <p><input type="radio" id="" name="forma2" value="0"> Desabilitar</p><?php
                        }else{?>
                            <p class='h3 mt-5 font-weight-bold w-100'>Online</p>
                            <p><input type="radio" id="" name="forma2" value="1"> Habilitar</p>
                            <p><input type="radio" id="" name="forma2" value="0"checked> Desabilitar</p><?php
                        }?>
                <?php } ?>
                <?php foreach($resultado3 as $row) { ?>
                    <?php
                        if($row['disponibilidadformaspago'] == 1 ){?>
                            <p class='h3 mt-5 font-weight-bold w-100'>POS</p>
                            <p><input type="radio" id="" name="forma3" value="1"checked> Habilitar</p>
                            <p><input type="radio" id="" name="forma3" value="0"> Desabilitar</p><?php
                        }else{?>
                            <p class='h3 mt-5 font-weight-bold w-100'>POS</p>
                            <p><input type="radio" id="" name="forma3" value="1"> Habilitar</p>
                            <p><input type="radio" id="" name="forma3" value="0"checked> Desabilitar</p><?php
                        }?>
                <?php } ?>                    
                    <input type="submit" value="Actualizar">

                </form>

            </div>

        </div>
    </main>

</body>
</html>