<?php

    require '../../conexion.php';

    session_start();

    if (!isset($_SESSION['sucursal'])) {
        header('Location: ../../index.php');
    }

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 2) {
            header('Location: ../../index.php');
        }
    } else {
        header('Location: ../../index.php');
    }

    if (isset($_GET['id'])) {
        $consultaCategoria = $conexion -> prepare(
            'SELECT * FROM categoriaproductos WHERE idcategoriaproducto = ?'
        );
        $consultaCategoria -> execute(array($_GET['id']));
        $consultaCategoria = $consultaCategoria -> fetch(PDO::FETCH_ASSOC);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $resultados = $conexion -> prepare('UPDATE categoriaproductos SET descripcioncategoriaproducto = ? WHERE idcategoriaproducto = ?');
        $resultados -> execute(array($_POST['cat-actualizada'], $_GET['id']));

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
    <title>Actualizar Categoria</title>
    <link rel="shorcut icon" href="../../img/favicon.ico">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
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

                <h1>Actualizar Categoria</h1>

                <form action="" class='form-panel' method = "post">

                    <p> Categoria Elegida:&nbsp;  
                        <?php echo $consultaCategoria['descripcioncategoriaproducto']; ?>
                    </p>
                    <p>Nuevo nombre: <input type="text" name = 'cat-actualizada'></p>
                    
                    <input class="btn btn-secondary bottom" type="submit" value="Actualizar Categoria">

                </form>

            </div>

        </div>
    </main>

</body>
</html>