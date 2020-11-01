<?php

    session_start();

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 3) {
            header('Location: ../index.php');
        }
    } else {
        header('Location: ../index.php');
    }

    require '../conexion.php';

    $resultadosRes = $conexion -> prepare('SELECT nomsucursal, correosucursal, telefono FROM sucursal');
    $resultadosRes -> execute();
    $resultadosRes = $resultadosRes -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Listar Restaurantes</title>
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
                    <li><a href="../">Regresar</a></li>
                    <li><a href="listarencargados.php">Listar Encargados</a></li>
                    <li><a href="anadirencargado.php">Añadir Encargado</a></li>
                    <li><a href="eliminarencargado.php">Eliminar Encargado</a></li>
                    <li><a href="listarrestaurantes.php">Listar Restaurantes</a></li>
                    <li><a href="anadirrestaurante.php">Añadir Restaurante</a></li>
                    <li><a href="eliminarrestaurante.php">Eliminar Restaurante</a></li>
                </ul>
            </nav>

            <div class='container p-5'>
                
                <h1 class='h3 text-center font-weight-bold'>LISTAR RESTAURANTES</h1>

                <table class="table mt-4">
                    <thead class='thead-light'>
                        <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Teléfono</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $cont = 0;
                        foreach($resultadosRes as $val) { 
                        $cont++;
                    ?>
                            <tr>
                                <th scope="row"><?php echo $cont ?></th>
                                <td><?php echo $val['nomsucursal'] ?></td>
                                <td><?php echo $val['correosucursal'] ?></td>
                                <td><?php echo $val['telefono'] ?></td>
                            </tr>
                    <?php } ?>

                    </tbody>
                </table>

            </div>

        </div>
    </main>

</body>
</html>