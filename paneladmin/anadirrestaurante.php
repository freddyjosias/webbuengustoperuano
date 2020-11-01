<?php

    session_start();

    // if (!isset($_SESSION['idsucursal'])) {
    //     header('Location: index.php');
    // }

    require '../conexion.php';

    if (isset($_POST['create'])) {
        $nombre = 'Restaurante ' . 
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Añadir Restaurante</title>
    <link rel="shorcut icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="panel.php">Regresar</a></li>
                    <li><a href="listarencargados.php">Listar Encargados</a></li>
                    <li><a href="anadirencargado.php">Añadir Encargado</a></li>
                    <li><a href="eliminarencargado.php">Eliminar Encargado</a></li>
                    <li><a href="listarrestaurantes.php">Listar Restaurantes</a></li>
                    <li><a href="anadirrestaurante.php">Añadir Restaurante</a></li>
                    <li><a href="eliminarrestaurante.php">Eliminar Restaurante</a></li>
                    
                </ul>
            </nav>

            <div class='container p-5'>
                
                <h1 class='h3 text-center font-weight-bold'>AÑADIR RESTAURANTE</h1>

                <form action="" method="post" class='text-center mt-5'>
                    <button class='btn btn-primary' name='create' value='true'>Añadir nuevo restaurante</button>
                </form>

            </div>

        </div>
    </main>

</body>
</html>