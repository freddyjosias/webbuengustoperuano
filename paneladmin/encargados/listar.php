<?php

    session_start();

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 3) {
            header('Location: ../../index.php');
        }
    } else {
        header('Location: ../../index.php');
    }

    require '../../conexion.php';

    $resultadosEn = $conexion -> prepare('SELECT a.idusuario, u.nombreusuario, s.nomsucursal, u.emailusuario FROM access as a INNER JOIN usuario as u ON a.idusuario = u.idusuario INNER JOIN sucursal as s ON s.idsucursal = a.idsucursal WHERE id_profile = 2');
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
    <link rel="shorcut icon" href="../../img/logo-icono.png">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.add.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">

</head>

<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">
            
            <?php

                require '../../menu/menupaneladmin.php';

            ?>

            <div class='container p-5 main-panel m-0 mw-85 w-85'>
                
                <div class="row w-90 m-auto">
                    <h1 class='h3 text-center font-weight-bold w-100'>ENCARGADOS</h1>
                    <div class="btn-color-princi ml-auto">
                        <a class="btn btn-primary bottom" href="agregar.php">Agregar</a>
                    </div>

                    <table class="table mt-4">
                    <thead class='thead-light'>
                        <tr>
                            <th scope="col" class='text-center'>N°</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Restaurante</th>
                            <th  class='text-center' scope="col">Más</th>
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
                                <th scope="row" class='text-center'><?php echo $cont ?></th>
                                <td><?php echo $val['nombreusuario'] ?></td>
                                <td><?php echo $val['emailusuario'] ?></td>
                                <td><?php echo $val['nomsucursal'] ?></td>
                                <!-- <td><a class="btn btn-danger" href="eliminar.php?id=<?php echo $val['idusuario'];?>&email=<?php echo $val['emailusuario'];?>">Eliminar</a></td> -->
                                <td  class='text-center'><i class="far fa-trash-alt"></i></td>
                            </tr>
                    <?php } ?>

                    </tbody>
                    </table>
                </div>
                

            </div>

        </div>
    </main>

</body>
</html>