<?php 

    require '../../conexion.php';

    session_start();

    if (!isset($_SESSION['sucursal'])) {
        header('Location: index.php');
    }

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 2) {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }

    $consultaCategorias = $conexion -> prepare('SELECT idcategoriaproducto, idsucursal, descripcioncategoriaproducto FROM categoriaproductos WHERE idsucursal = ?');
    $consultaCategorias -> execute(array($_SESSION['sucursal']));
    $consultaCategorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);
    

    if (isset($_GET['categoria'])) {
        $consultaCategoria = $conexion -> prepare('SELECT * FROM categoriaproductos WHERE idcategoriaproducto = ?');
        $consultaCategoria -> execute(array($_GET['categoria']));
        $consultaCategoria = $consultaCategoria -> fetch(PDO::FETCH_ASSOC);
    }

    if (isset($_GET['id'])) {
        $consultaProductoA = $conexion -> prepare('SELECT*FROM productos WHERE idproducto = ?');
        $consultaProductoA -> execute(array($_GET['id']));
        $consultaProductoA = $consultaProductoA -> fetch(PDO::FETCH_ASSOC);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $resultados = $conexion -> prepare('UPDATE productos SET nomproducto = ?, precio = ?, stock = ? WHERE idproducto = ?');
        $resultados -> execute(array($_POST['nuevonombre'],$_POST['nuevoprecio'],$_POST['nuevostock'], $_GET['id']));

        if ($resultados) {
            header('Location: listar.php');
        }

    }
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Actualizar Producto</title>
    <link rel="shorcut icon" href="../../img/favicon.ico">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/responpanel.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
</head>
<body>

    <main>
        <div class="contenedor-general panel-control">

            <?php require '../../menu/menupanel.php'; ?>

            <div class='formulario-panel'>

                <h1>Actualizar Producto</h1>

                <form action="" method="get"  class='form-panel'>
                    <p>Categoria Escogida: 
                        <?php echo $consultaCategoria['descripcioncategoriaproducto']; ?>
                    </p>
                </form>
                
                <?php if(isset($_GET['categoria']))   {    ?>       
                <form  action="" method="get"  class='form-panel'>

                    <input type="number" name="categoria" id="cate-edit-pro" value="<?php echo $_GET['categoria'] ?>">

                    <p>Producto Elegido:  
                        <?php echo $consultaProductoA['nomproducto']; ?>
                    </p>
                </form>

                <?php }  ?>                     
                <?php if(isset($_GET['categoria']) && isset($_GET['id'])) { ?>         
                    <form action="" class='form-panel' method = "post">
                        <p>Nuevo nombre: <input type="text" name="nuevonombre"></p>  
                        
                        <p>Precio: <?php echo $consultaProductoA['precio'] ?></p>
                        <p>Nuevo precio: <input type="number" name="nuevoprecio" step='0.01'></p>

                        <p>Stock: <?php echo $consultaProductoA['stock'] ?></p>
                        <p>Nuevo Stock: <input type="number" name="nuevostock"></p>
                        
                        <input class="btn btn-secondary bottom" type="submit" value="Actualizar Producto">
                    </form>
                <?php } ?>     

            </div>

        </div>
    </main>
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>