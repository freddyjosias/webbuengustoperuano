<?php
    $conexionDB = new mysqli('localhost', 'root', '', 'buengustoperuano');
    $conexionDB -> set_charset("utf8");

    $consultaRestaurantes = 'SELECT nomsucursal FROM "sucursal"';

?>

<!DOCTYPE html>
<html>
<head>
	<title>El Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
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
		<ul>
			<li>
				<img src="img/img1.jpg">
			</li>
			<li>
                <img src="img/img2.jpg">
            </li>
			<li>
                <img src="img/img3.jpg">
            </li>
			<li>
                <img src="img/img4.jpg">
            </li>
		</ul>
	</div>

    <section class="section-inicio">
        <div class="contenedor-general">
            <h1>RESTAURANTES</h1>
            <div class="presentacion-restaurantes">
                <a href="quienes-somos.html">
                    <div>
                        <h2>Restaurante 1:</h2>
                        <img src="img/img5.jpg">
                    </div>
                </a>
                <a href="">
                    <div>
                        <h2>Restaurante 2:</h2>
                        <img src="img/img6.jpg">
                    </div>
                </a>
            </div>
            <div class="presentacion-restaurantes">
                <a href="">
                    <div>
                        <h2>Restaurante 3:</h2>
                        <img src="img/img7.jpg">
                    </div>
                </a>
                <a href="">
                    <div>
                        <h2>Restaurante 4:</h2>
                        <img src="img/img8.jpg">
                    </div>
                </a>
            </div>
        </div>
    </section>

    <footer class="footer-inicio">
        <div class="contenedor-general">
            <div>© 2020 El Buen Gusto Peruano SAC. Todos los derechos reservados</div>
        </div>
    </footer>

</body>
</html>