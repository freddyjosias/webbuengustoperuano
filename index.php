<?php
    $conexionDB = new mysqli('localhost', 'root', '', 'buengustoperuano');
    $conexionDB -> set_charset("utf8");

    $consultaRestaurantes = 'SELECT idsucursal, nomsucursal FROM sucursal';

    session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<title>El Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <link rel="shorcut icon" href="img/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/slider.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>

    <?php if (isset($_SESSION['idusuario'])) { ?>                        
        
        <header class="header-inicio">
            <div class="contenedor-general contenido-header-inicio">
                <div class="contenedor-img">  
                    <img src="img/logo-white.png" class="contenido-header-inicio-img">
                </div>
                <div class="cerrar-sesion">
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

        <section class="section-inicio">
            <div class="contenedor-general">
                <h1>RESTAURANTES</h1>
                <?php $contadorRestaurantes = 0;
                $resultados = mysqli_query($conexionDB, $consultaRestaurantes); 
                while($row = mysqli_fetch_assoc($resultados)) { 
                    if ($contadorRestaurantes % 2 == 0) { ?>
                        <div class="presentacion-restaurantes">
                    <?php } ?>
                        <a href="bienvenida.php?view=<?php echo $row['idsucursal']; ?>">
                            <div>
                                <h2><?php echo $row['nomsucursal']; ?>:</h2>
                                <img src="img/img<?php echo ($row['idsucursal'] + 4); ?>.jpg">
                            </div>
                        </a>
                    <?php $contadorRestaurantes++;
                    if ($contadorRestaurantes % 2 == 0) {?>
                    </div>
                <?php }
                } mysqli_free_result($resultados); ?>

            </div>
        </section>

        <footer class="footer-inicio">
            <div class= "contenedor-general">
                <div>© 2020 El Buen Gusto Peruano SAC. Todos los derechos reservados</div>
            </div>
        </footer>

    <?php } else { ?>

        <form method='post' class="box-login">
            <h1>Iniciar sesión</h1>
            <input type="text" placeholder="&#128272; Usuario" name="usuario">
            <input type="password" placeholder="&#128272; Contraseña" name="clave">
            <input type="submit" value="Ingresar" name="login">
        </form>
        
    <?php 
    
        if (isset($_POST['login'])) {
            if (strlen($_POST['usuario']) > 0 && strlen($_POST['clave']) > 0) {
                $usuario = $_POST['usuario'];
                $clave = $_POST['clave'];
                $consultaUsuario = 'SELECT * FROM usuario';
                $datosErroneos = 1;
                $resultados = mysqli_query($conexionDB, $consultaUsuario); 
                while($row = mysqli_fetch_assoc($resultados)) { 
                    if ($row['email'] == $usuario && $row['contrasena'] == $clave) {
                        $datosErroneos = 0;
                        $_SESSION['idusuario'] = $row['idusuario'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['nombreencargado'] = $row['nombreencargado'];
                        $_SESSION['apellidoencargado'] = $row['nombreencargado'];
                    }
                } mysqli_free_result($resultados);
                
                if ($datosErroneos == 1) {
                    echo 'Ingrese bien sus datos';
                }

                header('Location: index.php');

            } else {
                echo 'Ingresa tus datos';
            }
        }

    } ?>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/slider.js"></script>
</body>
</html>