<?php

    session_start();

    if (!isset($_SESSION['idsucursal'])) {
        header('Location: index.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Añadir Encargado</title>
    <link rel="shorcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="panel.php">Inicio</a></li>
                    <li><a href="actualizartextobienvenida.php">Añadir Encargado.php</a></li>
                    <li><a href="actualizarimagenbienvenida.php">Añadir Restaurante.php</a></li>
                    <li><a href="actualizardestacados.php">Eliminar Encargado.php</a></li>
                    <li><a href="anadircategoria.php">Eliminar Restaurante.php</a></li>
                    
                </ul>
            </nav>

            <div class='contenido-panel-home'>
                <img src="../img/logo-icono.png">
                
            </div>

        </div>
    </main>

</body>
</html>