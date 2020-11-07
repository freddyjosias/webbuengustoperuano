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

                    $resultado2 = $conexion -> prepare('INSERT INTO shop_car(idusuario, idproducto, quantity) VALUE(?, ?, 1)');
                    $resultado2 -> execute(array($_SESSION['idusuario'], $_GET['anadir']));
                    $resultado2 = $resultado2 -> fetchAll(PDO::FETCH_ASSOC);
                
            }

        

?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <title>Pedidos | <?php echo $nombresucursal ?></title>
        <link rel="shorcut icon" href="img/faviconn.ico">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.add.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="fontawesome/css/all.min.css">
	    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>

    <div class='logo-icono d-none d-md-block'>
        <a href="index.php"><img src="img/logo-icono.png" alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <?php echo "<img class='' src='".$bannerSucursal."' >" ?>
        </div>
                
        <?php require 'menu/menurestaurants.php'; ?>

	</header>
	
    <main class= "carta">

        <div class= "contenedor-general">

            <h1 class='h2 fw-700 ls-13'>MENÚ - CARTA</h1>

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

                        <div class="categories-view container d-flex text-white m-0 p-0">

                            <h2 class='fw-500 ls-13 m-0 px-4 py-1'><?php echo $row['descripcioncategoriaproducto'] ?></h2>

                        </div>

                        <div class='list-products'>

                            <?php foreach($resultados2 as $row2) {
                                
                                if ($row2['stock'] > 0) {?>

                                    <div class="productos-carta">

                                        <div>

                                            <h3><?php echo $row2['stock'] . ' &nbsp; &nbsp; | &nbsp; &nbsp;' .$row2['nomproducto'] ?></h3>

                                        </div>

                                        <div>

                                            <a class="carritos" href="?view=<?php echo $_GET['view'] ?>&anadir=<?php echo $row2['idproducto'] ?>">

                                                <i class="fas fa-cart-plus"></i>

                                            </a> 

                                            &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp; S/. <?php echo $row2['precio'] ?>

                                        </div>

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
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

<?php
        }

    }

?>