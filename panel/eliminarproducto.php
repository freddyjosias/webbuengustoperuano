<?php 

    require '../conexion.php';

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

    $consultaCategorias = $conexion -> prepare('SELECT idcategoriaproducto, idsucursal, descripcioncategoriaproducto FROM categoriaproductos WHERE idsucursal = ? AND estado = 1');
    $consultaCategorias -> execute(array($_SESSION['sucursal']));
    $consultaCategorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);
    

    if (isset($_GET['categoria'])) {
        $consultaProducto = $conexion -> prepare('SELECT * FROM productos WHERE idcategoriaproducto = ? AND estado = 1');
        $consultaProducto -> execute(array($_GET['categoria']));
        $consultaProducto = $consultaProducto -> fetchAll(PDO::FETCH_ASSOC);

    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $resultados = $conexion -> prepare('UPDATE productos SET estado = 0 WHERE idproducto = ?');
        $resultados -> execute(array($_POST['producto']));

    }


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Eliminar Producto</title>
    <link rel="shorcut icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../css/responpanel.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">

            <?php require '../menu/menupanel.php'; ?>

            <div class='formulario-panel'>

                <h1>Eliminar Producto</h1>

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
                <form   form action="" method="post"  class='form-panel'>

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
                    <input type="submit" value="Eliminar Producto"> 
                </form>
                <?php }  ?>   
                
            </div>

        </div>
    </main>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>