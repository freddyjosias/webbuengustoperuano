<?php 

    require 'conexion.php';

    session_start();

    if (!isset($_SESSION['sucursal'])) {
        header('Location: index.php');
    }

    $consultaCategorias = $conexion -> prepare('SELECT idcategoriaproducto, idsucursal, descripcioncategoriaproducto FROM categoriaproductos WHERE idsucursal = ?');
    $consultaCategorias -> execute(array($_SESSION['sucursal']));
    $consultaCategorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);
    

    if (isset($_GET['categoria'])) {
        $consultaProducto = $conexion -> prepare('SELECT * FROM productos WHERE idcategoriaproducto = ?');
        $consultaProducto -> execute(array($_GET['categoria']));
        $consultaProducto = $consultaProducto -> fetchAll(PDO::FETCH_ASSOC);
    }

    if (isset($_GET['producto'])) {
        $consultaProductoA = $conexion -> prepare('SELECT*FROM productos WHERE idproducto = ?');
        $consultaProductoA -> execute(array($_GET['producto']));
        $consultaProductoA = $consultaProductoA -> fetchAll(PDO::FETCH_ASSOC);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $resultados = $conexion -> prepare('UPDATE productos SET nomproducto = ?, precio = ?, stock = ? WHERE idproducto = ?');
        $resultados -> execute(array($_POST['nuevonombre'],$_POST['nuevoprecio'],$_POST['nuevostock'], $_GET['producto']));

    }
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Actualizar Producto</title>
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
                    <li><a href="actualizarbanner.php">Actualizar Banner</a></li>
                    <li><a href="actualizartextobienvenida.php">Actualizar Texto de Bienvenida</a></li>
                    <li><a href="actualizarimagenbienvenida.php">Actualizar Imagen de Bienvenida</a></li>
                    <li><a href="actualizardestacados.php">Actualizar Platos Destacados</a></li>
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

                <form action="" method="get"  class='form-panel'>
                    <p>Categoria: 
                        <select name="categoria"  class='opciones-categoria'>            
                            <?php foreach($consultaCategorias as $row) { ?>

                                <?php 
                                    
                                    if (isset($_GET['categoria'])) {
                                        
                                        if ($row['idcategoriaproducto'] == $_GET['categoria']) { ?>
                                            <option value="<?php echo $row['idcategoriaproducto'] ?>" selected> <?php echo $row['descripcioncategoriaproducto'] ?> </option> <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo $row['idcategoriaproducto'] ?>" > <?php echo $row['descripcioncategoriaproducto'] ?> </option> <?php
                                        }

                                    } else {
                                        ?>
                                            <option value="<?php echo $row['idcategoriaproducto'] ?>"> <?php echo $row['descripcioncategoriaproducto'] ?> </option> <?php
                                    }
                                
                                ?>
                                
                                
                                
                            <?php } ?>
                        </select>
                    </p>
                    <input type='submit' value='Seleccionar'>
                </form>
                
                <?php if(isset($_GET['categoria']))   {    ?>       
                <form   form action="" method="get"  class='form-panel'>

                    <input type="number" name="categoria" id="cate-edit-pro" value="<?php echo $_GET['categoria'] ?>">

                    <p>Elegir Producto:  
                        <select name="producto" >  

                            <?php foreach($consultaProducto as $row) { ?>

                                <?php 
                                    
                                    if (isset($_GET['producto'])) {
                                        
                                        if ($row['idproducto'] == $_GET['producto']) { ?>
                                            <option value="<?php echo $row['idproducto'] ?>" selected> <?php echo $row['nomproducto'] ?> </option> <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo $row['idproducto'] ?>"> <?php echo $row['nomproducto'] ?> </option> <?php
                                        }

                                    } else {
                                        ?>
                                            <option value="<?php echo $row['idproducto'] ?>"> <?php echo $row['nomproducto'] ?> </option> <?php
                                    }
                                
                                ?>
                                        
                            
                            <?php } ?>
                        </select>
                    </p>
                    <input type='submit' value='Seleccionar'>
                </form>

                <?php }  ?>                     
                <?php if(isset($_GET['categoria']) && isset($_GET['producto']))   {    ?>         
                    <form action="" class='form-panel' method = "post">
                    <?php foreach($consultaProductoA as $row) { ?>
                        <p>Nuevo nombre: <input type="text" name="nuevonombre"></p>  
                        
                        <p>Precio: <?php echo $row['precio'] ?></p>
                        <p>Nuevo precio: <input type="number" name="nuevoprecio" step='0.01'></p>

                        <p>Stock: <?php echo $row['stock'] ?></p>
                        <p>Nuevo Stock: <input type="number" name="nuevostock"></p>
                    <?php } ?>
                        
                        <input type="submit" value="Actualizar Producto">

                    </form>

                <?php }    ?>     

            </div>

        </div>
    </main>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>