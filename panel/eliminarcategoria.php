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
    
    $consultaCategorias = $conexion -> prepare('SELECT idcategoriaproducto, descripcioncategoriaproducto FROM categoriaproductos WHERE idsucursal = ? AND estado = 1');
    $consultaCategorias -> execute(array($_SESSION['sucursal']));
    $consultaCategorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $resultados = $conexion -> prepare('UPDATE categoriaproductos SET estado = 0 WHERE idcategoriaproducto = ?');
        $resultados -> execute(array($_POST['categoria']));

    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Eliminar Categoria</title>
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

                <h1>Eliminar Categoria</h1>

                <form action="" class='form-panel' method="post">
                    <p>Elegir Categoria: 
                        <select name="categoria" id="">            
                            <?php foreach($consultaCategorias as $row) { ?>
                                <option value="<?php echo $row['idcategoriaproducto'] ?>"> <?php echo $row['descripcioncategoriaproducto'] ?> </option>
                            <?php } ?>
                        </select>
                    </p>
                    <input type="submit" value="Eliminar Categoria">

                </form>

            </div>

        </div>
    </main>

</body>
</html>