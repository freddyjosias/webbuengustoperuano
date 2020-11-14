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

    if (isset($_POST['mailaddadmin'])) {

        $existUser = $conexion -> prepare('SELECT idusuario, nombreusuario, apellidousuario FROM usuario WHERE emailusuario = ? AND estado = 1');
        $existUser -> execute(array($_POST['mailaddadmin']));
        $existUser = $existUser -> fetch(PDO::FETCH_ASSOC);

        if ($existUser) 
        {
            $existAdmin = $conexion -> prepare('SELECT state FROM detail_usuario_profile WHERE idusuario = ? AND id_profile = 3');
            $existAdmin -> execute(array($existUser['idusuario']));
            $existAdmin = $existAdmin -> fetch(PDO::FETCH_ASSOC);

            if ($existAdmin) 
            {
                if ($existAdmin['state'] == 1) {
                    $errorAlert = 3;
                } else
                {
                    $updateStateManager = $conexion -> prepare('UPDATE detail_usuario_profile SET state = 1 WHERE idusuario = ? AND id_profile = 3');
                    $updateStateManager -> execute(array($existUser['idusuario']));
                    
                    $errorAlert = 10;
                }
            } 
            else 
            {
                $crateManager = $conexion -> prepare('INSERT INTO detail_usuario_profile(idusuario, id_profile) VALUES (?, 3)');
                $crateManager -> execute(array($existUser['idusuario']));

                $errorAlert = 10;
            }

        }
        else 
        {
            $errorAlert = 1;
        }

    }
    
    if (isset($_POST['iddeleteadmin'])) 
    {
        $existDeleteManager = $conexion -> prepare('SELECT state FROM detail_usuario_profile WHERE idusuario = ? AND id_profile = 3');
        $existDeleteManager -> execute(array($_POST['iddeleteadmin']));
        $existDeleteManager = $existDeleteManager -> fetch(PDO::FETCH_ASSOC);
        
        if ($existDeleteManager)
        {
            $updateStateManager = $conexion -> prepare('UPDATE detail_usuario_profile SET state = 0 WHERE idusuario = ? AND id_profile = 3');
            $updateStateManager -> execute(array($_POST['iddeleteadmin']));

            $nameManager = $conexion -> prepare('SELECT nombreusuario, apellidousuario FROM usuario WHERE idusuario = ? AND estado = 1');
            $nameManager -> execute(array($_POST['iddeleteadmin']));
            $nameManager = $nameManager -> fetch(PDO::FETCH_ASSOC);

            if (!$nameManager) 
            {
                $nameManager['nombreusuario'] = '';
                $nameManager['apellidousuario'] = '';
            }

            $errorAlert = 11;

        }
        else
        {
            $errorAlert = 4;
        }
        
    }

    $resultadosEn = $conexion -> prepare('SELECT usuario.idusuario, nombreusuario, apellidousuario, emailusuario, dniusuario, telefonousuario FROM detail_usuario_profile INNER JOIN usuario ON usuario.idusuario = detail_usuario_profile.idusuario WHERE id_profile = 3 AND state = 1');
    $resultadosEn -> execute();
    $resultadosEn = $resultadosEn -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Lista de Administradores</title>
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
                    <h1 class='h3 text-center mt-5 mb-3 font-weight-bold w-100'>ADMINISTRADORES</h1>

                    <form class='text-center w-100 mt-0 form-add-admin' method='post'>

                        <div class="form-group">
                            <label for="exampleFormControlInput1" class='d-flex'>Ingrese el email del nuevo administrador:</label>
                            <input type="email" name='mailaddadmin' class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" value='<?php echo ($errorAlert == 1) ? $_POST['mailaddadmin'] : '' ?>' required>
                        </div>   

                        <div class='form-group d-flex'>
                            <button type="button" class="cancel-add-admin btn btn-light ml-auto mt-3 mr-3">Cancelar</button>
                            <button class='btn btn-primary mt-3 fw-500'>Añadir</button>
                        </div>

                    </form>

                    <div class="btn-color-princi ml-auto">
                        <a class="btn btn-primary bottom fw-600 button-add-admin">Agregar Administrador</a>
                    </div>

                    <table class="table mt-4">
                    <thead class='thead-light fs-18'>
                        <tr>
                            <th scope="col" class='text-center'>N°</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Celular</th>
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
                            if ($val['dniusuario'] == '') {
                                $val['dniusuario'] = 'N/A';
                            }
                            if ($val['telefonousuario'] == '') {
                                $val['telefonousuario'] = 'N/A';
                            }
                            $cont++;
                    ?>
                            <tr class='fs-17 fw-500'>
                                <th scope="row" class='text-center py-3'><?php echo $cont ?></th>
                                <td class='py-3'><?php echo $val['nombreusuario'] . ' ' . $val['apellidousuario'] ?></td>
                                <td class='py-3'><?php echo $val['emailusuario'] ?></td>
                                <td class='py-3'><?php echo $val['dniusuario'] ?></td>
                                <td class='py-3'><?php echo $val['telefonousuario'] ?></td>

                                <td class='text-center px-0 py-2'>

                                    <form action="" method="post" class='m-0 p-0'>

                                        <input type="text" name='iddeleteadmin' value='<?php echo $val['idusuario'] ?>' class='d-none'>

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

                $('.form-add-admin').show();
                $('.button-add-admin').hide();

                Swal.fire
                ({
                    icon: 'error',
                    title: 'El correo que ingresó no esta relacionado con ningún usuario'
                })

            </script>
                
            <?php
        } 
        else if ($errorAlert == 3) 
        {
            ?>

            <script>

                $('.form-add-admin').show();
                $('.button-add-admin').hide();

                Swal.fire
                ({
                    icon: 'error',
                    title: 'El usuario ingresadó ya es administrador'
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
                    title: 'Se agregó correctamente a <?php echo $existUser['nombreusuario'] . ' ' .  $existUser['apellidousuario'] ?> como administrador'
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
                    title: 'Se eliminó correctamente a <?php echo $nameManager['nombreusuario'] . ' ' .  $nameManager['apellidousuario'] ?> como administrador',
                })

            </script>
                
            <?php
        }
    ?>
    
</body>
</html>