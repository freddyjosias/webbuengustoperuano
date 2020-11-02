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

    if (isset($_GET['delete'])) {

        $accessRest = $conexion -> prepare('SELECT * FROM access WHERE idsucursal = ?');
        $accessRest -> execute(array($_GET['delete']));
        $accessRest = $accessRest -> fetchAll(PDO::FETCH_ASSOC);

        if (isset($accessRest[0])) {
            
            $deleteEncargado = $conexion -> prepare('DELETE FROM access WHERE idsucursal = ?');
            $deleteEncargado -> execute(array($_GET['delete']));

            $auxAccess = count($accessRest);

            for ($i = 0; $i < $auxAccess; $i++) {

                $updateProfile = $conexion -> prepare('UPDATE usuario SET id_profile = 1 WHERE idusuario = ?');
                $updateProfile -> execute(array($accessRest[$i]['idusuario']));

            }
                
        }

        $updateProfile = $conexion -> prepare('UPDATE sucursal SET estado = 0 WHERE idsucursal = ?');
        $updateProfile -> execute(array($_GET['delete']));
        
        header('Location: eliminarrestaurante.php');
    }

    $resultadosRes = $conexion -> prepare('SELECT idsucursal, nomsucursal, correosucursal FROM sucursal WHERE estado = 1');
    $resultadosRes -> execute();
    $resultadosRes = $resultadosRes -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Eliminar Encargado</title>
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
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
                
                <h1 class='h3 text-center font-weight-bold'>ELIMINAR RESTAURANTE</h1>

                <table class="table mt-4">
                    <thead class='thead-light'>
                        <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Restaurante</th>
                        <th scope="col">Eliminar</th>
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
                                <td class='text-center'><a href="?delete=<?php echo $val['idsucursal'] ?>" class='text-dark'> <i class="fas fa-trash"></i> </a></td>
                            </tr>
                    <?php } ?>

                    </tbody>
                </table>

            </div>

        </div>
    </main>

</body>
</html>