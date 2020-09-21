<?php
    $conexionDB = new mysqli('localhost', 'root', '', 'buengustoperuano');
    $conexionDB -> set_charset("utf8");

    $consultaRestaurantes = 'SELECT idsucursal, nomsucursal FROM sucursal';

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
</head>
<body>
    
	<header class="header-inicio">
		<div class="contenedor-general contenido-header-inicio">
            <div class="contenedor-img">  
                <img src="img/logo-white.png" class="contenido-header-inicio-img">
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
            <a href="#" class="atras" onclick="avanzaSlide(-1)">&#10094</a>
            <a href="#" class="adelante" onclick="avanzaSlide(1)">&#10095</a>
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
            } ?>

        </div>
    </section>

    <footer class="footer-inicio">
        <div class= "contenedor-general">
            <div>© 2020 El Buen Gusto Peruano SAC. Todos los derechos reservados</div>
        </div>
    </footer>
    <script src="js/slider.js"></script>
</body>
</html>