<?php

    session_start();

    require 'conexion.php';

    $consultaRestaurantes = 'SELECT idsucursal, nomsucursal, imgbienvenida FROM sucursal WHERE estado = 1';

?>

<!DOCTYPE html>
<html>
<head>
	<title>El Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="img/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>

    <?php if (isset($_SESSION['idusuario'])) { ?>                        
        
        <header class="header-inicio">
            <div class="contenedor-general contenido-header-inicio">
                <div class="contenedor-img">  
                    <img src="img/logo-white.png" class="contenido-header-inicio-img">
                </div>
                <div class="cerrar-sesion">
                <?php if ($_SESSION['profile'] == 3) { ?>
                    <a href="paneladmin/index.php"><img src="img/admin.png" class="admin"></a>
                <?php } ?>
                    <a href="logout.php"><img src="img/cerrar-sesion.png"></a>
                </div>
            </div>
        </header>

        <div class="slider contenedor-general">
            <div class="slider-img efecto">
                <img src="img/img1.jpg">
            </div>
            <div class="slider-img efecto">
                <img src="img/img2.jpg">
            </div>
            <div class="slider-img efecto">
                <img src="img/img3.jpg">
            </div>
            <div class="slider-img efecto">
                <img src="img/img4.jpg">
            </div>
            <div class="direcciones">
                <a href="#" class="atras">&#10094</a>
                <a href="#" class="adelante">&#10095</a>
            </div>
        </div>

        <section class="box-usuario">
            <div class="contenedor-general view-restaurants mb-4">
                <h1 class='text-center'>RESTAURANTES</h1>
                <?php $contadorRestaurantes = 0;
                $resultados = $conexion -> prepare($consultaRestaurantes);
                $resultados -> execute();
                $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
                foreach($resultados as $row) {
                    if ($contadorRestaurantes % 2 == 0) { ?>
                        <div class="presentacion-restaurantes">
                    <?php } ?>
                        <a href="hacerpedido.php?view=<?php echo $row['idsucursal']; ?>">
                            <div>
                                <h2><?php echo $row['nomsucursal']; ?>:</h2>
                                <img src="<?php echo $row['imgbienvenida']; ?>">
                            </div>
                        </a>
                    <?php $contadorRestaurantes++;
                    if ($contadorRestaurantes % 2 == 0) {?>
                    </div>
                <?php }
                } ?>

            </div>
        </section>

        <footer class="footer-inicio">
            <div class= "contenedor-general">
                <div>© 2020 El Buen Gusto Peruano SAC. Todos los derechos reservados</div>
            </div>
        </footer>

    <?php } else { 
        
        if (isset($_POST['login'])) {
            if (strlen($_POST['usuario']) > 0 && strlen($_POST['clave']) > 0) {
                $usuario = $_POST['usuario'];
                $clave = $_POST['clave'];
                $consultaUsuario = 'SELECT * FROM usuario WHERE estado = 1 OR estado = 2';
                $datosErroneos = 1;
                $resultados = $conexion -> prepare($consultaUsuario);
                $resultados -> execute();
                $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);

                foreach($resultados as $row) { 
                    if ($row['emailusuario'] == $usuario && $row['contrasena'] == $clave) {
                        $datosErroneos = 0;
                        $_SESSION['idusuario'] = $row['idusuario'];
                        $_SESSION['email'] = $row['emailusuario'];
                        $_SESSION['nombreusuario'] = $row['nombreusuario'];
                        $_SESSION['apellidousuario'] = $row['apellidousuario'];
                        $_SESSION['profile'] = $row['id_profile']; 
                        if ($row['id_profile'] == 2) {

                            $resultadosR = $conexion -> prepare('SELECT idsucursal FROM access WHERE idusuario = ?');
                            $resultadosR -> execute(array($row['idusuario']));
                            $resultadosR = $resultadosR -> fetchAll(PDO::FETCH_ASSOC);
                            $_SESSION['sucursal'] = $resultadosR[0]['idsucursal'];

                            header('Location: nosotros.php?view=' . $resultadosR[0]['idsucursal']);
                            die;

                        }
                        header('Location: index.php');
                        die;
                        break;
                    }
                }
                

            }
        }
    
        ?>

            <form method='post' class="box-login">
                <h1 class='mt-0'>Iniciar sesión</h1>
                <input type="text" placeholder="&#128272; Correo" name="usuario" required>
                <input type="password" placeholder="&#128272; Contraseña" name="clave" required>
                <input type="submit" value="Ingresar" name="login">
                <?php
                    if (isset($datosErroneos)) {
                        ?>
                            <div class="alert alert-danger text-center" role='alert'>
                                Datos incorrectos &nbsp; <i class="far fa-times-circle"></i>
                            </div>
                        <?php
                    }
                ?>
            </form>
        
        <?php 

    } ?>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>