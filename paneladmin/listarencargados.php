<?php

    session_start();

    if (!isset($_SESSION['idsucursal'])) {
        header('Location: index.php');
    }

    require '../conexion.php';

    $resultadosEn = $conexion -> prepare('SELECT nombreusuario, nomsucursal, emailusuario FROM access INNER JOIN usuario ON access.idusuario = usuario.idusuario INNER JOIN sucursal ON sucursal.idsucursal = access.idsucursal WHERE id_profile = 2');
    $resultadosEn -> execute();
    $resultadosEn = $resultadosEn -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Añadir Encargado</title>
    <link rel="shorcut icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="listarencargados.php">Listar Encargado</a></li>
                    <li><a href="anadirencargado.php">Añadir Encargado</a></li>
                    <li><a href="actualizarimagenbienvenida.php">Añadir Restaurante</a></li>
                    <li><a href="actualizardestacados.php">Eliminar Encargado</a></li>
                    <li><a href="anadircategoria.php">Eliminar Restaurante</a></li>
                    
                </ul>
            </nav>

            <div class='container p-5'>
                
                <h1 class='h3 text-center font-weight-bold'>LISTAR ENCARGADO</h1>

                <table class="table mt-5">
                    <thead class='thead-light'>
                        <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Restaurante</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $cont = 0;
                        foreach($resultadosEn as $val) { 
                        if ($val['nombreusuario'] == '') {
                            $val['nombreusuario'] = 'N/A';
                        }
                        $cont++;
                    ?>
                            <tr>
                                <th scope="row"><?php echo $cont ?></th>
                                <td><?php echo $val['nombreusuario'] ?></td>
                                <td><?php echo $val['emailusuario'] ?></td>
                                <td><?php echo $val['nomsucursal'] ?></td>
                            </tr>
                    <?php } ?>

                    </tbody>
                </table>

            </div>

        </div>
    </main>

</body>
</html>