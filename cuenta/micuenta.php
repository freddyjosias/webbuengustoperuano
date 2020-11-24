<?php

    require '../conexion.php';

    session_start();

    if (!isset($_SESSION['idusuario'])) 
    {
        header('Location: index.php');
    }

    $errorAlert = 0;

    if($_SERVER["REQUEST_METHOD"] == "POST") {


        if (isset($_POST['nombre'])) {
            $resultados2 = $conexion -> prepare('UPDATE usuario SET nombreusuario = ? WHERE idusuario = ?');
            $resultados2 -> execute(array($_POST['nombre'], $_SESSION['idusuario']));
        }

        if (isset($_POST['apellido'])) {
            $resultados3 = $conexion -> prepare('UPDATE usuario SET apellidousuario = ? WHERE idusuario = ?');
            $resultados3 -> execute(array($_POST['apellido'], $_SESSION['idusuario']));
        }

        if (isset($_POST['clave'])) {
            $resultados4 = $conexion -> prepare('UPDATE usuario SET LENGTH(AES_DECRYPT(contrasena, "BuenGustoPeruano")) = ? WHERE idusuario = ?');
            $resultados4 -> execute(array($_POST['clave'], $_SESSION['idusuario']));
        }

        if (isset($_POST['telefono'])) {
            $resultados5 = $conexion -> prepare('UPDATE usuario SET telefonousuario = ? WHERE idusuario = ?');
            $resultados5 -> execute(array($_POST['telefono'], $_SESSION['idusuario']));
        }

        if (isset($_POST['direccion'])) {
            $resultados6 = $conexion -> prepare('UPDATE usuario SET direccionusuario = ? WHERE idusuario = ?');
            $resultados6 -> execute(array($_POST['direccion'], $_SESSION['idusuario']));
        }

        if (isset($_POST['dni'])) {
            $resultados7 = $conexion -> prepare('UPDATE usuario SET dniusuario = ? WHERE idusuario = ?');
            $resultados7 -> execute(array($_POST['dni'], $_SESSION['idusuario']));
        }

        if (isset($_POST['referencia'])) {
            $resultados7 = $conexion -> prepare('UPDATE usuario SET referenciausuario = ? WHERE idusuario = ?');
            $resultados7 -> execute(array($_POST['referencia'], $_SESSION['idusuario']));
        }

    }

    $consultaUsuario = $conexion -> prepare('SELECT emailusuario, nombreusuario, apellidousuario, dniusuario, photo, direccionusuario, referenciausuario, telefonousuario, LENGTH(AES_DECRYPT(contrasena, "BuenGustoPeruano")) as password FROM usuario WHERE idusuario = ?');
    $consultaUsuario -> execute(array($_SESSION['idusuario']));
    $consultaUsuario = $consultaUsuario -> fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Mi Cuenta</title>
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
                require '../menu/menuusuario.php';
            ?>

            <div class='container p-0 main-panel ml-auto mr-0 my-0 mw-f19-85 mw-f18-84 mw-f17-83 mw-f16-82 mw-f15-81 mw-f14-80 mw-100 z-index-auto'>

                <div class="line-top-panel row h-4r m-0 py-0 px-4 justify-content-between align-items-center">
                    <div class='container-button-menu text-white fw-700 fs-30  no-select'> 
                        <i class="fas fa-bars button-show-menu-panel d-f14-none d-inline" role="button"> &nbsp;</i>  
                        MI CUENTA
                    </div>
                </div>

                <div class="row w-f14-80 w-90 m-auto">

                    <h1 class='h3 text-center mt-5 mb-3 font-weight-bold w-100 this-is-my-dates'>MIS DATOS PERSONALES</h1>

                    
                    <table class="table table-my-account d-flex w-75 m-auto">
                        <thead class="thead-light d-block w-50">
                            <tr class='d-block'>
                                <th scope="col" class='d-block table-my-account-border table-my-account-border-top px-4 ls-13'>CORREO ELECTRÓNICO</th>
                                <th scope="col" class='d-block table-my-account-border px-4 ls-13'>NOMBRES</th>
                                <th scope="col" class='d-block table-my-account-border px-4 ls-13'>APELLIDOS</th>
                                <th scope="col" class='d-block table-my-account-border px-4 ls-13'>DNI</th>
                                <th scope="col" class='d-block table-my-account-border px-4 ls-13'>DIRECCIÓN</th>
                                <th scope="col" class='d-block table-my-account-border px-4 ls-13'>REFERENCIA</th>
                                <th scope="col" class='d-block table-my-account-border px-4 ls-13'>TELÉFONO</th>
                            </tr>
                        </thead>
                        <tbody class=' w-50'>
                            <tr class='d-block'>
                                <td scope="row" class='d-block table-my-account-border table-my-account-border-top table-my-account-border-right px-4 ls-13'><?php  if ($consultaUsuario['emailusuario'] == '') { $consultaUsuario['emailusuario'] = 'N/A'; } ?><?php echo $consultaUsuario['emailusuario'] ?></td>
                                <td scope="row" class='d-block table-my-account-border table-my-account-border-right px-4 ls-13'><?php  if ($consultaUsuario['nombreusuario'] == '') { $consultaUsuario['nombreusuario'] = 'N/A'; } ?><?php echo $consultaUsuario['nombreusuario'] ?></td>
                                <td scope="row" class='d-block table-my-account-border table-my-account-border-right px-4 ls-13'><?php  if ($consultaUsuario['apellidousuario'] == '') { $consultaUsuario['apellidousuario'] = 'N/A'; } ?><?php echo $consultaUsuario['apellidousuario'] ?></td>
                                <td scope="row" class='d-block table-my-account-border table-my-account-border-right px-4 ls-13'><?php  if ($consultaUsuario['dniusuario'] == '') { $consultaUsuario['dniusuario'] = 'N/A'; } ?><?php echo $consultaUsuario['dniusuario'] ?></td>
                                <td scope="row" class='d-block table-my-account-border table-my-account-border-right px-4 ls-13'><?php  if ($consultaUsuario['direccionusuario'] == '') { $consultaUsuario['direccionusuario'] = 'N/A'; } ?><?php echo $consultaUsuario['direccionusuario'] ?></td>
                                <td scope="row" class='d-block table-my-account-border table-my-account-border-right px-4 ls-13'><?php  if ($consultaUsuario['referenciausuario'] == '') { $consultaUsuario['referenciausuario'] = 'N/A'; } ?><?php echo $consultaUsuario['referenciausuario'] ?></td>
                                <td scope="row" class='d-block table-my-account-border table-my-account-border-right px-4 ls-13'><?php  if ($consultaUsuario['telefonousuario'] == '') { $consultaUsuario['telefonousuario'] = 'N/A'; } ?><?php echo $consultaUsuario['telefonousuario'] ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <form class='w-100 fs-18 mt-5' method="post">

                        <div class="row">

                            <div class="col-10">

                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Correo electrónico:</label>

                                        <fieldset disabled class='m-0 p-0'>
                                            <input type="email" id="disabledTextInput" class="form-control" value="<?php echo $consultaUsuario['emailusuario'] ?>">
                                        </fieldset>

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Contraseña:</label>
                                        <input type="password" class="form-control" id="inputPassword4" value="<?php echo $consultaUsuario['contrasena'] ?>" name="clave" required>
                                    </div>

                                </div>

                                <div class="form-row mt-2">

                                    <div class="form-group col-md-6">
                                        <label for="inputPassword6">Nombres:</label>
                                        <input type="text" class="form-control" id="inputPassword6" value="<?php echo $consultaUsuario['nombreusuario'] ?>" name="nombre">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inputPassword7">Apellido:</label>
                                        <input type="text" class="form-control" id="inputPassword7" value="<?php echo $consultaUsuario['apellidousuario'] ?>" name="apellido">
                                    </div>

                                </div>

                            </div>

                            <div class="col-2 row">
                                <div class='border-grey border-5 mt-2r mb-2 ml-4 p-2 w-auto h-auto d-flex' >
                                    <img src="<?php echo $_SESSION['photo'] ?>" class='w-auto  h-auto border-grey border-3 p-1' alt="">
                                </div>

                            </div>
                            
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-2">
                                <label for="inputAddress3">DNI:</label>
                                <input type="text" class="form-control ls-20" id="inputAddress3" placeholder="88888888" value="<?php echo $consultaUsuario['dniusuario'] ?>" name="dni">
                            </div>

                            <div class="form-group col-md-5">
                                <label for="inputAddress">Dirección:</label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="Av. Lima #1202" value="<?php echo $consultaUsuario['direccionusuario'] ?>" name="direccion">
                            </div>

                            <div class="form-group col-md-5">
                                <label for="inputAddress2">Referecia:</label>
                                <input type="text" class="form-control" id="inputAddress2" placeholder="Departamento, barrio o piso"  value="<?php echo $consultaUsuario['referenciausuario'] ?>" name="referencia">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="inputAddress2">Teléfono:</label>
                                <input type="text" class="form-control" id="inputAddress2" placeholder="987 654 321"  value="<?php echo $consultaUsuario['telefonousuario'] ?>" name="telefono">
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary fw-600">Guardar</button>
                        <button href="" class="btn btn-light ml-2">Cancelar</button>

                    </form>


                    <form action="" class='form-panel d-none' method = "post">

                    <?php foreach($consultaUsuario as $row) { ?>
                        <p>Nombres &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="nombre" value ="<?php echo $row['nombreusuario'] ?>"></p>
                        <p>Apellidos &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="apellido" value ="<?php echo $row['apellidousuario'] ?>"></p>
                        <p>Telefono &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" name="telefono" value ="<?php echo $row['telefonousuario'] ?>"></p>
                        <p>Dirección &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="Text" name="direccion" value ="<?php echo $row['direccionusuario'] ?>"required></p>
                        <p>DNI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" name="dni" value ="<?php echo $row['dniusuario'] ?>"></p>    
                    <?php } ?>
                    
                    <div class="botonguardar">
                        <input class="mt-4" type="submit" value="Guardar">
                        <button class="mt-4"><a href="index.php">Volver</a></button>
                    </div>       
                    </form>
                    
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