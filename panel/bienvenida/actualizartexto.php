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

     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $resultados = $conexion -> prepare('UPDATE sucursal SET textobienvenida = ? WHERE idsucursal = ?');
        $resultados -> execute(array($_POST['nuevotexto'], $_SESSION['sucursal']));

    }

     $resultadosText = $conexion -> prepare('SELECT textobienvenida FROM sucursal WHERE idsucursal = ?');
     $resultadosText -> execute(array($_SESSION['sucursal']));
     $resultadosText = $resultadosText -> fetch(PDO::FETCH_ASSOC); 
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

                            <p>Texto: </p>

                                <textarea style= "resize: vertical" name="nuevotexto" id="" cols="100" rows="10"><?php echo $resultadosText['textobienvenida'] ?></textarea><br><br>

                                <input class="btn btn-secondary bottom mt-4" type="submit" value="Actualizar">
                                <button class="btn btn-secondary bottom volver mt-4"><a href="bienvenida.php">Volver</a></button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </main>

</body>
</html>