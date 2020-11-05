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

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $ruta = 'img/'.$_FILES['nuevobanner']['name']; 
        move_uploaded_file($_FILES['nuevobanner']['tmp_name'], "../".$ruta);

        $query = $conexion->prepare("UPDATE sucursal SET banner = ? WHERE idsucursal = ?");
        $resultado = $query->execute(array($ruta, $_SESSION['sucursal'])); 
        
    }

    $resultadosBanner= $conexion -> prepare('SELECT banner FROM sucursal WHERE idsucursal = ?');
    $resultadosBanner -> execute(array($_SESSION['sucursal']));
    $resultadosBanner = $resultadosBanner -> fetchAll(PDO::FETCH_ASSOC);   
        
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Actualizar Banner</title>
    <link rel="shorcut icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.add.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            
            <?php require '../menu/menupanel.php'; ?>

            <div class='formulario-panel'>

                <h1 class='font-weight-bold'>Actualizar Banner</h1>
                
                <form action="" class='form-panel' method="post" enctype="multipart/form-data">

                    <p class='fw-500'>Nuevo Banner: </p>
                    
                    <input type="file" name="nuevobanner"><br><br>
                    
                    <input type="submit" value="Actualizar Banner">

                </form>

                <div class='text-center mt-5'>
                    <?php echo "<img class='h-24r border border-dark' src='../". $resultadosBanner[0]['banner'] ."' >" ?>
                </div>

            </div>
            
        </div>
    </main>

</body>
</html>

