<?php 

    require 'conexion.php';
    session_start();

    if (!isset($_SESSION['idusuario'])) {
        header('Location: index.php');
    } 

    if (!isset($_GET['view'])) {
        header('Location: index.php');
    } else {

        $consultaVerificarRestaurante = 'SELECT idsucursal, nomsucursal, banner FROM sucursal WHERE estado = 1';

        $idRestaurante;
        $nombresucursal;
        $bannerSucursal;

        $resultados = $conexion -> prepare($consultaVerificarRestaurante);
        $resultados -> execute();
        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
        foreach($resultados as $row) {
            if ($row['idsucursal'] ==  $_GET['view']) {
                $idRestaurante = $row['idsucursal'];
                $nombresucursal = $row['nomsucursal'];
                $bannerSucursal = $row['banner'];
                break;
            }
        }

        if (!isset($idRestaurante)) {
            header('Location: index.php');
        } else {
            
            if (isset($_GET['anadir'])) {
                $resultadosAnadir = $conexion -> prepare('SELECT idproducto FROM productos INNER JOIN categoriaproductos ON categoriaproductos.idcategoriaproducto = productos.idcategoriaproducto INNER JOIN sucursal ON sucursal.idsucursal = categoriaproductos.idsucursal WHERE sucursal.idsucursal = ? AND categoriaproductos.idsucursal = ? AND categoriaproductos.estado = 1 AND productos.estado = 1 AND productos.idproducto = ?');
                $resultadosAnadir -> execute(array($_GET['view'], $_GET['view'], $_GET['anadir']));
                $resultadosAnadir = $resultadosAnadir -> fetchAll(PDO::FETCH_ASSOC);
                
            }

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
        <link rel="stylesheet" href="css/pedidosresponsivo.css">
</head>
<body>
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById("op1") .style.background="#969696";
    }
    </script>

    <div class='logo-icono'>
        <a href="index.php"><img src="img/logo-icono.png" alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <?php echo "<img src='".$bannerSucursal."' >" ?>
        </div>
        <nav>
            <ul>
                <li><a href="bienvenida.php?view=<?php echo $idRestaurante ?>"id="op0">Bienvenida</a></li>
                <li><a href="hacerpedido.php?view=<?php echo $idRestaurante ?>"id="op1">Pedidos</a></li>
                <li><a href="nosotros.php?view=<?php echo $idRestaurante ?>"id="op2">Nosotros</a></li>
                    <?php if ($_SESSION['profile'] == 2 && isset($_SESSION['sucursal'])) { ?>
                        <?php if ($_SESSION['sucursal'] == $_GET['view']) { ?>
                            <li><a href="panel.php">Panel</a></li>
                        <?php } ?> 
                    <?php } ?> 
                <li><a href="anadircarrito.php?view=<?php echo $idRestaurante ?>"id="op3"><img src="img/carrito.png" class="carrito-compras"></a></li>  
            </ul>
        </nav>
	</header>
	
    <main class= "carta">

        <div class= "contenedor-general">

            <h1>MENÚ - CARTA</h1>

			<div class="contenido-carta">	

                <?php $consultaCategoria = 'SELECT descripcioncategoriaproducto, idcategoriaproducto FROM categoriaproductos INNER JOIN sucursal ON sucursal.idsucursal = categoriaproductos.idsucursal WHERE sucursal.idsucursal = ? AND categoriaproductos.estado = 1';
                
                $resultados = $conexion -> prepare($consultaCategoria);
                $resultados -> execute(array($idRestaurante));
                $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
                foreach($resultados as $row) {

                    $consultaProductoCategoria = 'SELECT * FROM productos WHERE idcategoriaproducto = ? AND estado = 1';
                    $resultados2 = $conexion -> prepare($consultaProductoCategoria);
                    $resultados2 -> execute(array($row['idcategoriaproducto']));
                    $resultados2 = $resultados2 -> fetchAll(PDO::FETCH_ASSOC);

                    $productosOK = 0;

                    foreach ($resultados2 as $key) {
                        if ($key['stock'] > 0) {
                            $productosOK = 1;
                            break;
                        }
                    }
                    
                    if (count($resultados2) > 0 && $productosOK == 1) {?>
                    
                        <h2><?php echo $row['descripcioncategoriaproducto'] ?></h2>

                        <div>

                            <?php foreach($resultados2 as $row2) {
                                
                                if ($row2['stock'] > 0) {?>

                                    <div class="productos-carta">
                                        <div><h3><?php echo $row2['stock'] . ' &nbsp; &nbsp; | &nbsp; &nbsp;' .$row2['nomproducto'] ?></h3></div>
                                        <div><a class="carritos" href="?view=<?php echo $_GET['view'] ?>&anadir=<?php echo $row2['idproducto'] ?>"><i class="fas fa-cart-plus"></i></a> &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp; S/. <?php echo $row2['precio'] ?></div>
                                    </div>

                            <?php }
                            } ?>
                
                        </div>
                    
                <?php } 
                } ?>
            
            </div>           
        </div>
    </main>
    
	<footer class="footer-inicio">
        <div class='contenedor-general'>
            <div>© 2020 Restaurante 1 SAC. Todos los derechos reservados</div>
        </div>
    </footer>

    <img src="img/ir-arriba.png" class="ir-arriba">

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/4580061bb3.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>

<?php
        }

    }

?>