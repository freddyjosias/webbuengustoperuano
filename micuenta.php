<?php

    require 'conexion.php';

    session_start();

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
            $resultados4 = $conexion -> prepare('UPDATE usuario SET contrasena = ? WHERE idusuario = ?');
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

    }

    $consultaUsuario = $conexion -> prepare('SELECT * FROM usuario WHERE idusuario = ?');
    $consultaUsuario -> execute(array($_SESSION['idusuario']));
    $consultaUsuario = $consultaUsuario -> fetchAll(PDO::FETCH_ASSOC);

?>


                   


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Mi Cuenta</title>
    <link rel="shorcut icon" href="img/logo-icon-512-color.png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.add.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/formularios.css">

</head>

<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">
            
            <?php
                require 'menu/menuusuario.php';
            ?>

            <div class='container p-0 main-panel m-0 mw-85 w-85'>

                <div class="line-top-panel row h-4r m-0 p-0 align-items-center">
                    <div class='text-white fw-700 fs-30 col-12'>MI CUENTA</div> 
                </div>
                
                <div class="row w-80 m-auto">
                    <h1 class='h3 text-center mt-5 mb-3 font-weight-bold w-100 this-is-my-dates'>MIS DATOS PERSONALES</h1>

                    <h1>DATOS DEL USUSARIO</h1>
                    <form action="" class='form-panel' method = "post">

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

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.add.js"></script>
    <script src="sweetalert/sweetalert210.js"></script>
    <script src="js/script.js"></script>

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