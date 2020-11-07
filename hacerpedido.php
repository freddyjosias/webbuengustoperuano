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

                if($_SERVER["REQUEST_METHOD"] == "POST"){
                        $resultado2 = $conexion -> prepare('INSERT INTO shop_car(idusuario, idproducto, quantity) VALUE(?, ?, ?)');
                        $resultado2 -> execute(array($_SESSION['idusuario'], $_GET['anadir'], $_POST['addquantity']));
                        $resultado2 = $resultado2 -> fetchAll(PDO::FETCH_ASSOC);
                }
                
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

                                    <div class="row productos-carta fw-600">

                                        <div class="col-1 m-0 p-0">

                                            <div class="row  m-0 p-0 h-100 align-items-center">

                                                <div class="col-11 m-0 p-0 text-center ">
                                                    <?php echo $row2['stock'] ?>
                                                </div>

                                                <div class="col-1 m-0 h-100 p-0 border-3 border-secondary border-top-0 border-bottom-0 border-left-0 rounded">
                                                    
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-7 m-0 p-0">

                                            <div class="col-12 h-100 d-flex align-items-center">
                                                <?php echo $row2['nomproducto'] ?>
                                            </div>

                                        </div>

                                        <div class="col-2 m-0 p-0 align-items-center">

                                            <form class='d-flex' method='post' action='hacerpedido.php?view=<?php echo $_GET['view']?>&anadir=<?php echo $row2['idproducto'] ?>'>

                                                <div class="col-6 m-0 p-0">
                                                    <button type="submit" class=" btn btn-primary">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </div>

                                                <div class="col-6 m-0 pl-0 pr-3 form-group">
                                                    <input type="number" name='addquantity' class="no-arrow-numer form-control p-1 text-center fw-600" id="exampleInputPassword1" value='1' min='1' max='<?php echo $row2['stock'] ?>'> 
                                                </div>

                                            </form>

                                        </div>

                                        <div class="col-2 m-0 p-0">

                                            <div class="row m-0 p-0 h-100 align-items-center">

                                                <div class="col-1 h-100 my-0 ml-0 p-0 border-3 border-secondary border-top-0 border-bottom-0 border-right-0">
                                                    
                                                </div>

                                                <div class="col-11 m-0 p-0 text-center">
                                                    S/. <?php echo $row2['precio'] ?>
                                                </div>

                                            </div>

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

    <div class="function-go-up ir-arriba">
        <i class="fas fa-angle-up"></i>
    </div>

    <div class="submenu-bottom container-fluid position-fixed bottom-0 d-block d-lg-none border border-light border-bottom-0 border-right-0 border-left-0">

        <div class="row text-center h-100">

            <div class="col-6 fs-22 h-100 d-flex border-right">
                <a href="index.php" class='text-white h-100 w-100 pt-1'><i class="fas fa-home"></i></a>
            </div>

            <div class="col-6 text-white fs-35">

                <div class="function-go-up go-up h-100 d-flex top-0 justify-content-center w-100" role='button'>
                    <i class="fas fa-angle-up"></i>
                </div>

            </div>
        </div>

    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

<?php
        }

    }

?>