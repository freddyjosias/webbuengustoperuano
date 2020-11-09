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
	<title>El Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="img/logo-icon-512-color.png">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.add.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
                            
                <header class="header-inicio">
                    <div class="contenedor-general contenido-header-inicio row">

                    <div class="contenedor-img col-6 m-0 px-0 py-3 h-4r d-flex">
                        <img src="img/logo-icon-512-color.png" class="h-100">
                        <img src="img/logo-text-1024-white.png" class="h-100 ml-3 d-none d-sm-block">
                        <img src="img/logo-text-1024-white-min.png" class="h-100 ml-3 d-block d-sm-none">
                    </div>

                    </div>
                </header>

        <section class="box-usuariox">
                    
                    <div class="form-centro">

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
                        <input type="submit" value="Guardar">
                        <button><a href="index.php">Volver</a></button>
                    </div>       
                    </form>

                    </div>
            </section>


</body>
</html>