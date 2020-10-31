
<?php 

require 'conexion.php';

session_start();

$consultaVerificarRestaurante = 'SELECT * FROM sucursal';
        

        $idRestaurante;
        $bannerSucursal;
        $nombresucursal;
    

        $resultados = $conexion -> prepare($consultaVerificarRestaurante);
        $resultados -> execute();
        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
        foreach($resultados as $row) {
           
                $idRestaurante = $row['idsucursal'];
                $bannerSucursal = $row['banner'];
                $nombresucursal = $row['nomsucursal'];
                break;     
        }

?>

<!DOCTYPE html>
<html>
<head>
	<title>El Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="img/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/añadircarrito.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    
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
                  
            </ul>
        </nav>
    </header>
    
        <div class="text-carrito">
            <h1>Si el pago es en efectivo, indicar en COMENTARIOS el monto con el que cancelará. Si necesita una factura, indicar sus datos (RUC/Razón Social)</h1>
        </div>

    
                <section class="carrito-carrito"> 
                    <div class="carrito">
                            <div>
                                <p>Contacto</p>
                                <a href=""></a> 
                                <input type="text">
                                <i class="far fa-id-badge"></i>            
                            </div>
                            <div>
                                <p>Cantidad producto</p>
                                <input type="number">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <div>
                                <p>Formas de pago</p>
                                <input type="texto">
                                <i class="fas fa-align-center"></i>
                            </div>
                            <div>
                                <p>Tipos de pedido</p>
                                <input type="texto">
                                <i class="fas fa-bars"></i>
                            </div>
                    </div>
                    
                    <div class="carrito"> 
                            <div>
                                <p>Contacto</p>
                                <a href=""></a> 
                                <input type="text">
                                <i class="far fa-id-badge"></i>            
                            </div>
                            <div>
                                <p>Cantidad producto</p>
                                <input type="number">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <div>
                                <p>Formas de pago</p>
                                <input type="texto">
                                <i class="fas fa-align-center"></i>
                            </div>
                            <div>
                                <p>Pedido con la seguridad que nos caracteriza.</p>
                                <input type="submit" name="" value="Guardar">
                            </div>
                    </div>
                    
                </section>





                <footer class="footer-inicio">
                    <div class= "contenedor-general">
                        <div>© 2020 El Buen Gusto Peruano SAC. Todos los derechos reservados</div>
                    </div>
                </footer>

        <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>