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

     if($_SERVER["REQUEST_METHOD"] == "POST"){

        $ruta = 'img/'.$_FILES['nuevaimagen']['name']; 
        move_uploaded_file($_FILES['nuevaimagen']['tmp_name'], "../../".$ruta);

        $query = $conexion->prepare("UPDATE sucursal SET imgdestacado3 = ? WHERE idsucursal = ?");
        $resultado = $query->execute(array($ruta, $_SESSION['sucursal'])); 
        
    }

    $resultadosImg = $conexion -> prepare('SELECT imgdestacado3 FROM sucursal WHERE idsucursal = ?');
    $resultadosImg -> execute(array($_SESSION['sucursal']));
    $resultadosImg = $resultadosImg -> fetch(PDO::FETCH_ASSOC);  

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $resultados = $conexion -> prepare('UPDATE sucursal SET platodestacado3 = ? WHERE idsucursal = ?');
        $resultados -> execute(array($_POST['nuevotexto'], $_SESSION['sucursal']));

    }

    $resultadosText = $conexion -> prepare('SELECT platodestacado3 FROM sucursal WHERE idsucursal = ?');
    $resultadosText -> execute(array($_SESSION['sucursal']));
    $resultadosText = $resultadosText -> fetch(PDO::FETCH_ASSOC);   
    
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Actualizar Destacado</title>
    <link rel="shorcut icon" href="../../img/favicon.png">
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
                    <div class='formulario-panel'>

                        <h1 class='font-weight-bold'>Actualizar Plato Destacado</h1>

                        <form action="" class='form-panel' method="post" enctype="multipart/form-data">

                            <p class='fw-500'>Imagen: </p>
                        
                            <input type="file" name="nuevaimagen"><br><br>

                                <div class='text-center mt-5 destacado-panel'>
                                    <?php echo "<img class='h-25r border border-dark' src='../../". $resultadosImg['imgdestacado3'] ."' >" ?>
                                </div>
                        

                            <p>Texto: </p>

                                <textarea style= "resize: vertical" name="nuevotexto" id="" cols="100" rows="10"><?php echo $resultadosText['platodestacado3'] ?></textarea><br><br>

                                <input type="submit" value="Actualizar">

                        </form>

                    </div>

                </div>
                

            </div>


        </div>
    </main>

</body>
</html>