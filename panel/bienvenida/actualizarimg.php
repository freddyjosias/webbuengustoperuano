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

        $query = $conexion->prepare("UPDATE sucursal SET imgbienvenida = ? WHERE idsucursal = ?");
        $resultado = $query->execute(array($ruta, $_GET['view'])); 
        
    }

    $resultadosImg = $conexion -> prepare('SELECT imgbienvenida FROM sucursal WHERE idsucursal = ?');
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
    <title>Bienvenida</title>
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

                <div class="line-top-panel row h-4r">
                    
                </div>
                
                <div class="row w-80 m-auto">
                    <div class='formulario-panel container'>

                        <h1 class='font-weight-bold mt-4'>Actualizar Bienvenida</h1>

                        <form action="" class='form-panel' method="post" enctype="multipart/form-data">

                            <p class='fw-500'>Nueva Imagen: </p>
                        
                            <input type="file" name="nuevaimagen" required><br><br>

                                <p class='fw-500'>Imagen actual: </p>
                                <div class='text-center mt-5 destacado-panel'>
                                    <?php echo "<img class='h-25r border border-dark' src='../../". $resultadosImg['imgbienvenida'] ."' >" ?>
                                </div>
                            
                            <input class="btn btn-secondary bottom mt-4" type="submit" value="Actualizar">
                            <button class="btn btn-secondary bottom volver mt-4"><a href="bienvenida.php?view=<?php echo $idRestaurante ?>">Volver</a></button>

                        </form>
                    </div>

                </div>

            </div>

        </div>

    </main>

</body>
</html>
<?php

    }

?>