<?php

    session_start();

    require '../conexion.php';

    if (isset($_SESSION['idusuario'])) {

        $queryProfile = $conexion -> prepare("SELECT id_profile FROM detail_usuario_profile WHERE state = 1 AND idusuario = ? AND id_profile = 3");
        $queryProfile -> execute(array($_SESSION['idusuario']));
        $queryProfile = $queryProfile -> fetch(PDO::FETCH_ASSOC);

        if (isset($queryProfile['id_profile'])) 
        {
            $profileAdmin = true;
        } 
        else
        {
            $profileAdmin = false;
        }

        if (!$profileAdmin) {
            header('Location: ../index.php');
        }
        
    } else {
        header('Location: ../index.php');
    }

    if (isset($_POST['emailaddmanager'])) {
        
        $updateProfile = $conexion -> prepare('UPDATE usuario SET id_profile = 2 WHERE emailusuario = ?');
        $updateProfile -> execute(array($_POST['emailaddmanager']));

        $obtenerIdU = $conexion -> prepare('SELECT idusuario FROM usuario WHERE emailusuario = ?');
        $obtenerIdU -> execute(array($_POST['emailaddmanager']));
        $obtenerIdU = $obtenerIdU -> fetchAll(PDO::FETCH_ASSOC);

        $insertAccess = $conexion -> prepare('INSERT INTO access(idusuario, idsucursal) VALUES(?, ?)');
        $insertAccess -> execute(array($obtenerIdU[0]['idusuario'], $_POST['restaurant']));

        $insetadoExito = true;

    }

    $resultadosR = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE estado = 1');
    $resultadosR -> execute();
    $resultadosR = $resultadosR -> fetchAll(PDO::FETCH_ASSOC);

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
    <title>Lista de Encargados</title>
    <link rel="shorcut icon" href="../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.add.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../css/formularios.css">

</head>

<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">
            
            <?php
                require '../menu/menupaneladmin.php';
            ?>

            <div class='container p-0 main-panel m-0 mw-85 w-85'>

                <div class="line-top-panel row h-4r p-0 m-0">
                    
                </div>
                
                <div class="row w-80 m-auto">
                    <h1 class='h3 text-center mt-5 font-weight-bold w-100'>ENCARGADOS</h1>

                    <div class="col-12 form-add-manager">
                        
                        <form class='text-center w-100 mt-4' method='post'>
                            <div class="form-group">
                                <label for="exampleFormControlInput1" class='d-flex'>Ingrese el email del nuevo encargado:</label>
                                <input type="email" name='emailaddmanager' class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1" class='d-flex'>Seleccione de que restaurante sera encargado:</label>
                                <select class="form-control" id="exampleFormControlSelect1" name='restaurant' required>
                                
                                    <?php
                                        foreach($resultadosR as $val) {
                                            ?> <option value='<?php echo $val['idsucursal'] ?>'> <?php echo $val['nomsucursal'] ?> </option> <?php
                                        }
                                    ?>

                                </select>
                            </div>
                            
                            <div class='form-group d-flex'>
                                <button type="button" class="cancel-add-manager btn btn-light ml-auto mt-3 mr-3">Cancelar</button>
                                <button class='btn btn-primary mt-3 px-4 fw-600'>Añadir</button>
                            </div>

                        </form>

                    </div>

                    <div class="btn-color-princi ml-auto">
                        <a class="buttom-add-manager btn btn-primary bottom">Agregar</a>
                    </div>

                    <table class="table mt-4">
                    <thead class='thead-light'>
                        <tr>
                            <th scope="col" class='text-center'>N°</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Restaurante</th>
                            <th class='text-center' scope="col">Más</th>
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
                                <td class='text-center'><a href="eliminar.php?id=<?php echo $val['idusuario'];?>&email=<?php echo $val['emailusuario'];?>"><i class="far fa-trash-alt"></i></a></td>
                            </tr>
                    <?php } ?>

                    </tbody>
                    </table>
                </div>
                

            </div>

        </div>
    </main>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/script.js"></script>

</body>
</html>