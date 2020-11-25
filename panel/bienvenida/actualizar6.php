<?php   
     require '../../conexion.php';
     header('Cache-Control: no cache');
     session_cache_limiter('private_no_expire');
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

     if($_SERVER["REQUEST_METHOD"] == "POST"){

        $ruta = 'img/'.$_FILES['nuevaimagen']['name']; 
        move_uploaded_file($_FILES['nuevaimagen']['tmp_name'], "../../".$ruta);

        $query = $conexion->prepare("UPDATE sucursal SET imgdestacado3 = ? WHERE idsucursal = ?");
        $resultado = $query->execute(array($ruta, $_GET['view'])); 
        
    }


    $resultadosImg = $conexion -> prepare('SELECT imgdestacado3 FROM sucursal WHERE idsucursal = ?');
    $resultadosImg -> execute(array($_GET['view']));
    $resultadosImg = $resultadosImg -> fetch(PDO::FETCH_ASSOC);  

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
    <title>Actualizar Destacado</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.add.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">

    </head>
<body>

<main>
        <div class="container-fluid panel-control mw-1920p p-0">

            <?php require '../../menu/menupanel.php'; ?>

            <div class='container p-0 main-panel ml-auto mr-0 my-0 mw-f19-85 mw-f18-84 mw-f17-83 mw-f16-82 mw-f15-81 mw-f14-80 mw-100 z-index-auto'>

                <div class="line-top-panel row h-4r m-0 py-0 px-4 justify-content-between align-items-center">
                    <div class='container-button-menu text-white fw-700 fs-30  no-select'> 
                        <i class="fas fa-bars button-show-menu-panel d-f14-none d-inline" role="button"> &nbsp;</i>  
                        ENCARGADO
                    </div>
                </div>

                <div class="row w-f14-80 w-90 m-auto contenido-listar">
                <h1 class='h3 text-center mt-5 font-weight-bold w-100 this-is-welcome-page'>Actualizar Plato Destacado</h1>

                        <form action="" class='form-panel' method="post" enctype="multipart/form-data">

                            <p class='fw-500'>Imagen: </p>
                        
                            <input type="file" name="nuevaimagen" value="<?php $resultadosImg['imgdestacado3'] ?>" required><br><br>

                                <div class='text-center mt-5 destacado-panel'>
                                    <?php echo "<img class='h-25r border border-dark' src='../../". $resultadosImg['imgdestacado3'] ."' >" ?>
                                </div>

                                <input class="btn btn-secondary bottom mt-5" type="submit" value="Actualizar">
                                <a href="paginabienvenida.php?view=<?php echo $idRestaurante ?>" class="btn btn-secondary bottom volver mt-5">Volver</a>

                        </form>

                </div>
                

            </div>


        </div>
    </main>
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/bootstrap.add.js"></script>
    <script src="../../sweetalert/sweetalert210.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
<?php

    }

?>