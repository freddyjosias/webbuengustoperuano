
<?php 

require 'conexion.php';

session_start();

if (!isset($_GET['view'])) {
    header('Location: index.php');
}

$consultaVerificarRestaurante = 'SELECT * FROM sucursal WHERE idsucursal = ?';
        

        $idRestaurante;
        $bannerSucursal;
        $nombresucursal;
    

        $resultados = $conexion -> prepare($consultaVerificarRestaurante);
        $resultados -> execute(array($_GET['view']));
        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
        foreach($resultados as $row) {
           
                $idRestaurante = $row['idsucursal'];
                $bannerSucursal = $row['banner'];
                $nombresucursal = $row['nomsucursal'];
                break;     
        }
    
        $consultatipospedidos = $conexion -> prepare(
        "SELECT t.idtipospedido, t.descripciontipospedido, d.idsucursal 
         FROM tipospedido AS t INNER JOIN detalletipospedido AS d ON t.idtipospedido = d.idtipospedido 
        WHERE d.idsucursal = ? AND d.disponibilidadtipospedido = 1"
        );
        $consultatipospedidos -> execute(array($_GET['view']));
        $consultatipospedidos = $consultatipospedidos -> fetchAll(PDO::FETCH_ASSOC);

        $consultaformaspago = $conexion -> prepare(
        "SELECT f.idformaspago, f.descripcionformaspago, d.idsucursal 
         FROM formaspago AS f INNER JOIN detalleformaspago AS d ON f.idformaspago = d.idformaspago 
         WHERE d.idsucursal = ? AND d.disponibilidadformaspago = 1"
        );
        $consultaformaspago -> execute(array($_GET['view']));
        $consultaformaspago = $consultaformaspago -> fetchAll(PDO::FETCH_ASSOC);

    

?>

<!DOCTYPE html>
<html>
<head>
	<title>El Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="img/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Bienvenida | <?php echo $nombreRestaurante ?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/anadircarrito.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/responanadircar.css">
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
                <li><a href="nosotros.php?view=<?php echo $idRestaurante ?> ">Nosotros</a></li>
                <li><a href="panel.php?view=<?php echo $idRestaurante ?> ">Panel</a></li>
                  
            </ul>
        </nav>
    </header>
        <main class="contenedor-carrito">
                <div class="bgp">
                    <h1>BUEN GUSTO PERUANO</h1>
                </div>
                <div class="text-carrito">
                        <ul>
                            <li>Antes de hacer algun cambio, deberas actualizar tus datos. <a href="usuario.php">Actualizar Datos</a></li>			
                        </ul>
                </div>
  
                <section class="carrito-carrito"> 
                    <div class="carrito">
                        <form action="" method="post">
                            <p>Tipos de pedido:</p>
                                <select name="tipopedido">
                                    <?php foreach ($consultatipospedidos as $tipopedido) { ?>
                                        <option value="<?php echo $tipopedido['idtipospedido'] ?>"><?php echo $tipopedido['descripciontipospedido'] ?></option>
                                    <?php }  ?>
                                </select>
                            <p>Forma de Pago:</p>
                                <select name="formapago">
                                    <?php foreach ($consultaformaspago as $formaspago) { ?>
                                        <option value="<?php echo $formaspago['idformaspago'] ?>"><?php echo $formaspago['descripcionformaspago'] ?></option>
                                    <?php }  ?>
                                </select>
                            <p>Pedido con la seguridad que nos caracteriza.</p>
                            <input type="submit" name="" value="Guardar">
                        </form>
                    </div>
                    
                </section>
        </main>
                <footer class="footer-inicio">
                    <div class= "contenedor-general">
                        <div>© 2020 El Buen Gusto Peruano SAC. Todos los derechos reservados</div>
                    </div>
                </footer>

        <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>