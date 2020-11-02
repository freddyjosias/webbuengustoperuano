<?php

    require 'conexion.php';

    session_start();

    if (!isset($_SESSION['sucursal'])) {
        header('Location: index.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $resultados = $conexion -> prepare('UPDATE sucursal SET textobienvenida = ? WHERE idsucursal = ?');
        $resultados -> execute(array($_POST['nuevotextobienvenida'], $_SESSION['sucursal']));

    }

    $resultadosText = $conexion -> prepare('SELECT textobienvenida FROM sucursal WHERE idsucursal = ?');
    $resultadosText -> execute(array($_SESSION['sucursal']));
    $resultadosText = $resultadosText -> fetchAll(PDO::FETCH_ASSOC);   
       
?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Actualizar Texto de Bienvenida</title>
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

            <div class='formulario-panel'>

                <h1>Añadir Texto de Bienvenida</h1>

                <form action="" class='form-panel' method="post">

                    <p>Nuevo Texto de Bienvenida: </p>
                    
                    <textarea style= "resize: vertical" name="nuevotextobienvenida" id="" cols="100" rows="10"><?php echo $resultadosText[0]['textobienvenida'] ?></textarea><br><br>
                    
                    <input type="submit" value="Actualizar Texto de Bienvenida">

                </form>

            </div>

        </div>
    </main>

</body>
</html>