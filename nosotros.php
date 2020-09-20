<?php 

    $conexionDB = new mysqli('localhost', 'root', '', 'buengustoperuano');
    $conexionDB -> set_charset("utf8");

    if (!isset($_GET['view'])) {
        header('Location: index.php');
    } else {

        $consultaVerificarRestaurante = 'SELECT idsucursal FROM sucursal';

        $idRestaurante;
        $resultados = mysqli_query($conexionDB, $consultaVerificarRestaurante); 
        while($row = mysqli_fetch_assoc($resultados)) { 
            if ($row['idsucursal'] ==  $_GET['view']) {
                $idRestaurante = $row['idsucursal'];
                break;
            }
        }

        if (!isset($idRestaurante)) {
            header('Location: index.php');
        } else {

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Quienes Somos - Restaurante 1</title>
    
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="fonts/style.css">

</head>
<body>

    <div class='logo-icono'>
        <a href="index.php"><img src="img/logo-icono.png" alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <img src="img/norteño.jpg" alt="">
        </div>
        <nav>
            <ul>
                <li><a href="bienvenida.php?view=<?php echo $idRestaurante ?>">Bienvenida</a></li>
                <li><a href="hacer-pedido.php?view=<?php echo $idRestaurante ?>">Pedidos</a></li>
                <li><a href="">Nosotros</a></li>
            </ul>
        </nav>
	</header>

    <main class="contenedor-general">

        <div class="introduccion-quienes-somos">
            <p> Situado en el centro de Tarapoto, ofrecemos a nuestros clientes la experiencia de disfrutar de los productos tipicos y autóctonos de la selva peruana. Proponemos platos tipicos dinámico sujeto a la disponibilidad de los productos, tan cambiante e impredecible como puedan ser las condiciones climatológicas y la temporada, es por eso que nuestra carta esta a disponibilidad de todos nuestros clientes.</p>
		</div>
		
		<div class="contenido-main-somos">
            
            <div>
                <div class="horariodeatencion">
                    <h2>Horario de atención</h2>
                    <ul>
                        <li><p> lunes_Sabado  8.00 am_10 pm </p></li>
                    </ul>
                </div>
                
                <div class="telefono">
                    <h2>Telefono</h2>
                    <ul>
                        <li><p>+51 42 204050</p></li>
                    </ul>
                </div>
            </div>
            
            <div>
                <div class="ubicacion">
                    <h2>Dirección</h2>
                    <ul>
                        <li><p>San Martin_Tarapoto</p></li>
                    </ul>
                </div>

                <div class="correoelectronico">
                    <h2>Correo electronico</h2>
                    <ul>
                        <li><p>Cristianfd10@gmail.com</p></li>
                    </ul>
                </div>
            </div>
            
            <div>
                <div class="formadepago">
                    <h2>Forma de pagos</h2>
                    <ul>
                        <li><p>Pago en efectivo</p></li>
                        <li><p>Pago con POS</p></li>
                        <li><P>Pago online</P></li>
                </ul>
                </div>

                <div class="gastosdeenvio">
                    <h2>Gastos de envios</h2>
                    <ul>
                        <li><p>Tarifa: S/3.00</p>	</li>
                    </ul>
                </div>
            </div>
         
        </div>

        <div class="mapa-quienes-somos">    
            <h3>Nos Encontramos Aquí</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9428.608432958468!2d-76.36468223737711!3d-6.49107291844111!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91ba0c062708ad1d%3A0x470eec16e5498700!2sPlaza%20de%20Armas%20de%20Tarapoto!5e0!3m2!1ses-419!2spe!4v1600025859915!5m2!1ses-419!2spe"  style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>	
                    
    </main>
    <footer class="footer-inicio">
        <div class="contenedor-general">
            <div>© 2020 Restaurante 1 SAC. Todos los derechos reservados</div>
        </div>
    </footer>
</body>
</html>

<?php
        }

    }

?>