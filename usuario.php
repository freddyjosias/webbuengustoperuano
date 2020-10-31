<?php

    require 'conexion.php';

    session_start();



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
    <title>Usuario</title>
    <link rel="shorcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="css/usuariox.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

</head>
<body>
                            
                <header class="header-inicio">
                    <div class="contenedor-general contenido-header-inicio">

                        <div class="contenedor-img">  
                            <img src="img/logo-white.png" class="contenido-header-inicio-img">
                        </div>

                    </div>
                </header>

        <section class="box-usuario">
                    
                    <div class="form-centro">

                        <h1>ACTUALIZA TUS DATOS</h1>
                    <form action="" class='form-panel' method = "post">

                    <?php foreach($consultaUsuario as $row) { ?>
                        <p>Nombres <input type="text" name="nombre" value ="<?php echo $row['nombreusuario'] ?>"></p>
                        <p>Apellidos <input type="text" name="apellido" value ="<?php echo $row['apellidousuario'] ?>"></p>
                        <p>Contraseña <input type="text" name="clave" value ="<?php echo $row['contrasena'] ?>"></p>
                        <p>Telefono <input type="number" name="telefono" value ="<?php echo $row['telefonousuario'] ?>"></p>
                        <p>Dirección <input type="Text" name="direccion" value ="<?php echo $row['direccionusuario'] ?>"></p>
                        <p>DNI <input type="number" name="dni" value ="<?php echo $row['dniusuario'] ?>"></p>    
                    <?php } ?>
                    
                    <div class="botonguardar">
                        <input type="submit" value="Guardar">
                    </div>       
                    </form>

                    </div>
            </section>


</body>
</html>