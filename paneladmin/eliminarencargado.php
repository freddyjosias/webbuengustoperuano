<?php

    session_start();

    require '../conexion.php';

    if (isset($_GET['delete'])) {

        $resultadosUser = $conexion -> prepare('SELECT idusuario FROM usuario WHERE emailusuario = ?');
        $resultadosUser -> execute(array($_GET['delete']));
        $resultadosUser = $resultadosUser -> fetchAll(PDO::FETCH_ASSOC);

        $deleteEncargado = $conexion -> prepare('DELETE FROM access WHERE idusuario = ?');
        $deleteEncargado -> execute(array($resultadosUser[0]['idusuario']));

        $updateProfile = $conexion -> prepare('UPDATE usuario SET id_profile = 1 WHERE idusuario = ?');
        $updateProfile -> execute(array($resultadosUser[0]['idusuario']));

        header('Location: eliminarencargado.php');
    }

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
                
                <h1 class='h3 text-center font-weight-bold'>ELIMINAR ENCARGADO</h1>

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
                        foreach($resultadosEn as $val) { 
                        $cont++;
                    ?>
                            <tr>
                                <th scope="row"><?php echo $cont ?></th>
                                <td><?php echo $val['emailusuario'] ?></td>
                                <td><?php echo $val['nomsucursal'] ?></td>
                                <td class='text-center'><a href="?delete=<?php echo $val['emailusuario'] ?>" class='text-dark'> <i class="fas fa-trash"></i> </a></td>
                            </tr>
                    <?php } ?>

                    </tbody>
                </table>

            </div>

        </div>
    </main>

</body>
</html>