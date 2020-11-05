<?php

    require '../conexion.php';

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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        if (isset($_POST['delivery'])) {
            $resultados1 = $conexion -> prepare('UPDATE detalletipospedido SET disponibilidadtipospedido = ? WHERE idtipospedido = 1 AND idsucursal = ?');
            $resultados1 -> execute(array($_POST['delivery'],$_SESSION['sucursal']));
        }

        if (isset($_POST['recojo'])) {
            $resultados2 = $conexion -> prepare('UPDATE detalletipospedido SET disponibilidadtipospedido = ? WHERE idtipospedido = 2 AND idsucursal = ?');
            $resultados2 -> execute(array($_POST['recojo'],$_SESSION['sucursal']));
        }

        if (isset($_POST['reserva'])) {
            $resultados3 = $conexion -> prepare('UPDATE detalletipospedido SET disponibilidadtipospedido = ? WHERE idtipospedido = 3 AND idsucursal = ?');
            $resultados3 -> execute(array($_POST['reserva'],$_SESSION['sucursal']));
        }
    }

    $resultado1 = $conexion -> prepare('SELECT disponibilidadtipospedido FROM detalletipospedido WHERE idtipospedido = 1 AND idsucursal = ?');
    $resultado1 -> execute(array($_SESSION['sucursal']));

    $resultado2 = $conexion -> prepare('SELECT disponibilidadtipospedido FROM detalletipospedido WHERE idtipospedido = 2 AND idsucursal = ?');
    $resultado2 -> execute(array($_SESSION['sucursal']));

    $resultado3 = $conexion -> prepare('SELECT disponibilidadtipospedido FROM detalletipospedido WHERE idtipospedido = 3 AND idsucursal = ?');
    $resultado3 -> execute(array($_SESSION['sucursal']));

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Actualziar Tipos de Pedido</title>
    <link rel="shorcut icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../css/responpanel.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            
        <?php require '../menu/menupanel.php'; ?>

            <div class='formulario-panel'>

                <h1>Actualizar Tipos de Pedido</h1>

                <form action="" class='form-panel' method="post"> 
                <?php foreach($resultado1 as $row) { ?>
                    <?php
                        if($row['disponibilidadtipospedido'] == 1 ){?>
                            <p>Delivery</p>
                            <p><input type="radio" id="" name="delivery" value="1"checked> Habilitar</p>
                            <p><input type="radio" id="" name="delivery" value="0"> Desabilitar</p><?php
                        }else{?>
                            <p>Delivery</p>
                            <p><input type="radio" id="" name="delivery" value="1"> Habilitar</p>
                            <p><input type="radio" id="" name="delivery" value="0"checked> Desabilitar</p><?php
                        }?>
                <?php } ?>
                <?php foreach($resultado2 as $row) { ?>
                    <?php
                        if($row['disponibilidadtipospedido'] == 1 ){?>
                            <p>Recojo</p>
                            <p><input type="radio" id="" name="recojo" value="1"checked> Habilitar</p>
                            <p><input type="radio" id="" name="recojo" value="0"> Desabilitar</p><?php
                        }else{?>
                            <p>Recojo</p>
                            <p><input type="radio" id="" name="recojo" value="1"> Habilitar</p>
                            <p><input type="radio" id="" name="recojo" value="0"checked> Desabilitar</p><?php
                        }?>
                <?php } ?>
                <?php foreach($resultado3 as $row) { ?>
                    <?php
                        if($row['disponibilidadtipospedido'] == 1 ){?>
                            <p>Reserva</p>
                            <p><input type="radio" id="" name="reserva" value="1"checked> Habilitar</p>
                            <p><input type="radio" id="" name="reserva" value="0"> Desabilitar</p><?php
                        }else{?>
                            <p>Reserva</p>
                            <p><input type="radio" id="" name="reserva" value="1"> Habilitar</p>
                            <p><input type="radio" id="" name="reserva" value="0"checked> Desabilitar</p><?php
                        }?>
                <?php } ?> 
                    <input type="submit" value="Actualizar">

                </form>

            </div>

        </div>
    </main>

</body>
</html>