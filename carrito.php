
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

        $consultaCar = $conexion -> prepare('SELECT * FROM shop_car AS s INNER JOIN productos AS p ON s.idproducto = p.idproducto WHERE s.idusuario = ? AND p.estado = 1');
        $consultaCar -> execute(array($_SESSION['idusuario']));
        $consultaCar = $consultaCar -> fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html>
<head>
	<title>El Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="img/logo-icon-512-color.png">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Carrito | <?php echo $nombreRestaurante ?></title>
    <link rel="shorcut icon" href="img/logo-icono.png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.add.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">    
<body>

    <div class='logo-icono d-none d-md-block'>
        <a href="index.php"><img src="img/logo-icono.png" alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <?php echo "<img src='".$bannerSucursal."' >" ?>
        </div>
        
        <?php require 'menu/menurestaurants.php'; ?>

    </header>
    <main class="carro">
        <main class="contenedor-carrito">
  
                <section class="carrito-carrito"> 

                <div class="bgp">
                    <h1>BUEN GUSTO PERUANO</h1>
                </div>
                <div class="text-carrito">
                        <ul>
                            <li>Antes de hacer algun cambio, deberas actualizar tus datos. <a href="usuario.php">Actualizar Datos</a></li>			
                        </ul>
                </div>

                    <div class="carrito">
                        <form action="" method="post">
                                <p>Productos elegidos:</p>
                                <table class="table">
                                    <thead>
                                        <tr>                   
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unit.</th>
                                            <th>Monto Total</th>
                                            <th colspan="2">Opción</th>
                                        </tr>
                                    </thead>
                                    <?php foreach($consultaCar as $producto) {?>
                                        <tbody>
                                            <tr class="trcarrito">
                                                    <td><?php echo $producto['nomproducto'] ?></td>
                                                    <td><?php echo $producto['quantity'] ?></td>
                                                    <td>S/.<?php echo $producto['precio'] ?></td>
                                                    <td>S/.<?php if($producto['quantity'] == 1) {
                                                        echo $producto['precio']; ?>
                                                        <?php } else {
                                                            $Nproducto = $producto['precio']*$producto['quantity'];  
                                                            echo number_format($Nproducto, 2, '.', ' '); } ?>
                                                    </td>
                                                    <td class='text-center'><a href="eliminarcarrito.php?id=<?php echo $producto['idproducto']; ?>&view=<?php echo $_GET['view'] ?>"><i class="far fa-trash-alt"></i></a></td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>   
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
                            <input type="submit" name="" value="Realizar Pedido">
                        </form>
                    </div> 
                </section>
        </main>
    </main>
                <footer class="footer-inicio">
                    <div class= "contenedor-general">
                        <div>© 2020 El Buen Gusto Peruano SAC. Todos los derechos reservados</div>
                    </div>
                </footer>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>