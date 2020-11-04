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

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $resultados = $conexion -> prepare('UPDATE sucursal SET nomsucursal = ?, telefono = ?, correosucursal = ?, direcsucursal = ?, horaatencioninicio = ?, horaatencioncierre = ? WHERE idsucursal = ?');
        $resultados -> execute(array($_POST['res-actualizada'], $_POST['tele-actualizada'], $_POST['email-actualizada'], $_POST['dire-actualizada'], $_POST['horai-actualizada'], $_POST['horac-actualizada'], $_SESSION['sucursal']));

    }

    $consulta = $conexion -> prepare('SELECT * FROM sucursal WHERE idsucursal = ?');
    $consulta -> execute(array($_SESSION['sucursal']));
    $consulta = $consulta -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Panel</title>
    <link rel="shorcut icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="panel.php">Inicio</a></li>
                    <li><a href="restaurante.php">Restaurante</a></li>
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

                <h1>Información Restaurante</h1>

                <form action="" class='form-panel' method = "post">

                    <p> Nombre Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['nomsucursal'] ?>
                            <?php } ?>
                    </p>
                    <p>Nuevo nombre: <input value="<?php echo $row['nomsucursal'] ?>" type="text" name = 'res-actualizada'></p>

                    <p> Telefono Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['telefono'] ?>
                            <?php } ?>
                    </p>
                    <p>Nuevo Telefono: <input value="<?php echo $row['telefono'] ?>" type="text" name = 'tele-actualizada'></p>

                    <p> Correo Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['correosucursal'] ?>
                            <?php } ?>
                    </p>
                    <p>Nuevo Correo: <input value="<?php echo $row['correosucursal'] ?>" type="text" name = 'email-actualizada'></p>

                    <p> Dirección Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['direcsucursal'] ?>
                            <?php } ?>
                    </p>
                    <p>Nueva Dirección: <input value="<?php echo $row['direcsucursal'] ?>" type="text" name = 'dire-actualizada'></p>

                    <p> Hora inicio atención del Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['horaatencioninicio'] ?>
                            <?php } ?>
                    </p>
                    <p>Nueva Hora: <input value="<?php echo $row['horaatencioninicio'] ?>" type="time" name = 'horai-actualizada'></p>

                    <p> Hora cierre atención del Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['horaatencioncierre'] ?>
                            <?php } ?>
                    </p>
                    <p>Nueva Hora: <input value="<?php echo $row['horaatencioncierre'] ?>" type="time" name = 'horac-actualizada'></p>
                    
                    <input type="submit" value="Actualizar">

                </form>

            </div>

        </div>
    </main>

</body>
</html>
