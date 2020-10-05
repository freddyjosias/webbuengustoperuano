<?php 

    require 'conexion.php';

    session_start();

    $consultaCategorias = $conexion -> prepare('SELECT idcategoriaproducto, idsucursal, descripcioncategoriaproducto FROM categoriaproductos WHERE idsucursal = ?');
    $consultaCategorias -> execute(array($_SESSION['idsucursal']));
    $consultaCategorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);

    //$consultaProducto = $conexion -> prepare('SELECT * FROM productos WHERE idcategoriaproducto = ?');
    //$consultaCategorias -> execute(array($_POST['categoria']));
    //$consultaProducto = $consultaProducto -> fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Quienes Somos - Restaurante 1</title>
    <link rel="shorcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/responpanel.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="panel.php">Inicio</a></li>
                    <li><a href="anadircategoria.php">Añadir Categoria</a></li>
                    <li><a href="eliminarcategoria.php">Eliminar Categoria</a></li>
                    <li><a href="actualizarcategoria.php">Actualizar Categoria</a></li>
                    <li><a href="anadirproducto.php">Añadir Producto</a></li>
                    <li><a href="eliminarproducto.php">Eliminar Producto</a></li>
                    <li><a href="actualizarproducto.php">Actualizar Praducto</a></li>
                    <li><a href="actualizarformaspago.php">Actualizar Formas de Pago</a></li>
                    <li><a href="actualizartipospedido.php">Actualizar Tipos de pedido</a></li>
                </ul>
            </nav>

            <div class='formulario-panel'>

                <h1>Actualizar Producto</h1>

                <form action="" class='form-panel'>

                    <p>Categoria: 
                        <select name="categoria">            
                            <?php foreach($consultaCategorias as $row) { ?>
                                <option value="<?php echo $row['idcategoriaproducto'] ?>"> <?php echo $row['descripcioncategoriaproducto'] ?> </option>
                            <?php } ?>
                        </select>
                    </p>

                    <p> Elegir Producto: 
                        <select name="producto">
                            <?php foreach($consultaProducto as $row) {?>
                                <option value="<?php echo $row['idproducto'] ?>"> <?php echo $row['nomproducto'] ?> </option>
                            <?php } ?>
                        </select>
                    </p>

                    <input type="submit" value="Selecionar">
           
                    <p>Nombre: </p>
                    <p>Nuevo nombre: <input type="text"></p>  
                    
                    <p>Precio: </p>
                    <p>Nuevo precio: <input type="number"></p>

                    <p>Stock</p>
                    <p>Nuevo Stock: <input type="number"></p>
                    
                    <input type="submit" value="Actualizar Producto">

                </form>

            </div>

        </div>
    </main>

</body>
</html>