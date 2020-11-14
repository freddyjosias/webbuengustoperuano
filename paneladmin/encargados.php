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

    $errorAlert = 0;

    if (isset($_POST['emailaddmanager'])) {

        $existUser = $conexion -> prepare('SELECT idusuario, nombreusuario, apellidousuario FROM usuario WHERE emailusuario = ? AND estado = 1');
        $existUser -> execute(array($_POST['emailaddmanager']));
        $existUser = $existUser -> fetch(PDO::FETCH_ASSOC);

        if ($existUser) 
        {
            $existManager = $conexion -> prepare('SELECT state FROM detail_usuario_profile WHERE idusuario = ? AND id_profile = 2');
            $existManager -> execute(array($existUser['idusuario']));
            $existManager = $existManager -> fetch(PDO::FETCH_ASSOC);

            $existRestaurant = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE idsucursal = ? AND estado = 1');
            $existRestaurant -> execute(array($_POST['restaurant']));
            $existRestaurant = $existRestaurant -> fetch(PDO::FETCH_ASSOC);

            if ($existRestaurant) 
            {
                $existAccess = $conexion -> prepare('SELECT state FROM access WHERE idusuario = ? AND idsucursal = ?');
                $existAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));
                $existAccess = $existAccess -> fetch(PDO::FETCH_ASSOC);
        
                if ($existManager) 
                {
                    if ($existAccess && $existManager['state'] == 1) 
                    {
                        if ($existAccess['state'] == 1) 
                        {
                            $errorAlert = 3;
                        } 
                        else 
                        {
                            $updateStateAccess = $conexion -> prepare('UPDATE access SET state = 1 WHERE idusuario = ? AND idsucursal = ?');
                            $updateStateAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));
                        }
                    }
                    else 
                    {
                        $updateStateManager = $conexion -> prepare('UPDATE detail_usuario_profile SET state = 1 WHERE idusuario = ? AND id_profile = 2');
                        $updateStateManager -> execute(array($existUser['idusuario']));

                        $updateStateAccess = $conexion -> prepare('UPDATE access SET state = 1 WHERE idusuario = ? AND idsucursal = ?');
                        $updateStateAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));
                    }

                    if (!$existAccess) {
                        
                        $crateAccess = $conexion -> prepare('INSERT INTO access(idusuario, idsucursal) VALUES (?, ?)');
                        $crateAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));

                    }

                    if ($errorAlert == 0) 
                    {
                        $errorAlert = 10;
                    }
                    
                } 
                else 
                {
                    $crateManager = $conexion -> prepare('INSERT INTO detail_usuario_profile(idusuario, id_profile) VALUES (?, 2)');
                    $crateManager -> execute(array($existUser['idusuario']));

                    $crateAccess = $conexion -> prepare('INSERT INTO access(idusuario, idsucursal) VALUES (?, ?)');
                    $crateAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));

                    $errorAlert = 10;
                }

            }
            else
            {
                $errorAlert = 2;
            }
            
        }
        else 
        {
            $errorAlert = 1;
        }

    }
    
    if (isset($_POST['iddeletemanager'])) 
    {
        $existDeleteAccess = $conexion -> prepare('SELECT access_id FROM access WHERE idusuario = ? AND idsucursal = ?');
        $existDeleteAccess -> execute(array($_POST['iddeletemanager'], $_POST['idsucursal']));
        $existDeleteAccess = $existDeleteAccess -> fetch(PDO::FETCH_ASSOC);
        
        if ($existDeleteAccess)
        {
            $updateStateAccess = $conexion -> prepare('UPDATE access SET state = 0 WHERE idusuario = ? AND idsucursal = ?');
            $updateStateAccess -> execute(array($_POST['iddeletemanager'], $_POST['idsucursal']));

            $countAccess = $conexion -> prepare('SELECT count(access_id) as count FROM access WHERE idusuario = ? AND state = 1');
            $countAccess -> execute(array($_POST['iddeletemanager']));
            $countAccess = $countAccess -> fetch(PDO::FETCH_ASSOC);

            if ($countAccess['count'] == 0)
            {
                $updateStateManager = $conexion -> prepare('UPDATE detail_usuario_profile SET state = 0 WHERE idusuario = ? AND id_profile = 2');
                $updateStateManager -> execute(array($_POST['iddeletemanager']));
            }

            $nameManager = $conexion -> prepare('SELECT nombreusuario, apellidousuario FROM usuario WHERE idusuario = ? AND estado = 1');
            $nameManager -> execute(array($_POST['iddeletemanager']));
            $nameManager = $nameManager -> fetch(PDO::FETCH_ASSOC);

            if (!$nameManager) 
            {
                $nameManager['nombreusuario'] = '';
                $nameManager['apellidousuario'] = '';
            }

            $nameRest = $conexion -> prepare('SELECT nomsucursal FROM sucursal WHERE idsucursal = ? AND estado = 1');
            $nameRest -> execute(array($_POST['idsucursal']));
            $nameRest = $nameRest -> fetch(PDO::FETCH_ASSOC);

            if (!$nameRest) 
            {
                $nameRest['nomsucursal'] = '';
            }

            $errorAlert = 11;

        }
        else
        {
            $errorAlert = 4;
        }
        
    }

    $resultadosR = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE estado = 1');
    $resultadosR -> execute();
    $resultadosR = $resultadosR -> fetchAll(PDO::FETCH_ASSOC);

    $resultadosEn = $conexion -> prepare('SELECT a.idusuario, u.nombreusuario, u.apellidousuario, s.nomsucursal, u.emailusuario, s.idsucursal FROM access as a INNER JOIN usuario as u ON a.idusuario = u.idusuario INNER JOIN detail_usuario_profile as m ON a.idusuario = m.idusuario INNER JOIN sucursal as s ON s.idsucursal = a.idsucursal WHERE a.state = 1 AND s.estado = 1 AND m.state = 1 AND m.id_profile = 2 AND u.estado = 1 ORDER BY s.nomsucursal, u.nombreusuario');
    $resultadosEn -> execute();
    $resultadosEn = $resultadosEn -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Encargados</title>
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

                <div class="line-top-panel row h-4r m-0 p-0 align-items-center">
                    <div class='text-white fw-700 fs-30 col-12'>ADMINISTRADOR</div> 
                </div>
                
                <div class="row w-80 m-auto">
                    <h1 class='h3 text-center mt-5 mb-3 font-weight-bold w-100 this-is-manager'>ENCARGADOS</h1>

                    <div class="col-12 form-add-manager">
                        
                        <form class='text-center w-100 mt-0' method='post'>
                            <div class="form-group">
                                <label for="exampleFormControlInput1" class='d-flex'>Ingrese el email del nuevo encargado:</label>
                                <input type="email" name='emailaddmanager' class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" value='<?php echo ($errorAlert == 1) ? $_POST['emailaddmanager'] : '' ?>' required>
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
                        <a class="buttom-add-manager btn btn-primary bottom fw-600">Agregar Encargado</a>
                    </div>

                    <table class="table mt-4">
                    <thead class='thead-light fs-18'>
                        <tr>
                            <th scope="col" class='text-center'>N°</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">CORREO</th>
                            <th scope="col">RESTAURANTE</th>
                            <th class='text-center' scope="col">MÁS</th>
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
                            <tr class='fs-17 fw-500'>

                                <th scope="row" class='text-center py-3'><?php echo $cont ?></th>
                                <td class='py-3'><?php echo $val['nombreusuario'] . ' '. $val['apellidousuario'] ?></td>
                                <td class='py-3'><?php echo $val['emailusuario'] ?></td>
                                <td class='py-3'><?php echo $val['nomsucursal'] ?></td>

                                <td class='text-center px-0 py-2'>

                                    <form action="" method="post" class='m-0 p-0'>

                                        <input type="text" name='iddeletemanager' value='<?php echo $val['idusuario'] ?>' class='d-none'>

                                        <input type="text" name='idsucursal' value='<?php echo $val['idsucursal'] ?>' class='d-none'>

                                        <button class='btn btn-danger'>
                                            <i class="far fa-trash-alt "></i> &nbsp; Eliminar
                                        </button>

                                    </form>
                                    
                                </td>

                            </tr>
                    <?php } ?>

                    </tbody>
                    </table>
                </div>
                

            </div>

        </div>
    </main>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/bootstrap.add.js"></script>
    <script src="../sweetalert/sweetalert210.js"></script>
    <script src="../js/script.js"></script>

    <?php
        if ($errorAlert == 1) 
        {
            ?>

            <script>

                $('.form-add-manager').show();
                $('.buttom-add-manager').hide();

                Swal.fire
                ({
                    icon: 'error',
                    title: 'El correo que ingresó no esta relacionado con ningún usuario'
                })

            </script>
                
            <?php
        } 
        else if ($errorAlert == 2) 
        {
            ?>

            <script>

                $('.form-add-manager').show();
                $('.buttom-add-manager').hide();

                Swal.fire
                ({
                    icon: 'error',
                    title: 'El restaurante seleccionado no existe'
                })

            </script>
                
            <?php
        } 
        else if ($errorAlert == 3) 
        {
            ?>

            <script>

                $('.form-add-manager').show();
                $('.buttom-add-manager').hide();

                Swal.fire
                ({
                    icon: 'error',
                    title: 'El usuario ingresadó ya es encargado del restaurante seleccionado'
                })

            </script>
                
            <?php
        } 
        else if ($errorAlert == 4) 
        {
            ?>

            <script>

                Swal.fire
                ({
                    icon: 'error',
                    title: 'Al parecer este perfil ya ha sido removido'
                })

            </script>
                
            <?php
        } 
        else if ($errorAlert == 10) 
        {
            ?>

            <script>

                Swal.fire
                ({
                    icon: 'success',
                    title: 'Se agregó correctamente a <?php echo $existUser['nombreusuario'] . ' ' .  $existUser['apellidousuario'] ?> ',
                    html: 'como encargado del restaurante <?php echo $existRestaurant['nomsucursal'] ?> ' 
                })

            </script>
                
            <?php
        }
        else if ($errorAlert == 11) 
        {
            ?>

            <script>

                Swal.fire
                ({
                    icon: 'success',
                    title: 'Se eliminó correctamente a <?php echo $nameManager['nombreusuario'] . ' ' .  $nameManager['apellidousuario'] ?> ',
                    html: 'como encargado del restaurante <?php echo $nameRest['nomsucursal'] ?> '
                })

            </script>
                
            <?php
        }
    ?>

</body>
</html>