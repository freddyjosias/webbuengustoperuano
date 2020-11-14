<?php   
     require '../../conexion.php';
     session_start();
 
     if (!isset($_SESSION['idusuario'])) 
     {
         header('Location: ../../index.php');
     }
     else 
     {
         $queryProfile = $conexion -> prepare("SELECT id_profile FROM detail_usuario_profile WHERE state = 1 AND idusuario = ? AND id_profile = 2");
         $queryProfile -> execute(array($_SESSION['idusuario']));
         $queryProfile = $queryProfile -> fetch(PDO::FETCH_ASSOC);
 
         if (isset($queryProfile['id_profile'])) 
         {
             $profileManager = true;
         } 
         else
         {
             $profileManager = false;
         }
 
     }
     
     if (!isset($_GET['view'])) {
         header('Location: ../../index.php');
     } else {
        $consultaVerificarRestaurante = 'SELECT * FROM sucursal WHERE estado = 1';

        $idRestaurante;

        $resultados = $conexion -> prepare($consultaVerificarRestaurante);
        $resultados -> execute();
        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);

        foreach($resultados as $row) {
            if ($row['idsucursal'] ==  $_GET['view']) {
                $idRestaurante = $row['idsucursal'];
            break;
        }
    }

    $consultaCategorias = $conexion -> prepare(
        'SELECT * FROM categoriaproductos WHERE idsucursal = ? AND estado = 1'
    );
    $consultaCategorias -> execute(array($_GET['view']));
    $consultaCategorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);

    if($profileManager == true)  {
        $consultaManager = $conexion -> prepare("SELECT access_id FROM access WHERE state = 1 AND idusuario = ? AND idsucursal = ?");
        $consultaManager -> execute(array($_SESSION['idusuario'], $_GET['view']));
        $consultaManager = $consultaManager -> fetch(PDO::FETCH_ASSOC);

          if($consultaManager == false){

              $profileManager = false;
              
          }
      }
    
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
                        <a class="btn btn-primary bottom" href="agregar.php?view=<?php echo $idRestaurante ?>">Agregar</a>
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
                                    <td class='text-center'><a href="actualizar.php?view=<?php echo $idRestaurante ?>&id=<?php echo $categoria['idcategoriaproducto']; ?>"><i class="far fa-edit"></i></a></td>
                                    <td class='text-center'><a href="eliminar.php?view=<?php echo $idRestaurante ?>&id=<?php echo $categoria['idcategoriaproducto']; ?>"><i class="far fa-trash-alt"></i></a></td>
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
<?php

    }

?>