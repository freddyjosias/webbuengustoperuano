<?php 

    require 'conexion.php';

    session_start();

    if (!isset($_SESSION['idusuario'])) {
        header('Location: index.php');
    } 

    if (!isset($_GET['view'])) {
        header('Location: index.php');
    } else {

        $consultaVerificarRestaurante = 'SELECT * FROM sucursal WHERE estado = 1';
        

        $idRestaurante;
        $bannerSucursal;
        $nombresucursal;
        $telefonoRestaurante;
        $correoRestaurante;
        $ubicacionRestaurante;


        $resultados = $conexion -> prepare($consultaVerificarRestaurante);
        $resultados -> execute();
        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
        foreach($resultados as $row) {
            if ($row['idsucursal'] ==  $_GET['view']) {
                $idRestaurante = $row['idsucursal'];
                $bannerSucursal = $row['banner'];
                $nombresucursal = $row['nomsucursal'];
                $telefonoRestaurante = $row['telefono'];
                $correoRestaurante = $row['correosucursal'];
                $ubicacionRestaurante = $row['direcsucursal'];
                $atencioninicioRestautante = $row['horaatencioninicio'];
                $atencioncierreRestautante = $row['horaatencioncierre'];
                break;
            }
        }

        if (!isset($idRestaurante)) {
            header('Location: index.php');
        } else {
        
            $consultaFormaPago = 'SELECT descripciontipospedido FROM tipospedido INNER JOIN detalletipospedido ON tipospedido.idtipospedido = detalletipospedido.idtipospedido INNER JOIN sucursal ON sucursal.idsucursal = detalletipospedido.idsucursal WHERE disponibilidadtipospedido = 1 AND sucursal.idsucursal = ' . $_GET['view'];

            $consultaTipoPago = 'SELECT descripcionformaspago FROM formaspago INNER JOIN detalleformaspago ON formaspago.idformaspago = detalleformaspago.idformaspago INNER JOIN sucursal ON sucursal.idsucursal = detalleformaspago.idsucursal WHERE disponibilidadformaspago = 1 AND sucursal.idsucursal = ?';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Bienvenida | <?php echo $nombresucursal ?></title>
    <link rel="shorcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">

</head>
<body>

    <div class='logo-icono'>
        <a href="index.php"><img src="img/logo-icono.png" alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <?php echo "<img src='".$bannerSucursal."' >" ?>
        </div>
        <nav>
            <ul>
                <li><a href="bienvenida.php?view=<?php echo $idRestaurante ?>">Bienvenida</a></li>
                <li><a href="hacerpedido.php?view=<?php echo $idRestaurante ?>">Pedidos</a></li>
                <li><a href="">Nosotros</a></li>
                    <?php if ($_SESSION['profile'] == 2 && isset($_SESSION['sucursal'])) { ?>
                        <?php if ($_SESSION['sucursal'] == $_GET['view']) { ?>
                            <li><a href="panel.php">Panel</a></li>
                        <?php } ?> 
                    <?php } ?> 
            </ul>
        </nav>
	</header>

    <main class="contenedor-general">

        <div class="introduccion-quienes-somos">
            <p> Situado en el centro de Tarapoto, ofrecemos a nuestros clientes la experiencia de disfrutar de los productos tipicos y autóctonos de la selva peruana. Proponemos platos tipicos dinámico sujeto a la disponibilidad de los productos, tan cambiante e impredecible como puedan ser las condiciones climatológicas y la temporada, es por eso que nuestra carta esta a disponibilidad de todos nuestros clientes.</p>
		</div>
		
		<div class="contenido-main-somos">
            
            <div class="div">
                <div class="horariodeatencion">
                    <h2>Horario de atención</h2>
                    <ul>
                        <li><p>Lunes a Domingo <?php echo $atencioninicioRestautante . ' - ' . $atencioncierreRestautante ?></p></li>
                    </ul>
                </div>
                
                <div class="telefono">
                    <h2>Telefono</h2>
                    <ul>
                        <li><p><?php echo $telefonoRestaurante; ?></p></li>
                    </ul>
                </div>
            </div>
            
            <div class="div">
                <div class="ubicacion">
                    <h2>Dirección</h2>
                    <ul>
                        <li><p><?php echo $ubicacionRestaurante;?></p></li>
                    </ul>
                </div>

                <div class="correoelectronico">
                    <h2>Correo electronico</h2>
                    <ul>
                        <li><p><?php echo $correoRestaurante; ?></p></li>
                    </ul>
                </div>
            </div>
            
            <div class="div">
                <div class="formadepago">
                    <h2>Tipos de envio</h2>
                    <ul>
                        <?php $resultados = $conexion -> prepare($consultaFormaPago);
                        $resultados -> execute();
                        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
                        foreach($resultados as $row) {?>
                            <li><p><?php echo $row['descripciontipospedido'] ?></p></li>
                        <?php } ?>
                </ul>
                </div>

                <div class="gastosdeenvio">
                    <h2>Forma de pagos</h2>
                    <ul>
                        <?php $resultados = $conexion -> prepare($consultaTipoPago);
                        $resultados -> execute(array($_GET['view']));
                        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
                        foreach($resultados as $row) {?>
                            <li><p><?php echo $row['descripcionformaspago'] ?></p></li>
                        <?php } ?>
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
            <div>© 2020 <?php echo $nombresucursal ?>. Todos los derechos reservados</div>
        </div>
    </footer>

    <img src="img/ir-arriba.png" class="ir-arriba">

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

<?php
        }

    }

?>