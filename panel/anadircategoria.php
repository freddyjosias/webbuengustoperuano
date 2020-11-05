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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $resultados = $conexion -> prepare('INSERT INTO categoriaproductos(descripcioncategoriaproducto, idsucursal) VALUE(?, ?)');
        $resultados -> execute(array($_POST['nuevacategoria'], $_SESSION['sucursal']));

    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Añadir Categoria</title>
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

                <h1>Añadir Categoria</h1>

                <form action="" class='form-panel' method="post">

                    <p>Categoria Nueva: <input type="text" name='nuevacategoria'></p>  

                    <input type="submit" value="Añadir Categoria">

                </form>

            </div>

        </div>
    </main>

</body>
</html>