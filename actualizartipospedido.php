<?php

    require 'conexion.php';

    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        if (isset($_POST['delivery'])) {
            $resultados1 = $conexion -> prepare('UPDATE detalletipospedido SET disponibilidadtipospedido = ? WHERE idtipospedido = 1 AND idsucursal = ?');
            $resultados1 -> execute(array($_POST['delivery'],$_SESSION['idsucursal']));
        }

        if (isset($_POST['recojo'])) {
            $resultados2 = $conexion -> prepare('UPDATE detalletipospedido SET disponibilidadtipospedido = ? WHERE idtipospedido = 2 AND idsucursal = ?');
            $resultados2 -> execute(array($_POST['recojo'],$_SESSION['idsucursal']));
        }

        if (isset($_POST['reserva'])) {
            $resultados3 = $conexion -> prepare('UPDATE detalletipospedido SET disponibilidadtipospedido = ? WHERE idtipospedido = 3 AND idsucursal = ?');
            $resultados3 -> execute(array($_POST['reserva'],$_SESSION['idsucursal']));
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Quienes Somos - Restaurante 1</title>
    <link rel="shorcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/responpanel.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="panel.php">Inicio</a></li>
                    <li><a href="anadircategoria.php">Añadir Categoria</a></li>
                    <li><a href="eliminarcategoria.php">Eliminar Categoria</a></li>
                    <li><a href="actualizarcategoria.php">Actualizar Categoria</a></li>
                    <li><a href="anadirproducto.php">Añadir Producto</a></li>
                    <li><a href="eliminarproducto.php">Eliminar Producto</a></li>
                    <li><a href="actualizarproducto.php">Actualizar Praducto</a></li>
                    <li><a href="actualizarformaspago.php">Actualizar Formas de Pago</a></li>
                    <li><a href="actualizartipospedido.php">Actualizar Tipos de pedido</a></li>
                </ul>
            </nav>

            <div class='formulario-panel'>

                <h1>Actualizar Tipos de Pedido</h1>

                <form action="" class='form-panel' method="post"> 
    
                    <p>Delivery</p>
                    <p><input type="radio" id="" name="delivery" value="1"> Habilitar</p>
                    <p><input type="radio" id="" name="delivery" value="0"> Desabilitar</p>

                    <p>Recojo</p>
                    <p><input type="radio" id="" name="recojo" value="1"> Habilitar</p>
                    <p><input type="radio" id="" name="recojo" value="0"> Desabilitar</p>
                    
                    <p>Reserva</p>
                    <p><input type="radio" id="" name="reserva" value="1"> Habilitar</p>
                    <p><input type="radio" id="" name="reserva" value="0"> Desabilitar</p>

                    <input type="submit" value="Actualizar">

                </form>

            </div>

        </div>
    </main>

</body>
</html>