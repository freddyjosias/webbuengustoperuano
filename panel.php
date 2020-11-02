<?php

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

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Panel</title>
    <link rel="shorcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="panel.php">Inicio</a></li>
                    <li><a href="actualizarbanner.php">Actualizar Banner</a></li>
                    <li><a href="actualizartextobienvenida.php">Actualizar Texto de Bienvenida</a></li>
                    <li><a href="actualizarimagenbienvenida.php">Actualizar Imagen de Bienvenida</a></li>
                    <li><a href="actualizardestacados.php">Actualizar Platos Destacados</a></li>
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

            <div class='contenido-panel-home'>
                <img src="img/logo-icono.png">
                <p>Bienvenido a su Panel de Control</p>
                <a href="bienvenida.php?view=<?php echo $_SESSION['sucursal'] ?>">Ver mi Restaurante</a>
            </div>

        </div>
    </main>

</body>
</html>