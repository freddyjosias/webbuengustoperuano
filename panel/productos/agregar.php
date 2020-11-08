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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $agregarproducto = $conexion -> prepare('INSERT INTO productos(idcategoriaproducto,nomproducto,precio,stock) VALUES (?,?,?,?)');
        $agregarproducto -> execute(array($_POST['categoria'], $_POST['nuevo_producto'], floatval($_POST['precio']), $_POST['stock']));

        if ($agregarproducto) {
            header('Location: listar.php');
        }

    }


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Agregar Producto</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
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

            <div class='formulario-panel container'>

                <h1>Agregar Producto</h1>

                <form class='form-panel' method = "post">
                    <p>Categoria: 
                        <select name="categoria">            
                            <?php foreach($consultaCategorias as $row) { ?>
                                <option value="<?php echo $row['idcategoriaproducto'] ?>"> <?php echo $row['descripcioncategoriaproducto'] ?> </option>
                            <?php } ?>
                        </select>
                    </p>

                    <p>Nuevo Producto: <input type="text" name="nuevo_producto" ></p>  
                    <p>Precio: <input type="number" name="precio" step='0.01'></p>
                    <p>Stock: <input type="number" name="stock"></p>
                    
                    <input class="btn btn-secondary bottom" type="submit" value="Añadir Producto">

                </form>

            </div>

        </div>
    </main>

</body>
</html>