<?php   
     require '../../conexion.php';
     header('Cache-Control: no cache');
     session_cache_limiter('private_no_expire');
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

    $consultaCategorias = $conexion -> prepare(
        'SELECT * FROM categoriaproductos WHERE idsucursal = ? AND estado = 1'
    );
    $consultaCategorias -> execute(array($_SESSION['sucursal']));
    $consultaCategorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);
    
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Categorias</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/responpanel.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">

</head>
<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">

            <?php require '../../menu/menupanel.php'; ?>

            <div class='container p-0 main-panel m-0 mw-85 w-85'>
                <div class="contenido-listar">
                    <h1 class='h3 text-center mt-5 font-weight-bold w-100'>LISTA DE CATEGORÍAS</h1>
                    <div class="direccion-a">
                        <a class="btn btn-primary bottom" href="agregar.php">Agregar</a>
                    </div>
                    <table class="table mt-4">
                        <thead class='thead-light'>
                            <tr>                    
                                <th class="th" scope="col">Descripcion</th>
                                <th class="th text-center" colspan="2">Más</th>
                            </tr>
                        </thead>
                        <?php foreach($consultaCategorias as $categoria) {?>
                            <tbody>
                                <tr>
                                    <td><?php echo $categoria['descripcioncategoriaproducto'] ?></td>
                                    <td class='text-center'><a href="actualizar.php?id=<?php echo $categoria['idcategoriaproducto']; ?>"><i class="far fa-edit"></i></a></td>
                                    <td class='text-center'><a href="eliminar.php?id=<?php echo $categoria['idcategoriaproducto']; ?>"><i class="far fa-trash-alt"></i></a></td>
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