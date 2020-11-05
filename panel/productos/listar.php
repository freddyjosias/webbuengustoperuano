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

    $consultaProductos = $conexion -> prepare(
        'SELECT p.idproducto, p.idcategoriaproducto, p.nomproducto, p.precio, p.stock, p.estado, c.idsucursal, c.descripcioncategoriaproducto, c.estado
         FROM productos AS p INNER JOIN categoriaproductos AS c ON p.idcategoriaproducto = c.idcategoriaproducto
         WHERE c.idsucursal = ? AND p.estado = 1 AND c.estado = 1'
    );
    $consultaProductos -> execute(array($_SESSION['sucursal']));
    $consultaProductos = $consultaProductos -> fetchAll(PDO::FETCH_ASSOC);
    
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Actualizar Categoria</title>
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
                <div class="contenido-listar">
                    <h1>Lista de productos</h1>
                    <a class="btn btn-dark bottom" href="agregar.php">Agregar</a>
                    <table class="table">
                        <thead>
                            <tr>                    
                                <th class="th">Categoria</th>
                                <th class="th">Producto</th>
                                <th class="th">Precio</th>
                                <th class="th">Stock</th>
                                <th class="th" colspan="2">Operaciones</th>
                            </tr>
                        </thead>
                        <?php foreach($consultaProductos as $producto) {?>
                            <tbody>
                                <tr>
                                    <td><?php echo $producto['descripcioncategoriaproducto'] ?></td>
                                    <td><?php echo $producto['nomproducto'] ?></td>
                                    <td><?php echo $producto['precio'] ?></td>
                                    <td><?php echo $producto['stock'] ?></td>
                                    <td><a class="btn btn-success bottom" href="actualizar.php?id=<?php echo $producto['idproducto']; ?>&categoria=<?php echo $producto['idcategoriaproducto']; ?>">Actualizar</a></td>
                                    <td><a class="btn btn-danger bottom" href="eliminar.php?id=<?php echo $producto['idproducto']; ?>&categoria=<?php echo $producto['idcategoriaproducto']; ?>">Eliminar</a></td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>   
                </div>


            </div>

        </div>
    </main>

</body>
</html>